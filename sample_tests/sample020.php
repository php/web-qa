<?php
include("../include/functions.php");

$TITLE = "Sample Test [PHP-QAT: Quality Assurance Team]";
$SITE_UPDATE = date("D M d H:i:s Y T", filectime(__FILE__));

common_header();
?>

<div style="padding: 10px">
<h1>Sample Test: sample020.phpt</h1>
<p>Back to &quot;<a href="../phpt_details.php">PHPT Test File Layout</a>&quot;</p>
<pre>--TEST--
Bug #42082 (NodeList length zero should be empty)
--FILE--
&lt;?php
$doc = new DOMDocument();
$xpath = new DOMXPath($doc);
$nodes = $xpath-&gt;query(&#039;*&#039;);
var_dump($nodes);
var_dump($nodes-&gt;length);
$length = $nodes-&gt;length;
var_dump(empty($nodes-&gt;length), empty($length));

$doc-&gt;loadXML(&quot;&lt;element&gt;&lt;/element&gt;&quot;);
var_dump($doc-&gt;firstChild-&gt;nodeValue, empty($doc-&gt;firstChild-&gt;nodeValue), isset($doc-&gt;firstChild-&gt;nodeValue));
var_dump(empty($doc-&gt;nodeType), empty($doc-&gt;firstChild-&gt;nodeType))
?&gt;
--EXPECTF--
object(DOMNodeList)#%d (0) {
}
int(0)
bool(true)
bool(true)
string(0) &quot;&quot;
bool(true)
bool(true)
bool(false)
bool(false)</pre>
<p>Back to &quot;<a href="../phpt_details.php">PHPT Test File Layout</a>&quot;</p>
</div>

<?php
common_footer();
?>
