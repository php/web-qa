<?php /* $Id$ */

/*
 *  This file generates the "Providing QA for PHP x.x.x.." task item
 *  with list of urls to the packages.
 */

$CURRENT_QA_RELEASE = '4.3.6RC3';
$RELEASE_PROCESS = false;

$RC_FILES = array (
	array (	
		'http://downloads.php.net/ilia/',
		"php-{$CURRENT_QA_RELEASE}.tar.bz2",
	),
	array (	
		'http://downloads.php.net/ilia/',
		"php-{$CURRENT_QA_RELEASE}.tar.gz",
	),
	array (	
		'http://downloads.php.net/ilia/',
		"php-{$CURRENT_QA_RELEASE}-Win32.zip",
	),
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
);

if ($RELEASE_PROCESS) {
	$FILES = $RC_FILES;
	$MD5SUM = file('include/rc-md5sums.txt');
} else {
	$FILES = $SNAPSHOTS;
	$MD5SUM = array();
}

/* Content */

echo "
<!-- RELEASE QA -->
<span class='lihack'>Providing QA for PHP {$CURRENT_QA_RELEASE}
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

?>
