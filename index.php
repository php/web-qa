<?php
include("include/functions.php");

$TITLE = "PHP-QAT: Quality Assurance Team";
$SITE_UPDATE = date("D M d H:i:s Y T", filectime($SCRIPT_FILENAME))."<br />
/* $Id$ */";

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
                <span class="lihack">Providing QA for the PHP 4.3.2RC4 release:
                <ul>
                 <li><a href="http://downloads.php.net/jani/php-4.3.2RC4.tar.bz2">php-4.3.2RC4.tar.bz2</a><br />
                  md5sum:9efabc2c2ee949b256b46d7fc1818154
                 </li>
                 <li><a href="http://downloads.php.net/jani/php-4.3.2RC4.tar.gz">php-4.3.2RC4.tar.gz</a><br />
                  md5sum:21a48ba6623db3f40321aa7e394e4c75
                 </li>
                 <li><a href="http://downloads.php.net/jani/php-4.3.2RC4-Win32.zip">php-4.3.2RC4-Win32.zip</a><br />
                  md5sum:95e3b34848380b130cdee75b294b4c25
                 </li>
                </ul>
                </span><br />
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
