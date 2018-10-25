<?php
error_reporting(E_ALL);
include("include/functions.php");

$TITLE = "PHP: QA: PFTT";
$SITE_UPDATE = date("D M d H:i:s Y T", filectime(__FILE__));

common_header(NULL, $TITLE);

?>

<img src="howto_phpt.png" />

<p><strong>PFTT Command</strong> - Run this command in the <b>PFTT Shell</b> to reproduce the same tests. Use the `<b>rg</b>` command to get the same release if you don't already have it. Download and install PFTT from <a href="https://qa.php.net/pftt.php" target="_blank">https://qa.php.net/pftt.php</a>.</p>

<p><strong>Scenario Set</strong> - Scenarios that are tested (CLI, Apache mod_php ; Opcache, Filesystem, etc...)</p>

<p><strong>FAILED</strong> - PHPT tests that failed</p>
<p><strong>TIMEOUT</strong> - PHPT tests that did not finish after a minute</p>
<p><strong>CRASH</strong> - PHPT tests that CRASHed PHP</p>
<p><strong>SKIP</strong> - PHPT test that was not run. Should minimize this count as much as possible for better code coverage</p>
<p><strong>XSKIP</strong> - PHPT test that could not be run on OS. It is ok to skip these tests (whereas SKIP tests should be run if possible)</p>

<p>Report compares ERROR, FAILURE, TIMEOUT, CRASH and PASS for two PHP Builds, the <strong>Base Build</strong> with the <strong>Test Build</strong>. A +X indicates the count increased from Base to Test. A -X indicates the count decreased from Base to Test. If the difference is <font color="green">good</font>, it is shown in <font color="green">green</font> (fe increase in PASS, decrease in FAIL). If the difference is <font color="red">bad</font>, it is shown in <font color="red">red</font> (fe increase in FAIL).</p>

<p><a href="https://git.php.net/?p=pftt2.git;a=blob;f=src/com/mostc/pftt/model/core/EPhptTestStatus.java;h=9c0e00a92b05e1f0bd21601e197ccb4466e2b6d4;hb=HEAD" target="_blank">Full info on PHPT Test Statuses</a></p>

<p><strong>Result-Pack</strong> All the test logs are compressed into result-packs, which can be downloaded using the two links in the report.</p>

<?php
common_footer();
?>
