<?php
#  +----------------------------------------------------------------------+
#  | PHP QA Website                                                       |
#  +----------------------------------------------------------------------+
#  | Copyright (c) 2005-2006 The PHP Group                                |
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

$TITLE = "PHP Test reports Summary";

if (isset($_GET['version'])) {
    //sanity check
    if (!is_valid_php_version($_GET['version'], $QA_RELEASES)) {
        exit('invalid version');
    }
    $VERSION = $_GET['version'];
    $TITLE .= ' - PHP Version '.$_GET['version'];
}

require 'reportsfunctions.php';


$reportsPerVersion = get_summary_data();

if (isset($VERSION)) {
    $DBFILE = dirname(__FILE__).'/db/'.$VERSION.'.sqlite';
    if (!file_exists($DBFILE)) {
        die('no data for this version');
    }
    $database = new SQLite3($DBFILE, SQLITE3_OPEN_READONLY);
    if (!($database instanceof SQLite3)) {
        die("Error opening DB file: ".$database->lastErrorMsg());
    }
    $failedTestsArray = array();
    
    $query = 'SELECT test_name,COUNT(id) as cpt,COUNT(DISTINCT diff) as variations FROM failed
            GROUP BY test_name ORDER BY COUNT(id) DESC LIMIT 50';
    $q = @$database->query($query);
    if (!$q) die("Error querying DB: ".$database->lastErrorMsg());
    while ($tab = $q->fetchArray(SQLITE3_ASSOC)) {
        $failedTestsArray[] = $tab;
    }
    $database->close();
}




common_header();
?>
<script src="sorttable.js"></script>
<div style="margin:10px">

<h1><a href="/reports/"><img title="Go back home" src="home.png" border="0" style="vertical-align:middle;" /></a>Reports per version</h1>

<table class="sortable" style="border: 1px solid black;padding:5px; width:700px">
<thead>
 <tr>
  <th>PHP Version</th>
  <th>Reports</th>
  <th>Failing tests</th>
  <th>Failures</th>
  <th>Last record</th>
  <th class="sorttable_nosort">DB Size</th>
 </tr>
</thead>
<tbody>
<?php

foreach ($reportsPerVersion as $version => $line) {
    echo '<tr>';
    echo '<td><a href="./?version='.$version.'">'.$version.'</a></td>';
    echo '<td align="right">'.$line['nbReports'].'</td>';
    echo '<td align="right">'.$line['nbFailingTests'].'</td>';
    echo '<td align="right">'.$line['nbFailures'].'</td>';
    echo '<td nowrap align="right" sorttable_customkey="'.strtotime($line['lastReport']).'">';
    
    $lastReport = time()-strtotime($line['lastReport']);
    
    if($lastReport < 3600) {
        $_tmp = round($lastReport/60);
        echo "$_tmp ", ($_tmp == 1) ? 'minute' : 'minutes';
    } elseif ($lastReport < 3600*24) {
        $_tmp = round($lastReport/3600);
        echo "$_tmp ", ($_tmp == 1) ? 'hour' : 'hours';
    } elseif  ($lastReport < 3600*24*60) {
        $_tmp = round($lastReport/3600/24);
        echo "$_tmp ", ($_tmp == 1) ? 'day' : 'days';
    } else {
        $_tmp = floor($lastReport/3600/24/30);
        echo "$_tmp ", ($_tmp == 1) ? 'month' : 'months';
    }
    echo " ago";
    echo '</td>';
    echo '<td nowrap align="right"><small>'.round($line['dbsize']/1024/1024).' MB</small></td>';
    echo '</tr>'."\n";
}
?>
</tbody>
</table>

<?php if (isset($VERSION)): ?>
<br />
<style>
#testList td {
    padding: 3px;
}
</style>
<table id="testList" class="sortable" style="width: 700px; border-collapse: collapse">
    <thead>
     <tr>
     <th>Test name</th>
     <th>Count</th>
     <th>Variations</th>
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
         echo '<td><a href="viewreports.php?version='.$VERSION.'&amp;test='.urlencode($line['test_name']).'">
        <img src="report.png" title="View reports" border="0" /></a></td>';
     echo '</tr>'."\n";
     $i++;
 }
                
                ?>
</tbody></table>
<?php
if (count($failedTestsArray) == 50) {
    echo '<i>There are more failing tests not printed here (with less occurences)</i>';
}
endif; 
?>

</div>
<?php
$SITE_UPDATE = date('D M d H:i:s Y T', filemtime(__FILE__))."<br /> Generated in ".round((microtime(true)-$startTime)*1000)." ms";
common_footer();

