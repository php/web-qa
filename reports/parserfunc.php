<?php
#  +----------------------------------------------------------------------+
#  | PHP QA Website                                                       |
#  +----------------------------------------------------------------------+
#  | Copyright (c) 1997-2011 The PHP Group                                |
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

/**
 * Insert PHP make test results in SQLite database
 *
 * The following structure must be used as first array :
 *  [status]    => enum(failed, success)
 *  [version]   => string   - example: 5.4.1-dev
 *  [userEmail] => mangled
 *  [date]      => unix timestamp
 *  [phpinfo]   => string  - phpinfo() output (CLI)
 *  [buildEnvironment] => build environment
 *  [failedTest] => array: list of failed test. Example: array('/Zend/tests/declare_001.phpt')
 *  [expectedFailedTest] => array of expected failed test (same format as failedTest)
 *  [succeededTest] => array of successful tests. Provided only when parsing ci.qa results (for now)
 *  [tests] => array
        testName => array (
            'output' => string("Current output of test")
            'diff'   => string("Diff with expected output of this test")
 * @param array array to insert
 * @param array releases we accept (so that we don't accept a report that claims to be PHP 8.1 for example)
 * @return boolean success or not (for the moment, error leads to a call to 'exit;' ... not good I know)
 */
function insertToDb_phpmaketest($array, $QA_RELEASES = [])
{
    if (!is_array($array)) {
        // impossible to fetch data. We'll record this error later ...

    } else {
        if (strtolower($array['status']) == 'failed')
            $array['status'] = 0;

        elseif (strtolower($array['status']) == 'success')
            $array['status'] = 1;

        else
            die('status unknown: '.$array['status']);

        if (!is_valid_php_version($array['version'], $QA_RELEASES)) {
            exit('invalid version');
        }

        $dbFile = __DIR__.'/db/'.$array['version'].'.sqlite';

        $queriesCreate = [
            'failed' => 'CREATE TABLE IF NOT EXISTS failed (
                  `id` integer PRIMARY KEY AUTOINCREMENT,
                  `id_report` bigint(20) NOT NULL,
                  `test_name` varchar(128) NOT NULL,
                  `output` STRING NOT NULL,
                  `diff` STRING NOT NULL,
                  `signature` binary(16) NOT NULL
                )',
            'expectedfail' => 'CREATE TABLE IF NOT EXISTS expectedfail (
                  `id` integer PRIMARY KEY AUTOINCREMENT,
                  `id_report` bigint(20) NOT NULL,
                  `test_name` varchar(128) NOT NULL
                )',
            'success' => 'CREATE TABLE IF NOT EXISTS success (
                  `id` integer PRIMARY KEY AUTOINCREMENT,
                  `id_report` bigint(20) NOT NULL,
                  `test_name` varchar(128) NOT NULL
                )',
            'reports' => 'CREATE TABLE IF NOT EXISTS reports (
                  id integer primary key AUTOINCREMENT,
                  date datetime NOT NULL,
                  status smallint(1) not null,
                  nb_failed unsigned int(10)  NOT NULL,
                  nb_expected_fail unsigned int(10)  NOT NULL,
                  success unsigned int(10) NOT NULL,
                  build_env STRING NOT NULL,
                  phpinfo STRING NOT NULL,
                  user_email varchar(64) default null
            )',
        ];


        if (!file_exists($dbFile)) {
            //Create DB
            $dbi = new SQLite3($dbFile, SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE);
            foreach ($queriesCreate as $table => $query) {
                $dbi->exec($query);
                if ($dbi->lastErrorCode() != '') {
                    echo "ERROR when creating table ".$table.": ".$dbi->lastErrorMsg()."\n";
                    exit;
                }
            }
            $dbi->close();
        }
        $dbi = new SQLite3($dbFile, SQLITE3_OPEN_READWRITE) or exit('cannot open DB to record results');

        // handle tests with no success
        if (!isset($array['succeededTest'])) $array['succeededTest'] = [];

        $query = <<<'SQL'
