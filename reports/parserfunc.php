<?php

function insertToDb_phpmaketest($array) 
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
            
        $DBFILE = dirname(__FILE__).'/db/reports.sqlite';
        $dbi = new SQLite3($DBFILE, SQLITE3_OPEN_READWRITE) or exit('cannot open DB to record results');
        
        $query = "INSERT INTO `reports` (`id`, `date`, `version`, `status`, 
        `nb_failed`, `nb_expected_fail`, `build_env`, `phpinfo`, user_email) VALUES    (null, 
        datetime(".((int) $array['date']).", 'unixepoch', 'localtime'), 
        '".addslashes($array['version'])."', 
        '".addslashes($array['status'])."', 
        '".count($array['failedTest'])."', 
        '".count($array['expectedFailedTest'])."', 
        ('".$dbi->escapeString(gzdeflate($array['buildEnvironment'], 9))."'), 
        ('".$dbi->escapeString(gzdeflate($array['phpinfo'], 9))."'), ".$array['userEmail']."
        )";
        //not used : userEmail, 
        $dbi->query($query);
        if ($dbi->lastErrorCode() != '') {
            echo "ERROR: ".$dbi->error."\n";
            exit;
        }

        $reportId = $dbi->lastInsertRowID();

        foreach ($array['tests'] as $name => $test) {
            $query = "INSERT INTO `failed` 
            (`id`, `id_report`, `test_name`, `phpversion`, signature, `output`, `diff`) VALUES    (null, 
            '".$reportId."', '".$name."', '".$dbi->escapeString($array['version'])."', 
            X'".md5($array['version'].'__'.$name)."',
            ('".$dbi->escapeString(gzdeflate($test['output'], 9))."'), ('".$dbi->escapeString(gzdeflate($test['diff'], 9))."'))";
            
            $dbi->query($query);
            if ($dbi->lastErrorCode() != '') {
        echo "ERROR: ".$dbi->error."\n";
        exit;
            } 
            
        }
        $dbi->close();
    }
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
    if (preg_match('@^={5,}\s+$@', $row)) {
        if ($outputTest != '') $startDiff = true;
    }
    elseif ($startDiff === false) {
        $outputTest .= $row;
    }
    elseif (preg_match('@^[0-9]{1,}@', $row)) {
        $diff .= $row;
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
