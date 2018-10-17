<?php
include("include/functions.php");
$TITLE = "Submit Build Test [PHP-QAT: Quality Assurance Team]";
$SITE_UPDATE = date("D M d H:i:s Y T", filectime(__FILE__));

common_header();

    $d = var_export ($_POST, TRUE);
    if (count($_POST) > 0) {
        mail ("php-qa@lists.php.net", "PHP Test results", $d, "From: noreply@php.net");
        print("thank you for your submission.");
    } else {
        print("Your submission was empty, please try again.");
    }
common_footer();
?>