INSERT INTO `reports` (
    `id`, `date`, `status`, `nb_failed`, `nb_expected_fail`, `success`, `build_env`, `phpinfo`, `user_email`
) VALUES (
    null, datetime(:date, 'unixepoch', 'localtime'), :status, :nb_failed, 
    :nb_expected_fail, :success, :build_env, :phpinfo, :user_email
)
SQL;
        $stmt = $dbi->prepare($query);
        $stmt->bindValue(':date', (int) $array['date'], SQLITE3_INTEGER);
        $stmt->bindValue(':status', (int)$array['status'], SQLITE3_INTEGER);
        $stmt->bindValue(':nb_failed', count($array['failedTest']), SQLITE3_INTEGER);
        $stmt->bindValue(':nb_expected_fail', count($array['expectedFailedTest']), SQLITE3_INTEGER);
        $stmt->bindValue(':success', count($array['succeededTest']), SQLITE3_INTEGER);
        $stmt->bindValue(':build_env', $array['buildEnvironment'], SQLITE3_TEXT);
        $stmt->bindValue(':phpinfo', $array['phpinfo'], SQLITE3_TEXT);
        if (!$array['userEmail']) {
            $stmt->bindValue(':user_email', NULL, SQLITE3_NULL);
        } else {
            $stmt->bindValue(':user_email', $array['userEmail'], SQLITE3_TEXT);
        }
        $stmt->execute();
        if ($dbi->lastErrorCode() != '') {
            echo "ERROR: ".$dbi->lastErrorMsg()."\n";
            exit;
        }

        $reportId = $dbi->lastInsertRowID();

        foreach ($array['failedTest'] as $name) {
            if (substr($name, 0, 1) != '/') $name = '/'.$name;

            $test = $array['tests'][$name];
            $query = <<<'SQL'
INSERT INTO `failed` (`id`, `id_report`, `test_name`, `signature`, `output`, `diff`)
VALUES (null, :id_report, :test_name, :signature, :output, :diff)
SQL;
            $stmt = $dbi->prepare($query);
            $stmt->bindValue(':id_report', $reportId, SQLITE3_INTEGER);
            $stmt->bindValue(':test_name', $name, SQLITE3_TEXT);
            $stmt->bindValue(':signature', md5($name.'__'.$test['diff'], true), SQLITE3_BLOB);
            $stmt->bindValue(':output', $test['output'], SQLITE3_TEXT);
            $stmt->bindValue(':diff', $test['diff'], SQLITE3_TEXT);
            @$stmt->execute();
            if ($dbi->lastErrorCode() != '') {
                echo "ERROR when inserting failed test : ".$dbi->lastErrorMsg()."\n";
                exit;
            }
        }

        foreach ($array['expectedFailedTest'] as $name) {
            if (substr($name, 0, 1) != '/') $name = '/'.$name;
            $query = <<<'SQL'
INSERT INTO `expectedfail` (`id`, `id_report`, `test_name`)
VALUES (null, :id_report, :test_name)
SQL;
            $stmt = $dbi->prepare($query);
            $stmt->bindValue(':id_report', $reportId, SQLITE3_INTEGER);
            $stmt->bindValue(':test_name', $name, SQLITE3_TEXT);
            @$stmt->execute();
            if ($dbi->lastErrorCode() != '') {
                echo "ERROR when inserting expected fail test : ".$dbi->lastErrorMsg()."\n";
                exit;
            }
        }

        foreach ($array['succeededTest'] as $name) {
            // sqlite files too big .. For the moment, keep only one success over time
            $query = 'SELECT id, id_report FROM `success` WHERE test_name LIKE :name';
            $stmt = $dbi->prepare($query);
            $stmt->bindValue(':name', $name, SQLITE3_TEXT);
            $res = $stmt->execute();

            if ($res->numColumns() > 0) {
                // hit ! do nothing atm
            } else {
                $query = <<<'SQL'
INSERT INTO `success` (`id`, `id_report`, `test_name`)
VALUES (null, :id_report, :test_name)
SQL;
                $stmt = $dbi->prepare($query);
                $stmt->bindValue(':id_report', $reportId, SQLITE3_INTEGER);
                $stmt->bindValue(':test_name', $name, SQLITE3_TEXT);

                @$stmt->execute();
                if ($dbi->lastErrorCode() != '') {
                    echo "ERROR when inserting succeeded test : ".$dbi->lastErrorMsg()."\n";
                    exit;
                }
            }
        }
        $dbi->close();

        // remove cache
        if (file_exists($dbFile.'.cache'))
            unlink($dbFile.'.cache');
    }
    return true;
}

/**
 * Parse raw data from 'make test' and create array
 * suitable to function insertToDb_phpmaketest()
 *
 * @param $version string  PHP version (extracted from GET in buildtest-process.php \
 *                         or from mail subject in mailing qa-reports)
 * @param $status  enum (failed|success|unknown|null)  extracted from GET. Will be \
 *                         completed based on the raw data if not specified
 * @param $file   string   RAW data to parse (from POST in buildtest-process.php).
 *                         Can also handle email content in mailing qa-reports
 */
