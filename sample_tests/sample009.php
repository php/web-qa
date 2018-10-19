<?php
include("../include/functions.php");

$TITLE = "Sample Test [PHP-QAT: Quality Assurance Team]";
$SITE_UPDATE = date("D M d H:i:s Y T", filectime(__FILE__));

common_header();
?>

<div style="padding: 10px">
<h1>Sample Test: sample009.phpt</h1>
<p>Back to &quot;<a href="../phpt_details.php">PHPT Test File Layout</a>&quot;</p>
<pre>--TEST--
STDIN input
--FILE--
&lt;?php
var_dump(stream_get_contents(STDIN));
?&gt;
--STDIN--
fooBar
use this to input some thing to the php script
--EXPECT--
string(54) &quot;fooBar
use this to input some thing to the php script
&quot;
</pre>
<p>Back to &quot;<a href="../phpt_details.php">PHPT Test File Layout</a>&quot;</p>
</div>

<?php
common_footer();
?>
