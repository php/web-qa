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

if (isset($_GET['debug'])) error_reporting(E_ALL);

$startTime = microtime(true);
include "../include/functions.php";

// test testName

// sanitize
if (!preg_match('@^[a-zA-Z\.0-9\-_/]{1,}$@', $_GET['test'])) {
    exit('Invalid test');
}
if (!preg_match('@^[0-9]{1}\.[0-9]{1}\.[0-9\.\-dev]{1,}$@', $_GET['version'])) {
    exit('invalid version');
}

$testName = $_GET['test'];
$version  = $_GET['version'];

$DBFILE = dirname(__FILE__).'/db/'.$version.'.sqlite';
$SITE_UPDATE =  date("D M d H:i:s Y T", filemtime($DBFILE))."<br />\n";
$database = new SQLite3($DBFILE, SQLITE3_OPEN_READONLY);

if (!$database) {
    $error = (file_exists($yourfile)) ? "Impossible to open, check permissions" : "Impossible to create, check permissions";
    die("Error: ".$error);
}

// GET infos from DB
$query = 'SELECT id,COUNT(*) as cpt, output, diff FROM failed WHERE signature=X\''.md5($version.'__'.$testName).'\'
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
if (substr($version, 0, 3) == '5.3') {
    $urlTest = 'http://svn.php.net/viewvc/php/php-src/branches/PHP_5_3/'.ltrim($testName, '/').'?view=markup';
} elseif (substr($version, 0, 3) == '5.2') {
    $urlTest = 'http://svn.php.net/viewvc/php/php-src/branches/PHP_5_2/'.ltrim($testName, '/').'?view=markup';
} else {
    $urlTest = '';
}

// BUG url
if (preg_match('@bug([0-9]{1,}).phpt$@', $testName, $preg)) {
    $BugUrl = 'http://bugs.php.net/'.$preg[1];
} else {
    $BugUrl = '';
}




$TITLE = "Reports for test ".$testName;
common_header();
echo '<script src="sorttable.js"></script><div style="margin:10px">';
echo '<h1>Test: '.$testName.' - Version '.$version.' &nbsp; &nbsp; ';
if ($urlTest != '') {
   echo '<a target="_blank" href="'.$urlTest.'"><img src="phpsource.png"  title="View test source on svn.php.net" /></a> ';
}
if ($BugUrl != '') {
   echo '&nbsp; &nbsp; <a target="_blank" href="'.$BugUrl.'"><img src="bug.png" title="View bug overview on bugs.php.net" /></a>';
}
?></h1>
<hr size="1" />
<b><i>There are <?php echo count($allDiffArray); ?> different diff reported by users for this test.</i></b><br />
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
}
.diffminus {
    background-color: #ffbbbb;
    clear: both;
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
    echo " <tr>\n    <td align=\"right\" width=\"20\"><b>".$diff['cpt'].' ('.round($diff['cpt']/$sumCount*100)."%)</b></td>\n    <td>";
    echo '<div class="diffClass"><pre>';
    $diff2 = explode("\x0d", $diff['diff']);
    foreach ($diff2 as $line) {
        if (preg_match('@([0-9]{2,})(\-{1}) @', $line)) {
                    echo '<div class="diffminus">'.htmlentities($line).'</div>';
    
              } elseif (preg_match('@[0-9]{2,}[\+]{1,} @', $line)) {
                    echo '<div class="diffplus">'.htmlentities($line).'</div>';
            
                } else echo $line;
    }
    echo '</pre></div></td>'."\n  ";
    
    //echo '<td width="80" align="center"><a href="#">View complete output</a></td>';
    
    echo '</tr>'."\n";
    $i++;
    if ($i > 20) break;
}
?>
</table>
</div>
<?php
$SITE_UPDATE .= " Generated in ".round((microtime(true)-$startTime)*1000)." ms";
common_footer();
