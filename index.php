<?php
include("include/functions.php");

$TITLE = "PHP-QAT: Quality Assurance Team";
$SITE_UPDATE = date("D M d H:i:s Y T", filectime($SCRIPT_FILENAME))."<br>
/* $Id$ */";

common_header();
?>
      <table width="70%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="10"><img src="gfx/spacer.gif" width="10" height="1"></td>
          <td width="100%"> 
            <h1>Welcome to the<br>
              PHP Quality Assurance Team Web Page.</h1>
          </td>
          <td width="10"><img src="gfx/spacer.gif" width="10" height="1"></td>
        </tr>
        <tr> 
          <td width="10">&nbsp;</td>
          <td width="100%"> 
            <p>The team is currently focused on:</p>
            <ul>
              <li>
                <span class="lihack">Providing QA for the <a href="http://www.php.net/~andrei/php-4.3.0pre2.tar.bz2">PHP 4.3.0pre2 (source)</a> release.
                Windows binaries can be found <a href="http://www.php.net/~derick/php-4.3.0pre2-Win32.zip">here</a></span><br />
              </li>
            </ul>
            <p>
                You can help use by running the test framework, see:<br />
                <a href="http://qa.php.net/running-tests.php">http://qa.php.net/running-tests.php</a>
            </p>
          </td>
          <td width="10">&nbsp;</td>
        </tr>
        <tr> 
          <td width="10">&nbsp;</td>
          <td width="100%">
          <p>If you would like to contribute to this effort, please 
            visit our <a href="howtohelp.php">How To Help</a> page.</p> </td>
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
