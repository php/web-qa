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
Phar::chmod
--EXTENSIONS--
phar
--INI--
phar.readonly=1
phar.require_hash=0
--SKIPIF--
&lt;?php
if (getenv("GITHUB_ACTIONS") &amp;&amp; PHP_OS_FAMILY === "Darwin") {
    die("flaky Occasionally segfaults on macOS for unknown reasons");
}
?&gt;
--FILE--
&lt;?php
$fname = __DIR__ . '/' . basename(__FILE__, '.php') . '.1.phar.php';
$pname = 'phar://hio';
$file = '&lt;?php include "' . $pname . '/a.php"; __HALT_COMPILER(); ?&gt;';

$files = array();
$files['a.php']   = '&lt;?php echo "This is a\n"; include "'.$pname.'/b.php"; ?&gt;';
include 'files/phar_test.inc';
try {
    $a = new Phar($fname);
    var_dump($a['a.php']-&gt;isExecutable());
    $a['a.php']-&gt;chmod(0777);
    var_dump($a['a.php']-&gt;isExecutable());
    $a['a.php']-&gt;chmod(0666);
    var_dump($a['a.php']-&gt;isExecutable());
} catch (Exception $e) {
    echo $e-&gt;getMessage() . "\n";
}
?&gt;
--CLEAN--
&lt;?php
unlink(__DIR__ . '/' . basename(__FILE__, '.clean.php') . '.1.phar.php');
?&gt;
--EXPECTF--
bool(false)
Cannot modify permissions for file "a.php" in phar "%s033a.1.phar.php", write operations are prohibited
</pre>
<p>Back to &quot;<a href="../phpt_details.php">PHPT Test File Layout</a>&quot;</p>
</div>

<?php
common_footer();
?>
