#!/usr/bin/perl -w

# Brendan W. McAdams <bmcadams@php.net>
# PHP QA Team (c) 2000

# - fetchCVS - 
# grab the latest php4, Zend and TSRM source trees from CVS and set them up to compile.
# Also do some testing to see if essential tools are around.

# print our header ..

print "PHP QA Team fetchCVS $Revision$\n";
print "$Id$\n";
print "-------------------------------------------------------\n";
print "Brendan W. McAdams <bmcadams@php.net>\n";

# Check for our 3 required tools ...
$autoconf  =  system("which autoconf");
$automake =  system("which automake");
$libtool		= system("which libtool");
$cvs 			= system("which cvs");

if (!$autoconf) {
	
	die "The build process requires GNU autoconf v2.13 or greater, available via ftp from ftp.gnu.org\n";
	
} elsif (!$automake) {
	
	die "The build process requires GNU automake v1.4 or greater, available via ftp from ftp.gnu.org\n";
	
} elsif (!$libtool) {
	
	die "The build process requires GNU libtool v1.3.3 or greater, available via ftp from ftp.gnu.org\n";
	
}
