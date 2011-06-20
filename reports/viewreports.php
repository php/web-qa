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

// sanitize
if (!preg_match('@^[a-zA-Z\.0-9\-_/]{1,}$@', $_GET['test'])) {
    exit('Invalid test');
}

if (!is_valid_php_version($_GET['version'], $QA_RELEASES)) {
    exit('invalid version');
}

$testName = $_GET['test'];
$version  = $_GET['version'];

$dbFile = dirname(__FILE__).'/db/'.$version.'.sqlite';
$siteUpdate =  date("D M d H:i:s Y T", filemtime($dbFile))."<br />\n";
$database = new SQLite3($dbFile, SQLITE3_OPEN_READONLY);

if (!$database) {
    die("Error: Impossible to open, check permissions");
}

// GET infos from DB
$query = 'SELECT id,signature, COUNT(*) as cpt, output, diff FROM failed 
WHERE test_name="'.$database->escapeString($testName).'"
GROUP BY diff ORDER BY COUNT(*) desc';

$q = $database->query($query);
$allDiffArray = array();
$sumCount = 0;
while ($tab = $q->fetchArray(SQLITE3_ASSOC)) {
    $allDiffArray[] = $tab;
    $sumCount += $tab['cpt'];
}
// We stop everything
$database->close();



//URL test
if (substr($version, 0, 3) == '5.2') {
    $urlTest = 'http://svn.php.net/viewvc/php/php-src/branches/PHP_5_2/'.
                ltrim($testName, '/').'?view=markup';
} elseif (substr($version, 0, 3) == '5.3') {
    $urlTest = 'http://svn.php.net/viewvc/php/php-src/branches/PHP_5_3/'.
                ltrim($testName, '/').'?view=markup';
} elseif (substr($version, 0, 3) == '5.4') {
    $urlTest = 'http://svn.php.net/viewvc/php/php-src/branches/PHP_5_4/'.
                ltrim($testName, '/').'?view=markup';
} else {
    $urlTest = '';
}

// BUG url
if (preg_match('@bug([0-9]{1,}).phpt$@', $testName, $preg)) {
    $bugUrl = 'http://bugs.php.net/'.$preg[1];
} else {
    $bugUrl = '';
}




$TITLE = "Reports for test ".$testName;
common_header();
?>
<script src="sorttable.js"></script>
<div style="margin:10px">
<h1><a href="/reports/">
<img title="Go back home" src="home.png" border="0" 
style="vertical-align:middle;" /></a>
<?php
echo 'Test: '.$testName.' - Version '.$version.' &nbsp; &nbsp; ';
if ($urlTest != '') {
   echo '<a target="_blank" href="'.$urlTest.'">';
   echo '<img src="phpsource.png"  title="View test source" /></a> ';
}
if ($bugUrl != '') {
   echo '&nbsp; &nbsp; <a target="_blank" href="'.$bugUrl.'">';
   echo '<img src="bug.png" title="View bug overview" /></a>';
}
?></h1>

<strong><em>
<?php
$count = count($allDiffArray);

if ($count === 1) {
    echo "There is 1 diff reported by users for this test.";
} else {
    echo "There are $count different diffs reported by users for this test.";
}
?>
</em></strong>
<br /><br />
<style>
.diffClass {
    overflow: auto; 
    max-height: 200px; 
    max-width: 100%;
    border: 1px solid #c0c0c0;
    padding-left: 5px;
}
.diffplus {
    background-color: #bbffbb;
    clear: both;
    font-family: monospace;
}
.diffminus {
    background-color: #ffbbbb;
    clear: both;
    font-family: monospace;
}
</style>
<table width="100%">
 <thead>
  <tr>
   <th>Count</th>
   <th>Diff</th>
  <!-- <th>Complete output</th> -->
  </tr>
 </thead>
<?php
$i = 0;
foreach ($allDiffArray as $diff) {
    echo " <tr>\n    <td align=\"center\" width=\"20\"><b>".$diff['cpt'].' (';
    echo round($diff['cpt']/$sumCount*100)."%)</b><br />";
    echo '<a href="details.php?version='.$version.'&signature=';
    echo bin2hex($diff['signature']).'">';
    echo '<img src="detail.png" border="0" title="View users configurations" /></a></td>';
    echo "\n    <td>\n";
    echo '<div class="diffClass">';
    $diffExploded = explode("\x0d", $diff['diff']);
    foreach ($diffExploded as $line) {
        if (preg_match('@([0-9]{2,})(\-{1}) @', $line)) {
            echo '<div class="diffminus">'.htmlentities($line).'</div>'."\n";
    
        } elseif (preg_match('@[0-9]{2,}[\+]{1,} @', $line)) {
            echo '<div class="diffplus">'.htmlentities($line).'</div>'."\n";
            
        } else {
            // Should not happen. But print it anyway
            echo $line;
        }
    }
    echo '</div></td>'."\n  ";
    
    // Complete output will be available in the future (present in DB file)
    //echo '<td width="80" align="center"><a href="#">View complete output</a></td>';
    
    echo '</tr>'."\n";
    echo '<tr><td colspan="2" style="background-color: #c0c0c0;height:1px"></td></tr>';
    $i++;
    if ($i > 20) break;
}
?>
</table>
</div>
<?php
$siteUpdate .= " Generated in ".round((microtime(true)-$startTime)*1000)." ms";
common_footer();
