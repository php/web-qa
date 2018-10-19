<?php
include("../include/functions.php");

$TITLE = "Sample Test [PHP-QAT: Quality Assurance Team]";
$SITE_UPDATE = date("D M d H:i:s Y T", filectime(__FILE__));

common_header();
?>

<div style="padding: 10px">
<h1>Sample Test: sample002.phpt</h1>
<p>Back to &quot;<a href="../phpt_details.php">PHPT Test File Layout</a>&quot;</p>
<pre>--TEST--
Test receipt of cookie data.
--CREDITS--
Zoe Slattery zoe@php.net
# TestFest Munich 2009-05-19
--COOKIE--
hello=World;goodbye=MrChips
--FILE--
&lt;?php
var_dump($_COOKIE);
?&gt;
--EXPECT--
array(2) {
  [&quot;hello&quot;]=&gt;
  string(5) &quot;World&quot;
  [&quot;goodbye&quot;]=&gt;
  string(7) &quot;MrChips&quot;
}
</pre>
<p>Back to &quot;<a href="../phpt_details.php">PHPT Test File Layout</a>&quot;</p>
</div>

<?php
common_footer();
?>
