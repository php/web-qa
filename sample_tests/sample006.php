<?php
include("../include/functions.php");

$TITLE = "Sample Test [PHP-QAT: Quality Assurance Team]";
$SITE_UPDATE = date("D M d H:i:s Y T", filectime(__FILE__));

common_header();
?>

<div style="padding: 10px">
<h1>Sample Test: sample006.phpt</h1>
<p>Back to &quot;<a href="../phpt_details.php">PHPT Test File Layout</a>&quot;</p>
<pre>--TEST--
is_uploaded_file() function
--CREDITS--
Dave Kelsey &lt;d_kelsey@uk.ibm.com&gt;
--SKIPIF--
&lt;?php if (php_sapi_name()==&#039;cli&#039;) die(&#039;skip&#039;); ?&gt;
--POST_RAW--
Content-type: multipart/form-data, boundary=AaB03x

--AaB03x
content-disposition: form-data; name=&quot;field1&quot;

Joe Blow
--AaB03x
content-disposition: form-data; name=&quot;pics&quot;; filename=&quot;file1.txt&quot;
Content-Type: text/plain

abcdef123456789
--AaB03x--
--FILE--
&lt;?php
// uploaded file
var_dump(is_uploaded_file($_FILES[&#039;pics&#039;][&#039;tmp_name&#039;]));

// not an uploaded file
var_dump(is_uploaded_file($_FILES[&#039;pics&#039;][&#039;name&#039;]));

// not an uploaded file
var_dump(is_uploaded_file(&#039;random_filename.txt&#039;));

// not an uploaded file
var_dump(is_uploaded_file(&#039;__FILE__&#039;));

// Error cases
var_dump(is_uploaded_file());
var_dump(is_uploaded_file(&#039;a&#039;, &#039;b&#039;));

?&gt;
--EXPECTF--
bool(true)
bool(false)
bool(false)
bool(false)

Warning: is_uploaded_file() expects exactly 1 parameter, 0 given in %s on line %d
NULL

Warning: is_uploaded_file() expects exactly 1 parameter, 2 given in %s on line %d
NULL

</pre>
<p>Back to &quot;<a href="../phpt_details.php">PHPT Test File Layout</a>&quot;</p>
</div>

<?php
common_footer();
?>
