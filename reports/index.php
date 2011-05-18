<?php
$startTime = microtime(true);

include("include/functions.php");


$TITLE = "PHP Test reports Summary";

if (isset($_GET['version'])) {
	//sanity check
	if (!preg_match('@^[0-9]{1}\.[0-9]{1}\.[0-9\.\-dev]{1,}$@', $_GET['version'])) {
		exit('invalid version in GET');
	}
	$VERSION = $_GET['version'];
	$TITLE .= ' - PHP Version '.$_GET['version'];
}

$DBFILE = dirname(__FILE__).'/db/reports.sqlite';
$SITE_UPDATE =  date("D M d H:i:s Y T", filemtime($DBFILE))."<br />\n".
	'/* $Id$ */';
$database = new SQLite3($DBFILE, SQLITE3_OPEN_READONLY);

if (!$database) {
    $error = (file_exists($yourfile)) ? "Impossible to open, check permissions" : "Impossible to create, check permissions";
    die("Error: ".$error);
}

$query = $database->query("SELECT `version`,COUNT(*) AS nbReports,MAX(`date`) AS lastReport 
		 FROM reports GROUP BY `version` ORDER BY MAX(`date`) DESC");
if (!$query)
    die("Error: ".$database->lastErrorMsg()); #This means that most probably we catch a syntax error
if (!$query)
    die("Impossible to execute query."); #As reported above, this means that the db owner is different from the web server's one, but we did not commit any syntax mistake.
while ($row = $query->fetchArray(SQLITE3_ASSOC)) {
    $reportsPerVersion[] = $row;
}

if (isset($VERSION)) {
	// Get reports for specific version
	// @todo
	$failedTestsArray = array();
	
	$query = 'SELECT test_name,COUNT(id) as cpt,COUNT(DISTINCT diff) as variations FROM failed WHERE phpversion=\''.$VERSION.'\'
			GROUP BY test_name ORDER BY COUNT(id) DESC LIMIT 30';
	$q = @$database->query($query);
	if (!$q) die("Error querying DB: ".$database->lastErrorMsg());
	while ($tab = $q->fetchArray(SQLITE3_ASSOC)) {
		$failedTestsArray[] = $tab;
	}

}
// We stop everything
$database->close();



common_header();
?>
<div style="margin:10px">

<h1>Reports per version</h1>

<table style="border: 1px solid black;padding:5px; width:450px">
<thead>
 <tr>
  <th>PHP Version</th>
  <th>Number of reports</th>
  <th>Last report received</th>
 </tr>
</thead>
<tbody>
<?php

foreach ($reportsPerVersion as $line) {
	echo '<tr>';
	echo '<td><a href="./?version='.$line['version'].'">'.$line['version'].'</a></td>';
	echo '<td align="right">'.$line['nbReports'].'</td>';
	echo '<td nowrap align="right">';
	
	$lastReport = time()-strtotime($line['lastReport']);
	
	if($lastReport < 3600) {
		echo round($lastReport/60).' minutes ago';
	} elseif ($lastReport < 3600*24) {
		echo round($lastReport/3600).' hours ago';
	} elseif  ($lastReport < 3600*24*60) {
		echo round($lastReport/3600/24).' days ago';
	} else {
		echo floor($lastReport/3600/24/30).' month ago';
	}
	echo '</td>';
	
	echo '</tr>'."\n";
}
?>
</tbody>
</table>
<small><i> 
Database size: <?php echo round(filesize($DBFILE)/1024/1024, 1).' MB';?> </i></small>

<?php if (isset($VERSION)): ?>
<br />
<table>
	<thead>
	 <tr>
	 <th>Test name</th>
	 <th>Failed occurences</th>
	 <th>Variations</th>
	 <th>Reports</th>
	</tr>
	</thead>
	<tbody>
 <?php
 $i = 0;
 foreach ($failedTestsArray as $line) {
 	echo ' <tr ';
 	if ($i % 2) echo 'style="background-color: #ffcc66" ';
 	echo '><td>'.$line['test_name'].'</td>';
 	echo '<td align="right">'.$line['cpt'].'</td>';
 	echo '<td align="right">'.$line['variations'].'</td>';
 		echo '<td><a href="viewreports.php?version='.$VERSION.'&amp;test='.urlencode($line['test_name']).'">View reports</a></td>';
 	echo '</tr>'."\n";
 	$i++;
 }
				
				?>
</tbody></table>
<?php
endif; 
?>

</div>
<?php
$SITE_UPDATE .= " Generated in ".round((microtime(true)-$startTime)*1000)." ms";
common_footer();

