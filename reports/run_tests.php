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
    $TITLE = 'PHP Test Reports For PHP Version '.$_GET['version'];

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

    // Do we add expected failed ?
    if (isset($_GET['expect']) && $_GET['expect'] == 1) {
        $query = 'SELECT \'xfail\' as xfail, test_name,COUNT(expectedfail.id) as cpt,\'-\' as variations, 
                datetime(date) as date FROM expectedfail,reports WHERE expectedfail.id_report = reports.id 
                GROUP BY test_name ORDER BY cpt DESC LIMIT ' . $limit;
        $q = @$database->query($query);
        if ($q) {
            while ($tab = $q->fetchArray(SQLITE3_ASSOC)) {
                $failedTestsArray[] = $tab;
            }
        }
    }
    
    $query = 'SELECT failed.test_name,COUNT(failed.id) as cpt,COUNT(DISTINCT failed.diff) as variations, 
            datetime(reports.date) as date,success.id as success, r2.id as failedci FROM failed, reports 
            LEFT JOIN success ON success.test_name=failed.test_name
            LEFT JOIN failed f2  ON (f2.test_name=failed.test_name AND f2.output = "")
            LEFT JOIN reports r2 ON (f2.id_report = r2.id AND r2.user_email="ciqa")
            WHERE failed.id_report = reports.id 
            GROUP BY failed.test_name ORDER BY cpt DESC LIMIT ' . $limit;
    $q = @$database->query($query);
    if (!$q) die("Error querying DB (error ".$database->lastErrorCode()."): ".$database->lastErrorMsg());
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
$maxReportDate = 0;
foreach ($reportsPerVersion as $version => $line) {

    if (version_compare($version, '5.3.8', '<')) {
        continue;
    }
    if ($maxReportDate < strtotime($line['lastReport'])) $maxReportDate = strtotime($line['lastReport']);
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
<script type="text/javascript">
<!--
function changeExpect() 
{
    var check = document.getElementById('expect').checked;
    if (check == true) {
        document.location.href = '?version=<?php echo $getVersion; ?>&expect=1';
    } else {
        document.location.href = '?version=<?php echo $getVersion; ?>';
    }
}
// ->
</script>
<input type="checkbox" id="expect" onClick="javascript:changeExpect()" 
<?php if (isset($_GET['expect']) && $_GET['expect'] == '1') echo ' checked'; ?> /><small>Show XFAIL</small><br />

<table id="testList" class="sortable" style="margin-top:10px; width: 800px; border-collapse: collapse">
    <thead>
     <tr>
     <th>Test name</th>
     <th>Count</th>
     <th>Variations</th>
     <th>Last report date</th>
     <?php
     if (substr($getVersion, -4) == '-dev') {
     echo '<th>CIQA status</th>';
     }
     ?>
     <th>&nbsp;</th>
    </tr>
    </thead>
    <tbody>
 <?php
 $i = 0;
 $maxReportDate = 0;
 foreach ($failedTestsArray as $line) {
    if ($maxReportDate < strtotime($line['date'])) $maxReportDate = strtotime($line['date']);
     echo ' <tr ';
     if ($i % 2) echo 'style="background-color: #ffcc66" ';
     echo '><td>';
     if (isset($line['xfail'])) echo '[XFAIL] ';
     echo $line['test_name'].'</td>';
     echo '<td align="right">'.$line['cpt'].'</td>';
     echo '<td align="right">'.$line['variations'].'</td>';
     echo '<td align="right" sorttable_customkey="'.strtotime($line['date']).'">';
     echo format_readable_date(strtotime($line['date']));
     echo '</td>';
     if (substr($getVersion, -4) == '-dev') {
         echo '<td style="';
         $textCI = '';
         if (!array_key_exists('success', $line)) {
            // probably xfail
            echo 'background-color: grey';
         } elseif ($line['success'] === null) {
            // no success. Check fail ?
            if (isset($line['failedci'])) {
                echo 'background-color: #c00000';
                $textCI = 'FAIL';
            } else {
                echo 'background-color: grey';
            }
         } else {
            // success
            echo "background-color: #00c000";
            $textCI = 'PASS';
         }
         
         echo '" align="center">'.$textCI.'</td>';
     }
     echo '<td>';
     if (!isset($line['xfail'])) {
         echo '<a href="viewreports.php?version='.$getVersion.'&amp;test='.urlencode($line['test_name']).'">
         <img src="report.png" title="View reports" border="0" /></a>';
     }
     echo '</td>';
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
// Last update = date of last report in this very page
$SITE_UPDATE = date('D M d H:i:s Y T', $maxReportDate)."<br />".
               "Generated in ".round((microtime(true)-$startTime)*1000)." ms";
common_footer();

