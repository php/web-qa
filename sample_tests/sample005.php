<?php
include("../include/functions.php");

$TITLE = "Sample Test [PHP-QAT: Quality Assurance Team]";
$SITE_UPDATE = date("D M d H:i:s Y T", filectime(__FILE__));

common_header();
?>

<div style="padding: 10px">
<h1>Sample Test: sample005.phpt</h1>
<p>Back to &quot;<a href="../phpt_details.php">PHPT Test File Layout</a>&quot;</p>
<pre>--TEST--
SOAP Server 19: compressed request (gzip)
--SKIPIF--
&lt;?php
  if (php_sapi_name()==&#039;cli&#039;) echo &#039;skip&#039;;
  require_once(&#039;<a href="skipif2.php">skipif2.inc</a>&#039;);
  if (!extension_loaded(&#039;zlib&#039;)) die(&#039;skip zlib extension not available&#039;);
?&gt;
--INI--
precision=14
--GZIP_POST--
&lt;SOAP-ENV:Envelope
  SOAP-ENV:encodingStyle=&quot;http://schemas.xmlsoap.org/soap/encoding/&quot;
  xmlns:SOAP-ENV=&quot;http://schemas.xmlsoap.org/soap/envelope/&quot;
  xmlns:xsd=&quot;http://www.w3.org/2001/XMLSchema&quot;
  xmlns:xsi=&quot;http://www.w3.org/2001/XMLSchema-instance&quot;
  xmlns:si=&quot;http://soapinterop.org/xsd&quot;&gt;
  &lt;SOAP-ENV:Body&gt;
    &lt;ns1:test xmlns:ns1=&quot;http://testuri.org&quot; /&gt;
  &lt;/SOAP-ENV:Body&gt;
&lt;/SOAP-ENV:Envelope&gt;
--FILE--
&lt;?php
function test() {
  return &quot;Hello World&quot;;
}

$server = new soapserver(null,array(&#039;uri&#039;=&gt;&quot;http://testuri.org&quot;));
$server-&gt;addfunction(&quot;test&quot;);
$server-&gt;handle();
echo &quot;ok\n&quot;;
?&gt;
--EXPECT--
&lt;?xml version=&quot;1.0&quot; encoding=&quot;UTF-8&quot;?&gt;
&lt;SOAP-ENV:Envelope xmlns:SOAP-ENV=&quot;http://schemas.xmlsoap.org/soap/envelope/&quot; xmlns:ns1=&quot;http://testuri.org&quot; xmlns:xsd=&quot;http://www.w3.org/2001/XMLSchema&quot; xmlns:xsi=&quot;http://www.w3.org/2001/XMLSchema-instance&quot; xmlns:SOAP-ENC=&quot;http://schemas.xmlsoap.org/soap/encoding/&quot; SOAP-ENV:encodingStyle=&quot;http://schemas.xmlsoap.org/soap/encoding/&quot;&gt;&lt;SOAP-ENV:Body&gt;&lt;ns1:testResponse&gt;&lt;return xsi:type=&quot;xsd:string&quot;&gt;Hello World&lt;/return&gt;&lt;/ns1:testResponse&gt;&lt;/SOAP-ENV:Body&gt;&lt;/SOAP-ENV:Envelope&gt;
ok
</pre>
<p>Back to &quot;<a href="../phpt_details.php">PHPT Test File Layout</a>&quot;</p>
</div>

<?php
common_footer();
?>
