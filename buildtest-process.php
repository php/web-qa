<?php
	if (isset($_POST['php_test_data'])) {
		if (strlen($_POST['php_test_data']) > 90000) {
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
		mail ("php-qa@lists.php.net", "Test results [$status]", base64_decode(urldecode($_POST['php_test_data'])), "From: noreply@php.net");
	}
?>
$Revision$
