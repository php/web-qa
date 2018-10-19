<?php
include("../include/functions.php");

$TITLE = "Sample Test [PHP-QAT: Quality Assurance Team]";
$SITE_UPDATE = date("D M d H:i:s Y T", filectime(__FILE__));

common_header();
?>

<div style="padding: 10px">
<h1>Sample Test: sample025.phpt</h1>
<p>Back to &quot;<a href="../phpt_details.php">PHPT Test File Layout</a>&quot;</p>
<pre>--TEST--
Test imap_append() function : basic functionality
--SKIPIF--
&lt;?php
require_once(__DIR__.&#039;/skipif.inc&#039;);
?&gt;
--FILE--
&lt;?php
/* Prototype  : bool imap_append  ( resource $imap_stream  , string $mailbox  , string $message  [, string $options  ] )
 * Description: Append a string message to a specified mailbox.
 * Source code: ext/imap/php_imap.c
 */

echo &quot;*** Testing imap_append() : basic functionality ***\n&quot;;

require_once(__DIR__.&#039;/imap_include.inc&#039;);

echo &quot;Create a new mailbox for test\n&quot;;
$imap_stream = setup_test_mailbox(&quot;&quot;, 0);
if (!is_resource($imap_stream)) {
	exit(&quot;TEST FAILED: Unable to create test mailbox\n&quot;);
}

$mb_details = imap_mailboxmsginfo($imap_stream);
echo &quot;Add a couple of msgs to new mailbox &quot; . $mb_details-&gt;Mailbox . &quot;\n&quot;;
var_dump(imap_append($imap_stream, $mb_details-&gt;Mailbox
                   , &quot;From: webmaster@something.com\r\n&quot;
                   . &quot;To: info@something.com\r\n&quot;
                   . &quot;Subject: Test message\r\n&quot;
                   . &quot;\r\n&quot;
                   . &quot;this is a test message, please ignore\r\n&quot;
                   ));

var_dump(imap_append($imap_stream, $mb_details-&gt;Mailbox
                   , &quot;From: webmaster@something.com\r\n&quot;
                   . &quot;To: info@something.com\r\n&quot;
                   . &quot;Subject: Another test\r\n&quot;
                   . &quot;\r\n&quot;
                   . &quot;this is another test message, please ignore it too!!\r\n&quot;
                   ));

$check = imap_check($imap_stream);
echo &quot;Msg Count after append : &quot;. $check-&gt;Nmsgs . &quot;\n&quot;;

echo &quot;List the msg headers\n&quot;;
var_dump(imap_headers($imap_stream));

imap_close($imap_stream);
?&gt;
--CLEAN--
&lt;?php
require_once(&#039;clean.inc&#039;);
?&gt;
--EXPECTF--
*** Testing imap_append() : basic functionality ***
Create a new mailbox for test
Create a temporary mailbox and add 0 msgs
.. mailbox &#039;%s&#039; created
Add a couple of msgs to new mailbox {%s}INBOX.%s
bool(true)
bool(true)
Msg Count after append : 2
List the msg headers
array(2) {
  [0]=&gt;
  string(%d) &quot;%w%s       1)%s webmaster@something. Test message (%d chars)&quot;
  [1]=&gt;
  string(%d) &quot;%w%s       2)%s webmaster@something. Another test (%d chars)&quot;
}

</pre>
<p>Back to &quot;<a href="../phpt_details.php">PHPT Test File Layout</a>&quot;</p>
</div>

<?php
common_footer();
?>
