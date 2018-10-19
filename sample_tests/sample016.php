<?php
include("../include/functions.php");

$TITLE = "Sample Test [PHP-QAT: Quality Assurance Team]";
$SITE_UPDATE = date("D M d H:i:s Y T", filectime(__FILE__));

common_header();
?>

<div style="padding: 10px">
<h1>Sample Test: sample016.phpt</h1>
<p>Back to &quot;<a href="../phpt_details.php">PHPT Test File Layout</a>&quot;</p>
<pre>--TEST--
Test get variables with CGI binary
--GET--
hello=World&amp;goodbye=MrChips
--CGI--
--FILE--
&lt;?php
var_dump($_GET);
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
