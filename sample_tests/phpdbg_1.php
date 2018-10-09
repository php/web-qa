<?php
include("../include/functions.php");

$TITLE = "Sample Test [PHP-QAT: Quality Assurance Team]";
$SITE_UPDATE = date("D M d H:i:s Y T", filectime(__FILE__));

common_header();
?>

<div style="padding: 10px">
<h1>Sample Test: phpdbg_1.phpt</h1>
<p>Back to &quot;<a href="../phpt_details.php">PHPT Test File Layout</a>&quot;</p>
<pre>--TEST--
Test deleting breakpoints
--PHPDBG--
b 4
b del 0
b 5
r
b del 1
r
y
q
--EXPECTF--
[Successful compilation of %s]
prompt> [Breakpoint #0 added at %s:4]
prompt> [Deleted breakpoint #0]
prompt> [Breakpoint #1 added at %s:5]
prompt> 12
[Breakpoint #1 at %s:5, hits: 1]
>00005: echo $i++;
 00006: echo $i++;
 00007:&nbsp;
prompt> [Deleted breakpoint #1]
prompt> Do you really want to restart execution? (type y or n): 1234
[Script ended normally]
prompt>&nbsp;
--FILE--
&lt;?php
$i = 1;
echo $i++;
echo $i++;
echo $i++;
echo $i++;
</pre>
<p>Back to &quot;<a href="../phpt_details.php">PHPT Test File Layout</a>&quot;</p>
</div>

<?php
common_footer();
?>
