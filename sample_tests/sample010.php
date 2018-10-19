<?php
include("../include/functions.php");

$TITLE = "Sample Test [PHP-QAT: Quality Assurance Team]";
$SITE_UPDATE = date("D M d H:i:s Y T", filectime(__FILE__));

common_header();
?>

<div style="padding: 10px">
<h1>Sample Test: sample010.phpt</h1>
<p>Back to &quot;<a href="../phpt_details.php">PHPT Test File Layout</a>&quot;</p>
<pre>--TEST--
getopt#005 (Required values)
--ARGS--
--arg value --arg=value -avalue -a=value -a value
--INI--
register_argc_argv=On
variables_order=GPS
--FILE--
&lt;?php
  var_dump(getopt(&quot;a:&quot;, array(&quot;arg:&quot;)));
?&gt;
--EXPECT--
array(2) {
  [&quot;arg&quot;]=&gt;
  array(2) {
    [0]=&gt;
    string(5) &quot;value&quot;
    [1]=&gt;
    string(5) &quot;value&quot;
  }
  [&quot;a&quot;]=&gt;
  array(3) {
    [0]=&gt;
    string(5) &quot;value&quot;
    [1]=&gt;
    string(5) &quot;value&quot;
    [2]=&gt;
    string(5) &quot;value&quot;
  }
}


</pre>
<p>Back to &quot;<a href="../phpt_details.php">PHPT Test File Layout</a>&quot;</p>
</div>

<?php
common_footer();
?>
