<?php
	if (!isset($_POST['php_test_data'])) {
		mail ("php-qa@lists.php.net", "Test results", base64_decode(urldecode($_POST['php_test_data'])), "From: noreply@php.net");
	}
?>
