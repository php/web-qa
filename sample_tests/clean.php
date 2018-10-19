<?php
include("../include/functions.php");

$TITLE = "Sample Test [PHP-QAT: Quality Assurance Team]";
$SITE_UPDATE = date("D M d H:i:s Y T", filectime(__FILE__));

common_header();
?>

<div style="padding: 10px">
<h1>Sample Test: clean.inc</h1>
<p>Back to &quot;<a href="../phpt_details.php">PHPT Test File Layout</a>&quot;</p>
<pre>&lt;?php
include_once(__DIR__ . &#039;/imap_include.inc&#039;);

$imap_stream = imap_open($default_mailbox, $username, $password);

// delete all msgs in default mailbox, i.e INBOX
$check = imap_check($imap_stream);
for ($i = 1; $i &lt;= $check-&gt;Nmsgs; $i++) {
  imap_delete($imap_stream, $i);
}

$mailboxes = imap_getmailboxes($imap_stream, $server, &#039;*&#039;);

foreach($mailboxes as $value) {
  // Only delete mailboxes with our prefix
  if (preg_match(&#039;/\{.*?\}INBOX\.(.+)/&#039;, $value-&gt;name, $match) == 1) {
    if (strlen($match[1]) &gt;= strlen($mailbox_prefix)
    &amp;&amp; substr_compare($match[1], $mailbox_prefix, 0, strlen($mailbox_prefix)) == 0) {
      imap_deletemailbox($imap_stream, $value-&gt;name);
    }
  }
}

imap_close($imap_stream, CL_EXPUNGE);
?&gt;</pre>
<p>Back to &quot;<a href="../phpt_details.php">PHPT Test File Layout</a>&quot;</p>
</div>

<?php
common_footer();
?>
