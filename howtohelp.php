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
          <td width="100%">You can help the QA effort in several ways: <br>
            <br>
          </td>
          <td width="10">&nbsp;</td>
        </tr>
        <tr>
          <td width="10">&nbsp;</td>
          <td width="100%">
            <ul>
              <li class="lihack">If you have some spare time, why not join the 
                PHP/QA team? Follow the members link to find out how. </li>
              <li class="lihack">Submit a bug report. If you find what you think 
                is a problem, drop by <a href="http://bugs.php.net/" target="_blank">http://bugs.php.net/</a> and submit a report. 
                Just make sure to read the Dos and Dont's of bug submission before 
                posting a bug. </li>
              <li class="lihack">Give a PHP/QA Team member space on a server that 
                you administrate. To do this, please send mail to the PHP/QA email 
                list (<a href="mailto:php-qa@lists.php.net">php-qa@lists.php.net</a>) with the subject 'Guest Account for 
                PHP/QA Team Member'. In the body of the message, please list the 
                specifications on the machine (hardware, operating system, installed 
                software, etc...). </li>
            </ul>
          </td>
          <td width="10">&nbsp;</td>
        </tr>
      </table>
<?php

common_footer();
?>