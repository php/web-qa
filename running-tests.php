<?php
include("include/functions.php");

$TITLE = "Submit Build Test [PHP-QAT: Quality Assurance Team]";
$SITE_UPDATE = date("D M d H:i:s Y T", filectime(__FILE__));
/* $Id$ */

common_header();
?>
<table width="70%" border="0" cellspacing="0" cellpadding="0">
 <tr> 
  <td width="10"><img src="gfx/spacer.gif" width="10" height="1"></td>
  <td width="100%">
   <h1>Test framework tests</h1>
   <p>
    Please run the tests from our test framework. You can do this by typing
    <code>make test</code> after you compiled PHP with <code>make</code>.
   </p>

   <p>
    When <code>make test</code> finished running tests, and if there are any
    failed tests, the script asks to send the logs to the PHP QA mailinglist. 
    Please answer "y" to this question so that we can efficiently process the results, 
    entering your e-mail address (which will not be transmitted in plaintext to any list)
    enables us to ask you some more information if a test failed. Note that this script 
    also uploads php -i output so your hostname may be transmitted.
   </p>
  </td>
 </tr>
</table>
<?php
common_footer();
?>
