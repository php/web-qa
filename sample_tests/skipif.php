<?php
include("../include/functions.php");

$TITLE = "Sample Test [PHP-QAT: Quality Assurance Team]";
$SITE_UPDATE = date("D M d H:i:s Y T", filectime(__FILE__));

common_header();
?>

<div style="padding: 10px">
<h1>Sample Test: skipif.inc</h1>
<p>Back to &quot;<a href="../phpt_details.php">PHPT Test File Layout</a>&quot;</p>
<pre>&lt;?php
// This script prints &quot;skip&quot; if condition does not meet.
if (!extension_loaded(&quot;session&quot;) &amp;&amp; ini_get(&quot;enable_dl&quot;)) {
  $dlext = (substr(PHP_OS, 0, 3) == &quot;WIN&quot;) ? &quot;.dll&quot; : &quot;.so&quot;;
  @dl(&quot;session$dlext&quot;);
}
if (!extension_loaded(&quot;session&quot;)) {
    die(&quot;skip Session module not loaded&quot;);
}
$save_path = ini_get(&quot;session.save_path&quot;);
if ($save_path) {
  if (!file_exists($save_path)) {
    die(&quot;skip Session save_path doesn&#039;t exist&quot;);
  }

  if ($save_path &amp;&amp; !@is_writable($save_path)) {
    if (($p = strpos($save_path, &#039;;&#039;)) !== false) {
      $save_path = substr($save_path, ++$p);
    }
    if (!@is_writable($save_path)) {
      die(&quot;skip\n&quot;);
    }
  }
}
?&gt;
</pre>
<p>Back to &quot;<a href="../phpt_details.php">PHPT Test File Layout</a>&quot;</p>
</div>

<?php
common_footer();
?>
