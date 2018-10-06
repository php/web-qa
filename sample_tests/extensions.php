<?php
include("../include/functions.php");

$TITLE = "Sample Test [PHP-QAT: Quality Assurance Team]";
$SITE_UPDATE = date("D M d H:i:s Y T", filectime(__FILE__));

common_header();
?>

<div style="padding: 10px">
<h1>Sample Test: extensions.phpt</h1>
<p>Back to &quot;<a href="../phpt_details.php">PHPT Test File Layout</a>&quot;</p>

<pre>--TEST--
phpt EXTENSIONS directive with shared extensions
--DESCRIPTION--
This test covers the presence of some loaded extensions with a list of additional
extensions to be loaded when running test.
--EXTENSIONS--
curl
imagick
tokenizer
--FILE--
&lt;?php
var_dump(extension_loaded(&apos;curl&apos;));
var_dump(extension_loaded(&apos;imagick&apos;));
var_dump(extension_loaded(&apos;tokenizer&apos;));
?&gt;
--EXPECT--
bool(true)
bool(true)
bool(true)
</pre>

<p>Back to &quot;<a href="../phpt_details.php">PHPT Test File Layout</a>&quot;</p>
</div>

<?php
common_footer();
?>
