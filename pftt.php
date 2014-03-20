<?php

include("include/functions.php");

$TITLE = "PHP: QA: PFTT";
$SITE_UPDATE = date("D M d H:i:s Y T", filectime(__FILE__));
/* $Id$ */

common_header();

define('BASE_REPORT_DIR', dirname($_SERVER['SCRIPT_FILENAME'])."/pftt-reports/");

?>
<h1>PFTT</h1>

<p>Choose a PHP Branch</p>

<?php

foreach ( scandir(BASE_REPORT_DIR) as $branch ) {
	if ($branch=="." or $branch=="..")
		continue;
	if (is_dir(BASE_REPORT_DIR."/$branch")) {
		$latest_revision = '';
		$mtime = 0;

		foreach ( scandir(BASE_REPORT_DIR."/$branch") as $revision ) {
			if ($revision=="." or $revision=="..")
				continue;
			if (is_dir(BASE_REPORT_DIR."/$branch/$revision")) {
				$mtime = stat(BASE_REPORT_DIR."/$branch/$revision")[9];
				if ($mtime > $latest_revision_mtime) {
					$latest_revision = $revision;
					$latest_revision_mtime = $mtime;
				}
			}
		}

?>
<table>
	<tr>
		<td colspan="2"><a href="list_builds.php?branch=<?php echo $branch; ?>"><?php echo $branch; ?></a></td>
		<td>Latest:</td>
		<td><a href="build.php?branch=<?php echo $branch; ?>&revision=<?php echo $latest_revision; ?>"><?php echo $latest_revision; ?></a></td>
	</tr>
<?php /*	<tr>
		<td>New Failures:</td>
		<td></td>
		<td>New Crashes:</td>
		<td></td>
	</tr>*/ ?>
</table>
<br/>	
<?php

	} // end if
}

common_footer();
?>