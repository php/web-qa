<?php
include("include/functions.php");

$TITLE = "PHP-QAT: Quality Assurance Team";
$SITE_UPDATE = date("D M d H:i:s Y T", filectime($SCRIPT_FILENAME));
/* $Id$ */

common_header();
?>
      <table width="70%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="10"><img src="gfx/spacer.gif" width="10" height="1"></td>
          <td width="100%"> 
            <h1>Welcome to the<br />PHP Quality Assurance Team Web Page</h1>

            <p>
              The PHP Quality Assurance Team is supporting to the PHP
              Development Team by means of providing them with information on
              compatibility and stability issues.
            </p>
            <p>
              The team is currently focused on upgrading the testsuite. This
              includes extending the testsuites with tests for every function,
              collecting test data in a different way then mailing all output
              to the QA mailinglist.
            </p>
            <p>
              If you would like to contribute to this effort, please visit our
              <a href="howtohelp.php">How To Help</a> page.
            </p>
          </td>
          <td width="10">&nbsp;</td>
        </tr>
        <tr> 
          <td width="10">&nbsp;</td>
          <td width="100%">&nbsp;</td>
          <td width="10">&nbsp;</td>
        </tr>
      </table>
<?php

common_footer();
?>
