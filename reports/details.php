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
include "../include/functions.php";
include "../include/release-qa.php";

// sanitize
if (!preg_match('@^[a-z0-9]{32}$@', $_GET['signature'])) {
    exit('Invalid signature');
}

if (!is_valid_php_version($_GET['version'], $QA_RELEASES)) {
    exit('invalid version');
}

$signature = $_GET['signature'];
$version  = $_GET['version'];

$dbFile = __DIR__.'/db/'.$version.'.sqlite';

$database = new SQLite3($dbFile, SQLITE3_OPEN_READONLY);

if (!$database) {
    die("Error opening DB file: ".$database->lastErrorMsg());
}

// GET infos from DB
$query = 'SELECT reports.* FROM failed JOIN reports ON reports.id=failed.id_report WHERE signature=:signature';
$stmt = $database->prepare($query);
$stmt->bindValue(':signature', hex2bin($signature), SQLITE3_BLOB);
$q = $stmt->execute();
$reportsArray = [];
while ($tab = $q->fetchArray(SQLITE3_ASSOC)) {
    $reportsArray[$tab['id']] = $tab;
}

$query = 'SELECT test_name FROM failed WHERE signature=:signature LIMIT 1';
$stmt = $database->prepare($query);
$stmt->bindValue(':signature', hex2bin($signature), SQLITE3_BLOB);
$tab = $database->query($query);
list($testName) = $tab->fetchArray(SQLITE3_NUM);

// We stop everything
$database->close();

$TITLE = "Report details";
common_header(['<meta name="robots" content="noindex">']);
?>
<script src="sorttable.js"></script>
<div style="margin:10px">
<h1><a href="/reports/">
<img title="Go back home" src="home.png" border="0" style="vertical-align:middle;" /></a>
List of reports associated</h1>
<b>Test name: </b><?php echo $testName; ?><br />
<b>Version: </b><?php echo $version; ?>
<br /><br />
<style>
#reportTable td {
    padding: 3px;
}
</style>
<script>
function switchVisibility(elem)
{
    if (elem.style.display == '' || elem.style.display == 'block') {
        elem.style.visibility = 'hidden';
        elem.style.display = 'none';
    } else {
        elem.style.visibility = 'visible';
        elem.style.display = 'block';
    }
}
</script>
<div id="reportLink"><a href="#" onClick="javascript:switchVisibility(document.getElementById('reportTable'));"><i>Show/Hide list of reports</i></a></div>
<table id="reportTable" class="sortable" style="visibility:hidden ; display: none">
 <thead>
 <tr>
   <th>Date</th>
   <th>Failed tests</th>
   <th>Email</th>
   <th>&nbsp;</th>
  </tr>
 </thead>
<?php
    foreach ($reportsArray as $report) {
        echo '  <tr>'."\n";
        echo '    <td sorttable_customkey="'.strtotime($report['date']).'">'.$report['date'].'</td>'."\n";
        echo '    <td align="right" width="50">'.$report['nb_failed'].'</td>'."\n";
        if ($report['user_email'] == 'ciqa') {
            echo '    <td><a href="http://ci.qa.php.net/" target="_blank">CI.QA.PHP.NET</a></td>'."\n";
        } else {
            echo '    <td>***'.strstr($report['user_email'], ' at ').'</td>'."\n";
        }

        echo '    <td><a href="details.php?version='.$version.'&signature='.$signature.'&idreport='.$report['id'].'">';
        echo '<img src="report.png" title="View phpinfo and environment" border="0" /></a></td>'."\n";
        echo '  </tr>'."\n";
    }

?>

</table>
<?php
if (isset($_GET['idreport'])) {
?>
<hr size="1" />
<br />
<b>Goto: <a href="#phpinfo">PHPInfo</a> &nbsp; &nbsp; <a href="#buildenv">Build environment</a></b><br />
<br />
<?php

    $idreport = (int) $_GET['idreport'];
    echo '<a name="phpinfo"></a><h2>PHPInfo</h2><pre>';
    echo htmlspecialchars($reportsArray[$idreport]['phpinfo'], ENT_QUOTES, 'UTF-8');
    echo '</pre><hr size=1 />';
    echo '<a name="buildenv"></a><h2>Build environment</h2><pre>';
    echo htmlspecialchars(str_replace(
        $reportsArray[$idreport]['user_email'],
        '*** (truncated on purpose) ***',
        $reportsArray[$idreport]['build_env']
    ), ENT_QUOTES, 'UTF-8');

}


echo '</div>';
$SITE_UPDATE = date('D M d H:i:s Y T', filemtime($dbFile)).
               "<br /> Generated in ".round((microtime(true)-$startTime)*1000)." ms";
common_footer();
