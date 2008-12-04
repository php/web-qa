<?php
include("include/functions.php");
include("include/release-qa.php");

$TITLE = "PHP-QAT: Quality Assurance Team";
$SITE_UPDATE = date("D M d H:i:s Y T", filectime(__FILE__))."<br />\n".
'/* $Id$ */';

common_header();

?>
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
            <br /><h3>The team is currently focused on:</h3>
            <ul>

              <li>
<?php show_release_qa(); ?>

                See <a href="http://windows.php.net/qa/">here</a> for the Windows builds.
                <br><br>

              </li>

              <li>
                Upgrading the testsuite. This includes extending the testsuites with tests for every function,
                collecting test data in a different way then mailing all output to the QA mailinglist.
              </li>

            </ul>
            <p>
             Anyone can help us by running the test framework, see:<br />
             <a href="http://qa.php.net/running-tests.php">http://qa.php.net/running-tests.php</a>
            </p>
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
