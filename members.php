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
							
					  array("name" => "Jalal Pushman",
							"email" => "the_jalal@yahoo.com",
							"focus" => "empty",
							"skills" => "empty",
							"plattform" => array("empty",
												 "empty"
												 )
							),
							
					  array("name" => "James Moore",
							"email" => "jmoore@php.net",
							"focus" => "empty",
							"skills" => "empty",
							"plattform" => array("empty",
												 "empty"
												 )
							),
							
					  array("name" => "Jani Taskinen",
							"email" => "sniper@php.net",
							"focus" => "empty",
							"skills" => "empty",
							"plattform" => array("empty",
												 "empty"
												 )
							),
							
					  array("name" => "Joey Smith",
							"email" => "joey@php.net",
							"focus" => "empty",
							"skills" => "empty",
							"plattform" => array("empty",
												 "empty"
												 )
							),
							
					  array("name" => "Olivier Cahagne",
							"email" => "olivier.cahagne@epita.fr",
							"focus" => "empty",
							"skills" => "empty",
							"plattform" => array("empty",
												 "empty"
												 )
							),
							
					  array("name" => "Phil Driscoll",
							"email" => "phil@dialsolutions.co.uk",
							"focus" => "empty",
							"skills" => "empty",
							"plattform" => array("empty",
												 "empty"
												 )
							),
							
					  array("name" => "Sebastian Bergmann",
							"email" => "sebastian@php.net",
							"focus" => "Testing Builds",
							"skills" => "PHP, Java",
							"plattform" => array("Win32 + Apache2",
												 "Linux 2.4.xx + Apache2"
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
							)
 					);

$supportmember_list = array( array("name" => "Brendan W. McAdams",
							"email" => "brendan@plexmedia.com",
							"focus" => "empty",
							"skills" => "empty",
							"plattform" => array("empty",
												 "empty"
												 )
							),
							
					  array("name" => "Cameron Brunner ",
							"email" => "gamr@gattcomp.com.au",
							"focus" => "empty",
							"skills" => "empty",
							"plattform" => array("empty",
												 "empty"
												 )
							),
							
					  array("name" => "Hartmut Holzgraefe",
							"email" => "harmut@six.de",
							"focus" => "empty",
							"skills" => "empty",
							"plattform" => array("empty",
												 "empty"
												 )
							),
							
					  array("name" => "Howard Cohodas",
							"email" => "Howard.Cohodas@dkt.com",
							"focus" => "empty",
							"skills" => "empty",
							"plattform" => array("empty",
												 "empty"
												 )
							),
							
					  array("name" => "Kirill Maximov",
							"email" => "maxkir@email.com",
							"focus" => "empty",
							"skills" => "empty",
							"plattform" => array("empty",
												 "empty"
												 )
							),
							
					  array("name" => "Richard Lynch",
							"email" => "richard@zend.com",
							"focus" => "empty",
							"skills" => "empty",
							"plattform" => array("empty",
												 "empty"
												 )
							)
					);

$inactivemember_list = array("Alexander Feldman",
							 "Andreas Otto",
							 "Evan Klein",
							 "Karl Austin",
							 "Mårten Gustafson",
							 "Patrik Bengtsson",
							 "Rebecca \"Bean\" Visger",
							 "Shawn Wallace");

common_header();
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
              <li class="lihack"><b><?= $member_list[$x]["name"]."</b> [".make_link("mailto:".$member_list[$x]["email"], $member_list[$x]["email"])."]"; ?>
                <ul>
                  <li class="lihack">Skills: <?= $member_list[$x]["skills"]; ?></li>
                  <li class="lihack">Focus: <?= $member_list[$x]["focus"]; ?></li>
				  <?php 
				  	// BEGIN PLATTFORM
				 	for ($y=0; $y < count ($member_list[$x]["plattform"]); $y++) {
				  ?>
                  <li class="lihack">Plattform <?= ($y+1).": ".$member_list[$x]["plattform"][$y]; ?></li>
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
        <tr> 
          <td width="10">&nbsp;</td>
          <td width="100%"> 
            <h3>PHP-QAT Supporting Members:</h3>
          </td>
          <td width="10">&nbsp;</td>
        </tr>
<?php
// BEGIN SUPPORT MEMMBERS
for ($x=0; $x < count($supportmember_list); $x++) {
?>
        <tr> 
          <td width="10">&nbsp;</td>
          <td width="100%"> 
            <ul>
              <li class="lihack"><b><?= $supportmember_list[$x]["name"]."</b> [".make_link("mailto:".$supportmember_list[$x]["email"], $supportmember_list[$x]["email"])."]"; ?>
                <ul>
                  <li class="lihack">Skills: <?= $supportmember_list[$x]["skills"]; ?></li>
                  <li class="lihack">Focus: <?= $supportmember_list[$x]["focus"]; ?></li>
				  <?php 
				  	// BEGIN PLATTFORM
				 	for ($y=0; $y < count ($supportmember_list[$x]["plattform"]); $y++) {
				  ?>
                  <li class="lihack">Plattform <?= ($y+1).": ".$supportmember_list[$x]["plattform"][$y]; ?></li>
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
        <tr> 
          <td width="10">&nbsp;</td>
          <td width="100%"> 
            <h3>PHP-QAT Inactive Members:</h3>
          </td>
          <td width="10">&nbsp;</td>
        </tr>
        <tr> 
          <td width="10">&nbsp;</td>
          <td width="100%"> 
            <ul>
<?php
// BEGIN SUPPORT MEMMBERS
for ($x=0; $x < count($inactivemember_list); $x++) {
            echo "<li class=\"lihack\">".$inactivemember_list[$x]."</li>";
} // END MEMBERS
?>
            </ul>
            </td>
          <td width="10">&nbsp;</td>
        </tr>
      </table>
<?php

common_footer();
?>