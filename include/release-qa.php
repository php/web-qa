<?php

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

        '7.1.24' => array(
                'active'                => true,
                'release'		=> array(
                        'type'          => 'RC',
                        'number'        => 1,
                        'sha256_bz2'    => 'ef53c6c5e4124a943bbf4bc5db40fcce1ece6d97fb8c623a6ee9f32499c348cc',
                        'sha256_gz'     => '35fb2ad8279bbb26810d32bc71d78f55482dd6b3e2f401b46c155ee80a235cff',
                        'sha256_xz'     => '994185b8b395a3f0448364999e72a7fe42c14daa978ba6a6a446a8039dad10a8',
                        'date'          => '25 Oct 2018',
                        'baseurl'       => 'http://downloads.php.net/~remi/',
                ),
		),

        '7.2.12' => array(
                'active'                => true,
                'release'		=> array(
                        'type'          => 'RC',
                        'number'        => 1,
                        'sha256_bz2'    => '59bbcd35e576be8838c588c5a0d17b4b9886e89355ba168bf525a0066eddebca',
                        'sha256_gz'     => 'b281ab7f286f310d35ffb5b72b88b04c06918180009987769d9d4c6dc906c7f8',
                        'sha256_xz'     => 'cbc000432efea35f323d4b8edaae5633e44fa2a0a87f56293d12afe72416d8b1',
                        'date'          => '25 Oct 2018',
                        'baseurl'       => 'https://downloads.php.net/~remi/',
                ),
        ),
		'7.3.0' => array(
            'active'                => true,
            'release'		=> array(
                    'type'          => 'RC',
                    'number'        => 4,
                    'sha256_bz2'    => 'afd973238a9dd3286ab01a46c859409c20176da3a431a78c8db94a5c5391e90c',
                    'sha256_gz'     => '22ad2fb8e7148de8d618f773121e14abd095f22dc7b5ac21991daed45c265099',
                    'sha256_xz'     => '11582176003e0e8ca06dbdebab0921d539cab2ad795c0d90f146977859e21c26',
                    'date'          => '25 Oct 2018',
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
