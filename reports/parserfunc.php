<?php
#  +----------------------------------------------------------------------+
#  | PHP QA Website                                                       |
#  +----------------------------------------------------------------------+
#  | Copyright (c) 1997-2011 The PHP Group                                |
#  +----------------------------------------------------------------------+
#  | This source file is subject to version 3.01 of the PHP license,      |
#  | that is bundled with this package in the file LICENSE, and is        |
#  | available through the world-wide-web at the following url:           |
#  | http://www.php.net/license/3_01.txt                                  |
#  | If you did not receive a copy of the PHP license and are unable to   |
#  | obtain it through the world-wide-web, please send a note to          |
#  | license@php.net so we can mail you a copy immediately.               |
#  +----------------------------------------------------------------------+
#  | Author: Olivier Doucet <odoucet@php.net>                             |
#  +----------------------------------------------------------------------+
#   $Id$

function insertToDb_phpmaketest($array, $QA_RELEASES = array()) 
{
    if (!is_array($array)) {
        // impossible to fetch data. We'll record this error later ...
        
    } else {
        if ($array['userEmail'] == null) 
            $array['userEmail'] = 'NULL';
        else 
            $array['userEmail'] = "'".addslashes($array['userEmail'])."'";
        
        if (strtolower($array['status']) == 'failed') 
            $array['status'] = 0;
            
        elseif (strtolower($array['status']) == 'success') 
            $array['status'] = 1;
            
        else 
            die('status unknown: '.$array['status']);
            
		if (!is_valid_php_version($array['version'], $QA_RELEASES)) {
			exit('invalid version');
		}
        
        $DBFILE = dirname(__FILE__).'/db/'.$array['version'].'.sqlite';
		
		if (!file_exists($DBFILE)) {
			//Create DB
			$dbi = new SQLite3($DBFILE, SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE);
			$query = 'CREATE TABLE failed (
			  `id` integer PRIMARY KEY AUTOINCREMENT,
			  `id_report` bigint(20) NOT NULL,
			  `test_name` varchar(128) NOT NULL,
			  `output` STRING NOT NULL,
			  `diff` STRING NOT NULL,
			  `signature` binary(16) NOT NULL
			)';
			$dbi->exec($query);
			if ($dbi->lastErrorCode() != '') {
				echo "ERROR: ".$dbi->lastErrorMsg()."\n";
				exit;
			}
			
			$query = 'CREATE TABLE reports (
			  id integer primary key AUTOINCREMENT,
			  date datetime NOT NULL,
			  status smallint(1) not null,
			  nb_failed unsigned int(10)  NOT NULL,
			  nb_expected_fail unsigned int(10)  NOT NULL,
			  build_env STRING NOT NULL,
			  phpinfo STRING NOT NULL,
			  user_email varchar(64) default null
			)';
			$dbi->exec($query);
			if ($dbi->lastErrorCode() != '') {
				echo "ERROR: ".$dbi->lastErrorMsg()."\n";
				exit;
			}
			$dbi->close();
		}
        $dbi = new SQLite3($DBFILE, SQLITE3_OPEN_READWRITE) or exit('cannot open DB to record results');
        
        $query = "INSERT INTO `reports` (`id`, `date`, `status`, 
        `nb_failed`, `nb_expected_fail`, `build_env`, `phpinfo`, user_email) VALUES    (null, 
        datetime(".((int) $array['date']).", 'unixepoch', 'localtime'), 
        '".addslashes($array['status'])."', 
        '".count($array['failedTest'])."', 
        '".count($array['expectedFailedTest'])."', 
        ('".$dbi->escapeString($array['buildEnvironment'])."'), 
        ('".$dbi->escapeString($array['phpinfo'])."'), ".$array['userEmail']."
        )";
        // userEmail is already escaped on line 28
        
        $dbi->query($query);
        if ($dbi->lastErrorCode() != '') {
            echo "ERROR: ".$dbi->error."\n";
            exit;
        }

        $reportId = $dbi->lastInsertRowID();

        foreach ($array['tests'] as $name => $test) {
            $query = "INSERT INTO `failed` 
            (`id`, `id_report`, `test_name`, signature, `output`, `diff`) VALUES    (null, 
            '".$reportId."', '".$name."', 
            X'".md5($name.'__'.$test['diff'])."',
            ('".$dbi->escapeString($test['output'])."'), ('".$dbi->escapeString($test['diff'])."'))";
            
            $dbi->query($query);
            if ($dbi->lastErrorCode() != '') {
                echo "ERROR: ".$dbi->error."\n";
                exit;
            } 
            
        }
        $dbi->close();
    }
	return true;
}

