<?php
include("include/functions.php");

$TITLE = "How To Help [PHP-QAT: Quality Assurance Team]";
$SITE_UPDATE = date("D M d H:i:s Y T", filectime($SCRIPT_FILENAME))."<br>
/* $Id$ */";

common_header();
?>
    <table width="70%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="10"><img src="gfx/spacer.gif" width="10" height="1"></td>
          <td width="100%"> 
            <h1>How You Can Help</h1>
          </td>
          <td width="10"><img src="gfx/spacer.gif" width="10" height="1"></td>
        </tr>
        <tr> 
          <td width="10">&nbsp;</td>
          <td width="100%">You can help the QA effort in several ways:<br />
            <br />
          </td>
          <td width="10">&nbsp;</td>
        </tr>
        <tr>
          <td width="10">&nbsp;</td>
          <td width="100%">
            <ul>
              <li class="lihack">Write testcases:
              <ul>
                <li class="lihack">to reproduce bugs</li>
                <li class="lihack">for PHP functions for which no testcase exist</li>
              </ul>
              </li>
              <li class="lihack">
                Run our <a href="/running-tests.php">test suite</a> on a
                regular schedule, we're currently setting up a system to do
                this all automatically.<br /><br />
              </li>
              <li class="lihack">Give a PHP/QA Team member access to a server that 
                you administrate, especially on ones running some of the more
                exotic Operation Systems.  <br /><br /> To do this, please send
                mail to the PHP/QA email list (<a
                href="mailto:php-qa@lists.php.net">php-qa@lists.php.net</a>)
                with the subject 'Guest Account for PHP/QA Team Member'. In the
                body of the message, please list the specifications on the
                machine (hardware, operating system, installed software,
                etc...). </li>
            </ul>
          </td>
          <td width="10">&nbsp;</td>
        </tr>
      </table>
<?php

common_footer();
?>
