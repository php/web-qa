<?php
include("include/functions.php");
$TITLE = "Submit Build Test [PHP-QAT: Quality Assurance Team]";
$SITE_UPDATE = date("D M d H:i:s Y T", filectime($SCRIPT_FILENAME))."<br>
/* $Id$ */";

common_header();

	ob_start();
	print_r ($_POST);
	$d = ob_get_contents();
	ob_clean();
	
	//printf("%s", $d);
	mail ("php-qa@lists.php.net", "PHP Test results", $d, "From: noreply@php.net");

	print("thank you for your submission.");

common_footer();
?>