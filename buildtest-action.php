<?php
include("include/functions.php");

$TITLE = "How To Help [PHP-QAT: Quality Assurance Team]";
$SITE_UPDATE = date("D M d H:i:s Y T", filectime($SCRIPT_FILENAME))."<br>
/* $Id$ */";

common_header();

	ob_start();
	print_r ($_POST);
	$d = ob_get_contents();
	ob_clean();
	mail ("php-qa@lists.php.net", "PHP Test results", $d, "From: noreply@php.net");

	print("thank you for your submission.");

common_footer();
?>