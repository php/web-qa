<?php
error_reporting(E_ALL);
include("include/functions.php");

$TITLE = "PHP: QA: PFTT";
$SITE_UPDATE = date("D M d H:i:s Y T", filectime(__FILE__));

common_header(NULL, $TITLE);

define('BASE_REPORT_DIR', dirname($_SERVER['SCRIPT_FILENAME'])."/reports/db/");

?>
<h1>PFTT</h1>

<p>Choose a PHP Branch</p>

<?php
$branches = scandir(BASE_REPORT_DIR);
if ($branches!==FALSE) {
    $branches = array_reverse($branches);
    foreach ( $branches as $branch ) {
	    if ($branch=="." or $branch==".." or $branch==".svn")
		    continue;
	    if (is_dir(BASE_REPORT_DIR."/$branch")) {
		    $latest_revision = '';
		    $latest_revision_mtime = 0;

		    foreach ( scandir(BASE_REPORT_DIR."/$branch") as $revision ) {
			    if ($revision=="." or $revision==".." or $revision==".svn")
				    continue;
			    if (is_dir(BASE_REPORT_DIR."/$branch/$revision")) {
				    $s = stat(BASE_REPORT_DIR."/$branch/$revision");
				    $mtime = $s['mtime'];
				    if ($mtime > $latest_revision_mtime) {
					    $latest_revision = $revision;
					    $latest_revision_mtime = $mtime;
				    }
			    }
		    }

		    $red = is_file(BASE_REPORT_DIR."/$branch/$latest_revision/FAIL_CRASH.txt");

?>
<table class="pftt" style="background:<?php echo $red ? '#ff0000;' : '#ccff66'; ?>">
	<tr>
		<td style="width:300px"><a href="list_builds.php?branch=<?php echo urlencode($branch); ?>"><?php echo htmlentities($branch); ?></a></td>
		<td style="width:100px">Latest:</td>
		<td style="width:300px"><a href="build.php?branch=<?php echo urlencode($branch); ?>&revision=<?php echo urlencode($latest_revision); ?>"><?php echo htmlentities($latest_revision); ?></a></td>
	</tr>
</table>
<br/>
<?php

	    } // end if
    }
}

?>

<p><strong>PFTT Source Code:</strong> <a href="https://git.php.net/?p=pftt2.git">https://git.php.net/?p=pftt2.git</a></p>

<p><strong>PFTT Binaries:</strong> <a href="https://windows.php.net/downloads/snaps/ostc/pftt/" target="_blank">https://windows.php.net/downloads/snaps/ostc/pftt/</a></p>

<br/>
<br/>
<?php

common_footer();
?>
