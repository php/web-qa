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

header('HTTP/1.0 403 Forbidden');
die('This script is for local testing purposes only! Uncomment these lines to use it.');

error_reporting(E_ALL);

require 'parserfunc.php';
require '../include/functions.php';
echo '<h1>Testing QA report parsing and database handling</h1>';
echo '<pre>'."\n";

$str = file_get_contents('sample.txt');
echo 'Content length: '.strlen($str);
if (strlen($str) == 126341) echo " <font color='green'>OK</font> \n";
else                        echo " <font color='red'>KO (value: ".strlen($str)."</font> \n";
echo "Parsing with function parse_phpmaketest() ... \n";
$array = parse_phpmaketest('5.3.7-dev', 'failed', $str);

printf("%-30s", "Result should be array: ");
if (is_array($array)) echo " <font color='green'>OK</font> \n";
else                        echo " <font color='red'>KO</font> \n";

printf("%-30s", "Version extracted match: ");
if ($array['version'] == '5.3.7-dev') echo " <font color='green'>OK</font> \n";
else                        echo " <font color='red'>KO. value extracted: ".$array['version']."</font> \n";

printf("%-30s", "Test email match: ");
if ($array['userEmail'] == 'thisisatestmail@testdomain.com') echo " <font color='green'>OK</font> \n";
else                        echo " <font color='red'>KO. value extracted: ".$array['userEmail']."</font> \n";

printf("%-30s", "extract 17 expectedFailedTest");
if (count($array['expectedFailedTest']) == 17) echo " <font color='green'>OK</font> \n";
else                        echo " <font color='red'>KO</font> \n";

printf("%-30s", "extract 33 failedTest");
if (count($array['failedTest']) == 33) echo " <font color='green'>OK</font> \n";
else                        echo " <font color='red'>KO</font> \n";

printf("%-30s", "33 detailed test");
if (count($array['tests']) == 33) echo " <font color='green'>OK</font> \n";
else                        echo " <font color='red'>KO</font> \n";

printf("%-30s", "specific expectedFailedTest");
if (in_array('Zend/tests/bug48770_3.phpt', $array['expectedFailedTest'])) echo " <font color='green'>OK</font> \n";
else                        echo " <font color='red'>KO</font> \n";

printf("%-30s", "specific failedTest");
if (in_array('ext/dom/tests/DOMDocument_validate_on_parse_variation.phpt', $array['failedTest']))
     echo " <font color='green'>OK</font> \n";
else echo " <font color='red'>KO</font> \n";

printf("%-30s", "specific test diff");
$strlen = strlen($array['tests']['/tests/func/010.phpt']['diff']);
if (isset($array['tests']['/tests/func/010.phpt']['diff']) && $strlen >= 290 )
     echo " <font color='green'>OK size:   ".$strlen." - optimal =   293</font> \n";
else echo " <font color='red'>KO (length: $strlen should be > 290)</font> \n";

printf("%-30s", "specific test output");
$strlen = strlen($array['tests']['/tests/func/010.phpt']['output']);
if (isset($array['tests']['/tests/func/010.phpt']['output']) && $strlen >= 165 )
     echo " <font color='green'>OK size:   ".$strlen." - optimal =   167</font> \n";
else echo " <font color='red'>KO</font> \n";

printf("%-30s", "phpinfo");
if (strlen($array['phpinfo']) >= 27940) echo " <font color='green'>OK size: ".strlen($array['phpinfo'])."</font> \n";
else                        echo " <font color='red'>KO</font> \n";

printf("%-30s", "buildEnvironment");
if (strlen($array['buildEnvironment']) >= 4500)
     echo " <font color='green'>OK size:  ".strlen($array['buildEnvironment'])."</font> \n";
else echo " <font color='red'>KO</font> \n";

// total diff / output, to see if we parsed everything Ok
$totalDiff = 0;
$totalOutput = 0;

foreach ($array['tests'] as $name => $content) {
    $totalDiff += strlen($content['diff']);
    $totalOutput += strlen($content['output']);
}

printf("%-30s", "Total diff length");
if ($totalDiff >= 27900) echo " <font color='green'>OK size: ".$totalDiff." - optimal = 27938</font> \n";
else                     echo " <font color='red'>KO</font> \n";

