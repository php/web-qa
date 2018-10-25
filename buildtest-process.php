<?php
	include("include/release-qa.php");
	include("include/functions.php");

	if (isset($_POST['php_test_data'])) {
		if (strlen($_POST['php_test_data']) > 800000) {
			die("can't handle input that large.");
		}
		if (isset($_GET['status'])) {
			switch($_GET['status']) {
				case 'failed':
					$status = "failed";
					break;
				case 'success':
					$status = "success";
					break;
				default:
					$status = "unknown";
			}
		} else {
			$status = "unknown";
		}
		if (isset($_GET['version'])) {
			$version = $_GET['version'];
		} else {
			$version = "unknown";
		}
		if (in_array($version, $QA_RELEASES['reported'])) {
			mail ("qa-reports@lists.php.net", "Test results for $version [$status]", base64_decode($_POST['php_test_data']), "From: noreply@php.net");
		}

		// Aggregator (https://qa.php.net/reports/)
		include 'reports/parserfunc.php';
		$array = parse_phpmaketest($version, $status, base64_decode($_POST['php_test_data']));
		insertToDb_phpmaketest($array, $QA_RELEASES);
	}
?>
$Revision$
