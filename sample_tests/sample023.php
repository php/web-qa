<?php
include("../include/functions.php");

$TITLE = "Sample Test [PHP-QAT: Quality Assurance Team]";
$SITE_UPDATE = date("D M d H:i:s Y T", filectime(__FILE__));

common_header();
?>

<div style="padding: 10px">
<h1>Sample Test: sample023.phpt</h1>
<p>Back to &quot;<a href="../phpt_details.php">PHPT Test File Layout</a>&quot;</p>
<pre>--TEST--
Bug #23894 (sprintf() decimal specifiers problem)
--FILE--
&lt;?php
$a = -12.3456;
$test = sprintf(&quot;%04d&quot;, $a);
var_dump($test, bin2hex($test));
$test = sprintf(&quot;% 13u&quot;, $a);
var_dump($test, bin2hex($test));
?&gt;
--EXPECTREGEX--
string\(4\) \&quot;-012\&quot;
string\(8\) \&quot;2d303132\&quot;
(string\(13\) \&quot;   4294967284\&quot;|string\(20\) \&quot;18446744073709551604\&quot;)
(string\(26\) \&quot;20202034323934393637323834\&quot;|string\(40\) \&quot;3138343436373434303733373039353531363034\&quot;)
</pre>
<p>Back to &quot;<a href="../phpt_details.php">PHPT Test File Layout</a>&quot;</p>
</div>

<?php
common_footer();
?>
