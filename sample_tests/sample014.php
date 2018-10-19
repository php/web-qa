<?php
include("../include/functions.php");

$TITLE = "Sample Test [PHP-QAT: Quality Assurance Team]";
$SITE_UPDATE = date("D M d H:i:s Y T", filectime(__FILE__));

common_header();
?>

<div style="padding: 10px">
<h1>Sample Test: sample014.phpt</h1>
<p>Back to &quot;<a href="../phpt_details.php">PHPT Test File Layout</a>&quot;</p>
<pre>--TEST--
MySQL
--SKIPIF--
&lt;?php # vim:ft=php
if (!extension_loaded(&#039;pdo&#039;) || !extension_loaded(&#039;pdo_mysql&#039;)) print &#039;skip not loaded&#039;;
?&gt;
--REDIRECTTEST--
# magic auto-configuration

$config = array(
  &#039;TESTS&#039; =&gt; &#039;ext/pdo/tests&#039;
);

if (false !== getenv(&#039;PDO_MYSQL_TEST_DSN&#039;)) {
  # user set them from their shell
  $config[&#039;ENV&#039;][&#039;PDOTEST_DSN&#039;] = getenv(&#039;PDO_MYSQL_TEST_DSN&#039;);
  $config[&#039;ENV&#039;][&#039;PDOTEST_USER&#039;] = getenv(&#039;PDO_MYSQL_TEST_USER&#039;);
  $config[&#039;ENV&#039;][&#039;PDOTEST_PASS&#039;] = getenv(&#039;PDO_MYSQL_TEST_PASS&#039;);
  if (false !== getenv(&#039;PDO_MYSQL_TEST_ATTR&#039;)) {
    $config[&#039;ENV&#039;][&#039;PDOTEST_ATTR&#039;] = getenv(&#039;PDO_MYSQL_TEST_ATTR&#039;);
  }
} else {
  $config[&#039;ENV&#039;][&#039;PDOTEST_DSN&#039;] = &#039;mysql:host=localhost;dbname=test&#039;;
  $config[&#039;ENV&#039;][&#039;PDOTEST_USER&#039;] = &#039;root&#039;;
  $config[&#039;ENV&#039;][&#039;PDOTEST_PASS&#039;] = &#039;&#039;;
}

return $config;
</pre>
<p>Back to &quot;<a href="../phpt_details.php">PHPT Test File Layout</a>&quot;</p>
</div>

<?php
common_footer();
?>
