<?php

include("include/functions.php");
include("reports/reportsfunctions.php");
$branch = $_GET['branch'] ?? '';
isValidBranch($branch) or $branch = 'PHP_5_6';

$TITLE = "PHP: QA: PFTT: $branch";
$SITE_UPDATE = date("D M d H:i:s Y T", filectime(__FILE__));

common_header(NULL, $TITLE);

echo '<h1><a href="pftt.php">', htmlentities($branch), "</a></h1>\n";
echo "<p>Choose a PHP revision or build</p>\n";

(function() use ($branch) {
	$branchdir = makeBranchPath($branch);
	if (!is_dir($branchdir)) { return; }

	$revisions = scandir($branchdir);
	if ($revisions === false) { return; }

	$revisions = array_filter($revisions, function($rev) use ($branchdir) {
		return ($rev !== '.') && ($rev !== '..') && is_dir("$branchdir/$rev");
	});
	if (empty($revisions)) { return; }

	// Create an array of [ $rev => $mtime] pairs,
	// sorted by mtime from most recent to least.
	$revisions = array_flip($revisions);
	foreach ($revisions as $revision => &$mtime) {
		$mtime = filemtime("$branchdir/$revision");
	}
	unset($mtime);
	arsort($revisions, SORT_NUMERIC);

	// Output revisions, from most recent to least.
	echo "<table class=\"pftt\">\n";
	foreach ($revisions as $revision => $mtime) {
		$revpath = makeRevisionPath($branch, $revision);
		if (!is_dir($revpath)) { continue; }
		$style = 'background: ' .
			(is_file("$revpath/FAIL_CRASH.txt") ? '#ff0000' : '#ccff66');
		echo "<tr style=\"$style\">";
		echo '<td><a href="build.php?branch=', urlencode($branch),
		     '&revision=', urlencode($revision), '">',
		     htmlentities($revision), "</a></td></tr>\n";
	}
	echo "</table>\n";
	echo "<br/><br/>\n";
})();

common_footer();
