<?php
	if (isset($_POST['php_test_data'])) {
		if (strlen($_POST['php_test_data']) > 90000) {
			die("can't handle input that large.");
		}
		mail ("php-qa@lists.php.net", "Test results", base64_decode(urldecode($_POST['php_test_data'])), "From: noreply@php.net");
	}
?>
$Revision$
