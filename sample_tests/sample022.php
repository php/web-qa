<?php
include("../include/functions.php");

$TITLE = "Sample Test [PHP-QAT: Quality Assurance Team]";
$SITE_UPDATE = date("D M d H:i:s Y T", filectime(__FILE__));

common_header();
?>

<div style="padding: 10px">
<h1>Sample Test: sample022.phpt</h1>
<p>Back to &quot;<a href="../phpt_details.php">PHPT Test File Layout</a>&quot;</p>
<pre>--TEST--
shm_detach() tests
--SKIPIF--
&lt;?php if (!extension_loaded(&quot;sysvshm&quot;)) print &quot;skip&quot;; ?&gt;
--FILE--
&lt;?php

$key = ftok(__DIR__.&#039;/003.phpt&#039;, &#039;q&#039;);

var_dump(shm_detach());
var_dump(shm_detach(1,1));

$s = shm_attach($key);

var_dump(shm_detach($s));
var_dump(shm_detach($s));
shm_remove($s);

var_dump(shm_detach(0));
var_dump(shm_detach(1));
var_dump(shm_detach(-1));

echo &quot;Done\n&quot;;
?&gt;
--CLEAN--
&lt;?php
$key = ftok(__DIR__.&quot;/003.phpt&quot;, &#039;q&#039;);
$s = shm_attach($key);
shm_remove($s);
?&gt;
--EXPECTF--
Warning: shm_detach() expects exactly 1 parameter, 0 given in %ssample022.php on line %d
NULL

Warning: shm_detach() expects exactly 1 parameter, 2 given in %ssample022.php on line %d
NULL
bool(true)

Warning: shm_detach(): %d is not a valid sysvshm resource in %ssample022.php on line %d
bool(false)

Warning: shm_remove(): %d is not a valid sysvshm resource in %ssample022.php on line %d

Warning: shm_detach() expects parameter 1 to be resource, integer given in %ssample022.php on line %d
NULL

Warning: shm_detach() expects parameter 1 to be resource, integer given in %ssample022.php on line %d
NULL

Warning: shm_detach() expects parameter 1 to be resource, integer given in %ssample022.php on line %d
NULL
Done
</pre>
<p>Back to &quot;<a href="../phpt_details.php">PHPT Test File Layout</a>&quot;</p>
</div>

<?php
common_footer();
?>
