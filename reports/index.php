<?php
include("../include/functions.php");

$SITE_UPDATE = date("D M d H:i:s Y T", filectime(__FILE__));

common_header();

?>

<p>QA reports and test data are generated using two different tools, <a href="run_tests.php">run-tests.php</a> and <a href="/pftt.php">PFTT</a>:</p>

<p>
<a href="run_tests.php">run-tests.php</a>  The standard tool for running PHPT tests against PHP core on the command-line (CLI scenario). Whenever users build PHP for install, they should run `make test`, which runs run-test.php on their build.
</p>

<p>
<a href="/pftt.php">PFTT</a>

The Php Full Test Tool (PFTT) is a cross-platform test tool for PHP Core and Applications developed by Microsoft, primarily for PHP on Microsoft Windows, Windows Server and Azure.
PFTT covers the PHP ecosystem and is designed for convenience, thoroughness and speed: PFTT can run PHPT and PhpUnit tests across a variety of scenarios, including on Apache.

</p>
<?php

common_footer();
?>
