<?php /* $Id$ */

/*
What this file does:
	- Generates the download links found at qa.php.net
	- Determines which test results are emailed to news.php.net/php.qa.reports
	- Defines $QA_RELEASES for internal and external (api.php) use, contains all qa related information for future PHP releases

Documentation:
	$QA_RELEASES documentation:
		Configuration:
		- Key is future PHP version number
			- Example: If 5.3.6 is the latest stable release, then use 5.3.7 because 5.3.7-dev is our qa version
			- Typically, this is the only part needing changed
		- active (bool): 
			- It's active and being tested here 
			- Meaning, the version will be reported to the qa.reports list, and be linked at qa.php.net
			- File extensions .tar.gz and .tar.bz2 are assumed to be available
		- snap (array):
			- Define the array to link at qa.php.net, otherwise array() to not list it
			- prefix: prefix of the filename, minus the .tar.gz/bz2 extensions
			- baseurl: base url of snaps server
			- We define a prefix because our snapshot filenames are not consistent with version (e.g., php-trunk)
			- File extensions .tar.gz and .tar.bz2 are assumed to be available
		- release (array):
			- type: RC, alpha, and beta are examples (case should match filename case)
			- version: 0 if no such release exists, otherwise an integer of the rc/alpha/beta number
			- md5_bz2: md5 checksum of this downloadable .tar.bz2 file
			- md5_gz:  md5 checksum of this downloadable .tar.gz file
			- date: date of release e.g., 21 May 2011
			- baseurl: base url of where these downloads are located
		Other variables within $QA_RELEASES are later defined including:
			- reported: versions that make it to the qa.reports mailing list
			- release: all current qa releases, including paths to dl urls (w/ md5 info)
			- snaps: all current snaps, including paths to dl urls
			- dev_version: dev version
			- $QA_RELEASES is made available at qa.php.net/api.php

TODO:
	- Save all reports (on qa server) for all tests, categorize by PHP version (see buildtest-process.php)
	- Consider storing rc downloads at one location, independent of release master
	- Consider not linking to snaps if rcs exist
	- Determine best way to handle snap/rc baseurl, currently assumes .tar.gz/tar.bz2 will exist
	- Determine if $QA_RELEASES is compatible with all current, and most future configurations
	- Determine if $QA_RELEASES can be simplified
	- Determine if alpha/beta options are desired
	- Unify then create defaults for most settings
	- Add option to allow current releases (e.g., retrieve current release info via daily cron, cache, check, configure ~ALLOW_CURRENT_RELEASES)
*/

$QA_RELEASES = array(
	
	'5.3.28' => array(
		'active'		=> false,
		'snaps'			=> array(
			'prefix'	=> 'php5.3-latest',
			'baseurl'	=> 'http://snaps.php.net/',
		),
		'release'		=> array(
			'type'		=> 'RC',
			'number'	=> 0,
			'md5_bz2'	=> '',
			'md5_gz'	=> '',
			'date'		=> '?? ??? 2013',
			'baseurl'	=> 'http://downloads.php.net/johannes/',
		),
	),

	'5.4.21' => array(
		'active'		=> true,
		'snaps'			=> array(
			'prefix'	=> 'php5.4-latest',
			'baseurl'	=> 'http://snaps.php.net/',
		),
		'release'		=> array(
			'type'		=> 'RC',
			'number'    => 0,
			'md5_bz2'   => '11b787cc1fae3d6fe5ca8b23c753d68d',
			'md5_gz'    => 'f28a875608a152e76ba08d95ef366b90',
			'date'		=> '05 Sep 2013',
			'baseurl'	=> 'http://downloads.php.net/stas/',
		),
	),
	
	'5.5.5' => array(
		'active'		=> true,
		'snaps'			=> array(
			'prefix'	=> 'php5.5-latest',
			'baseurl'	=> 'http://snaps.php.net/',
		),
		'release'		=> array(
			'type'		=> 'RC',
			'number'    => 1,
			'md5_bz2'   => 'b00cf95cf39f542b5414d5e9208ea7a4',
			'md5_gz'    => '0ace378d26edbdeee4b77dc45ce78322',
			'md5_xz'    => '1cd60486f76ce52f57b1c634a585702f',
			'date'      => '03 Oct 2013',
			'baseurl'	=> 'http://downloads.php.net/jpauli/',
		),
	),

	'trunk' => array(
		'active'		=> false,
		'snaps'			=> array(
			'prefix'	=> 'php-trunk-latest',
			'baseurl'	=> 'http://snaps.php.net/',
		),
	),
);
/*** End Configuration *******************************************************************/

// $QA_RELEASES eventually contains just about everything, also for external use
// release  : These are encouraged for use (e.g., linked at qa.php.net)
// reported : These are allowed to report @ the php.qa.reports mailing list
// snap     : Snapshots that are being monitored by the QA team

