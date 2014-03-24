<?php

define('BASE_REPORT_DIR', dirname($_SERVER['SCRIPT_FILENAME'])."/reports/db/");

$branch = $_GET['branch'];
$revision = $_GET['revision'];
if (substr($branch, 0, 3)!='PHP') {
	$branch = "PHP_5_6";
}
if (substr($revision, 0, 1)!='r' and strpos($revision, ".")===FALSE) {
	$revision = "";
}



include("include/functions.php");

$TITLE = "PHP: QA: PFTT: $branch: $revision";
$SITE_UPDATE = date("D M d H:i:s Y T", filectime(__FILE__));
/* $Id$ */

common_header(NULL, $TITLE);



?>
<h1><a href="list_builds.php?branch=<?php echo $branch; ?>"><?php echo $branch; ?></a> <?php echo $revision; ?></h1>

<h2>Summary</h2>

<table>
	<tr>
		<td><?php echo $branch; ?> <?php echo $revision; ?> </td>
	</tr>
</table>

<br/>

<h2>Comparison Reports</h2>

<table>
	<tr>
		<td><strong>PHPT</strong>  <a href="howto_phpt.php" target="_blank">How to</a></td>
	</tr>
	<?php
foreach ( scandir(BASE_REPORT_DIR."/$branch/$revision") as $report ) {
	if (substr($report, 0, 4)=="PHPT" && is_file(BASE_REPORT_DIR."/$branch/$revision/$report")) {
	    $report_name = $report;
	    if (substr($report_name, strlen($report_name)-5, 5)==".html")
		$report_name = substr($report_name, 0, strlen($report_name)-5);
	
	?>
	<tr>
		<td>with <a href="/reports/db/<?php echo $branch; ?>/<?php echo $revision; ?>/<?php echo $report; ?>" target="_blank"><?php echo $report_name; ?></a></td>
	</tr>
	<?php
	
	} // end if
}
	
	?>
</table>
<br/>
<table>
	<tr>
		<td><strong>PhpUnit</strong>  <a href="howto_phpunit.php" target="_blank">How to</a></td>
	</tr>
	<?php

foreach ( scandir(BASE_REPORT_DIR."/$branch/$revision") as $report ) {
	if (substr($report, 0, 7)=="PhpUnit" && is_file(BASE_REPORT_DIR."/$branch/$revision/$report")) {
	    $report_name = $report;
	    if (substr($report_name, strlen($report_name)-5, 5)==".html")
		$report_name = substr($report_name, 0, strlen($report_name)-5);
	
	?>
	<tr>
		<td>with <a href="/reports/db/<?php echo $branch; ?>/<?php echo $revision; ?>/<?php echo $report; ?>" target="_blank"><?php echo $report_name; ?></a></td>
	</tr>
	<?php
	
	} // end if
}

?>
</table>
<br/>
<h2>Abbreviations</h2>
<p><b>NTS</b> - Non-Thread Safe build, use for CLI or IIS (PHP on Windows uses 2 types of builds, TS and NTS)</p>
<p><b>TS</b> - Thread Safe build, use for CLI or Apache mod_php on Windows</p>
<p><b>VC11</b> - Build compiled using VC11 (Visual Studio 2012)</p>
<p><b>VC9</b> - Build compiled using VC9 (Visual Studio 2008)</p>
<p><b>GCC</b> - Build compiled using GCC</p>
<br/>
<h2>Common Scenario Sets</h2>
<p><b>Local-FileSystem_MySQL_Apache-ModPHP-ApacheLounge-2.4.4-VC9-OpenSS</b> - Tests run on local file system, using Apache with MySQL</p>
<p><b>Local-FileSystem_MySQL_CLI</b> - Tests run on local file system on CLI with MySQL</p>
<p><b>Opcache_Local-FileSystem_MySQL_Apache-ModPHP-ApacheLounge-2</b> - Tests run on local file system, using Apache with Opcache, MySQL</p>
<p><b>Opcache_Local-FileSystem_MySQL_CLI</b> - Tests run on local file system on CLI with MySQL</p>
<p><b>Opcache_Local-FileSystem_MySQL_CLI_WinCacheU</b> - Tests run on local file system on CLI with Opcache, MySQL and WinCache (user & file caches)</p>
<p><b>SMB-DFS_MySQL_Apache-ModPHP-ApacheLounge-2.4.4-VC9-OpenSS</b> - Tests run on remote DFS file system, using Apache with MySQL</p>
<p><b>SMB-DFS_MySQL_CLI</b> - Tests run on remote DFS file system on CLI with MySQL</p>
<p><b>Opcache_SMB-DFS_MySQL_Apache-ModPHP-ApacheLounge-2</b> - Tests run on remote DFS file system, using Apache with Opcache, MySQL</p>
<p><b>Opcache_SMB-DFS_MySQL_CLI</b> - Tests run on remote DFS file system on CLI with MySQL</p>
<p><b>Opcache_SMB-DFS_MySQL_CLI_WinCacheU</b> - Tests run on remote DFS file system on CLI with Opcache, MySQL and WinCache (user & file caches)</p>

<?php

common_footer();

?>
