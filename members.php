<?php
include("include/functions.php");

$TITLE = "Member List [PHP-QAT: Quality Assurance Team]";
$SITE_UPDATE = date("D M d H:i:s Y T", filectime($SCRIPT_FILENAME))."<br>
/* $Id$ */";

$member_list = array(
	array("name" => "André Langhorst",
		"email" => "andre@php.net",
		"focus" => "QA for RCs and QA in general",
		"skills" => "preparing sushi, C/C++, PHP, Java, XML, XSLT...",
		"platform" => array("FreeBSD4.4","Debian Woody","W2K (sometimes)","- modules and SAPIs varying")
	),

	array(
		"name" => "Derick Rethans",
		"email" => "derick@php.net",
		"focus" => "Guarding release process",
		"skills" => "C, PHP (yes, really), DB Design... and much much more",
		"platform" => array(
			"Redhat Linux 7.1 - Apache static module - gd, ttf, mysql, pdflib, ftp, srm, mcrypt, ctype, gmp, ldap, ncurses, shmop, sockets, sysvsem, sysvshm, wddx, zlib ",
			"Redhat Linux 7.1 - CGI/CLI - gd, ttf, mysql, pdflib, ftp, zip, srm, mcrypt, ctype, gmp, shmop, sockets, sysvsem, sysvshm, wddx, zlib ",
			"FreeBSD 4.4 stable - Apache static module - mysql, mcrypt, gd, wddx",
			"FreeBSD 4.4 stable - CGI/CLI - mysql, mcrypt, gd, wddx",
			"SunOS 5.8/i386 - Apache static module - ftp, mysql, ctype, sockets, shmop, sysvsem, sysvshm",
			"SunOS 5.8/i386 - CGI/CLI - ftp, mysql, ctype, sockets, shmop, sysvsem, sysvshm",
			"OpenBSD 2.8 - Apache static module - mysql, ftp, ctyup, shmop, sockets, sysvsem, sysvshm, wddx, zlib",
			"OpenBSD 2.8 - CGI/CLI - mysql, ftp, ctyup, shmop, sockets, sysvsem, sysvshm, wddx, zlib"
		)
	),

	array(
		"name" => "Hellekin O. Wolf",
		"email" => "hellekin@php.net",
		"focus" => "Testing RC builds",
		"skills" => "PHP",
		"platform" => array("Debian GNU/Linux SID + Apache 1.3.20")
	),

	array(
		"name" => "James Moore",
		"email" => "jmoore@php.net",
		"focus" => "Windows Performance and Bugs, Release Testing",
		"skills" => "C/C++, PHP, Java, XML, XSLT .......",
		"platform" => array("Windows 2000 Professional", "Linux Redhat", "BeOS (Newbie)")
	),

	array(
		"name" => "Jan Lehnardt",
		"email" => "jan@php.net",
		"focus" => "Documentation, PEAR, Databases",
		"skills" => "PHP, (My)SQL, some C, PASCAL (hooray ;), Unix Administration",
		"platform" => array("FreeBSD 4.2-STABLE")
	),

	array(
		"name" => "Jani Taskinen",
		"email" => "sniper@php.net",
		"focus" => "Bug Hunting",
		"skills" => "Kossu Fu",
		"platform" => array()
	),

	array(
		"name" => "Joey Smith",
		"email" => "joey@php.net",
		"focus" => "Sybase, domxml, builds",
		"skills" => "C, PHP, Sybase, Unix Admin, PgSQL",
		"platform" => array("Linux (Debian Woody, Debian Sarge, Slackware 7.0)")
	),

	array(
		"name" => "Karl Austin",
		"email" => "karl@karl.co.uk",
		"focus" => "Testing",
		"skills" => "Design, Programming, Hosting",
		"platform" => array("RH 7.1 2.4.14", "RH 7.1 2.4.10", "WinXP Pro")
	),
					  
	array(
		"name" => "Lars Torben Wilson",
		"email" => "torben@php.net",
		"focus" => "Documentation",
		"skills" => "PHP, XML, XSLT",
		"platform" => array("Linux Debian testing/unstable")
	),

	array(
		"name" => "Liz Kimber",
		"email" => "liz@xcalibur.demon.co.uk",
		"focus" => "Bug hunting, compilation, linux, windows",
		"skills" => "all round techy/geek, unix+windows (no mac!)", 
		"platform" => array("Slackware Linux","NT 4","W2K","WXP")
		),		
		  
	array(
		"name" => "Marco Kaiser",
		"email" => "bate@php.net",
		"focus" => "Testing Builds / PHP-QAT Website",
		"skills" => "PHP, C++, Perl, HTML, Javascript, Photoshop",
		"platform" => array(
					"FreeBSD 4.4: Apache + mod_perl + mod_ssl + openssl + GDLIB Support + MySQL",
					"SuSe 7.x: Apache + mod_perl + mod_ssl + openssl + GDLIB Support + MySQL"
				   )
	),
							
	array(
		"name" => "Olivier Cahagne",
		"email" => "olivier.cahagne@epita.fr",
		"focus" => "Testing builds",
		"skills" => "PHP",
		"platform" => array("NetBSD 1.5 + Apache 1.3 + suEXEC", "Win2k + Apache 1.3 + IIS")
	),

	array(
		"name" => "Phil Driscoll",
		"email" => "phil@dialsolutions.co.uk",
		"focus" => "Windows installer",
		"skills" => "Competent C programmer, Linux newbie",
		"platform" => array("SuSE Linux on various x86 platforms", "Occasional access to NT4")
	),

	array(
		"name" => "Richard Lynch",
		"email" => "ceo@l-i-e.com",
		"focus" => "Kibbitzing",
		"skills" => "Patience with newbies",
		"platform" => array("The less I have to pretend to be an IT Admin, the better.","RedHat","Windows","Mandrake")
	),

	array(
		"name" => "Sebastian Bergmann",
		"email" => "sebastian@php.net",
		"focus" => "Testing Builds",
		"skills" => "PHP, Java",
		"platform" => array("Win32 + Apache2", "Linux 2.4.xx + Apache2")
	),
    array(
        "name" => "Sebastian Nohn",
        "email" => "sebastian@nohn.net",
        "focus" => "Testing snapshots, QA RCs",
        "skills" => "PHP, SQL, HTML, JavaScript",
        "platform" => array(
                        "SuSE Linux 7.3 on AMD Duron (Apache 1.3.x, CLI | mySQL, GD, LDAP, IMAP, WDDX, FTP, mnoGoSearch, Ming, PDFlib)",
                        "Compaq Tru64 on Alpha (Apache 1.3.x, CLI | EXIF, WDDX, FTP, OCI8, mySQL)",
                        "Solaris 7 on UltraSparc (Apache 1.3.x, CLI | EXIF, WDDX, FTP, GD, OCI8)"
                        )
    ),
	array(
		"name" => "Yasuo Ohgaki",
		"email" => "yohgaki@php.net",
		"focus" => "QA, Maintain PostgreSQL Module",
		"skills" => "Some skills that are useful",
		"platform" => array("Linux + Apache basically")
	),

	array(
		"name" => "Zak Greant",
		"email" => "zak@php.net",
		"focus" => "Organizing the PHP QA effort",
		"skills" => "PHP, HTML, JavaScript",
		"platform" => array("SuSe 7.1: Apache 1.3.20 + MySQL + Postgres")
	)
);