printf("%-30s", "Total output length");
if ($totalOutput >= 31950) echo " <font color='green'>OK size: ".$totalOutput." - optimal = 31971</font> \n";
else                       echo " <font color='red'>KO</font> \n";


// now insert data and check
echo "\nTesting SQLite insertion ...\n";

$return = insertToDb_phpmaketest($array);
printf("%-30s", "Function call");

if ($return === true) echo " <font color='green'>OK</font> \n";
else                  echo " <font color='red'>KO (return: ".$return.")</font> \n";

$dbFile = __DIR__.'/db/'.$array['version'].'.sqlite';

printf("%-30s", "DB file exists");
if (file_exists($dbFile)) echo " <font color='green'>OK</font> \n";
else                  echo " <font color='red'>KO</font> \n";

$database = new SQLite3($dbFile, SQLITE3_OPEN_READONLY);

if (!$database) {
    die("Error opening DB file: ".$database->lastErrorMsg());
}

// Check report ?
$query = 'SELECT * FROM reports WHERE user_email = \'thisisatestmail@testdomain.com\' ORDER BY date DESC LIMIT 1';
$q = $database->query($query);
$sqlReport = $q->fetchArray(SQLITE3_ASSOC);
printf("%-30s", "Found report in DB");
if (is_array($sqlReport) && isset($sqlReport['id']))
     echo " <font color='green'>OK (id: ".$sqlReport['id'].")</font> \n";
else echo " <font color='red'>KO</font> \n";

// check how many failed ?
if (!isset($sqlReport['id'])) die('cannot make more tests');

$query = 'SELECT * FROM failed WHERE id_report = '.$sqlReport['id'];
$q = $database->query($query);
$sqlFailed = [];
while ($tab = $q->fetchArray(SQLITE3_ASSOC)) {
    $sqlFailed[$tab['test_name']] = $tab;
}

printf("%-30s", "Found 33 failedTest");
if (count($sqlFailed) == 33) {
    echo " <font color='green'>OK</font> \n";
} else {
    echo " <font color='red'>KO (found: ".count($sqlFailed).")</font> \n";
    var_dump($sqlFailed);
}

// expected fail
$query = 'SELECT count(*) FROM expectedfail WHERE id_report = '.$sqlReport['id'];
$q = $database->query($query);
list($nbExpected) = $q->fetchArray();

printf("%-30s", "Found 17 expectedFailedTests");
if ($nbExpected == 17) {
    echo " <font color='green'>OK</font> \n";
} else {
    echo " <font color='red'>KO (found: ".$nbExpected.")</font> \n";
}



printf("%-30s", "specific test diff");
$strlen = strlen($sqlFailed['/tests/func/010.phpt']['diff']);
if (isset($sqlFailed['/tests/func/010.phpt']['diff']) && $strlen >= 290 )
     echo " <font color='green'>OK size:   ".$strlen." - optimal =   293</font> \n";
else echo " <font color='red'>KO</font> \n";

printf("%-30s", "specific test output");
$strlen = strlen($sqlFailed['/tests/func/010.phpt']['output']);
if (isset($sqlFailed['/tests/func/010.phpt']['output']) && $strlen >= 165 )
     echo " <font color='green'>OK size:   ".$strlen." - optimal =   167</font> \n";
else echo " <font color='red'>KO</font> \n";

$totalDiff = 0;
$totalOutput = 0;

foreach ($sqlFailed as $name => $content) {
    $totalDiff += strlen($content['diff']);
    $totalOutput += strlen($content['output']);
}

printf("%-30s", "Total diff length");
if ($totalDiff >= 27900) echo " <font color='green'>OK size: ".$totalDiff." - optimal = 27938</font> \n";
else                     echo " <font color='red'>KO</font> \n";

printf("%-30s", "Total output length");
if ($totalOutput >= 31950) echo " <font color='green'>OK size: ".$totalOutput." - optimal = 31971</font> \n";
else                       echo " <font color='red'>KO</font> \n";

// Cleanup
$database->close();

$database = new SQLite3($dbFile, SQLITE3_OPEN_READWRITE) or exit('cannot open DB to remove test');
$database->exec('DELETE FROM failed WHERE id_report = '.$sqlReport['id']);
$database->exec('DELETE FROM expectedfail WHERE id_report = '.$sqlReport['id']);
$database->exec('DELETE FROM reports WHERE id = '.$sqlReport['id']);
$database->close();
echo "<b>Cleanup done</b>";
