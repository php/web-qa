<?php
include("../include/functions.php");

$TITLE = "Sample Test [PHP-QAT: Quality Assurance Team]";
$SITE_UPDATE = date("D M d H:i:s Y T", filectime(__FILE__));

common_header();
?>

<div style="padding: 10px">
<h1>Sample Test: sample001.phpt</h1>
<p>Back to &quot;<a href="../phpt_details.php">PHPT Test File Layout</a>&quot;</p>
<pre>--TEST--
Test filter_input() with GET and POST data.
--DESCRIPTION--
This test covers both valid and invalid usages of
filter_input() with INPUT_GET and INPUT_POST data
and several different filter sanitizers.
--CREDITS--
Felipe Pena &lt;felipe@php.net&gt;
--INI--
precision=14
--SKIPIF--
&lt;?php if (!extension_loaded(&quot;filter&quot;)) die(&quot;Skipped: filter extension required.&quot;); ?&gt;
--GET--
a=&lt;b&gt;test&lt;/b&gt;&amp;b=https://example.com
--POST--
c=&lt;p&gt;string&lt;/p&gt;&amp;d=12345.7
--FILE--
&lt;?php
ini_set(&#039;html_errors&#039;, false);
var_dump(filter_input(INPUT_GET, &quot;a&quot;, FILTER_SANITIZE_STRIPPED));
var_dump(filter_input(INPUT_GET, &quot;b&quot;, FILTER_SANITIZE_URL));
var_dump(filter_input(INPUT_GET, &quot;a&quot;, FILTER_SANITIZE_SPECIAL_CHARS, array(1,2,3,4,5)));
var_dump(filter_input(INPUT_GET, &quot;b&quot;, FILTER_VALIDATE_FLOAT, new stdClass));
var_dump(filter_input(INPUT_POST, &quot;c&quot;, FILTER_SANITIZE_STRIPPED, array(5,6,7,8)));
var_dump(filter_input(INPUT_POST, &quot;d&quot;, FILTER_VALIDATE_FLOAT));
var_dump(filter_input(INPUT_POST, &quot;c&quot;, FILTER_SANITIZE_SPECIAL_CHARS));
var_dump(filter_input(INPUT_POST, &quot;d&quot;, FILTER_VALIDATE_INT));
var_dump(filter_var(new stdClass, &quot;d&quot;));
var_dump(filter_input(INPUT_POST, &quot;c&quot;, &quot;&quot;, &quot;&quot;));
var_dump(filter_var(&quot;&quot;, &quot;&quot;, &quot;&quot;, &quot;&quot;, &quot;&quot;));
var_dump(filter_var(0, 0, 0, 0, 0));
echo &quot;Done\n&quot;;
?&gt;
--EXPECTF--
string(4) &quot;test&quot;
string(19) &quot;https://example.com&quot;
string(27) &quot;&amp;#60;b&amp;#62;test&amp;#60;/b&amp;#62;&quot;

Notice: Object of class stdClass could not be converted to int in %ssample001.php on line %d
bool(false)
string(6) &quot;string&quot;
float(12345.7)
string(29) &quot;&amp;#60;p&amp;#62;string&amp;#60;/p&amp;#62;&quot;
bool(false)

Warning: filter_var() expects parameter 2 to be long, string given in %ssample001.php on line %d
NULL

Warning: filter_input() expects parameter 3 to be long, string given in %ssample001.php on line %d
NULL

Warning: filter_var() expects at most 3 parameters, 5 given in %ssample001.php on line %d
NULL

Warning: filter_var() expects at most 3 parameters, 5 given in %ssample001.php on line %d
NULL
Done
</pre>
<p>Back to &quot;<a href="../phpt_details.php">PHPT Test File Layout</a>&quot;</p>
</div>

<?php
common_footer();
?>
