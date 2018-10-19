<?php
include("../include/functions.php");

$TITLE = "Sample Test [PHP-QAT: Quality Assurance Team]";
$SITE_UPDATE = date("D M d H:i:s Y T", filectime(__FILE__));

common_header();
?>

<div style="padding: 10px">
<h1>Sample Test: sample013.phpt</h1>
<p>Back to &quot;<a href="../phpt_details.php">PHPT Test File Layout</a>&quot;</p>
<pre>--TEST--
SQLite2
--SKIPIF--
&lt;?php # vim:ft=php
if (!extension_loaded(&#039;pdo&#039;) || !extension_loaded(&#039;sqlite&#039;)) print &#039;skip&#039;; ?&gt;
--REDIRECTTEST--
return array(
  &#039;ENV&#039; =&gt; array(
      &#039;PDOTEST_DSN&#039; =&gt; &#039;sqlite2::memory:&#039;
    ),
  &#039;TESTS&#039; =&gt; &#039;ext/pdo/tests&#039;
  );
</pre>
<p>Back to &quot;<a href="../phpt_details.php">PHPT Test File Layout</a>&quot;</p>
</div>

<?php
common_footer();
?>
