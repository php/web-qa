<?php
#  +----------------------------------------------------------------------+
#  | PHP QA Website                                                       |
#  +----------------------------------------------------------------------+
#  | Copyright (c) 1997-2012 The PHP Group                                |
#  +----------------------------------------------------------------------+
#  | This source file is subject to version 3.01 of the PHP license,      |
#  | that is bundled with this package in the file LICENSE, and is        |
#  | available through the world-wide-web at the following url:           |
#  | https://php.net/license/3_01.txt                                     |
#  | If you did not receive a copy of the PHP license and are unable to   |
#  | obtain it through the world-wide-web, please send a note to          |
#  | license@php.net so we can mail you a copy immediately.               |
#  +----------------------------------------------------------------------+
#  | Author: Olivier Doucet <odoucet@php.net>                             |
#  +----------------------------------------------------------------------+
#  This file retrieve results from CI.QA and add them to QA report databases
#
#  TODO : to handle "trunk", add |trunk  to the first () in regexp line ~38
#         and update code about $QA_RELEASES at line ~143

set_time_limit(0);

header('Content-Type: text/plain');
$rss = new SimpleXMLElement('http://ci.qa.php.net/rssAll', 0, true);

// get latest build done
if (!file_exists('db/ciqaversion.txt')) {
    $latestVersion = [];
} else {
    $latestVersion = unserialize(file_get_contents('db/ciqaversion.txt'));
}
$newLatestVersion = []; // this array will erase latestVersion at the end of the next loop

// we grab builds in this array
$buildArray = [];

foreach ($rss->entry as $test) {
    $linkAttr = $test->link->attributes();
    $z = preg_match('@http://ci.qa.php.net/job/php-src-([0-9\.]{3,})-matrix-build/'
                   .'./architecture=([^/]{1,})/([0-9]{1,})@', (string) $linkAttr['href'], $pos);

    if (!$z) continue;

    // check if we already did this
    if (isset($latestVersion[ $pos[1] ]) && $latestVersion[ $pos[1] ] >= (int) $pos[3]) {
        continue;
    }


    $elem = [
        'id' => (int) $pos[3],
        'date' => strtotime($test->updated),
        'version' => $pos[1],
        'archi' => $pos[2],
        'url'  => $pos[0],
    ];
    //keep it !
    $buildArray[] = $elem;

    //  update what has been done so far
    if (!isset($newLatestVersion[ $pos[1] ]) || $newLatestVersion[ $pos[1] ] < $elem['id'])
        $newLatestVersion[ $pos[1] ] = $elem['id'];

    // stop at 5 reports (take time to parse)
    if (count($buildArray) == 5) break;
}
unset($rss);
file_put_contents('db/ciqaversion.txt', serialize($newLatestVersion));

echo "We have ".count($buildArray)." builds to parse ... \n\n";


/***
 * we do not add each report to QA (sqlite files will be too big)
 * We choose to pack them based on version parsed
 */
$failingTests = [];
$successfulTests = [];

foreach ($buildArray as $build) {
    printf(" * #%s (%5s) - %-30s ", $build['id'], $build['version'], $build['archi']);

    // retrieve and parse junit artefact
    $junitxml = new SimpleXMLElement($build['url'].'/artifact/junit.xml', 0, true);
    //$junitxml = new SimpleXMLElement('sample-junit.xml', LIBXML_NOCDATA, true);

    foreach ($junitxml->testsuite as $suite) {
        foreach ($suite->testsuite as $subsuite) {
            foreach ($subsuite->testcase as $case) {
                $attr = $case->attributes();

                if (substr($attr['classname'], 0, 8) == 'php-src.') {
                    $uri = '/'.str_replace('.', '/', substr($attr['classname'], 8)).'/'.
                           substr($attr['name'], 0, strpos($attr['name'], '.phpt')+5);
                } else continue;

                // add it to array
                if (isset($case->failure)) {
                    $fail = $case->failure->attributes();

                    if ($fail->type == 'FAILED')
                        $failingTests[$build['version']][$uri] = trim(
                            preg_replace(
                                '@ [^\s]{1,}'.substr($uri, 0, -1).'@',
                                ' %s/'.basename(substr($uri, 0, -1)),
                                (string) $case->failure
                            )
                        );
                    else {
                        printf("ERROR: unknown failing type: ".$fail->type."\n");
                        continue;
                    }
                } elseif (isset($case->skipped)) {
                    // do nothing

                } else {
                    // success
                    $successfulTests[$build['version']][$uri] = true;
                }
            }
        }
    }
    unset($junitxml); // free memory

    printf("Success: %5s   Fail: %5s  (from all builds parsed)\n",
        count($successfulTests[$build['version']]),
        count($failingTests[$build['version']])
    );
}

// Add data !
echo "\n\nAdding data to databases ... \n";
require 'parserfunc.php';
require '../include/release-qa.php';
require '../include/functions.php';

foreach ($successfulTests as $version => $successTests) {
    echo "* ".$version." ";

    $firstArray = [];

    // determine status (success or failure ?)
    if (count($failingTests[$version]) == 0)
        $firstArray['status'] = 'success';
    else
        $firstArray['status'] = 'failed';

    // determine correct version
    // hard because we only have "5.4" and we know it's dev, so find next coming version ?
    foreach ($QA_RELEASES as $ver => $releaseData) {
        if (substr($ver, 0, strlen($version)) == $version) {
            $firstArray['version'] = $ver.'-dev';
            break;
        }
    }

    if (!isset($firstArray['version'])) {
        // for trunk atm
        die('cannot determine version for '.$version);
    }

    // email
    $firstArray['userEmail'] = 'ciqa'; // magic value

    // date
    $firstArray['date'] = time();

    $firstArray['phpinfo'] = '';
    $firstArray['buildEnvironment'] = '';

    // failed tests
    $firstArray['failedTest'] = array_keys($failingTests[$version]);

    // expected Failed Test
    $firstArray['expectedFailedTest'] = [];

    // success
    $firstArray['succeededTest'] = array_keys($successTests);

    // tests
    foreach ($failingTests[$version] as $test => $diff) {
        $firstArray['tests'][$test] = ['output' => '', 'diff' => str_replace("\n", "\x0d\n", $diff)];
    }

    $status = insertToDb_phpmaketest($firstArray, $QA_RELEASES);
    if ($status === true) echo "SUCCESS !\n";
    else echo " ERROR :(  \n";
}
