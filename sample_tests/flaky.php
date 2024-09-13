<?php
include("../include/functions.php");

$TITLE = "Sample Test [PHP-QAT: Quality Assurance Team]";
$SITE_UPDATE = date("D M d H:i:s Y T", filectime(__FILE__));

common_header();
?>

<div style="padding: 10px">
<h1>Sample Test: sample001.phpt</h1>
<p>Back to &quot;<a href="../phpt_details.php">PHPT Test File Layout</a>&quot;</p>
<pre>--TEST--
Test hrtime() aligns with microtime()
--FLAKY--
This test frequently fails in CI
--FILE--
&lt;?php

$m0 = microtime(true);
$h0 = hrtime(true);
for ($i = 0; $i &lt; 1024*1024; $i++);
$h1 = hrtime(true);
$m1 = microtime(true);

$d0 = ($m1 - $m0)*1000000000.0;
$d1 = $h1 - $h0;

/* Relative uncertainty. */
$d = abs($d0 - $d1)/$d1;

if ($d &gt; 0.05) {
    print "FAIL, $d";
} else {
    print "OK, $d";
}

?&gt;
--EXPECTF--
OK, %f
</pre>
<p>Back to &quot;<a href="../phpt_details.php">PHPT Test File Layout</a>&quot;</p>
</div>

<?php
common_footer();
?>
