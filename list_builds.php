<?php
define('BASE_REPORT_DIR', dirname($_SERVER['SCRIPT_FILENAME'])."/reports/db/");

$branch = $_GET['branch'];
if (substr($branch, 0, 3)!='PHP') {
	$branch = "PHP_5_6";
}


include("include/functions.php");

$TITLE = "PHP: QA: PFTT: $branch";
$SITE_UPDATE = date("D M d H:i:s Y T", filectime(__FILE__));
/* $Id$ */

common_header(NULL, $TITLE);


?>
<h1><a href="pftt.php"><?php echo $branch; ?></a></h1>

<p>Choose a PHP revision or build</p>
<?php

$r = scandir(BASE_REPORT_DIR."/$branch");


if ($r!==FALSE) {
sort($r);

$latest_revision = '';
$mtime = 0;

$revisions_by_mtime = array();

foreach ( $r as $revision ) {
	if ($revision=="." or $revision=="..")
		continue;
	if (is_dir(BASE_REPORT_DIR."/$branch/$revision")) {
		$s = stat(BASE_REPORT_DIR."/$branch/$revision");
		$mtime = $s['mtime'];
		if ($mtime > $latest_revision_mtime) {
			$latest_revision = $revision;
			$latest_revision_mtime = $mtime;
		}
		$revisions_by_mtime[$mtime] = $revision;
	}
} // end foreach

$mtimes = array_keys($revisions_by_mtime);

sort($mtimes);

$revisions = array();

foreach ($mtimes as $mtime) {
    array_push($revisions, $revisions_by_mtime[$mtime]);
}

$red = is_file(BASE_REPORT_DIR."/$branch/$latest_revision/FAIL_CRASH.txt");


?>
<table class="pftt" style="background:<?php echo $red ? '#ff0000' : '#ccff66'; ?>">
	<tr>
		<td>Latest:</td>
		<td><a href="build.php?branch=<?php echo $branch; ?>&revision=<?php echo $latest_revision; ?>"><?php echo $latest_revision; ?></a></td>
	</tr>
</table>
<br/>
<table class="pftt">
	<?php

$revisions = array_reverse($revisions);
	
foreach ( $revisions as $revision ) {
	$red = is_file(BASE_REPORT_DIR."/$branch/$revision/FAIL_CRASH.txt");
	
	?>
	<tr style="background:<?php echo $red ? '#ff0000' : '#ccff66'; ?>">
		<td><a href="build.php?branch=<?php echo $branch; ?>&revision=<?php echo $revision; ?>"><?php echo $revision; ?></a></td>
	</tr>
	<?php
	
} // end foreach
	
	
	?>
</table>
<br/>
<br/>
<?php

} // end if


common_footer();

?>
