<?php
include("../include/functions.php");

$TITLE = "Sample Test [PHP-QAT: Quality Assurance Team]";
$SITE_UPDATE = date("D M d H:i:s Y T", filectime(__FILE__));

common_header();
?>

<div style="padding: 10px">
<h1>Sample Test: sample008.phpt</h1>
<p>Back to &quot;<a href="../phpt_details.php">PHPT Test File Layout</a>&quot;</p>
<pre>--TEST--
GET/POST/REQUEST Test with input_filter
--SKIPIF--
&lt;?php if (!extension_loaded(&quot;filter&quot;)) die(&quot;skip&quot;); ?&gt;
--POST--
d=379
--GET--
ar[elm1]=1234&amp;ar[elm2]=0660&amp;a=0234
--FILE--
&lt;?php
$ret = filter_input(INPUT_GET, &#039;a&#039;, FILTER_VALIDATE_INT);
var_dump($ret);

$ret = filter_input(INPUT_GET, &#039;a&#039;, FILTER_VALIDATE_INT, array(&#039;flags&#039;=&gt;FILTER_FLAG_ALLOW_OCTAL));
var_dump($ret);

$ret = filter_input(INPUT_GET, &#039;ar&#039;, FILTER_VALIDATE_INT, array(&#039;flags&#039;=&gt;FILTER_REQUIRE_ARRAY));
var_dump($ret);

$ret = filter_input(INPUT_GET, &#039;ar&#039;, FILTER_VALIDATE_INT, array(&#039;flags&#039;=&gt;FILTER_FLAG_ALLOW_OCTAL|FILTER_REQUIRE_ARRAY));
var_dump($ret);

?&gt;
--EXPECT--
bool(false)
int(156)
array(2) {
  [&quot;elm1&quot;]=&gt;
  int(1234)
  [&quot;elm2&quot;]=&gt;
  bool(false)
}
array(2) {
  [&quot;elm1&quot;]=&gt;
  int(1234)
  [&quot;elm2&quot;]=&gt;
  int(432)
}
</pre>
<p>Back to &quot;<a href="../phpt_details.php">PHPT Test File Layout</a>&quot;</p>
</div>

<?php
common_footer();
?>
