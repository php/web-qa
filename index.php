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
            <p>The team is currently focused on several areas: </p>
            <ul>
              <li>
                <span class="lihack">Providing QA for the <a href="http://www.php.net/~derick/php-4.2.0RC2.tar.gz">PHP 4.2.0RC2</a> release.</span><br />
            </ul>
			<p>
You can help use by completing one of the following tasks:<br />
<br />
Simple build tests<br />
<ol>
   <li>Download the RC from: <a href="http://www.php.net/~derick/">http://www.php.net/~derick/</a>
     <ul>
       <li><a href="http://www.php.net/~derick/php-4.2.0RC4.tar.gz">php-4.2.0RC4.tar.gz</a> (Source)

	   <li><a href="http://www.php.net/~derick/php-4.2.0RC4-win32.zip">php-4.2.0RC4-win32.zip</a>
		   (windows binaries: CLI, CGI, ISAP module and extensions: cpdf,
		   ctype, cybercash, db, dbx, domxml, fdsql, fdf, filepro, gd, gettext,
		   java, mhash, oci8, openssl, pdf, pgsql, shmop, sockets, tokeniser,
		   w32api, xslt and zlib (all without libraries!!!) - <b>you may find you 
		   need to go with RC3 win32 builds if you get a 404 error.</b>

       <li>php4apache.dll (apache 1.3.23 module for windows)
     </ul>

  <li>Build and test the RC
  <li>Provide feedback through: 
      <a href="http://qa.php.net/buildtest-submit.php">http://qa.php.net/buildtest-submit.php</a>
</ol>
If you are really serious, you can also help us run testcases in the 
following ways:
<ol>
  <li>Run 'make test' after you build from source (non-windows only) and 
      provide feedback to php-qa@lists.php.net

  <li>Run testcases, which you can find on: <a
	  href="http://qa.php.net/testcases-4.2.0.php">http://qa.php.net/testcases-4.2.0.php</a>.<br
	  /> These testcases address areas of PHP, which need some special
	  attention during the Release Process. It's very important that you run
	  these cases very thouroughly. You can provide feedback with <a
	  href="http://qa.php.net/buildtest-submit.php">http://qa.php.net/buildtest-submit.php</a>
	  (specify your testcase there).
</ol>
If you have any questions, please mail to the php-qa@lists.php.net 
mailinglist.
            <ul>
              <li>
                <span class="lihack">Reworking the bug tracking system. (Subscribe to the 
                <a href="mailto:jitterbug-subscribe@lists.php.net">list</a> 
                for more information)</span></li><br />
              <li><span class="lihack">Processing the open bug reports from the official PHP 4 bug 
                list (<a href="http://bugs.php.net" target="_blank">http://bugs.php.net</a>).</span></li><br />
            </ul>
            <br />
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
