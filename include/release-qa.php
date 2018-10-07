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
			- sha256_bz2: sha256 checksum of this downloadable .tar.bz2 file
			- sha256_gz:  sha256 checksum of this downloadable .tar.gz file
			- sha256_xz: sha256 checksum of this downloadble .xz file
			- date: date of release e.g., 21 May 2011
			- baseurl: base url of where these downloads are located
			- Multiple checksums can be available, see the $QA_CHECKSUM_TYPES array below
		Other variables within $QA_RELEASES are later defined including:
			- reported: versions that make it to the qa.reports mailing list
			- release: all current qa releases, including paths to dl urls (w/ sha256 info)
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


/**********************************************************************/
/****** REMEMBER TO UPDATE "functions.php" WHEN BRANCHES CHANGE! ******/
/**********************************************************************/

$QA_RELEASES = array(
	'5.6.39' => array(
		'active'		=> true,
		'release'		=> array(
			'type'	    	=> 'RC',
			'number'    	=> 0,
			'sha256_bz2'	=> '',
			'sha256_gz'	=> '',
			'sha256_xz'	=> '',
			'date'      	=> '05 January 2017',
			'baseurl'   	=> 'http://downloads.php.net/tyrael/',
		),
	),

        '7.0.33' => array(
                'active'                => true,
                'release'               => array(
                        'type'      	=> 'RC',
                        'number'    	=> 0,
                        'sha256_bz2'	=> '',
                        'sha256_gz'     => '',
                        'sha256_xz'     => '',
                        'date'      	=> '07 December 2017',
                        'baseurl'   	=> 'http://downloads.php.net/ab/',
                ),
        ),

        '7.1.23' => array(
                'active'                => true,
                'release'		=> array(
                        'type'          => 'RC',
                        'number'        => 1,
                        'sha256_bz2'    => 'f4832f3c46946342d9ba99bc8cbacad1d2c011eafdd5f76723d1b30505c94248',
                        'sha256_gz'     => 'd3c72114c354dced813720adcb0bab56b5cc6f9ef7bfd61a7cd67de645de7aa9',
                        'sha256_xz'     => '4946c920452faa3b342df5652bd7c287c7f429ba1f30472de4740b65d947cb10',
                        'date'          => '27 Sep 2018',
                        'baseurl'       => 'http://downloads.php.net/~pollita/',
                ),
		),

        '7.2.11' => array(
                'active'                => true,
                'release'		=> array(
                        'type'          => 'RC',
                        'number'        => 1,
                        'sha256_bz2'    => '8c99815db93ada114f2100eb19f82306b91077eb9909a01b81f2dec857fcea3c',
                        'sha256_gz'     => 'bab813bfbc0b3b853a917440e350432608998125f1578a1078508fc06d62c416',
                        'sha256_xz'     => '52b14d1017863da157e7126a01fa46e11a9c0ceacef0fbcd5e84b1246235d805',
                        'date'          => '27 Sep 2018',
                        'baseurl'       => 'https://downloads.php.net/~pollita/',
                ),
        ),
		'7.3.0' => array(
            'active'                => true,
            'release'		=> array(
                    'type'          => 'RC',
                    'number'        => 2,
                    'sha256_bz2'    => '600709d884e2a5f9b525056a2f4bd1e4b3199a0554bbb6da0ed3bdd1816e4e05',
                    'sha256_gz'     => '510413cbe8bd151056972398dff245138dde4101809b760cfd74f20b10dcb0cd',
                    'sha256_xz'     => 'f52692cb4f5144365a72c6ff698101035a27bceebf2d5a307ad82dd43ee9d751',
                    'date'          => '28 Sep 2018',
                    'baseurl'       => 'https://downloads.php.net/~cmb/',
            ),
		),
);

/*** End Configuration *******************************************************************/

// This is a list of the possible checksum values that can be supplied with a QA release. Any
// new algorithm is read from the $QA_RELEASES array under the 'release' index for each version
// in the form of "$algorithm_$filetype".
//
// For example, if SHA512 were to be supported, the following indices would have to be added:
//
// 'sha512_bz2' => 'xxx',
// 'sha512_gz'	=> 'xxx',
// 'sha512_xz'	=> 'xxx',
$QA_CHECKSUM_TYPES = [ 'sha256' ];

// $QA_RELEASES eventually contains just about everything, also for external use
// release  : These are encouraged for use (e.g., linked at qa.php.net)
// reported : These are allowed to report @ the php.qa.reports mailing list

(function(&$QA_RELEASES) use ($QA_CHECKSUM_TYPES) {
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
					foreach ([ 'bz2', 'gz', 'xz' ] as $file_type) {
						foreach ($QA_CHECKSUM_TYPES as $algo) {
							if (isset($info['release'][$algo . '_' . $file_type])) {
								$QA_RELEASES[$pversion]['release']['files'][$file_type][$algo] = $info['release'][$algo . '_' . $file_type];
							}
						}
						if (!empty($QA_RELEASES[$pversion]['release']['files'][$file_type])) {
							$QA_RELEASES[$pversion]['release']['files'][$file_type]['path']= $info['release']['baseurl'] . $fn_base . '.tar.' . $file_type;
						}
					}

					if (empty($QA_RELEASES[$pversion]['release']['files'])) {
						$QA_RELEASES[$pversion]['release']['enabled'] = false;
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

})($QA_RELEASES);
