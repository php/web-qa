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
 <title><?php echo $GLOBALS["TITLE"]; ?></title>
 <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
 <meta name="MSSmartTagsPreventParsing" content="TRUE">
 <link rel="stylesheet" href="/styles.css" type="text/css">
</head>

<body bgcolor="#ffffff" text="#000000" link="#000000" vlink="#000000" alink="#000000">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td bgcolor="#ffcc66"><img src="/gfx/spacer.gif" width="5" height="1" alt="">
	<a href="http://qa.php.net/"><img src="/gfx/logo_qa.jpg" width="111" height="58" border="0" alt="QA logo"></a></td>
    <td bgcolor="#ffcc66" align="right" valign="bottom"> 
      <table border="0" cellspacing="0" cellpadding="0" style="height:70px">
        <tr> 
          <td align="right" valign="top" class="headline_white"><?php echo date("l, F d, Y"); ?></td>
          <td align="right" valign="top" class="headline_white"><img src="/gfx/spacer.gif" width="5" height="1" alt=""></td>
        </tr>
        <tr> 
          <td valign="bottom" align="right"><a href="/" class="head_links">Home</a> 
            | <a href="/projects.php" class="head_links">Projects and Goals</a> 
            | <a href="/rc.php" class="head_links">Release Candidates</a> 
            | <a href="/howtohelp.php" class="head_links">How to Help</a>
            | <a href="/handling-bugs.php" class="head_links">Handling Bug Reports</a>
            | <a href="/reports/" class="head_links">Test reports</a>
          </td>
          <td valign="bottom" align="right" class="head_links">&nbsp;</td>
        </tr>
      </table>
    </td>
  </tr>
  <tr> 
    <td colspan="2" bgcolor="#000000" height="1"><img alt="" src="/gfx/spacer.gif" width="1" height="1" border="0"></td>
  </tr>
  <tr> 
      <td colspan="2" bgcolor="#ff9900" align="right" class="head_links">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" bgcolor="#000000" height="1"><img alt="" src="/gfx/spacer.gif" width="1" height="1"></td>
  </tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0" style="height:70%">
  <tr>
    <td width="200" bgcolor="#eeeeee" align="center" valign="top"> 
      <table width="95%" border="0" cellspacing="0" cellpadding="0">
	<tr>
	 <td class="sidebox">
            <h2>PHP-QAT</h2>
          </td>
         </tr>
        <tr> 
          <td class="sidebox"> 		
            The PHP/QA Team is a small group of developers 
              whose primary goal is to support the PHP core developers by providing 
              them with timely quality assurance.
          </td>
        </tr>
        <tr> 
          <td class="sidebox"> 
            <h2>Projects &amp; Goals</h2>
          </td>
        </tr>
        <tr> 
          <td class="sidebox">
            Find more information about PHP/QA Team's <a href="/projects.php">current 
              projects and future goals</a>.
          </td>
        </tr>
        <tr> 
          <td class="sidebox"> 
            <h2>Release Candidates</h2>
          </td>
        </tr>
        <tr> 
          <td class="sidebox">
            What are <a href="/rc.php">release candidates</a> and how you can help us testing them.
          </td>
        </tr>
        <tr> 
          <td class="sidebox"> 
            <h2>Contact Information</h2>
          </td>
        </tr>
        <tr> 
          <td class="sidebox"> 
            Questions about the PHP-QAT should be sent to the
            <a href="mailto:php-qa@lists.php.net">PHP/QAT Mailing List</a>
            <br />
            <br />

            Bug Reports should be submitted to the official PHP bug list 
            (<a href="http://bugs.php.net/" target="_blank">http://bugs.php.net</a>)
            <br />
            <br />

            All other questions should be directed to the appropriate
            <a href="http://www.php.net/support.php" target="_blank">PHP mailing list.</a>
            </td>
        </tr>
      </table>
      <img alt="" src="/gfx/spacer.gif" width="1" height="20"></td>
    <td style="background:url(/gfx/line_1.jpg); width: 1px;"><img alt="" src="/gfx/spacer.gif" width="1" height="1"><br>
</td>
    <td align="left" valign="top" bgcolor="#FFFFFF"> <br>
<?php
}

function common_footer() {
?>
 </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td bgcolor="#000000"><img alt="" src="/gfx/spacer.gif" width="1" height="1"></td>
  </tr>
  <tr> 
    <td bgcolor="#ff9900">&nbsp;</td>
  </tr>
  <tr> 
    <td bgcolor="#000000"><img alt="" src="/gfx/spacer.gif" width="1" height="1"></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="height:60px">
  <tr valign="middle"> 
    <td bgcolor="#cccccc" align="left" width="100%"> 
      <table border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="80" align="center"><a href="http://www.php.net/"><img src="/gfx/php-logo.gif" width="69" height="36" border="0" alt="Go to the main PHP site"></a></td>
          <td class="footer"><a href="http://www.php.net/copyright.php" target="_blank">Copyright 
            &copy; 1997 - <?php echo date('Y', time()); ?> PHP Group</a><br>
            All rights reserved.</td>
        </tr>
      </table>
    </td>
    <td bgcolor="#cccccc" nowrap align="right" class="footer">Last 
      update: <?php echo $GLOBALS["SITE_UPDATE"]; ?></td>
    <td bgcolor="#cccccc" nowrap align="right" class="footer"><img alt="" src="/gfx/spacer.gif" width="10" height="1"></td>
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

function is_valid_php_version($version, $QA_RELEASES = array()) {
	
	if (isset($QA_RELEASES['reported']) && in_array($version, $QA_RELEASES['reported'])) {
		return true;
	}
	
	if (preg_match('@^\d{1}\.\d{1}\.\d{1,}(?:(?:RC|alpha|beta)\d{0,2})?(?:-dev)?$@i', $version)) {
		return true;
	}
	
	return false;
}
