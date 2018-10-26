<?php
#  +----------------------------------------------------------------------+
#  | PHP QA Website                                                       |
#  +----------------------------------------------------------------------+
#  | Copyright (c) 1997-2011 The PHP Group                                |
#  +----------------------------------------------------------------------+
#  | This source file is subject to version 3.01 of the PHP license,      |
#  | that is bundled with this package in the file LICENSE, and is        |
#  | available through the world-wide-web at the following url:           |
#  | https://php.net/license/3_01.txt                                     |
#  | If you did not receive a copy of the PHP license and are unable to   |
#  | obtain it through the world-wide-web, please send a note to          |
#  | license@php.net so we can mail you a copy immediately.               |
#  +----------------------------------------------------------------------+
#  | Author: Olivier Doucet <odoucet@php.net>                             |
#  +----------------------------------------------------------------------+

$startTime = microtime(true);

include __DIR__ . '/../include/release-qa.php';
include __DIR__ . '/../include/functions.php';
require __DIR__ . '/reportsfunctions.php';

common_header();
echo "<script src=\"sorttable.js\"></script>\n";
echo "<div style=\"margin:10px\">\n";

$version = $_GET['version'] ?? '';
if (is_valid_php_version($version, $QA_RELEASES)) {
    $tmSiteUpdate = outputTestReportsForVersion($version);
} else {
    $tmSiteUpdate = outputTestReportsSummary();
}

echo "</div>\n";
// Last update = date of last report in this very page
$SITE_UPDATE = date('D M d H:i:s Y T', $tmSiteUpdate)."<br />".
               "Generated in ".round((microtime(true)-$startTime)*1000)." ms";
common_footer();

/////////////////////////////////////////////////////////////////////////////

function outputReportTitle(string $TITLE) {
    echo '<h1><a href="run_tests.php">',
         '<img title="Go back home" src="home.png" border="0" style="vertical-align:middle;" /></a>',
         htmlentities($TITLE), "</h1>\n";
}

function outputTestReportsSummary() {
    outputReportTitle('PHP Test Reports Summary');
    echo <<<HTML
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
HTML;

    $filter = $_GET['summary_filter'] ?? QA_REPORT_FILTER_ALL;
    $reportsPerVersion = get_summary_data($filter);
    uksort($reportsPerVersion, 'version_compare');
    $maxReportDate = 0;
    foreach ($reportsPerVersion as $version => $line) {
        if (version_compare($version, '5.3.8', '<')) {
            continue;
        }
        $tmLastReport = strtotime($line['lastReport']);
        if ($maxReportDate < $tmLastRport) $maxReportDate = $tmLastReport;
           echo '<tr>';
           echo '<td><a href="run_tests.php?version=', urlencode($version), '">',
             htmlentities($version).'</a></td>';
           echo '<td align="right">', intval($line['nbReports']), '</td>';
           echo '<td align="right">', intval($line['nbFailingTests']), '</td>';
           echo '<td align="right">', intval($line['nbFailures']), '</td>';
           echo "<td nowrap align=\"right\" sorttable_customkey=\"$tmLastReport\">",
                format_readable_date($tmLastReport),
                '</td>';
           echo "</tr>\n";
    }
    echo <<<HTML
</tbody>
</table>
<p>(<a href="run_tests.php?summary_filter=0">Show all versions</a> |
    <a href="run_tests.php">Show stable and current dev only</a>)</p>
HTML;

    return $maxReportDate;
}

