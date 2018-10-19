<?php
include("../include/functions.php");

$TITLE = "Sample Test [PHP-QAT: Quality Assurance Team]";
$SITE_UPDATE = date("D M d H:i:s Y T", filectime(__FILE__));

common_header();
?>

<div style="padding: 10px">
<h1>Sample Test: sample019.phpt</h1>
<p>Back to &quot;<a href="../phpt_details.php">PHPT Test File Layout</a>&quot;</p>
<pre>--TEST--
bzopen() and invalid parameters
--SKIPIF--
&lt;?php if (!extension_loaded(&quot;bz2&quot;)) print &quot;skip&quot;; ?&gt;
--FILE--
&lt;?php

var_dump(bzopen());
var_dump(bzopen(&quot;&quot;, &quot;&quot;));
var_dump(bzopen(&quot;&quot;, &quot;r&quot;));
var_dump(bzopen(&quot;&quot;, &quot;w&quot;));
var_dump(bzopen(&quot;&quot;, &quot;x&quot;));
var_dump(bzopen(&quot;&quot;, &quot;rw&quot;));
var_dump(bzopen(&quot;no_such_file&quot;, &quot;r&quot;));

$fp = fopen(__FILE__,&quot;r&quot;);
var_dump(bzopen($fp, &quot;r&quot;));

echo &quot;Done\n&quot;;
?&gt;
--EXPECTF--
Warning: bzopen() expects exactly 2 parameters, 0 given in %s on line %d
NULL

Warning: bzopen(): &#039;&#039; is not a valid mode for bzopen(). Only &#039;w&#039; and &#039;r&#039; are supported. in %s on line %d
bool(false)

Warning: bzopen(): filename cannot be empty in %s on line %d
bool(false)

Warning: bzopen(): filename cannot be empty in %s on line %d
bool(false)

Warning: bzopen(): &#039;x&#039; is not a valid mode for bzopen(). Only &#039;w&#039; and &#039;r&#039; are supported. in %s on line %d
bool(false)

Warning: bzopen(): &#039;rw&#039; is not a valid mode for bzopen(). Only &#039;w&#039; and &#039;r&#039; are supported. in %s on line %d
bool(false)

Warning: bzopen(no_such_file): failed to open stream: No such file or directory in %s on line %d
bool(false)
resource(%d) of type (stream)
Done
</pre>
<p>Back to &quot;<a href="../phpt_details.php">PHPT Test File Layout</a>&quot;</p>
</div>

<?php
common_footer();
?>
