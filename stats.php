<?php

include("include/functions.php");

$TITLE = "Stats Help [PHP-QAT: Quality Assurance Team]";
$SITE_UPDATE = date("D M d H:i:s Y T", filectime($SCRIPT_FILENAME));
/* $Id$ */

common_header();

$year = date ('Y');

?>
	<table width="70%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="10"><img src="gfx/spacer.gif" width="10" height="1"></td>
          <td width="100%"> 
            <h1>Statistics <?php echo $year; ?></h1>
          </td>
          <td width="10"><img src="gfx/spacer.gif" width="10" height="1"></td>
        </tr>
        <tr> 
          <td width="10">&nbsp;</td>
          <td width="100%">
           <?php include('http://www.php.net/~jani/bugsmap001'); ?>
           <img src="http://www.php.net/~jani/total-count-<?php echo $year; ?>.png" ISMAP USEMAP="#bugsmap001" border="0" alt=""><br /><br />
          </td>
          <td width="10">&nbsp;</td>
        </tr>
      </table>
<?php

common_footer();
?>