$supportmember_list = array(

			  array(
				"name" => "Hartmut Holzgraefe",
				"email" => "harmut@six.de",
				"focus" => "empty",
				"skills" => "empty",
				"platform" => array()
			   )
);		

$inactivemember_list = array(
				"Alexander Feldman",
				"Andreas Otto",
				"Brendan W. McAdams",
				"Cameron Brunner ",
				"Evan Klein",
				"Howard Cohodas",
				"Jalal Pushman",
				"Kirill Maximov",
				"Mårten Gustafson",
				"Patrik Bengtsson",
				"Rebecca \"Bean\" Visger",
				"Shawn Wallace"
);

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
<!--
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
//-->        
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
				  	// BEGIN platform
				 	for ($y=0; $y < count ($member_list[$x]["platform"]); $y++) {
				 		if (strcmp($member_list[$x]["platform"][$y],"empty")==0) continue;
				  ?>
                  <li class="lihack">platform <?= ($y+1).": ".$member_list[$x]["platform"][$y]; ?></li>
                  <?php
				  	} // END platform
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
				  	// BEGIN platform
				 	for ($y=0; $y < count ($supportmember_list[$x]["platform"]); $y++) {
				  ?>
                  <li class="lihack">platform <?= ($y+1).": ".$supportmember_list[$x]["platform"][$y]; ?></li>
                  <?php
				  	} // END platform
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