function parse_phpmaketest($version, $status=null, $file)
{
    $extract = [];

    $extract['version'] = $version;

    if (in_array($status, ['failed', 'success', 'unknown']))
        $extract['status'] = $status;
    else
        $extract['status'] = null;

    $extract['userEmail'] = null;

    $extract['date'] = time();

    $extract['expectedFailedTest'] = [];
    $extract['failedTest'] = [];
    $extract['outputsRaw'] = [];
    $extract['tests']      = [];
    $extract['phpinfo']    = '';
    $extract['buildEnvironment']    = '';

    //for each part
    $rows = explode("\n", $file);
    $currentPart = '';
    $currentTest = '';

    foreach ($rows as $row) {
        if (preg_match('@^={5,}@', $row) && $currentPart != 'phpinfo' && $currentPart != 'buildEnvironment') {
            // =======
            $currentPart = '';

        } elseif ($currentPart == '' && trim($row) == 'FAILED TEST SUMMARY') {
            $currentPart = 'failedTest';

        } elseif ($currentPart == '' && trim($row) == 'EXPECTED FAILED TEST SUMMARY') {
            $currentPart = 'expectedFailedTest';

        } elseif ($currentPart == '' && trim($row) == 'BUILD ENVIRONMENT') {
            $currentPart = 'buildEnvironment';
            $currentTest = '';

        } elseif (trim($row) == 'PHPINFO') {
            $currentPart = 'phpinfo';
            $currentTest = '';

        } elseif ($currentPart == 'failedTest' || $currentPart == 'expectedFailedTest') {
            preg_match('@(?<!via) \[([^\]]{1,})\]\s*(?:$|XFAIL)@', $row, $tab);
            if (count($tab) == 2)
                if (!isset($extract[$currentPart])  || !in_array($tab[1], $extract[$currentPart]))
                    $extract[$currentPart][] = $tab[1];

        } elseif ($currentPart == 'buildEnvironment') {
            if (preg_match('@User\'s E-mail: (.*)$@', $row, $tab)) {
                //User's E-mail
                $extract['userEmail'] = trim($tab[1]);

                if ($extract['userEmail'] == 'ciqa') {
                    //reserved value !
                    $extract['userEmail'] = '';
                }
            }
            if (!isset($extract[$currentPart]))
                $extract[$currentPart] = '';
            $extract[$currentPart] .= $row."\n";

        } elseif ($currentPart == 'phpinfo') {
            if (!isset($extract[$currentPart]))
                $extract[$currentPart] = '';
            $extract[$currentPart] .= $row."\n";

        } elseif (substr(trim($row), -5) == '.phpt') {
            $currentTest = trim($row);
            continue;
        }
        if ($currentPart == '' && $currentTest != '') {
            if (!isset($extract['outputsRaw'][$currentTest]))
                $extract['outputsRaw'][$currentTest] = '';
            $extract['outputsRaw'][$currentTest] .= $row."\n";

        }
    }
    // 2nd try to cleanup name
    $prefix = '';


    foreach ($extract['outputsRaw'] as $name => $output) {
        if (strpos($name, '/ext/') !== false) {
            $prefix = substr($name, 0, strpos($name, '/ext/'));
            break;
        }
        if (strpos($name, '/Zend/') !== false) {
            $prefix = substr($name, 0, strpos($name, '/Zend/'));
            break;
        }
    }

    if ($prefix == '' && count($extract['outputsRaw']) > 0) {
        return 'cannot determine prefix (last test name: '.$name.')';
    }


    // 2nd loop on outputs
    foreach ($extract['outputsRaw'] as $name => $output) {
        $name = substr($name, strlen($prefix));
        $extract['tests'][$name] = ['output' => '', 'diff' => ''];
        $outputTest = '';
        $diff = '';
        $startDiff = false;
        $output = explode("\n", $output);

        foreach ($output as $row) {
            if (preg_match('@^={5,}(\s)?$@', $row)) {
                if ($outputTest != '') $startDiff = true;

            } elseif ($startDiff === false) {
                $outputTest .= $row."\n";

            } elseif (preg_match('@^[0-9]{1,}@', $row)) {
                $diff .= $row."\n";
            }
        }
        $extract['tests'][$name]['output'] = $outputTest;
        $extract['tests'][$name]['diff']   = rtrim(
            preg_replace('@ [^\s]{1,}'.substr($name, 0, -1).'@', ' %s/'.basename(substr($name, 0, -1)), $diff)
        );
    }
    unset($extract['outputsRaw']);

    // cleanup phpInfo
    $extract['phpinfo'] = preg_replace('@^={1,}\s+@', '', $extract['phpinfo']);
    $extract['buildEnvironment'] = trim(preg_replace('@^={1,}\s+@', '', $extract['buildEnvironment']));
    $extract['buildEnvironment'] = preg_replace('@={1,}$@', '', trim($extract['buildEnvironment']));

    // define status if not set
    if ($extract['status'] === null) {
        if (isset($extract['failedTest']) && count($extract['failedTest']) > 0)
            $extract['status'] = 'failed';
        else
            $extract['status'] = 'success';
    }

    return $extract;
}
