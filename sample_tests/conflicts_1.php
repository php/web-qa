<?php
include("../include/functions.php");

$TITLE = "Sample Test [PHP-QAT: Quality Assurance Team]";
$SITE_UPDATE = date("D M d H:i:s Y T", filectime(__FILE__));

common_header();
?>

<div style="padding: 10px">
<h1>Sample Test: conflicts_1.phpt</h1>
<p>Back to &quot;<a href="../phpt_details.php">PHPT Test File Layout</a>&quot;</p>
<pre>--TEST--
Test get_headers() function : test with context
--CONFLICTS--
server
--FILE--
&lt;?php

include __DIR__.&quot;/../../../../sapi/cli/tests/php_cli_server.inc&quot;;
php_cli_server_start(&#039;header(&quot;X-Request-Method: &quot;.$_SERVER[&quot;REQUEST_METHOD&quot;]);&#039;);

$opts = array(
    &#039;http&#039; =&gt; array(
    &#039;method&#039; =&gt; &#039;HEAD&#039;
  )
);

$context = stream_context_create($opts);
$headers = get_headers(&quot;http://&quot;.PHP_CLI_SERVER_ADDRESS, 1, $context);
echo $headers[&quot;X-Request-Method&quot;].&quot;\n&quot;;

stream_context_set_default($opts);
$headers = get_headers(&quot;http://&quot;.PHP_CLI_SERVER_ADDRESS, 1);
echo $headers[&quot;X-Request-Method&quot;].&quot;\n&quot;;

echo &quot;Done&quot;;
?&gt;
--EXPECT--
HEAD
HEAD
Done
</pre>
<p>Back to &quot;<a href="../phpt_details.php">PHPT Test File Layout</a>&quot;</p>
</div>

<?php
common_footer();
?>
