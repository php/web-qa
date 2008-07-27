<?php /* $Id$ */

/*
 *  This file generates the "Providing QA for PHP x.x.x.." task item
 *  with list of urls to the packages.
 */

$BUILD_TEST_RELEASES = array( '4.4.9RC1', '5.2.6');
$DEV_RELEASES = array('5.3.0-dev');

foreach($BUILD_TEST_RELEASES as $release) {
	/* If RC, bump to next RC-dev, if release, bump to next release-dev */
	$pos = strlen($release)-1;
	$release[$pos] = $release[$pos]+1;
	$DEV_RELEASES[] = $release . "-dev";
}

$RELEASE_PROCESS = array(4 => true, 5 => false);

$CURRENT_QA_RELEASE_4 = '4.4.9RC1'; // false
$RC_FILES_4 = array (
	array (
		'http://downloads.php.net/derick/',
		"php-{$CURRENT_QA_RELEASE_4}.tar.bz2",
	),
	array (
		'http://downloads.php.net/derick/',
		"php-{$CURRENT_QA_RELEASE_4}.tar.gz",
	),
	array (
		'http://downloads.php.net/derick/',
		"php-{$CURRENT_QA_RELEASE_4}-win32.zip",
	),
);

/* PHP 5 Releases */
$CURRENT_QA_RELEASE_5 = false;
$RC_FILES_5 = array (

	array (
		'http://downloads.php.net/ilia/',
		"php-{$CURRENT_QA_RELEASE_5}.tar.bz2",
	),
	array (
		'http://downloads.php.net/ilia/',
		"php-{$CURRENT_QA_RELEASE_5}.tar.gz",
	),
	array (
		'http://pecl2.php.net/downloads/php-windows-builds/qa/',
		"php-{$CURRENT_QA_RELEASE_5}-Win32.zip",
	),
/*
	array (
		'http://downloads.php.net/edink/',
		"php-{$CURRENT_QA_RELEASE_5}-Win32.zip",
	),
	array (
		'http://downloads.php.net/edink/',
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
		$FILES = array_merge($RC_FILES_4, $RC_FILES_5);
	} elseif($RELEASE_PROCESS[4]) {
		$FILES = $RC_FILES_4;
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
	global $CURRENT_QA_RELEASE_4, $CURRENT_QA_RELEASE_5, $FILES, $MD5SUM;

	$text = "PHP";

	if ($CURRENT_QA_RELEASE_4 && $CURRENT_QA_RELEASE_5) {
		$text = "these <a href='http://qa.php.net/rc.php'>release candidates</a>: ";
	} else if ($CURRENT_QA_RELEASE_4 || $CURRENT_QA_RELEASE_5) {
		$text = "this <a href='http://qa.php.net/rc.php'>release candidate</a>: ";
	}

echo "
<!-- RELEASE QA -->
<span class='lihack'>Providing QA for {$text} {$CURRENT_QA_RELEASE_4} {$CURRENT_QA_RELEASE_5}
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
