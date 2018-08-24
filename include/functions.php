<?php
/* 
(c) 2001 by Marco Kaiser (bate@php.net) and the PHP Group
*/

function common_header($extra_headers=NULL, $TITLE = "Quality Assurance") {
    if ($extra_headers) {
        $HEAD_RAND = join("\n", $extra_headers);
    }
    $SUBDOMAIN = "QA";
    $CSS = array("/styles/qa.css");
    $LINKS = array(
        array("href" => "/projects.php",      "text" => "Goals"),
        array("href" => "/rc.php",            "text" => "What is RC?"),
        array("href" => "/howtohelp.php",     "text" => "Contributing"),
        array("href" => "/handling-bugs.php", "text" => "Handling Reports"),
        array("href" => "/reports/",          "text" => "Reports"),
        array("href" => "/pulls/",            "text" => "Github PRs"),
    );
    include __DIR__ . "/../shared/templates/header.inc";
    echo '<section class="mainscreen">';
}

function common_footer($JS = array()) {
    echo "</section>";
    include __DIR__ . "/../shared/templates/footer.inc";
}

function make_link($string, $text = "", $target = "") {
	$buffer = "<a href=\"$string\"";
	if ($target!="") $buffer .= " target=\"$target\">"; else $buffer .= ">";
	if ($text!="") $buffer .= "$text"; else $buffer .= "$string";
	$buffer .= "</a>";
	return $buffer;
}

function is_valid_php_version($version, $QA_RELEASES = array()) {
	
	if (isset($QA_RELEASES['reported']) && in_array($version, $QA_RELEASES['reported'])) {
		return true;
	}
	
	if (preg_match('@^\d{1}\.\d{1}\.\d{1,}(?:(?:RC|alpha|beta)\d{0,2})?(?:-dev)?$@i', $version)) {
		return true;
	}
	
	return false;
}

// This is used for linking to GCOV (Format: GCOV version => Human readable version)
function get_active_branches() {
	return [
		'PHP_5_6' 	=> '5.6', 
		'PHP_7_1' 	=> '7.1', 
		'PHP_7_2' 	=> '7.2', 
		'PHP_7_3'	=> '7.3',
		'PHP_HEAD' 	=> '7.4',
		];
}
