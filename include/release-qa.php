<?php /* $Id$ */

/*
 *  This file generates the "Providing QA for PHP x.x.x.." task item
 *  with list of urls to the packages.
 */

$CURRENT_QA_RELEASE = false;
$BUILD_TEST_RELEASES = array( '4.4.5', '5.2.1');

$RELEASE_PROCESS = array(4 => false, 5 => false);

$RC_FILES = array (
	array (	
		'http://downloads.php.net/derick/',
		"php-{$CURRENT_QA_RELEASE}.tar.bz2",
	),
	array (	
		'http://downloads.php.net/derick/',
		"php-{$CURRENT_QA_RELEASE}.tar.gz",
	),
/*
	array (	
		'http://downloads.php.net/derick/',
		"php-{$CURRENT_QA_RELEASE}-Win32.zip",
	),
*/
);

/* PHP 5 Releases */
$CURRENT_QA_RELEASE_5 = false; #'5.2.2RC1';
$RC_FILES_5 = array (

	array (	
		'http://downloads.php.net/ilia/',
		"php-{$CURRENT_QA_RELEASE_5}.tar.bz2",
	),
	array (	
		'http://downloads.php.net/ilia/',
		"php-{$CURRENT_QA_RELEASE_5}.tar.gz",
	),
/*
	array (	
		'http://downloads.php.net/ilia/',
		"php-{$CURRENT_QA_RELEASE_5}-Win32.zip",
	),
	array (	
		'http://downloads.php.net/ilia/',
		"pecl-{$CURRENT_QA_RELEASE_5}-Win32.zip",
	),
*/
);

/* Snapshot urls and files */
$SNAPSHOTS = array (
	array (
		'http://snaps.php.net/',
		'php4-STABLE-latest.tar.bz2',
	),
	array (
		'http://snaps.php.net/',
		'php4-STABLE-latest.tar.gz',
	),
	array (
		'http://snaps.php.net/win32/',
		'php4-win32-STABLE-latest.zip',
	),
	array (
		'http://snaps.php.net/',
		'php5.2-latest.tar.bz2',
	),
	array (
		'http://snaps.php.net/',
		'php5.2-latest.tar.gz',
	),
	array (
		'http://snaps.php.net/win32/',
		'php5.2-win32-latest.zip'
	),
);

if ($RELEASE_PROCESS[4] || $RELEASE_PROCESS[5]) {
	$MD5SUM = file('include/rc-md5sums.txt');
	if($RELEASE_PROCESS[4] && $RELEASE_PROCESS[5]) {
		$FILES = array_merge($RC_FILES, $RC_FILES_5);
	} elseif($RELEASE_PROCESS[4]) {
		$FILES = $RC_FILES;
	} elseif($RELEASE_PROCESS[5]) {
		$FILES = $RC_FILES_5;
	} else {
		$FILES = $SNAPSHOTS;
		$MD5SUM = array();
	}
} else {
	$FILES = $SNAPSHOTS;
	$MD5SUM = array();
}

/* Content */
function show_release_qa() {
	global $CURRENT_QA_RELEASE_5, $CURRENT_QA_RELEASE, $FILES, $MD5SUM;
	
echo "
<!-- RELEASE QA -->
<span class='lihack'>Providing QA for PHP {$CURRENT_QA_RELEASE} {$CURRENT_QA_RELEASE_5}
 <ul>
";

foreach ($FILES as $key => $FILE) {
	echo "  <li><a href='{$FILE[0]}{$FILE[1]}'>{$FILE[1]}</a>";
	echo (!empty($MD5SUM[$key])) ? "<br />{$MD5SUM[$key]}" : '';
	echo "</li>\n";
}
		
echo " </ul>
</span>
<br />
<!-- END -->
";
}

?>
