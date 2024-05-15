<?php

include("include/functions.php");
include("reports/reportsfunctions.php");

$branch = $_GET['branch'] ?? '';
isValidBranch($branch) or $branch = 'PHP_5_6';

$revision = $_GET['revision'] ?? '';
isValidRevision($revision) or $revision = '';

$TITLE = htmlentities("PHP: QA: PFTT: $branch: $revision");
$SITE_UPDATE = date("D M d H:i:s Y T", filectime(__FILE__));

common_header(NULL);

echo '<h1><a href="list_builds.php?branch=', urlencode($branch), '">',
	 htmlentities($branch), '</a>', htmlentities($revision), "</h1>\n";

echo "<h2>Summary</h2>\n";
echo '<table><tr><td>',
	 htmlentities($branch), ' ', htmlentities($revision),
	 "</td></tr></table>\n";
echo "<br/>\n";
echo "<h2>Comparison Reports</h2>\n";

outputReportTable('PHPT', $branch, $revision);
outputReportTable('PhpUnit', $branch, $revision);

?>

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
<p><b>Opcache_Local-FileSystem_MySQL_CLI_WinCacheU</b> - Tests run on local file system on CLI with Opcache, MySQL and WinCache (user &amp; file caches)</p>
<p><b>SMB-DFS_MySQL_Apache-ModPHP-ApacheLounge-2.4.4-VC9-OpenSS</b> - Tests run on remote DFS file system, using Apache with MySQL</p>
<p><b>SMB-DFS_MySQL_CLI</b> - Tests run on remote DFS file system on CLI with MySQL</p>
<p><b>Opcache_SMB-DFS_MySQL_Apache-ModPHP-ApacheLounge-2</b> - Tests run on remote DFS file system, using Apache with Opcache, MySQL</p>
<p><b>Opcache_SMB-DFS_MySQL_CLI</b> - Tests run on remote DFS file system on CLI with MySQL</p>
<p><b>Opcache_SMB-DFS_MySQL_CLI_WinCacheU</b> - Tests run on remote DFS file system on CLI with Opcache, MySQL and WinCache (user &amp; file caches)</p>

<?php

common_footer();

// Generator function to enumerate structured data from reports/db
function genReports(string $type, string $branch, string $revision) {
	$dir = makeRevisionPath($branch, $revision);
	if (!is_dir($dir)) { return; }

	$baseURL = '/reports/db/' . urlencode($branch) . '/' . urlencode($revision) . '/';

	foreach (scandir($dir) as $report) {
		if (!strncmp($report, $type, strlen($type)) &&
			is_file("$dir/$report")) {
			$reportName = $report;
			if (substr($reportName, -5) === '.html') {
				$reportName = substr($reportName, 0, -5);
			}

			yield [
				'url' => $baseURL . urlencode($report),
				'name' => $reportName,
				'has_fails_crashes' => file_exists("$dir/FAIL_CRASH.txt"),
			];
		}
	}
}

function outputReportTable(string $type, string $branch, string $revision) {
	echo "<table>\n";
	echo '<tr><td><strong>', htmlentities($type, ENT_QUOTES), '</strong> ',
		 '<a href="howto_', urlencode(strtolower($type)), '.php" target="_blank">How to</a>',
		 "</td></tr>\n";
	foreach (genReports($type, $branch, $revision) as $report) {
		$url = htmlentities($report['url'], ENT_QUOTES);
		$name = htmlentities($report['name'], ENT_QUOTES);
		$style = '';
		if ($report['has_fails_crashes']) {
			$style = ' style="background:#ff0000"';
		}
		echo "<tr{$style}><td>with <a href=\"$url\" target=\"_blank\">$name</a></td></tr>\n";
	}
	echo "</table>\n";
	echo "<br/>\n";
}
