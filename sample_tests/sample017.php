<?php
include("../include/functions.php");

$TITLE = "Sample Test [PHP-QAT: Quality Assurance Team]";
$SITE_UPDATE = date("D M d H:i:s Y T", filectime(__FILE__));

common_header();
?>

<div style="padding: 10px">
<h1>Sample Test: sample017.phpt</h1>
<p>Back to &quot;<a href="../phpt_details.php">PHPT Test File Layout</a>&quot;</p>
<pre>--TEST--
PDO Common: Bug #34630 (inserting streams as LOBs)
--SKIPIF--
&lt;?php # vim:ft=php
if (!extension_loaded(&#039;pdo&#039;)) die(&#039;skip&#039;);
$dir = getenv(&#039;REDIR_TEST_DIR&#039;);
if (false == $dir) die(&#039;skip no driver&#039;);
require_once $dir . &#039;pdo_test.inc&#039;;
PDOTest::skip();
?&gt;
--FILE--
&lt;?php
if (getenv(&#039;REDIR_TEST_DIR&#039;) === false) putenv(&#039;REDIR_TEST_DIR=&#039;.__DIR__ . &#039;/../../pdo/tests/&#039;);
require_once getenv(&#039;REDIR_TEST_DIR&#039;) . &#039;pdo_test.inc&#039;;
$db = PDOTest::factory();

$driver = $db-&gt;getAttribute(PDO::ATTR_DRIVER_NAME);
$is_oci = $driver == &#039;oci&#039;;

if ($is_oci) {
  $db-&gt;exec(&#039;CREATE TABLE test (id int NOT NULL PRIMARY KEY, val BLOB)&#039;);
} else {
  $db-&gt;exec(&#039;CREATE TABLE test (id int NOT NULL PRIMARY KEY, val VARCHAR(256))&#039;);
}
$db-&gt;setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$fp = tmpfile();
fwrite($fp, &quot;I am the LOB data&quot;);
rewind($fp);

if ($is_oci) {
  /* oracle is a bit different; you need to initiate a transaction otherwise
   * the empty blob will be committed implicitly when the statement is
   * executed */
  $db-&gt;beginTransaction();
  $insert = $db-&gt;prepare(&quot;insert into test (id, val) values (1, EMPTY_BLOB()) RETURNING val INTO :blob&quot;);
} else {
  $insert = $db-&gt;prepare(&quot;insert into test (id, val) values (1, :blob)&quot;);
}
$insert-&gt;bindValue(&#039;:blob&#039;, $fp, PDO::PARAM_LOB);
$insert-&gt;execute();
$insert = null;

$db-&gt;setAttribute(PDO::ATTR_STRINGIFY_FETCHES, true);
var_dump($db-&gt;query(&quot;SELECT * from test&quot;)-&gt;fetchAll(PDO::FETCH_ASSOC));

?&gt;
--XFAIL--
This bug might be still open on aix5.2-ppc64 and hpux11.23-ia64
--EXPECT--
array(1) {
  [0]=&gt;
  array(2) {
    [&quot;id&quot;]=&gt;
    string(1) &quot;1&quot;
    [&quot;val&quot;]=&gt;
    string(17) &quot;I am the LOB data&quot;
  }
}
</pre>
<p>Back to &quot;<a href="../phpt_details.php">PHPT Test File Layout</a>&quot;</p>
</div>

<?php
common_footer();
?>
