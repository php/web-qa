<?php
	$TITLE = 'Goals (PHP|QAT: The PHP Quality Assurance Team)';
	$CVS_KEYWORDS = '$Author$ / $Date$ / $Revision$';

	include ('inc/header.inc');
?>

<h1>PHP|QAT Goals</h1>

<ol>
	<li><span class="lihack"><b>Release Candidates Testing and QA (<a href="release.4.0.2.php">Upcoming Release 4.0.2</a>)</b></span></li>
	<p>
		&nbsp; * Release Candidate Build<br />
		&nbsp; * Automated Smoke Tests<br />
		&nbsp; * Automated QA Checklists<br />
		&nbsp; * Automated Regression Tests<br />
	</p>

	<li><span class="lihack"><b><!-- a href="" -->Get PHP/QA Team organized</a></b></span></li>
	<p>
		&nbsp; * get members to take care of regular tasks<br />
		&nbsp; * continue work on defining goals, methods and requirements<br />
	</p>

	<li><span class="lihack"><b><a href="bugs.php">Bug Hunting</a></b></span></li>
	<p>
		&nbsp; * analysing/closing existing bug reports at bugs.php.net<br />
		&nbsp; * analysing new bugs posted on the php-dev list<br />
		&nbsp; * actively seeking and tracking bugs on available platforms<br />
		&nbsp; * Monitoring/reviewing information from existing PHP mailing lists<br />
	</p>

	<li><span class="lihack"><b><!-- a href="" -->Finish PHP|QAT Website</a></b></span></li>
	<b>QA Team Roster Application</b>
	<p>
		&nbsp; * a simple database application that tracks active QA Team members<br />
		&nbsp; * team members should be able to administrate their own information<br />
		&nbsp; * the application should also track available platforms<br />
	</p>
	<p>
		<b>Finish resource and link pages.</b>
	</p>
	<p>
		<b>Finish how to help page</b>
	</p>
	<p>
		<b>archive and condense important threads from the php-qa list a la perl.com</b>
	</p>
	<p>
		<b>Expand projects/goals page</b><br />
		&nbsp; * add additional information on projects.<br />
		&nbsp; * build simple interface to allow project managers to update goals, status, members, etc... for projects<br />
	</p>


	<li><span class="lihack"><b><!-- a href="" -->Modify The Bug Database Interface</a></b></span></li>
	<p>
		<b>The interface should:</b><br />
		&nbsp; * reduce the occurance of multiple reports on the same bug<br />
		&nbsp; * improve the accuracy of the reports<br />
		&nbsp; * make it easier for the QAT to reproduce the bug<br />
		&nbsp; * track the solution to the bug<br />
	</p>

	<p>
		<b><!-- a href="" -->Provide Client-Side Bug Reporting via PHP Interpreter</a></b><br />
		&nbsp; * Add functionality to PHP to help php users submit accurate bugs.<br />
		&nbsp; * Probably the best solution that has been proposed is the addition of a submit_bug() function that would automatically send platform data, along with PHP interpreter state when it is called.  This solution would address the security concerns that have been raised by the possible display of platform information to malicious visitors.<br />
		&nbsp; * Bugs gathered from this source would need to be filtered by an agent before they could be considered truly useful.<br />
		&nbsp; * Note that filtering many spurious bug reports should be relatively simple.  Bug reports that were generated due to parse errors could be ignored or flagged as low priority.<br />
		&nbsp; * However, all of this would require developer involvement and is probably the least plausible goal! <br />
	</p>
</ol>

<?php include ('inc/footer.inc'); ?>