function outputTestReportsForVersion(string $getVersion) {
    outputReportTitle("PHP Test Reports For PHP Version $getVersion");
    $isDevVersion = substr($getVersion, -4) === '-dev';

    $limit = intval($_GET['limit'] ?? 0);
    if ($limit <= 0) {
        $limit = 50;
    }

    $dbFile = __DIR__ . "/db/{$getVersion}.sqlite";
    file_exists($dbFile) or die('no data for this version');

    $database = new SQLite3($dbFile, SQLITE3_OPEN_READONLY);
    ($database instanceof SQLite3) or die("Error opening DB file: ".$database->lastErrorMsg());

    $failedTestsArray = [];

    // Do we add expected failed ?
    if (($_GET['expect'] ?? 0) == 1) {
        $query = 'SELECT \'xfail\' as xfail, test_name,COUNT(expectedfail.id) as cpt,\'-\' as variations, 
                datetime(date) as date FROM expectedfail,reports WHERE expectedfail.id_report = reports.id 
                GROUP BY test_name ORDER BY cpt DESC LIMIT :limit';
        $stmt = $database->prepare($query);
        $stmt->bindValue(':limit', $limit, SQLITE3_INTEGER);
        $q = @$stmt->execute();
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
            GROUP BY failed.test_name ORDER BY cpt DESC LIMIT :limit';
    $stmt = $database->prepare($query);
    $stmt->bindValue(':limit', $limit, SQLITE3_INTEGER);
    $q = @$stmt->execute();
    $q or die("Error querying DB (error ".$database->lastErrorCode()."): ".$database->lastErrorMsg());
    while ($tab = $q->fetchArray(SQLITE3_ASSOC)) {
        $failedTestsArray[] = $tab;
    }
    $database->close();

    // Variables interpolated in the following heredoc.
    $getVersionURL = urlencode($getVersion);
    $expectCHECKED = (($_GET['expect'] ?? 0) == 1) ? ' CHECKED' : '';
    $CIQAcolumn = $isDevVersion ? '<th>CIQA status</th>' : '';
    echo <<<HTML
<style>
#testList td {
    padding: 3px;
}
</style>
<script>
function changeExpect()
{
    var check = document.getElementById('expect').checked;
    if (check == true) {
        document.location.href = 'run_tests.php?version=$getVersionURL&expect=1';
    } else {
        document.location.href = 'run_tests.php?version=$getVersionURL';
    }
}
</script>
<input type="checkbox" id="expect" onClick="javascript:changeExpect()" $expectCHECKED />
<small>Show XFAIL</small><br />

<table id="testList" class="sortable" style="margin-top:10px; width: 800px; border-collapse: collapse">
    <thead>
     <tr>
     <th>Test name</th>
     <th>Count</th>
     <th>Variations</th>
     <th>Last report date</th>
     $CIQAcolumn
     <th>&nbsp;</th>
    </tr>
    </thead>
    <tbody>
HTML;

    $maxReportDate = 0;
    foreach ($failedTestsArray as $i => $line) {
        $tmDate = strtotime($line['date']);
        if ($maxReportDate < $tmDate) $maxReportDate = $tmDate;

        $style = ($i % 2) ? ' style="background-color: #ffcc66"' : '';
        echo " <tr{$style}><td>";
        if (isset($line['xfail'])) { echo '[XFAIL] '; }
        echo htmlentities($line['test_name']), '</td>';
        echo '<td align="right">', htmlentities($line['cpt']), '</td>';
        echo '<td align="right">', htmlentities($line['variations']), '</td>';
        echo "<td align=\"right\" sorttable_customkey=\"$tmDate\">",
              format_readable_date($tmDate),
              '</td>';
        if ($isDevVersion) {
            $style = 'background-color: grey';
             $textCI = '&nbsp;';
             if (!array_key_exists('success', $line)) {
                // probably xfail
             } elseif ($line['success'] === null) {
                // no success. Check fail ?
                if (isset($line['failedci'])) {
                    $style = 'background-color: #c00000';
                    $textCI = 'FAIL';
                 }
             } else {
                // success
                $style = "background-color: #00c000";
                $textCI = 'PASS';
             }

             echo "<td style=\"$style\" align=\"center\">$textCI</td>";
         }
         echo '<td>';
         if (!isset($line['xfail'])) {
             echo '<a href="viewreports.php?version='.$getVersion.'&amp;test='.urlencode($line['test_name']).'">
             <img src="report.png" title="View reports" border="0" /></a>';
         }
         echo '</td>';
         echo '</tr>'."\n";
    }
    echo "</tbody></table>\n";

    if (count($failedTestsArray) >= $limit) {
        echo '<i>There are more failing tests ';
        echo '(<a href="run_tests.php?version=' . $getVersion . '&limit=1000">view all)</i>';
    } else {
        echo '<i>View only the most common failed tests ';
        echo '(<a href="run_tests.php?version=' . $getVersion . '&limit=50">view 50)</i>';
    }

    return $maxReportDate;
}
