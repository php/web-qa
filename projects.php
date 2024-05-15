<?php
include("include/functions.php");

$TITLE = "Projects &amp; Goals [PHP-QAT: Quality Assurance Team]";
$SITE_UPDATE = date("D M d H:i:s Y T", filectime(__FILE__));

$CURRENT_PAGE = "Goals";

common_header();
?>
            <h1>PHP-QAT Goals</h1>
            <h3>Release Candidates Testing and QA</h3>
            <ul>
              <li><span class="lihack">Release Candidate Build </span></li>
              <li><span class="lihack">Automated Smoke Tests </span></li>
              <li><span class="lihack">Automated QA Checklists </span></li>
              <li><span class="lihack">Automated Regression Tests </span></li>
            </ul>
            <h3>Modify The Bug Database Interface</h3>
            <h4>The interface should:</h4>
            <ul>
              <li><span class="lihack">reduce the occurrence of multiple reports on the same bug</span></li>
              <li><span class="lihack">improve the accuracy of the reports </span></li>
              <li><span class="lihack">make it easier for the QAT to reproduce the bug </span></li>
              <li><span class="lihack">track the solution to the bug </span></li>
            </ul>
            <h3>Bug Hunting</h3>
            <ul>
              <li><span class="lihack"><a href="handling-bugs.php">analysing/closing existing bug reports</a> at bugs.php.net </span></li>
              <li><span class="lihack">analysing new bugs posted on the php-dev list </span></li>
              <li><span class="lihack">actively seeking and tracking bugs on available platforms </span></li>
              <li><span class="lihack">monitoring/reviewing information from existing PHP mailing lists</span></li>
            </ul>
            <h3>Provide Client-Side Bug Reporting via PHP Interpreter</h3>
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
<?php

common_footer();
?>