function parse_phpmaketest($version, $status, $file) {

    $extract = array();

    $extract['version'] = $version;
    $extract['status']  = $status;
    $extract['userEmail'] = null;

    $extract['date'] = time();

    $extract['expectedFailedTest'] = array();
    $extract['failedTest'] = array();
    $extract['outputsRaw'] = array();
    $extract['tests']      = array();
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
        }
        elseif ($currentPart == '' && trim($row) == 'FAILED TEST SUMMARY') {
    $currentPart = 'failedTest';    
        }
        elseif ($currentPart == '' && trim($row) == 'EXPECTED FAILED TEST SUMMARY') {
    $currentPart = 'expectedFailedTest';    
        }
        elseif ($currentPart == '' && trim($row) == 'BUILD ENVIRONMENT') {
    $currentPart = 'buildEnvironment';
    $currentTest = '';
        }
        elseif (trim($row) == 'PHPINFO') {
    $currentPart = 'phpinfo';
    $currentTest = '';
        }
        elseif ($currentPart == 'failedTest' || $currentPart == 'expectedFailedTest') {
            preg_match('@ \[([^\]]{1,})\]@', $row, $tab);
            if (count($tab) == 2)
                if (!isset($extract[$currentPart])  || !in_array($tab[1], $extract[$currentPart])) 
                    $extract[$currentPart][] = $tab[1];
        }
        elseif ($currentPart == 'buildEnvironment') {
    if (preg_match('@User\'s E-mail: (.*)$@', $row, $tab)) {
        //User's E-mail
        $extract['userEmail'] = trim($tab[1]);
    }
    if (!isset($extract[$currentPart]))
        $extract[$currentPart] = '';
        
    $extract[$currentPart] .= $row."\n";
        }
        elseif ($currentPart == 'phpinfo') {
    if (!isset($extract[$currentPart]))
        $extract[$currentPart] = '';
        
    $extract[$currentPart] .= $row."\n";
        }
        elseif (substr(trim($row), -5) == '.phpt') {
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
        if (strpos($name, '/lang/') !== false) {
            $prefix = substr($name, 0, strpos($name, '/lang/'));
            break;
        }
    }

    if ($prefix == '' && count($extract['outputsRaw']) > 0) {
        return 'cannot determine prefix (last test name: '.$name.')';
    }


    // 2nd loop on outputs
    foreach ($extract['outputsRaw'] as $name => $output) {
        $name = substr($name, strlen($prefix));
        $extract['tests'][$name] = array ('output' => '', 'diff' => '');
        $outputTest = '';
        $diff = '';
        $startDiff = false;
        $output = explode("\n", $output);
        
        foreach ($output as $row) {
            if (preg_match('@^={5,}$@', $row)) {
                if ($outputTest != '') $startDiff = true;
            }
            elseif ($startDiff === false) {
                $outputTest .= $row."\n";
            }
            elseif (preg_match('@^[0-9]{1,}@', $row)) {
                $diff .= $row."\n";
            }
        }
        $extract['tests'][$name]['output'] = $outputTest;
        $extract['tests'][$name]['diff']   = rtrim( preg_replace('@ [^\s]{1,}'.substr($name, 0, -1).'@', ' %s/'.basename(substr($name, 0, -1)), $diff));
    }
    unset($extract['outputsRaw']);

    // cleanup phpInfo
    $extract['phpinfo'] = preg_replace('@^={1,}\s+@', '', $extract['phpinfo']);
    $extract['buildEnvironment'] = trim(preg_replace('@^={1,}\s+@', '', $extract['buildEnvironment']));
    $extract['buildEnvironment'] = preg_replace('@={1,}$@', '', trim($extract['buildEnvironment']));

    return $extract;
}
