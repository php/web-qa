<?php
include("include/functions.php");

$TITLE = "Member List [PHP-QAT: Quality Assurance Team]";
$SITE_UPDATE = date("D M d H:i:s Y T", filectime($SCRIPT_FILENAME))."<br>/* $Id$ */";

$member_list = array( array("name" => "André Langhorst",
							"email" => "andre@php.net",
							"focus" => "empty",
							"skills" => "empty",
							"plattform" => array("empty",
												 "empty"
												 )
							),
							
					  array("name" => "Hellekin O. Wolf",
							"email" => "ellekin@php.net",
							"focus" => "empty",
							"skills" => "empty",
							"plattform" => array("empty",
												 "empty"
												 )
							),
							
					  array("name" => "Hellekin O. Wolf",
							"email" => "ellekin@php.net",
							"focus" => "empty",
							"skills" => "empty",
							"plattform" => array("empty",
												 "empty"
												 )
							),
							
					  array("name" => "Hellekin O. Wolf",
							"email" => "ellekin@php.net",
							"focus" => "empty",
							"skills" => "empty",
							"plattform" => array("empty",
												 "empty"
												 )
							),
							
					  array("name" => "Hellekin O. Wolf",
							"email" => "ellekin@php.net",
							"focus" => "empty",
							"skills" => "empty",
							"plattform" => array("empty",
												 "empty"
												 )
							),
							
					  array("name" => "Hellekin O. Wolf",
							"email" => "ellekin@php.net",
							"focus" => "empty",
							"skills" => "empty",
							"plattform" => array("empty",
												 "empty"
												 )
							),
							
					  array("name" => "Hellekin O. Wolf",
							"email" => "ellekin@php.net",
							"focus" => "empty",
							"skills" => "empty",
							"plattform" => array("empty",
												 "empty"
												 )
							),
							
					  array("name" => "Hellekin O. Wolf",
							"email" => "ellekin@php.net",
							"focus" => "empty",
							"skills" => "empty",
							"plattform" => array("empty",
												 "empty"
												 )
							),
							
					  array("name" => "Hellekin O. Wolf",
							"email" => "ellekin@php.net",
							"focus" => "empty",
							"skills" => "empty",
							"plattform" => array("empty",
												 "empty"
												 )
							),
							
					  array("name" => "Zak Greant",
							"email" => "zak@php.net",
							"focus" => "empty",
							"skills" => "empty",
							"plattform" => array("empty",
												 "empty"
												 )
							),
							
					  array("name" => "Marco Kaiser",
							"email" => "bate@php.net",
							"focus" => "Testing Builds / PHP-QAT Website",
							"skills" => "PHP, C++, Perl, HTML, Javascipt, Photoshop",
							"plattform" => array("FreeBSD 4.4: Apache + mod_perl + mod_ssl + openssl + GDLIB Support + MySQL",
												 "SuSe 7.x: Apache + mod_perl + mod_ssl + openssl + GDLIB Support + MySQL"
												 )
							),
 					);
						

/*
Jalal Pushman the_jalal@yahoo.com
James Moore jmoore@php.net
Jani Taskinen sniper@php.net
Joey Smith joey@php.net
Olivier Cahagne olivier.cahagne@epita.fr
Phil Driscoll phil@dialsolutions.co.uk
Sebastian Bergmann sebastian@php.net
*/
			
siteHeader();
?>
<table width="70%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="10"><img src="gfx/spacer.gif" width="10" height="1"></td>
          <td width="100%"> 
            <h1>PHP-QAT Members</h1>
          </td>
          <td width="10"><img src="gfx/spacer.gif" width="10" height="1"></td>
        </tr>
        <tr> 
          <td width="10">&nbsp;</td>
          <td width="100%"><b><font color="#FF9900">To become a member</font></b>, 
            you need to contribute to the PHP Quality Assurance effort. We always 
            need people to hunt for bugs, to test Release Candidates and otherwise 
            help out. Start by subscribing to the PHP|QA mailing list (Send a 
            blank message to <a href="mailto:php-qa-subscribe@lists.php.net">php-qa-subscribe@lists.php.net</a>. 
            Once you have subscribed, sent a message to the list introducing yourself. 
            We would like to know your name, your skill set and your interests 
            (as they relate to doing QA for PHP).<br>
            Every once in a while core QA team members review and update the membership 
            list. If you have been actively contributing to the effort for a while, 
            we may ask you to join the group. Also, you can mail the group and 
            ask to become a member. </td>
          <td width="10">&nbsp;</td>
        </tr>
        <tr> 
          <td width="10">&nbsp;</td>
          <td width="100%">&nbsp;</td>
          <td width="10">&nbsp;</td>
        </tr>
        <tr> 
          <td width="10">&nbsp;</td>
          <td width="100%"><b><font color="#FF9900">Wanted:</font></b><br>
            If you have any of the following platforms which can be used for testing 
            please contact us Now: </td>
          <td width="10">&nbsp;</td>
        </tr>
        <tr> 
          <td width="10">&nbsp;</td>
          <td width="100%"> 
            <ul>
              <li class="lihack">MAC OS</li>
              <li class="lihack">MAC OS X</li>
            </ul>
          </td>
          <td width="10">&nbsp;</td>
        </tr>
        <tr> 
          <td width="10">&nbsp;</td>
          <td width="100%"> 
            <h3>PHP-QAT Members:</h3>
          </td>
          <td width="10">&nbsp;</td>
        </tr>
<?php
// BEGIN MEMMBERS
for ($x=0; $x < count($member_list); $x++) {
?>
        <tr> 
          <td width="10">&nbsp;</td>
          <td width="100%"> 
            <ul>
              <li><b><?= $member_list[$x]["name"]."</b> [".make_link("mailto:".$member_list[$x]["email"], $member_list[$x]["email"])."]"; ?>
                <ul>
                  <li>Skills: <?= $member_list[$x]["skills"]; ?></li>
                  <li>Focus: <?= $member_list[$x]["focus"]; ?></li>
				  <?php 
				  	// BEGIN PLATTFORM
				 	for ($y=0; $y < count ($member_list[$x]["plattform"]); $y++) {
				  ?>
                  <li>Plattform <?= ($y+1).": ".$member_list[$x]["plattform"][$y]; ?></li>
                  <?php
				  	} // END PLATTFORM
				  ?>
                </ul>
              </li>
            </ul>
<?php
} // END MEMBERS
?>
            </td>
          <td width="10">&nbsp;</td>
        </tr>
        <tr>
          <td width="10">&nbsp;</td>
          <td width="100%"></td>
          <td width="10">&nbsp;</td>
        </tr>
      </table>
<?php

siteFooter();
?>