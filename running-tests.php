<?php
include("functions.php");

$TITLE = "Submit Build Test [PHP-QAT: Quality Assurance Team]";
$SITE_UPDATE = date("D M d H:i:s Y T", filectime($SCRIPT_FILENAME))."<br>
/* $Id$ */";

common_header();
?>
      <table width="70%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="10"><img src="gfx/spacer.gif" width="10" height="1"></td>
          <td width="100%">
<h2>Test framework tests</h2>
<p>
Please run the tests from our testframe work. You can do this by typing
<code>make test</code> after you compiled PHP with <code>make</code>. You
can only see non-passed tests by running this instead:
<code>make test | grep -v PASS</code>. If there are "FAIL"ed tests, the
script asks to send the logs to the PHP QA mailinglist. Please answer "y"
to this question so that we can efficiently process the results. Beware
that this script also uploads php -i output so your hostname may be
transmitted.
</p>
<?php
common_footer();
?>
