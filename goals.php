<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>
Goals (PHP/QAT: The PHP Quality Assurance Team)
</title>
</head>
<body bgcolor="#FFFFFF" background="img/bg_page.gif" text="#000000" link="#0000FF"
	vlink="#009999" marginheight="0" marginwidth="0"
	topmargin="0" leftmargin="0">

<table cellpadding="0" cellspacing="0" border="0" width="619">
<tr>
	<td colspan="2" background="img/bg_green.gif"><img SRC="img/title.gif" WIDTH="202" HEIGHT="41" border="0" alt="PHP/QAT: The PHP Quality Assurance Team"></td>
</tr>
<tr>
	<td valign="top">
		<font face="Tahoma, Arial, Helvetica, Sans Serif" size="3">
		<div style="text-align: right; padding: 5">
		<font size="1" face="MS SANS SERIF, GENEVA, SANS SERIF">
		&gt; &gt; &gt;
		<a href="index.php">Home</a> |
		<a href="index.php#news">News</a> |
		<a href="goals.php">Projects and Goals</a> |
		<a href="resources.php">Links &amp; Resources</a> |
		<a href="members.php">Members</a> |
		<a href="howtohelp.php">How to help</a>
		</font>
		</div>
		<blockquote>

		<br />
		<b>PHP/QAT Goals</b>
		<hr size="1" />
		<ol>
		<li><b>Release Candidates Testing and QA (<a href="release.4.0.2.php">Upcoming Release 4.0.2</a>)</b></li><br />
		&nbsp;* Release Candidate Build<br />
		&nbsp;* Automated Smoke Tests<br />
		&nbsp;* Automated QA Checklists<br />
		&nbsp;* Automated Regression Tests<br />
		<br />


		<li><b><!-- a href="" -->Get PHP/QA Team organized</a></b></li><br />
		&nbsp; * get members to take care of regular tasks<br />
		&nbsp; * continue work on defining goals, methods and requirements<br />
		<br />


		<li><b><a href="bugs.php">Bug Hunting</a></b></li><br />
		&nbsp;* analysing/closing existing bug reports at bugs.php.net<br />
		&nbsp;* analysing new bugs posted on the php-dev list<br />
		&nbsp;* actively seeking and tracking bugs on available platforms<br />
		&nbsp;* Monitoring/reviewing information from existing PHP mailing lists<br />
		<br />

		<li><b><!-- a href="" -->Finish PHP/QAT Website</a></b></li><br />
		&nbsp;QA Team Roster Application</a></b></li><br />
		&nbsp; * a simple database application that tracks active QA Team members<br />
		&nbsp; * team members should be able to administrate their own information<br />
		&nbsp; * the application should also track available platforms<br /><br />
		&nbsp;Finish resource and link pages.<br />
		&nbsp;Finish how to help page <br />
		&nbsp;archive and condense important threads from the php-qa list a la perl.com<br />
		&nbsp;Expand projects/goals page<br />
		&nbsp; * add additional information on projects.<br />
		&nbsp; * build simple interface to allow project managers to update goals, status, members, etc... for projects<br />
		<br />


		<li><b><!-- a href="" -->Modify The Bug Database Interface</a></b></li><br />
		&nbsp;The interface should to:<br />
		&nbsp;* reduce the occurance of multiple reports on the same bug<br />
		&nbsp;* improve the accuracy of the reports<br />
		&nbsp;* make it easier for the QAT to reproduce the bug<br />
		&nbsp;* track the solution to the bug<br />
		<br />

		<li><b><!-- a href="" -->Provide Client-Side Bug Reporting via PHP Interpreter</a></b></li><br />
		&nbsp;* Add functionality to PHP to help php users submit accurate bugs.<br />
		&nbsp;* Probably the best solution that has been proposed is the addition of a submit_bug() function that would automatically send platform data, along with PHP interpreter state when it is called.  This solution would address the security concerns that have been raised by the possible display of platform information to malicious visitors.<br />
		&nbsp;* Bugs gathered from this source would need to be filtered by an agent before they could be considered truly useful.<br />
		&nbsp;* Note that filtering many spurious bug reports should be relatively simple.  Bug reports that were generated due to parse errors could be ignored or flagged as low priority.<br />
		&nbsp;* However, all of this would require developer involvement and is probably the least plausible goal! <br />
		<br />

		</ol>


		<br />
		<? include ('inc/footer.txt') ?>

<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font face="ms sans serif, arial, geneva, sans serif" size="3">$Author$ / $Date$ / $Revision$</font><br /><br />
</body>
</html>
