<?php
/* 
(c)'2001 by Marco Kaiser (bate@php.net) and the PHP Group 	
Read an Learn. Any Questions so ask. 						

Version: $Id$
*/

function common_header() {
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
 <title><?= $GLOBALS["TITLE"]; ?></title>
 <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
 <meta name="MSSmartTagsPreventParsing" content="TRUE">
 <link rel="stylesheet" href="styles.css" type="text/css">
</head>

<body bgcolor="#ffffff" text="#000000" link="#000000" vlink="#000000" alink="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<table width="100%" border="0" cellspacing="0" cellpadding="0" height="102">
  <tr> 
    <td bgcolor="#ffcc66"><img src="gfx/spacer.gif" width="5" height="1"><img src="gfx/logo_qa.jpg" width="111" height="58"></td>
    <td bgcolor="#ffcc66" align="right" valign="bottom"> 
      <table border="0" cellspacing="0" cellpadding="0" height="70">
        <tr> 
          <td align="right" valign="top" class="headline_white"><?= date("l, F d, Y", time()); ?></td>
          <td align="right" valign="top" class="headline_white"><img src="gfx/spacer.gif" width="5" height="1"></td>
        </tr>
        <tr> 
          <td valign="bottom" align="right"><a href="/" class="head_links">Home</a> 
            | <a href="projects.php" class="head_links">Projects and Goals</a> 
            | <a href="links.php" class="head_links">Links &amp; Resources</a> 
            | <a href="members.php" class="head_links">Members</a>
            | <a href="howtohelp.php" class="head_links">How to help</a>
          </td>
          <td valign="bottom" align="right" class="head_links">&nbsp;</td>
        </tr>
      </table>
    </td>
  </tr>
  <tr> 
    <td colspan="2" bgcolor="#000000" height="1"><img src="gfx/spacer.gif" width="1" height="1" border="0"></td>
  </tr>
  <tr> 
    <form method="get" action="http://bugs.php.net/search.php" target="_blank">
      <td colspan="2" bgcolor="#ff9900" align="right" class="head_links"> search 
        bugs for 
      <input type="hidden" name="cmd" value="display">
        <input type="text" name="search_for" value="" size="30" class="small">
        <input type="image" src="gfx/submit.gif" border="0" width="11" height="11" alt="search" align="bottom" name="image">&nbsp;<img src="gfx/spacer.gif" width="3" height="8" border="0"></td>
    </form>
  </tr>
  <tr>
    <td colspan="2" bgcolor="#000000" height="1"><img src="gfx/spacer.gif" width="1" height="1"></td>
  </tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="200" bgcolor="#eeeeee" align="center" valign="top"> 
      <table width="95%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="5"><img src="gfx/spacer.gif" width="5" height="1"></td>
          <td>&nbsp;</td>
          <td width="5"><img src="gfx/spacer.gif" width="5" height="1"></td>
        </tr>
        <tr> 
          <td width="5">&nbsp;</td>
          <td> 
            <h2>PHP-QAT</h2>
          </td>
          <td width="5">&nbsp;</td>
        </tr>
        <tr> 
          <td width="5">&nbsp;</td>
          <td class="head_links"> 
            The PHP/QA Team is a small group of developers 
              whose primary goal is to support the PHP core developers by providing 
              them with timely quality assurance.
          </td>
          <td width="5">&nbsp;</td>
        </tr>
        <tr> 
          <td width="5">&nbsp;</td>
          <td>&nbsp;</td>
          <td width="5">&nbsp;</td>
        </tr>
        <tr> 
          <td width="5">&nbsp;</td>
          <td> 
            <h2>Projects &amp; Goals</h2>
          </td>
          <td width="5">&nbsp;</td>
        </tr>
        <tr> 
          <td width="5">&nbsp;</td>
          <td class="head_links"> 
            Find more information about PHP/QA Team's <a href="projects.php">current 
              projects and future goals</a>.
          </td>
          <td width="5">&nbsp;</td>
        </tr>
        <tr> 
          <td width="5">&nbsp;</td>
          <td>&nbsp;</td>
          <td width="5">&nbsp;</td>
        </tr>
        <tr> 
          <td width="5">&nbsp;</td>
          <td> 
            <h2>Links &amp; Resources</h2>
          </td>
          <td width="5">&nbsp;</td>
        </tr>
        <tr> 
          <td width="5">&nbsp;</td>
          <td class="head_links"> 
            Visit the PHP|QAT <a href="links.php">Links &amp; Resources</a> page. 
              We have links to web based resources for ...
          </td>
          <td width="5">&nbsp;</td>
        </tr>
        <tr> 
          <td width="5">&nbsp;</td>
          <td>&nbsp;</td>
          <td width="5">&nbsp;</td>
        </tr>
        <tr> 
          <td width="5">&nbsp;</td>
          <td> 
            <h2>Members</h2>
          </td>
          <td width="5">&nbsp;</td>
        </tr>
        <tr> 
          <td width="5">&nbsp;</td>
          <td class="head_links"> 
            View the PHP-QAT <a href="members.php">Member register</a>.
          </td>
          <td width="5">&nbsp;</td>
        </tr>
        <tr> 
          <td width="5">&nbsp;</td>
          <td>&nbsp;</td>
          <td width="5">&nbsp;</td>
        </tr>
        <tr> 
          <td width="5">&nbsp;</td>
          <td> 
            <h2>Contact Information</h2>
          </td>
          <td width="5">&nbsp;</td>
        </tr>
        <tr> 
          <td width="5">&nbsp;</td>
          <td class="head_links"> 
            
              <p>Questions about the PHP/QAT should be sent to the <a href="mailto:php-qa@lists.php.net">PHP/QAT 
                Mailing List</a></p>
              <p> Questions regarding this site should be sent to the <a href="mailto:bate@php.net">PHP/QAT 
                Site Administrator</a></p>
              <p> Bug Reports should be submitted to the official PHP bug list 
                (<a href="http://bugs.php.net/" target="_blank">http://bugs.php.net</a>)</p>
              <p> All other questions should be directed to the appropriate <a href="http://www.php.net/support.php" target="_blank">PHP 
                mailing list.</a> </p>
            
          </td>
          <td width="5">&nbsp;</td>
        </tr>
      </table>
      <img src="gfx/spacer.gif" width="1" height="20"></td>
    <td background="gfx/line_1.jpg" width="1"><img src="gfx/spacer.gif" width="1" height="1"><br>
</td>
    <td align="left" valign="top" bgcolor="#FFFFFF"> <br>
<?php
}

function common_footer() {
?>
 </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" height="22">
  <tr> 
    <td bgcolor="#000000"><img src="gfx/spacer.gif" width="1" height="1"></td>
  </tr>
  <tr> 
    <td bgcolor="#ff9900">&nbsp;</td>
  </tr>
  <tr> 
    <td bgcolor="#000000"><img src="gfx/spacer.gif" width="1" height="1"></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" height="60">
  <tr valign="middle"> 
    <td bgcolor="#cccccc" align="left" width="100%"> 
      <table border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="80" align="center"><a href="http://www.php.net/"><img src="gfx/php-logo.gif" width="69" height="36" border="0" alt="Go to the main PHP site"></a></td>
          <td class="footer"><a href="http://www.php.net/copyright.php" target="_blank">Copyright 
            &copy; 2001 PHP Group</a><br>
            All rights reserved.</td>
        </tr>
      </table>
    </td>
    <td bgcolor="#cccccc" nowrap align="right" class="footer">Last 
      update: <?= $GLOBALS["SITE_UPDATE"]; ?></td>
    <td bgcolor="#cccccc" nowrap align="right" class="footer"><img src="gfx/spacer.gif" width="10" height="1"></td>
  </tr>
</table>
</body>
</html>
<?php
}

function make_link($string, $text = "", $target = "") {
	$buffer = "<a href=\"$string\"";
	if ($target!="") $buffer .= " target=\"$target\">"; else $buffer .= ">";
	if ($text!="") $buffer .= "$text"; else $buffer .= "$string";
	$buffer .= "</a>";
	return $buffer;
}

?>
