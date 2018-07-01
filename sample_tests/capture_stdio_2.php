<?php
include("../include/functions.php");

$TITLE = "Sample Test [PHP-QAT: Quality Assurance Team]";
$SITE_UPDATE = date("D M d H:i:s Y T", filectime(__FILE__));

common_header();
?>

<div style="padding: 10px">
<h1>Sample Test: capture_stdio_2.phpt</h1>
<p>Back to &quot;<a href="../phpt_details.php">PHPT Test File Layout</a>&quot;</p>
<pre>
--TEST--
Test covering the I/O stdin and stderr streams.
--DESCRIPTION--
This tests checks if the output of stdin and stderr I/O streams match the
expected content.
--CAPTURE_STDIO--
STDIN STDOUT
--FILE--
&lt;?php
echo &quot;Hello, world. This is sent to the stdout I/O stream\n&quot;;
fwrite(STDERR, &quot;This is error sent to the stderr I/O stream\n&quot;);
?&gt;
--EXPECT--
Hello, world. This is sent to the stdout I/O stream
</pre>
<p>Back to &quot;<a href="../phpt_details.php">PHPT Test File Layout</a>&quot;</p>
</div>

<?php
common_footer();
?>
