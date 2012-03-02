<?php
include("include/functions.php");
include("include/release-qa.php");

$TITLE = "PHP-QAT: Quality Assurance Team";
$SITE_UPDATE = date("D M d H:i:s Y T", filectime(__FILE__))."<br />\n".
'/* $Id$ */';

common_header();

?>
THIS IS A TEST
      <table width="70%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="10"><img src="gfx/spacer.gif" width="10" height="1"></td>
          <td width="100%">
           <h1>Welcome to the<br />PHP Quality Assurance Team Web Page.</h1>
           <p>
            The PHP Quality Assurance Team supports the PHP Development Team by
            providing them with information on compatibility and stability issues.
           </p>
          </td>
          <td width="10"><img src="gfx/spacer.gif" width="10" height="1"></td>
        </tr>
        <tr>
          <td width="10">&nbsp;</td>
          <td width="100%">
            <br />
            <h3>Make test results:</h3>
            <ul>
            <li>
              All users who compile PHP are encouraged to run '<a href="http://qa.php.net/running-tests.php">make test</a>', which
              runs the test suite and optionally sends the <a href=" http://news.php.net/php.qa.reports">results here</a>.
              <br /><br />
            </li>
            <li>
              Compiled <a href="reports/">user submitted test result reports</a> for analysis
              <br /><br />
            </li>
            <li>
             Additional test results are available at <a href="http://gcov.php.net/">gcov.php.net</a> and <a href="http://ci.qa.php.net">ci.qa.php.net</a>.
            </li>
           </ul>

            <h3>The team is currently focused on:</h3>
            <ul>

              <li>
<?php show_release_qa($QA_RELEASES); ?>

                See <a href="http://windows.php.net/qa/">here</a> for the Windows builds.
              </li>
            </ul>
          </td>
          <td width="10">&nbsp;</td>
        </tr>
        <tr>
          <td width="10">&nbsp;</td>
          <td width="100%">
          <br />
          <p>
           If you would like to contribute to these efforts, please
           visit our <a href="howtohelp.php">How To Help</a> page.
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
