#!/usr/bin/perl -w

# Brendan W. McAdams <bmcadams@php.net>
# PHP QA Team (c) 2000

# - fetchCVS - 
# grab the latest php4, Zend and TSRM source trees from CVS and set them up to compile.
# Also do some testing to see if essential tools are around.

# print our header ..

system("clear");

print "PHP QA Team fetchCVS " . '$Revision$' . "\n";
print '$Id$\n';
print "-------------------------------------------------------\n";
print "Brendan W. McAdams <bmcadams\@php.net>\n";

# Check for our 3 required tools ...
$autoconf  	= `which autoconf`;
$automake 	= `which automake`;
$libtool	= `which libtool`;
$cvs 		= `which cvs`;

chomp($autoconf);
chomp($automake);
chomp($libtool);
chomp($cvs);

if (!$autoconf) {
	
	die "The build process requires GNU autoconf v2.13 or greater, available via ftp from ftp.gnu.org\n Please install this application and ensure that it is in your system path.\n";
	
} elsif (!$automake) {
	
	die "The build process requires GNU automake v1.4 or greater, available via ftp from ftp.gnu.org\n Please install this application and ensure that it is in your system path.\n";
	
} elsif (!$libtool) {
	
	die "The build process requires GNU libtool v1.3.3 or greater, available via ftp from ftp.gnu.org\n Please install this application and ensure that it is in your system path.\n";
	
} elsif (!$cvs) {
	
	die "The build process requires CVS v1.10 or greater, available via web from http://www.cyclic.com\n Please install this application and ensure that it is in your system path.\n";

}

print "Please input the directory you wish to sync the PHP tree into.\n";
print "(We will sync into <directory>/php4)\n";

$directory = <STDIN>; # get the directory

chomp($directory);

if (-e $directory) { # if the dir exists
	
	chdir($directory); # go to the dir

} else {
	
	print "Can't find $directory so I'm creating it...\n";

	mkdir($directory); # make the directory
	chdir($directory); # go to the new dir

}

print "Please login to the PHP repository (the password is phpfi)\n";

system("$cvs -d :pserver:cvsread\@cvs.php.net:/repository login");

print "Syncing the PHP4 source in $directory/php4 ...\n";

@php_sync = `$cvs -d :pserver:cvsread\@cvs.php.net:/repository checkout php4`;

foreach $line (@php_sync) { # catch and print each line so we know when the sync is done 

	print $line;

}	

print "Please login to the Zend repository (the password is zend)\n";

system("$cvs -d :pserver:cvsread\@cvs.zend.com:/repository login");

print "Syncing the Zend source in $directory/php4/Zend ...\n";

@zend_sync = `$cvs -d :pserver:cvsread\@cvs.zend.com:/repository checkout Zend`;

foreach $line (@zend_sync) { # catch and print each line so we know when the sync is done 

	print $line;

}	

@tsrm_sync = `$cvs -d :pserver:cvsread\@cvs.zend.com:/repository checkout TSRM`;

foreach $line (@tsrm_sync) { # catch and print each line so we know when the sync is done 

	print $line;

}	
