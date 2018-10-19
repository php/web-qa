<?php
include("../include/functions.php");

$TITLE = "Sample Test [PHP-QAT: Quality Assurance Team]";
$SITE_UPDATE = date("D M d H:i:s Y T", filectime(__FILE__));

common_header();
?>

<div style="padding: 10px">
<h1>Sample Test: sample003.phpt</h1>
<p>Back to &quot;<a href="../phpt_details.php">PHPT Test File Layout</a>&quot;</p>
<pre>--TEST--
session object deserialization
--SKIPIF--
&lt;?php include(&#039;<a href="skipif.php">skipif.inc</a>&#039;); ?&gt;
--INI--
session.use_cookies=0
session.cache_limiter=
register_globals=1
session.serialize_handler=php
session.save_handler=files
--FILE--
&lt;?php
error_reporting(E_ALL);

class foo {
	public $bar = &quot;ok&quot;;
	function method() { $this-&gt;yes++; }
}

session_id(&quot;abtest&quot;);
session_start();
session_decode(&#039;baz|O:3:&quot;foo&quot;:2:{s:3:&quot;bar&quot;;s:2:&quot;ok&quot;;s:3:&quot;yes&quot;;i:1;}arr|a:1:{i:3;O:3:&quot;foo&quot;:2:{s:3:&quot;bar&quot;;s:2:&quot;ok&quot;;s:3:&quot;yes&quot;;i:1;}}&#039;);

$baz-&gt;method();
$arr[3]-&gt;method();

var_dump($baz);
var_dump($arr);
session_destroy();
--EXPECT--
object(foo)#1 (2) {
  [&quot;bar&quot;]=&gt;
  string(2) &quot;ok&quot;
  [&quot;yes&quot;]=&gt;
  int(2)
}
array(1) {
  [3]=&gt;
  object(foo)#2 (2) {
    [&quot;bar&quot;]=&gt;
    string(2) &quot;ok&quot;
    [&quot;yes&quot;]=&gt;
    int(2)
  }
}
</pre>
<p>Back to &quot;<a href="../phpt_details.php">PHPT Test File Layout</a>&quot;</p>
</div>

<?php
common_footer();
?>
