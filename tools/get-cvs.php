<?php
/**************************************
 * get-cvs.php -- jalal @ gnomedia
 *
 * a rewrite of Brendan W. McAdams Perl script for fetching
 * the cvs tree from cvs.php.net and cvs.zend.com
 *
 * Description:
 * Runs some checks on the system (check for cvs prog etc)
 * Asks whether we are doing an update or a checkout.
 * Runs the appropriate cvs method.
 *
 * Notes:
 *
 * fopen("php://stdin", 'r') can only be called once in a script
 *   for reasons unknown.
 *
 * TODO:
 * mkdir() does not do recursive makes.
 * cwd() gives us the directory the script is in, not where we started it from.
 * 
 **************************************/
// some constants etc.
define( NL, "\n" );
define( UNIX, 1 );
define( WINDOWS, 2 );

$cvs_at_php = "-d :pserver:cvsread@cvs.php.net:/repository";
$cvs_at_zend = "-d :pserver:cvsread@cvs.zend.com:/repository";
$errors = array(); // only one error at present...

set_time_limit(0);
register_shutdown_function( "shutdown" );

print_header();

// system_check will store errors in $errors
system_check();

if( count($errors) > 0 ) {
  print "System failed checks, aborting.\n";
  print "Following errors were found:\n";
  foreach( $errors as $err ) {
    print $err . NL;
  }
  exit();
}

//
// OK, lets do some work.
//
// Is this a checkout or an update?
//
// "Checkout" will create a directory for the check out
// and then proceed to run the cvs checkout
//
// "Update" will check if there is a ./php4 directory
// and, if found, will run cvs update on it.
//
// "Quit" will, er, quit...;-}
//
$s = "Enter " . makebold("C") . "heckout, ";
$s .= makebold("U") ."pdate: " . makebold("Q") . "uit: ";
              
$mode = input( $s );
$mode = chop(strtoupper( $mode ));
switch( $mode ) {
 case 'C':
   print "Checking out files for php4" . NL;
   make_checkout_directory(); // will die() on failure, chdir() on success
   php_cvs_checkout();
   break;
 case 'U':
   // check for a php4 directory.
   $dir = chop(`pwd`);
   $dir = chop( $dir )  . '/php4';
   $dirhandle = opendir( $dir );
   if( ! $dirhandle ) { // no php4 directory
     die("Could not find php4 directory to update, quitting now...\n");
   }
   else { closedir( $dirhandle ); }
   echo "Updating files in php4" . NL;
   php_cvs_update();
   break;
 case "Q":
   die( "Quitting.\n" );
   break;
 default:
   die("Unrecognised menu option, quitting..." . NL);
}

print "Done! Next run ./buildconf; ./configure <options>; make; make install\n";

exit();

//=========== end of main ============//

function shutdown() {
  if( $fp ) {
    fclose( $fp );
  }
}

// we could use readline for this, but its not compiled in
// by default.
// fopen("php://stdin", 'r'); 
// can only be called once in a script, so 
// we have to reuse the handle.
function input( $prompt ) {
  global $fp;
  if( ! $fp ) {
    $fp = fopen("php://stdin", 'r');
  }
  if( $fp ) {
    print $prompt;
    $s = fgets($fp, 1024);
    return $s;
  }
  // couldn't open stdin
  die( "Error opening stdin for input, aborting...\n");
}

function php_cvs_checkout() {
  global $cvs_at_php, $cvs_at_zend;
  print "Connecting to cvs.php.net, use 'phpfi' as password.\n";
  exec( "cvs " . $cvs_at_php . " login" );
  exec( "cvs " . $cvs_at_php . " checkout php4" );
  exec( "cvs " . $cvs_at_php . " logout" );
  chdir("php4");
  print "Connecting to cvs.zend.com, use 'zend' as password.\n";
  exec( "cvs " . $cvs_at_zend . " login" );
  exec( "cvs " . $cvs_at_zend . " checkout Zend" );
  exec( "cvs " . $cvs_at_zend . " checkout TSRM" );
  exec( "cvs " . $cvs_at_zend . " logout" );
  
}

function php_cvs_update() {
  global $cvs_at_php, $cvs_at_zend;
  print "Connecting to cvs.php.net, use 'phpfi' as password.\n";
  exec( "cvs " . $cvs_at_php . " login" );
  exec( "cvs " . $cvs_at_php . " update php4" );
  exec( "cvs " . $cvs_at_php . " logout" );
  chdir("php4");
  print "Connecting to cvs.zend.com, use 'zend' as password.\n";
  exec( "cvs " . $cvs_at_zend . " login" );
  exec( "cvs " . $cvs_at_zend . " update Zend" );
  exec( "cvs " . $cvs_at_zend . " update TSRM" );
  exec( "cvs " . $cvs_at_zend . " logout" );
}

function make_checkout_directory() {
  $cwd = chop(`pwd`);
  $str =  makebold("Enter directory to put CVS tree in ($cwd)\n(php4 will be appended): ");
  $directory = chop(input( $str ));
  if( ! $directory ) {
    $directory = $cwd;
  }
  // does this directory exist?
  $dir = is_dir( $directory );
  if( ! $dir ) { // no
    $res = input( makebold( "Directory $directory does not exist, create it? [Y/N]" ) );
    if( substr( strtoupper($res), 0, 1 ) === "Y" ) {
      unset( $res );
      //TODO mkdir won't do multiple directories.
      $res = @mkdir( $directory, 0777 ); // minus umask
      if( ! $res ) {
        die( "Error creating directory $directory. Must finish now.\n" );
      }
    }
    else {
      die( "OK, I'm quitting then...\n" );
    }
  }
  chdir( $directory );
  print "Retrieving CVS into " . $directory . NL;
}

function system_check() {
  global $errors, $term_bold, $term_norm, $platform;
  // check if we have cvs
  print "Checking system... ";
  $res = `cvs --version `;
  if( strpos( $res, "Concurrent" ) > 0 ) {
    print "OK\n";
  }
  else {
    print "not found.\n";
    $errors[] = "CVS program not found.";
  }
  // could do some more checks here...
  //
  // stole this bit from Stig's run-test.php
  $term = getenv("TERM");
  if (preg_match('/^(xterm|vt220)/', $term)) {
    $term_bold = sprintf("%c%c%c%c", 27, 91, 49, 109);
    $term_norm = sprintf("%c%c%c", 27, 91, 109);
  } elseif (preg_match('/^vt100/', $term)) {
    $term_bold = sprintf("%c%c%c%c", 27, 91, 49, 109);
    $term_norm = sprintf("%c%c%c", 27, 91, 109);
  } else {
    $term_bold = $term_norm = "";
  }
}

function print_header() {
  print "PHP QA Team get-cvs.php " . '$Revision$' . NL;
  print '$Id:';
  print "-------------------------------------------------------" . NL;
  print "    jalal <jalal\@php.net>" . NL . NL;
}
  
function makebold( $s ) {
  global $term_bold, $term_norm;
  return $term_bold . $s . $term_norm;
}
/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 */

?>
