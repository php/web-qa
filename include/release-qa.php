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
			- dev_version: dev version
			- $QA_RELEASES is made available at qa.php.net/api.php

TODO:
	- Save all reports (on qa server) for all tests, categorize by PHP version (see buildtest-process.php)
	- Consider storing rc downloads at one location, independent of release master
	- Determine best way to handle rc baseurl, currently assumes .tar.gz/tar.bz2 will exist
	- Determine if $QA_RELEASES is compatible with all current, and most future configurations
	- Determine if $QA_RELEASES can be simplified
	- Determine if alpha/beta options are desired
	- Unify then create defaults for most settings
	- Add option to allow current releases (e.g., retrieve current release info via daily cron, cache, check, configure ~ALLOW_CURRENT_RELEASES)
*/

$QA_RELEASES = array(
	
	'5.3.30' => array(
		'active'		=> false
	),

	'5.4.45' => array(
		'active'		=> false,
		'release'		=> array(
			'type'		=> 'RC',
			'number'    => 0,
			'md5_bz2'   => '',
			'md5_gz'    => '',
			'date'		=> '04 Aug 2014',
			'baseurl'	=> 'http://downloads.php.net/stas/',
		),
	),
	
	'5.5.38' => array(
		'active'		=> false,
		'release'		=> array(
			'type'		=> 'RC',
			'number'    => 0,
			'md5_bz2'   => '',
			'md5_gz'    => '',
			'md5_xz'    => '',
			'date'      => '25 Jun 2015',
			'baseurl'	=> 'http://downloads.php.net/jpauli/',
		),
	),

	'5.6.26' => array(
		'active'		=> true,
		'release'		=> array(
			'type'	    => 'RC',
			'number'    => 0,
			'md5_bz2'   => '',
			'md5_gz'    => '',
			'md5_xz'    => '',
			'date'      => '04 Aug 2016',
			'baseurl'   => 'http://downloads.php.net/tyrael/',
		),
	),

        '7.0.11' => array(
                'active'                => true,
                'release'               => array(
                        'type'      => 'RC',
                        'number'    => 1,
                        'md5_bz2'   => '5ac7b567b6915dd0cdf7426ab2c97117',
                        'md5_gz'    => 'deb5bd99f60b829f69bfafe861d4a06c',
                        'md5_xz'    => '67314fa8496154d6212f4dab9fce27ce',
                        'date'      => '04 August 2016',
                        'baseurl'   => 'http://downloads.php.net/ab/',
                ),
        ),

        '7.1.0' => array(
                'active'                => true,
                'release'               => array(
                        'type'      => 'beta',
                        'number'    => 3,
                        'md5_bz2'   => 'a10c0b46a83c34f8c0423ef70ac941bd',
                        'md5_gz'    => '17d8f9eb26cd2a39d6ecb52110a85a0b',
                        'md5_xz'    => 'a8dac6900b017f2036c8b5a2770c3091',
                        'date'      => '18 August 2016',
                        'baseurl'   => 'http://downloads.php.net/~davey/',
                ),
	),

	'master' => array(
		'active'		=> false,
	),
);
/*** End Configuration *******************************************************************/

// $QA_RELEASES eventually contains just about everything, also for external use
// release  : These are encouraged for use (e.g., linked at qa.php.net)
// reported : These are allowed to report @ the php.qa.reports mailing list

foreach ($QA_RELEASES as $pversion => $info) {

	if (isset($info['active']) && $info['active']) {
	
		// Allow -dev versions of all active types
		// Example: 5.3.6-dev
		$QA_RELEASES['reported'][] = "{$pversion}-dev";
		$QA_RELEASES[$pversion]['dev_version'] = "{$pversion}-dev";
		
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
foreach ($QA_RELEASES as $pversion => $info) {
	
	if (isset($info['active']) && $info['active'] && !empty($info['release']['number'])) {
		$QA_RELEASES['releases'][$pversion] = $info['release'];
	}
}

/* Content */
function show_release_qa($QA_RELEASES) {
	
	echo "<!-- RELEASE QA -->\n";
	
	if (!empty($QA_RELEASES['releases'])) {
		
		$plural = count($QA_RELEASES['releases']) > 1 ? 's' : '';
		
		// QA Releases
		echo "<span class='lihack'>\n";
		echo "Providing QA for the following <a href='/rc.php'>test release{$plural}</a>:\n";
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

	echo "<!-- END -->\n";
}
