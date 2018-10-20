<?php
include("../include/functions.php");

$TITLE = "Sample Test [PHP-QAT: Quality Assurance Team]";
$SITE_UPDATE = date("D M d H:i:s Y T", filectime(__FILE__));

common_header();
?>

<div style="padding: 10px">
<h1>Sample Test: file012.inc</h1>
<p>Back to &quot;<a href="../../phpt_details.php">PHPT Test File Layout</a>&quot;</p>
<pre>&lt;?php
  echo &quot;hello world\n&quot;;
?&gt;
</pre>
<p>Back to &quot;<a href="../phpt_details.php">PHPT Test File Layout</a>&quot;</p>
</div>

<?php
common_footer();
?>
