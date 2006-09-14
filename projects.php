<?php
include("include/functions.php");

$TITLE = "Projects &amp; Goals [PHP-QAT: Quality Assurance Team]";
$SITE_UPDATE = date("D M d H:i:s Y T", filectime(__FILE__));
/* $Id$ */

common_header();
?>
      <table width="70%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="10"><img src="gfx/spacer.gif" width="10" height="1"></td>
          <td width="100%"> 
            <h1>PHP-QAT Goals</h1>
          </td>
          <td width="10"><img src="gfx/spacer.gif" width="10" height="1"></td>
        </tr>
        <tr> 
          <td width="10">&nbsp;</td>
          <td width="100%"> 
            <h3>Release Candidates Testing and QA</h3>
          </td>
          <td width="10">&nbsp;</td>
        </tr>
        <tr> 
          <td width="10">&nbsp;</td>
          <td width="100%"> 
            <ul>
              <li><span class="lihack">Release Candidate Build </span></li>
              <li><span class="lihack">Automated Smoke Tests </span></li>
              <li><span class="lihack">Automated QA Checklists </span></li>
              <li><span class="lihack">Automated Regression Tests </span></li>
            </ul>
          </td>
          <td width="10">&nbsp;</td>
        </tr>
        <tr> 
          <td width="10">&nbsp;</td>
          <td width="100%"> 
            <h3>Modify The Bug Database Interface</h3>
          </td>
          <td width="10">&nbsp;</td>
        </tr>
        <tr> 
          <td width="10">&nbsp;</td>
          <td width="100%"> 
            <h4>The interface should:<br>
            </h4>
          </td>
          <td width="10">&nbsp;</td>
        </tr>
        <tr> 
          <td width="10">&nbsp;</td>
          <td width="100%"> 
            <ul>
              <li><span class="lihack">reduce the occurance of multiple reports on the same bug</span></li>
              <li><span class="lihack">improve the accuracy of the reports </span></li>
              <li><span class="lihack">make it easier for the QAT to reproduce the bug </span></li>
              <li><span class="lihack">track the solution to the bug </span></li>
            </ul>
          </td>
          <td width="10">&nbsp;</td>
        </tr>
        <tr> 
          <td width="10">&nbsp;</td>
          <td width="100%"> 
            <h3>Bug Hunting</h3>
          </td>
          <td width="10">&nbsp;</td>
        </tr>
        <tr> 
          <td width="10">&nbsp;</td>
          <td width="100%"> 
            <ul>
              <li><span class="lihack"><a href="handling-bugs.php">analysing/closing existing bug reports</a> at bugs.php.net </span></li>
              <li><span class="lihack">analysing new bugs posted on the php-dev list </span></li>
              <li><span class="lihack">actively seeking and tracking bugs on available platforms </span></li>
              <li><span class="lihack">monitoring/reviewing information from existing PHP mailing lists</span></li>
            </ul>
          </td>
          <td width="10">&nbsp;</td>
        </tr>
        <tr> 
          <td width="10">&nbsp;</td>
          <td width="100%"> 
            <h3>Provide Client-Side Bug Reporting via PHP Interpreter</h3>
          </td>
          <td width="10">&nbsp;</td>
        </tr>
        <tr> 
          <td width="10">&nbsp;</td>
          <td width="100%"> 
            <ul>
              <li><span class="lihack">Add functionality to PHP to help php users submit accurate bugs. 
              </span></li>
              <li><span class="lihack">Probably the best solution that has been proposed is the addition 
                of a submit_bug() function that would automatically send platform 
                data, along with PHP interpreter state when it is called. This 
                solution would address the security concerns that have been raised 
                by the possible display of platform information to malicious visitors. 
              </span></li>
              <li><span class="lihack">Bugs gathered from this source would need to be filtered by 
                an agent before they could be considered truly useful. </span></li>
              <li><span class="lihack">Note that filtering many spurious bug reports should be relatively 
                simple. Bug reports that were generated due to parse errors could 
                be ignored or flagged as low priority. </span></li>
              <li><span class="lihack">However, all of this would require developer involvement and 
                is probably the least plausible goal! </span></li>
            </ul>
          </td>
          <td width="10">&nbsp;</td>
        </tr>
      </table>
<?php

common_footer();
?>
