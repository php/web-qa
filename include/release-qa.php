<?php /* $Id$ */

/*
 *  This file generates the "Providing QA for PHP x.x.x.." task item
 *  with list of urls to the packages.
 */

// FIXME: Use http://www.php.net/releases/index.php?serialize=1 info here?
// Note:  These two variables determine which failed make tests may report to the qa.reports list
$BUILD_TEST_RELEASES = array('5.3.6', '5.3.98');
$DEV_RELEASES = array();

foreach($BUILD_TEST_RELEASES as $release) {
	/* If RC, bump to next RC-dev, if release, bump to next release-dev */
	$pos = strlen($release)-1;
	$release[$pos] = $release[$pos]+1;
	$DEV_RELEASES[] = $release . "-dev";
}

$RELEASE_PROCESS = array(53 => false, 54 => false);

$CURRENT_QA_RELEASE_54 = false; // '5.4.0RC1';
$RC_FILES_54 = array(); array (
	array (
		'http://downloads.php.net/gandhi/',
		"php-{$CURRENT_QA_RELEASE_54}.tar.bz2",
	),
	array (
		'http://downloads.php.net/gandhi/',
		"php-{$CURRENT_QA_RELEASE_54}.tar.gz",
	),
);

/* PHP 5 Releases */
$CURRENT_QA_RELEASE_5 = false; // '5.3.6RC3';
$RC_FILES_5 = array (
	array (
		'http://downloads.php.net/johannes/',
		"php-{$CURRENT_QA_RELEASE_5}.tar.bz2",
	),
	array (
		'http://downloads.php.net/johannes/',
		"php-{$CURRENT_QA_RELEASE_5}.tar.gz",
	),

);

/* Snapshot urls and files */
$SNAPSHOTS = array (
	array (
		'http://snaps.php.net/',
		'php-trunk-latest.tar.bz2',
	),
	array (
		'http://snaps.php.net/',
		'php-trunk-latest.tar.gz',
	),
	array (
		'http://snaps.php.net/',
		'php5.3-latest.tar.bz2',
	),
	array (
		'http://snaps.php.net/',
		'php5.3-latest.tar.gz',
	),
);

if ($RELEASE_PROCESS[54] || $RELEASE_PROCESS[53]) {
	$MD5SUM = file('include/rc-md5sums.txt');
	if($RELEASE_PROCESS[54] && $RELEASE_PROCESS[53]) {
		$FILES = array_merge($RC_FILES_54, $RC_FILES_5);
	} elseif($RELEASE_PROCESS[54]) {
		$FILES = $RC_FILES_54;
	} elseif($RELEASE_PROCESS[53]) {
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
	global $CURRENT_QA_RELEASE_54, $CURRENT_QA_RELEASE_5, $FILES, $MD5SUM;

	$text = "PHP";

	if ($CURRENT_QA_RELEASE_54 && $CURRENT_QA_RELEASE_5) {
		$text = "these <a href='http://qa.php.net/rc.php'>release candidates</a>: ";
	} else if ($CURRENT_QA_RELEASE_54 || $CURRENT_QA_RELEASE_5) {
		$text = "this <a href='http://qa.php.net/rc.php'>release candidate</a>: ";
	}

echo "
<!-- RELEASE QA -->
<span class='lihack'>Providing QA for {$text} {$CURRENT_QA_RELEASE_54} {$CURRENT_QA_RELEASE_5}
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
