<?php
error_reporting(E_ALL);
include("include/functions.php");

$TITLE = "PHP: QA: PFTT";
$SITE_UPDATE = date("D M d H:i:s Y T", filectime(__FILE__));

common_header(NULL, $TITLE);

?>

<p><img src="howto_phpunit.png" /></p>

<p><strong>Application</strong> - Application tested (Symfony, Joomla-Platform, Drupal, Mediawiki, Wordpress)</p>
<p><strong>Scenario Set</strong> - Scenarios that are tested (CLI, Apache mod_php ; Opcache, Filesystem, etc...)</p>

<p><strong>ERROR</strong> - PhpUnit tests that finished with Error(s)</p>
<p><strong>FAILURE</strong> - PhpUnit tests that failed</p>
<p><strong>TIMEOUT</strong> - Tests that did not finish after the maximum amount of time passed (usually one minute)</p>
<p><strong>CRASH</strong> - Tests that Crashed PHP</p>

<p>Report compares ERROR, FAILURE, TIMEOUT, CRASH and PASS for two PHP Builds, the <strong>Base Build</strong> with the <strong>Test Build</strong>. A +X indicates the count increased from Base to Test. A -X indicates the count decreased from Base to Test. If the difference is <font color="green">good</font>, it is shown in <font color="green">green</font> (fe increase in PASS, decrease in ERROR). If the difference is <font color="red">bad</font>, it is shown in <font color="red">red</font> (fe increase in FAILURE).</p>

<p><a href="https://git.php.net/?p=pftt2.git;a=blob;f=src/com/mostc/pftt/model/app/EPhpUnitTestStatus.java;h=31aa09ba8ee577603af9f22d94f78c0ff830c038;hb=HEAD" target="_blank">Full Info on PFTT's PHPUnit Test Statuses</a></p>

<p><strong>Result-Pack</strong> All the test logs are compressed into result-packs, which can be downloaded using the two links in the report.</p>

<?php
common_footer();
?>
