<?php
include("../include/functions.php");

$TITLE = "Sample Test [PHP-QAT: Quality Assurance Team]";
$SITE_UPDATE = date("D M d H:i:s Y T", filectime(__FILE__));

common_header();
?>

<div style="padding: 10px">
<h1>Sample Test: sample027.phpt</h1>
<p>Back to &quot;<a href="../phpt_details.php">PHPT Test File Layout</a>&quot;</p>
<pre>--TEST--
SPL: ArrayIterator implementing RecursiveIterator
--FILE--
&lt;?php

$array = array(1, 2 =&gt; array(21, 22 =&gt; array(221, 222), 23 =&gt; array(231)), 3);

$dir = new RecursiveIteratorIterator(new RecursiveArrayIterator($array), RecursiveIteratorIterator::LEAVES_ONLY);

foreach ($dir as $file) {
	print &quot;$file\n&quot;;
}

?&gt;
===DONE===
&lt;?php exit(0); ?&gt;
--EXPECT--
1
21
221
222
231
3
</pre>
<p>Back to &quot;<a href="../phpt_details.php">PHPT Test File Layout</a>&quot;</p>
</div>

<?php
common_footer();
?>
