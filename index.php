<?php
include("include/functions.php");

$TITLE = "PHP-QAT: Quality Assurance Team";
$SITE_UPDATE = date("D M d H:i:s Y T", filectime($SCRIPT_FILENAME))."<br>/* $Id$ */";

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
            <p>The team is currently focused on several areas: </p>
            <ul>
              <li><span class="lihack">Providing QA for the 
			  	<a href="http://www.php.net/~zeev/php-4.1.0RC3.tar.gz">PHP 4.1.0 Final Release Candidate</a><br />
				Visit the experimental <a href="http://fooassociates.com/phpqa">PHP QA Wiki</a> to see what platforms have been tested so far.</span></li>
              <li><span class="lihack">Reworking the bug tracking system. (Subscribe to to <a href="mailto:jitterbug-subscribe@lists.php.net">jitterbug-subscribe@lists.php.net</a> 
                for more information)</span></li>
              <li><span class="lihack">Processing the open bug reports from the official PHP 4 bug 
                list (<a href="http://bugs.php.net" target="_blank">http://bugs.php.net</a>).</span></li>
            </ul>
          </td>
          <td width="10">&nbsp;</td>
        </tr>
        <tr> 
          <td width="10">&nbsp;</td>
          <td width="100%">If you would like to contribute to this effort, please 
            visit our How To Help page. (<a href="howtohelp.php">view</a>)</td>
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
