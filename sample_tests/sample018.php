<?php
include("../include/functions.php");

$TITLE = "Sample Test [PHP-QAT: Quality Assurance Team]";
$SITE_UPDATE = date("D M d H:i:s Y T", filectime(__FILE__));

common_header();
?>

<div style="padding: 10px">
<h1>Sample Test: sample018.phpt</h1>
<p>Back to &quot;<a href="../phpt_details.php">PHPT Test File Layout</a>&quot;</p>
<pre>--TEST--
Phar front controller rewrite access denied [cache_list]
--INI--
default_charset=UTF-8
phar.cache_list={PWD}/frontcontroller10.php
--SKIPIF--
&lt;?php if (!extension_loaded(&quot;phar&quot;)) die(&quot;skip&quot;); ?&gt;
--ENV--
SCRIPT_NAME=/frontcontroller10.php
REQUEST_URI=/frontcontroller10.php/hi
PATH_INFO=/hi
--FILE_EXTERNAL--
files/frontcontroller4.phar
--EXPECTHEADERS--
Content-type: text/html; charset=UTF-8
Status: 403 Access Denied
--EXPECT--
&lt;html&gt;
 &lt;head&gt;
  &lt;title&gt;Access Denied&lt;/title&gt;
 &lt;/head&gt;
 &lt;body&gt;
  &lt;h1&gt;403 - File /hi Access Denied&lt;/h1&gt;
 &lt;/body&gt;
&lt;/html&gt;
</pre>
<p>Back to &quot;<a href="../phpt_details.php">PHPT Test File Layout</a>&quot;</p>
</div>

<?php
common_footer();
?>
