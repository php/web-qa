<?php

function parse_email($file) {

	$extract = array();

	// extraction version / status

	$z = preg_match('@Test results for ([0-9\.\-dev]{1,}) \[([a-z]{1,})\]@', $file, $tab);
	if (!$z) return 'cannot extract subject';

	$extract['version'] = $tab[1];
	$extract['status']  = $tab[2];
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