foreach ($QA_RELEASES as $pversion => $info) {

	if (isset($info['active']) && $info['active']) {
	
		// Allow -dev versions of all active types
		// Example: 5.3.6-dev
		$QA_RELEASES['reported'][] = "{$pversion}-dev";
		$QA_RELEASES[$pversion]['dev_version'] = "{$pversion}-dev";

		// Allowed snaps, unless 'snaps' => array() (empty)
		if (!empty($info['snaps'])) {
			$QA_RELEASES[$pversion]['snaps']['files']['bz2']['path'] = $info['snaps']['baseurl'] . $info['snaps']['prefix'] . '.tar.bz2';
			$QA_RELEASES[$pversion]['snaps']['files']['gz']['path']  = $info['snaps']['baseurl'] . $info['snaps']['prefix'] . '.tar.gz';
		}
		
		// Allow -dev version of upcoming qa releases (rc/alpha/beta)
		// @todo confirm this php version format for all dev versions
		if ((int)$info['release']['number'] > 0) {
			$QA_RELEASES['reported'][] = "{$pversion}{$info['release']['type']}{$info['release']['number']}";
			if (!empty($info['release']['baseurl'])) {
				
				// php.net filename format for qa releases
				// example: php-5.3.0RC2
				$fn_base = 'php-' . $pversion . $info['release']['type'] . $info['release']['number'];

				$QA_RELEASES[$pversion]['release']['version'] = $pversion . $info['release']['type'] . $info['release']['number'];
				$QA_RELEASES[$pversion]['release']['files']['bz2']['path']= $info['release']['baseurl'] . $fn_base . '.tar.bz2'; 
				$QA_RELEASES[$pversion]['release']['files']['bz2']['md5'] = $info['release']['md5_bz2'];
				$QA_RELEASES[$pversion]['release']['files']['gz']['path'] = $info['release']['baseurl'] . $fn_base . '.tar.gz';
				$QA_RELEASES[$pversion]['release']['files']['gz']['md5']  = $info['release']['md5_gz'];

				if (!empty($info['release']['md5_xz'])) {
					$QA_RELEASES[$pversion]['release']['files']['xz']['path'] = $info['release']['baseurl'] . $fn_base . '.tar.xz';
					$QA_RELEASES[$pversion]['release']['files']['xz']['md5']  = $info['release']['md5_xz'];
				}
			}
		} else {
			$QA_RELEASES[$pversion]['release']['enabled'] = false;
		}
	}
}

// Sorted information for later use
// @todo need these?
// $QA_RELEASES['releases']   : All current versions with active qa releases
// $QA_RELEASES['snaps']      : All current versions with active snaps
foreach ($QA_RELEASES as $pversion => $info) {
	
	if (isset($info['active']) && $info['active']) {

		if (!empty($info['release']['number'])) {
			$QA_RELEASES['releases'][$pversion] = $info['release'];
		}
	
		if (!empty($info['snaps'])) {
			$QA_RELEASES['snaps'][$pversion] = $info['snaps'];
		}
	}
}

/* Content */
function show_release_qa($QA_RELEASES) {
	
	echo "<!-- RELEASE QA -->\n";
	
	if (!empty($QA_RELEASES['releases'])) {
		
		$plural = count($QA_RELEASES['releases']) > 1 ? 's' : '';
		
		// QA Releases
		echo "<span class='lihack'>\n";
		echo "Providing QA for the following <a href='http://qa.php.net/rc.php'>test release{$plural}</a>:\n";
		echo "<ul>\n";

		// @todo check for vars, like if md5_* are set
		foreach ($QA_RELEASES['releases'] as $pversion => $info) {

			// pure madness
			echo "<li>{$info['version']}: [<a href='{$info['files']['bz2']['path']}'>tar.bz2</a>] (md5 checksum: {$info['files']['bz2']['md5']})</li>\n";
			echo "<li>{$info['version']}: [<a href='{$info['files']['gz']['path']}'>tar.gz</a>] (md5 checksum: {$info['files']['gz']['md5']})</li>\n";
			if (isset($info['files']['xz'])) {
				echo "<li>{$info['version']}: [<a href='{$info['files']['xz']['path']}'>tar.xz</a>] (md5 checksum: {$info['files']['xz']['md5']})</li>\n";
			}
		}
		
		echo "</ul>\n</span>\n";
	}
	
	if (!empty($QA_RELEASES['snaps'])) {
	
		$plural = count($QA_RELEASES['snaps']) > 1 ? 's' : '';
		
		// Snap for dev releases
		echo "Providing QA for the following snapshot{$plural} of future PHP versions:\n";
		echo "<span class='lihack'>\n";
		echo "<ul>\n";

		// @todo check for vars, like if md5_* are set
		foreach ($QA_RELEASES['snaps'] as $pversion => $info) {
			
			// more madness
			echo "<li>$pversion: ";
			echo "[<a href='{$info['files']['bz2']['path']}'>tar.bz2</a>] or ";
			echo "[<a href='{$info['files']['gz']['path']}'>tar.gz</a>]</li>\n";
		}
		
		echo "</ul>\n</span>\n";
	}

	echo "<!-- END -->\n";
}
