<?php
include("../include/functions.php");

$TITLE = "Sample Test [PHP-QAT: Quality Assurance Team]";
$SITE_UPDATE = date("D M d H:i:s Y T", filectime(__FILE__));
/* $Id$ */

common_header();
?>

<div style="padding: 10px">
<h1>Sample Test: sample015.phpt</h1>
<p>Back to &quot;<a href="../phpt_details.php">PHPT Test File Layout</a>&quot;</p>
<pre>--TEST--
Multipart Form POST Data
--HEADERS--
return &lt;&lt;&lt;END
Content-Type=multipart/form-data; boundary=---------------------------240723202011929
Content-Length=862
END;
--ENV--
return &lt;&lt;&lt;END
CONTENT_TYPE=multipart/form-data; boundary=---------------------------240723202011929
CONTENT_LENGTH=862
END;
--POST--
-----------------------------240723202011929
Content-Disposition: form-data; name=&quot;entry&quot;

entry box
-----------------------------240723202011929
Content-Disposition: form-data; name=&quot;password&quot;

password box
-----------------------------240723202011929
Content-Disposition: form-data; name=&quot;radio1&quot;

test 1
-----------------------------240723202011929
Content-Disposition: form-data; name=&quot;checkbox1&quot;

test 1
-----------------------------240723202011929
Content-Disposition: form-data; name=&quot;choices&quot;

Choice 1
-----------------------------240723202011929
Content-Disposition: form-data; name=&quot;choices&quot;

Choice 2
-----------------------------240723202011929
Content-Disposition: form-data; name=&quot;file&quot;; filename=&quot;info.php&quot;
Content-Type: application/octet-stream

&lt;?php
phpinfo();
?&gt;
-----------------------------240723202011929--

--FILE--
&lt;?php 
error_reporting(0);
print_r($_POST);
print_r($_FILES);
?&gt;
--EXPECTF--
Array
(
    [entry] =&gt; entry box
    [password] =&gt; password box
    [radio1] =&gt; test 1
    [checkbox1] =&gt; test 1
    [choices] =&gt; Choice 2
)
Array
(
    [file] =&gt; Array
        (
            [name] =&gt; info.php
            [type] =&gt; application/octet-stream
            [tmp_name] =&gt; %s
            [error] =&gt; 0
            [size] =&gt; 21
        )

)
</pre>
<p>Back to &quot;<a href="../phpt_details.php">PHPT Test File Layout</a>&quot;</p>
</div>

<?php
common_footer();
?>