<?php
	$TITLE = 'Goals (PHP|QAT: The PHP Quality Assurance Team)';
	$CVS_KEYWORDS = '$Author$ / $Date$ / $Revision$';

	include ('inc/header.inc');
?>

    <h1>PHP|QAT Goals</h1>

    <h2>Release Candidates Testing and QA (Upcoming Release 4.0.4)</h2>
    <ul>
      <li><span class="lihack">Release Candidate Build</span></li>
      <li><span class="lihack">Automated Smoke Tests</span></li>
      <li><span class="lihack">Automated QA Checklists</span></li>
      <li><span class="lihack">Automated Regression Tests</span></li>
    </ul>

    <h2>Modify The Bug Database Interface</h2>
    <h3>The interface should:</h3>
    <ul>
      <li><span class="lihack">reduce the occurance of multiple reports on the same bug</span></li>
      <li><span class="lihack">improve the accuracy of the reports</span></li>
      <li><span class="lihack">make it easier for the QAT to reproduce the bug</span></li>
      <li><span class="lihack">track the solution to the bug</span></li>
    </ul>

    <h2><a href="bugs.php">Bug Hunting</a></h2>
    <ul>
      <li><span class="lihack">analysing/closing existing bug reports at bugs.php.net</span></li>
      <li><span class="lihack">analysing new bugs posted on the php-dev list</span></li>
      <li><span class="lihack">actively seeking and tracking bugs on available platforms</span></li>
      <li><span class="lihack">monitoring/reviewing information from existing PHP mailing lists</span></li>
    </ul>

    <h2>Finish PHP|QAT Website</h2>

    <h3>QA Team Roster Application</h3>
    <ul>
      <li><span class="lihack">a simple database application that tracks active QA Team members</span></li>
      <li><span class="lihack">team members should be able to administrate their own information</span></li>
      <li><span class="lihack">the application should also track available platforms</span></li>
    </ul>

    <h3>Finish resource and link pages.</h3>
    <ul>
      <li><span class="lihack">Finish how to help page</span></li>
      <li><span class="lihack">Archive and condense important threads from the php-qa list &agrave; la perl.com</span></li>
      <li><span class="lihack">Expand projects/goals page:</span>
        <ul>
          <li><span class="lihack">add additional information on projects.</span></li>
          <li><span class="lihack">build simple interface to allow project managers to update goals, status, members, etc... for projects</span></li>
        </ul>
      </li>
    </ul>

    <h3>Provide Client-Side Bug Reporting via PHP Interpreter</h3>
    <ul>
      <li><span class="lihack">Add functionality to PHP to help php users submit accurate bugs.</span></li>
      <li><span class="lihack">Probably the best solution that has been proposed is the addition of a submit_bug() function that would automatically send platform data, along with PHP interpreter state when it is called.  This solution would address the security concerns that have been raised by the possible display of platform information to malicious visitors.</span></li>
      <li><span class="lihack">Bugs gathered from this source would need to be filtered by an agent before they could be considered truly useful.</span></li>
      <li><span class="lihack">Note that filtering many spurious bug reports should be relatively simple.  Bug reports that were generated due to parse errors could be ignored or flagged as low priority.</span></li>
      <li><span class="lihack">However, all of this would require developer involvement and is probably the least plausible goal! </span></li>
    </ul>

<?php include ('inc/footer.inc'); ?>
