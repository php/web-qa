<?php
include("../include/functions.php");

$TITLE = "Sample Test [PHP-QAT: Quality Assurance Team]";
$SITE_UPDATE = date("D M d H:i:s Y T", filectime(__FILE__));
/* $Id$ */

common_header();
?>

<div style="padding: 10px">
<h1>Sample Test: sample004.phpt</h1>
<p>Back to &quot;<a href="../phpt_details.php">PHPT Test File Layout</a>&quot;</p>
<pre>--TEST--
QUERY_STRING Security Bug
--DESCRIPTION--
This bug was present in PHP 4.3.0 only.
A failure should print HELLO.
--REQUEST--
return &lt;&lt;&lt;END
SCRIPT_NAME=/nothing.php
QUERY_STRING=$filename
END;
--ENV--
return &lt;&lt;&lt;END
REDIRECT_URL=$scriptname
PATH_TRANSLATED=c:\apache\1.3.27\htdocs\nothing.php
QUERY_STRING=$filename
PATH_INFO=/nothing.php
SCRIPT_NAME=/phpexe/php.exe/nothing.php
SCRIPT_FILENAME=c:\apache\1.3.27\htdocs\nothing.php
END;
--FILE--
&lt;?php
    echo &quot;HELLO&quot;;
?&gt;
--EXPECTHEADERS--
Status: 404
--EXPECT--
No input file specified.</pre>
<p>Back to &quot;<a href="../phpt_details.php">PHPT Test File Layout</a>&quot;</p>
</div>

<?php
common_footer();
?>