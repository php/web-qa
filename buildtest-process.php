<?php
	include("include/release-qa.php");

	if (isset($_POST['php_test_data'])) {
		if (strlen($_POST['php_test_data']) > 200000) {
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
		if (in_array($version, $BUILD_TEST_RELEASES) || in_array($version, $DEV_RELEASES)) {
			mail ("php-qa@lists.php.net", "Test results for $version [$status]", base64_decode($_POST['php_test_data']), "From: noreply@php.net");
		}
	}
?>
$Revision$
