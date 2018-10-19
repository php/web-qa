<?php
include("../include/functions.php");

$TITLE = "Sample Test [PHP-QAT: Quality Assurance Team]";
$SITE_UPDATE = date("D M d H:i:s Y T", filectime(__FILE__));

common_header();
?>

<div style="padding: 10px">
<h1>Sample Test: sample021.phpt</h1>
<p>Back to &quot;<a href="../phpt_details.php">PHPT Test File Layout</a>&quot;</p>
<pre>--TEST--
Math constants
--INI--
precision=14
--FILE--
&lt;?php
$constants = array(
    &quot;M_E&quot;,
    &quot;M_LOG2E&quot;,
    &quot;M_LOG10E&quot;,
    &quot;M_LN2&quot;,
    &quot;M_LN10&quot;,
    &quot;M_PI&quot;,
    &quot;M_PI_2&quot;,
    &quot;M_PI_4&quot;,
    &quot;M_1_PI&quot;,
    &quot;M_2_PI&quot;,
    &quot;M_SQRTPI&quot;,
    &quot;M_2_SQRTPI&quot;,
    &quot;M_LNPI&quot;,
    &quot;M_EULER&quot;,
    &quot;M_SQRT2&quot;,
    &quot;M_SQRT1_2&quot;,
    &quot;M_SQRT3&quot;
);
foreach($constants as $constant) {
    printf(&quot;%-10s: %s\n&quot;, $constant, constant($constant));
}
?&gt;
--EXPECTREGEX--
M_E       : 2.718281[0-9]*
M_LOG2E   : 1.442695[0-9]*
M_LOG10E  : 0.434294[0-9]*
M_LN2     : 0.693147[0-9]*
M_LN10    : 2.302585[0-9]*
M_PI      : 3.141592[0-9]*
M_PI_2    : 1.570796[0-9]*
M_PI_4    : 0.785398[0-9]*
M_1_PI    : 0.318309[0-9]*
M_2_PI    : 0.636619[0-9]*
M_SQRTPI  : 1.772453[0-9]*
M_2_SQRTPI: 1.128379[0-9]*
M_LNPI    : 1.144729[0-9]*
M_EULER   : 0.577215[0-9]*
M_SQRT2   : 1.414213[0-9]*
M_SQRT1_2 : 0.707106[0-9]*
M_SQRT3   : 1.732050[0-9]*

</pre>
<p>Back to &quot;<a href="../phpt_details.php">PHPT Test File Layout</a>&quot;</p>
</div>

<?php
common_footer();
?>
