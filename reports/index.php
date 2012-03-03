<?php
#  +----------------------------------------------------------------------+
#  | PHP QA Website                                                       |
#  +----------------------------------------------------------------------+
#  | Copyright (c) 1997-2011 The PHP Group                                |
#  +----------------------------------------------------------------------+
#  | This source file is subject to version 3.01 of the PHP license,      |
#  | that is bundled with this package in the file LICENSE, and is        |
#  | available through the world-wide-web at the following url:           |
#  | http://www.php.net/license/3_01.txt                                  |
#  | If you did not receive a copy of the PHP license and are unable to   |
#  | obtain it through the world-wide-web, please send a note to          |
#  | license@php.net so we can mail you a copy immediately.               |
#  +----------------------------------------------------------------------+
#  | Author: Olivier Doucet <odoucet@php.net>                             |
#  +----------------------------------------------------------------------+
#   $Id$

$startTime = microtime(true);

include "../include/functions.php";
include "../include/release-qa.php";

require 'reportsfunctions.php';

$getVersion = null;

if (isset($_GET['version'])) {
    //sanity check
    if (!is_valid_php_version($_GET['version'], $QA_RELEASES)) {
        exit('invalid version');
    }
    $getVersion = $_GET['version'];
    $TITLE .= 'PHP Test Reports For PHP Version '.$_GET['version'];

    $limit = 50;
    if (!empty($_GET['limit'])) {
        if (is_numeric($_GET['limit'])) {
            $limit = (int) $_GET['limit'];
        }
    }

    $dbFile = dirname(__FILE__).'/db/'.$getVersion.'.sqlite';
    if (!file_exists($dbFile)) {
        die('no data for this version');
    }
    $database = new SQLite3($dbFile, SQLITE3_OPEN_READONLY);
    if (!($database instanceof SQLite3)) {
        die("Error opening DB file: ".$database->lastErrorMsg());
    }
    $failedTestsArray = array();
    $query = 'SELECT test_name,COUNT(failed.id) as cpt,COUNT(DISTINCT diff) as variations, 
            date(date) as date FROM failed,reports WHERE failed.id_report = reports.id 
            GROUP BY test_name ORDER BY cpt DESC LIMIT ' . $limit;
    $q = @$database->query($query);
    if (!$q) die("Error querying DB: ".$database->lastErrorMsg());
    while ($tab = $q->fetchArray(SQLITE3_ASSOC)) {
        $failedTestsArray[] = $tab;
    }
    $database->close();

} else {
    if (!isset($_GET['summary_filter'])) {
        $filter = QA_REPORT_FILTER_ALL;
    } else {
        $filter = $_GET['summary_filter'];
    }
    $reportsPerVersion = get_summary_data($filter);
    $TITLE = "PHP Test Reports Summary";

}

common_header();
?>
<script src="sorttable.js"></script>
<div style="margin:10px">

<h1><a href="/reports/">
<img title="Go back home" src="home.png" border="0" style="vertical-align:middle;" /></a>
<?php echo $TITLE; ?></h1>

<?php
if (!$getVersion) {
?>
<table class="sortable" style="border: 1px solid black;padding:5px; width:800px">
<thead>
 <tr>
  <th>PHP Version</th>
  <th>Reports</th>
  <th>Unique failed tests</th>
  <th>Total failed tests</th>
  <th>Last report date</th>
 </tr>
</thead>
<tbody>
<?php

uksort($reportsPerVersion, 'version_compare');

foreach ($reportsPerVersion as $version => $line) {

    if (version_compare($version, '5.3.8', '<')) {
        continue;
    }
    
    echo '<tr>';
    echo '<td><a href="./?version='.$version.'">'.$version.'</a></td>';
    echo '<td align="right">'.$line['nbReports'].'</td>';
    echo '<td align="right">'.$line['nbFailingTests'].'</td>';
    echo '<td align="right">'.$line['nbFailures'].'</td>';
    echo '<td nowrap align="right" sorttable_customkey="'.strtotime($line['lastReport']).'">';
    echo format_readable_date(strtotime($line['lastReport']));
    echo '</td>';
    echo '</tr>'."\n";
}
?>
</tbody>
</table>
<p>(<a href="./?summary_filter=0">Show all versions</a> |
    <a href="./?summary_filter=<?php echo QA_REPORT_FILTER_ALL; ?>">Show stable and current dev only</a>)</p>
<?php 
} else { /* $getVersion */
?>
<style>
#testList td {
    padding: 3px;
}
</style>
<table id="testList" class="sortable" style="width: 800px; border-collapse: collapse">
    <thead>
     <tr>
     <th>Test name</th>
     <th>Count</th>
     <th>Variations</th>
     <th>Last report date</th>
     <th>&nbsp;</th>
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
     echo '<td align="right" sorttable_customkey="'.strtotime($line['date']).'">';
	 echo format_readable_date(strtotime($line['date']));
	 echo '</td>';
         echo '<td><a href="viewreports.php?version='.$getVersion.'&amp;test='.urlencode($line['test_name']).'">
        <img src="report.png" title="View reports" border="0" /></a></td>';
     echo '</tr>'."\n";
     $i++;
 }
                
                ?>
</tbody></table>
<?php
    if (count($failedTestsArray) >= $limit) {
        echo '<i>There are more failing tests ';
        echo '(<a href="?version=' . $getVersion . '&limit=1000">view all)</i>';
    } else {
        echo '<i>View only the most common failed tests ';
        echo '(<a href="?version=' . $getVersion . '&limit=50">view 50)</i>';
    }
} 
?>

</div>
<?php
$SITE_UPDATE = date('D M d H:i:s Y T', filemtime(__FILE__))."<br />".
               "Generated in ".round((microtime(true)-$startTime)*1000)." ms";
common_footer();

