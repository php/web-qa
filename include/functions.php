<?php
/*
(c) 2001 by Marco Kaiser (bate@php.net) and the PHP Group
*/

function common_header($extra_headers=NULL, $TITLE = "Quality Assurance") {
    if ($extra_headers) {
        $HEAD_RAND = join("\n", $extra_headers);
    }
    $SUBDOMAIN = "QA";
    $CSS = ["/styles/qa.css"];
    $LINKS = [
        ["href" => "/projects.php",      "text" => "Goals"],
        ["href" => "/rc.php",            "text" => "What is RC?"],
        ["href" => "/howtohelp.php",     "text" => "Contributing"],
        ["href" => "/handling-bugs.php", "text" => "Handling Reports"],
        ["href" => "/reports/",          "text" => "Reports"],
        ["href" => "/pulls/",            "text" => "Github PRs"],
    ];
    include __DIR__ . "/../shared/templates/header.inc";
    echo '<section class="mainscreen">';
}

function common_footer($JS = []) {
    echo "</section>";
    include __DIR__ . "/../shared/templates/footer.inc";
}

function is_valid_php_version($version, $QA_RELEASES = []) {

	if (isset($QA_RELEASES['reported']) && in_array($version, $QA_RELEASES['reported'])) {
		return true;
	}

	if (preg_match('@^\d{1}\.\d{1}\.\d{1,}(?:(?:RC|alpha|beta)\d{0,2})?(?:-dev)?$@i', $version)) {
		return true;
	}

	return false;
}
