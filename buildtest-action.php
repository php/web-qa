<?php
include("include/functions.php");
$TITLE = "Submit Build Test [PHP-QAT: Quality Assurance Team]";
$SITE_UPDATE = date("D M d H:i:s Y T", filectime($SCRIPT_FILENAME))."<br>
/* $Id$ */";

common_header();

	$d = var_export ($_POST, TRUE);
	
	mail ("php-qa@lists.php.net", "PHP Test results", $d, "From: noreply@php.net");

	print("thank you for your submission.");

common_footer();
?>
