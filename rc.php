<?php
include("include/functions.php");

$TITLE = "Release Candidates";
$SITE_UPDATE = date("D M d H:i:s Y T", filectime(__FILE__));
/* $Id$ */

common_header();
?>
    <table width="70%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="10"><img src="gfx/spacer.gif" width="10" height="1"></td>
          <td width="100%"> 
            <h1>Release Candidates</h1>
          </td>
          <td width="10"><img src="gfx/spacer.gif" width="10" height="1"></td>
        </tr>
        <tr> 
          <td width="10">&nbsp;</td>
		  <td width="100%">
			<h2>Basics</h2>
			Release candidates are development packages released to check if any critical
			problems have slipped into the code during the previous development period.
			<i>Release candidates are <b>NOT</b> for production use, they are for testing purposes only</i>
			even though in most cases there are almost no differences between the general
			availability (GA) release and the last RC.
			You can help the PHP Team and yourself detect problems by installing and testing
			release candidates on your own (<i>non-production!</i>) server.
            <br />
            <br />
          </td>
          <td width="10">&nbsp;</td>
        </tr>
        <tr> 
          <td width="10">&nbsp;</td>
		  <td width="100%">
			<h2>Installation problems</h2>
			First of all, make sure the build process (on *nix only) and installation went fine for you.
			PHP supports quite a number of operating systems on different platforms and we continue
			to work on increasing this number.
			If you encounter any problems during the installation, we would like to know about them.
			<br/>
			<br/>
          </td>
          <td width="10">&nbsp;</td>
        </tr>
        <tr> 
          <td width="10">&nbsp;</td>
		  <td width="100%">
			<h2>Testing the installation</h2>
			When done with the build, please run the test engine by using the '<code>make test</code>' command
			and send us the results (hit '<code>Y</code>' when it asks you whether to send the report).
			This way we'll receive the required information about your system to fix the problems
			detected by the test suite (if any). Each and every report goes towards helping us
			provide the best software we can, your feedback is a valuable resource and the
			PHP group would hereby like to extend their gratitude for your effort.
			<br/>
			<br/>
          </td>
          <td width="10">&nbsp;</td>
        </tr>
        <tr> 
          <td width="10">&nbsp;</td>
		  <td width="100%">
			<h2>Real-life tests</h2>
			We would also appreciate if you install the RC on your development server and run
			your software. This would help us to detect any unintentional changes between
			the release candidates and general releases.
			Such real-life tests are the most valuable because our test suite does not yet
			cover every possible use case (but we're working on that).
            <br />
          </td>
          <td width="10">&nbsp;</td>
        </tr>

      </table>
<?php

common_footer();
?>
