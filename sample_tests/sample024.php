<?php
include("../include/functions.php");

$TITLE = "Sample Test [PHP-QAT: Quality Assurance Team]";
$SITE_UPDATE = date("D M d H:i:s Y T", filectime(__FILE__));

common_header();
?>

<div style="padding: 10px">
<h1>Sample Test: sample024.phpt</h1>
<p>Back to &quot;<a href="../phpt_details.php">PHPT Test File Layout</a>&quot;</p>
<pre>--TEST--
DOMDocument::save  Test basic function of save method
--SKIPIF--
&lt;?php
require_once(&#039;skipif.inc&#039;);
?&gt;
--FILE--
&lt;?php
$doc = new DOMDocument(&#039;1.0&#039;);
$doc-&gt;formatOutput = true;

$root = $doc-&gt;createElement(&#039;book&#039;);

$root = $doc-&gt;appendChild($root);

$title = $doc-&gt;createElement(&#039;title&#039;);
$title = $root-&gt;appendChild($title);

$text = $doc-&gt;createTextNode(&#039;This is the title&#039;);
$text = $title-&gt;appendChild($text);

$temp_filename = __DIR__.&#039;/DomDocument_save_basic.tmp&#039;;

echo &#039;Wrote: &#039; . $doc-&gt;save($temp_filename) . &#039; bytes&#039;; // Wrote: 72 bytes
?&gt;
--CLEAN--
&lt;?php
  unlink(__DIR__.&#039;/DomDocument_save_basic.tmp&#039;);
?&gt;
--EXPECTF--
Wrote: 72 bytes

</pre>
<p>Back to &quot;<a href="../phpt_details.php">PHPT Test File Layout</a>&quot;</p>
</div>

<?php
common_footer();
?>
