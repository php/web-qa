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
			- md5_xz: md5 checksum of this downloadble .xz file
			- date: date of release e.g., 21 May 2011
			- baseurl: base url of where these downloads are located
			- Multiple checksums can be available, see the $QA_CHECKSUM_TYPES array below
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
	'5.6.31' => array(
		'active'		=> true,
		'release'		=> array(
			'type'	    	=> 'RC',
			'number'    	=> 0,
			'md5_bz2'   	=> '',
			'md5_gz'    	=> '',
			'md5_xz'    	=> '',
			'sha256_bz2'	=> '',
			'sha256_gz'	=> '',
			'sha256_xz'	=> '',
			'date'      	=> '05 January 2017',
			'baseurl'   	=> 'http://downloads.php.net/tyrael/',
		),
	),

        '7.0.21' => array(
                'active'                => true,
                'release'               => array(
                        'type'      	=> 'RC',
                        'number'    	=> 1,
                        'md5_bz2'   	=> 'a205484bdaf2a58e031861cb22eba4e6',
                        'md5_gz'    	=> 'ed2e7e22cbc6313db88e65d19d0a92b8',
                        'md5_xz'    	=> 'e37a28689626385630615cf49a6f3983',
                        'sha256_bz2'	=> '0fc5210314bf3a9d110683bf3e27799108af5ff760bd4f18ab7b8c9fb4e0a53e',
                        'sha256_gz'     => '4acb712df856c8303dbb9c8cd20b9839021e36194520500984557bfa41f711cc',
                        'sha256_xz'     => '0093d288a10ddcd69f06b2fad7ea8068217ad37b55589bfa6e3ee20ae7708239',
                        'date'      	=> '22 June 2017',
                        'baseurl'   	=> 'http://downloads.php.net/ab/',
                ),
        ),

        '7.1.7' => array(
                'active'                => true,
                'release'		=> array(
                        'type'          => 'RC',
                        'number'        => 1,
                        'md5_bz2'       => '18de7af73bf99a8d5093493cef084ed9',
                        'md5_gz'        => '28b86e81df03ea10749484e0e97974f1',
                        'md5_xz'        => 'ad7404a0024069f6edf3e73b47b21c7b',
                        'sha256_bz2'    => '24e8a62077ba1cb415cb13327f607f725ce46969f0e198c4ec994b72940ba28f',
                        'sha256_gz'     => 'd8d3af5f35e8cba7583e217b87fb39198489d80f64d0fae2c5e098492c944968',
                        'sha256_xz'     => '125050947d0c1ad714769e53508e16584a2db3482d2f867f8797cdd326249e5d',
                        'date'          => '22 Jun 2017',
                        'baseurl'       => 'http://downloads.php.net/~krakjoe/',
                ),
	),

        '7.2.0' => array(
                'active'                => true,
                'release'		=> array(
                        'type'          => 'alpha',
                        'number'        => 2,
                        'md5_bz2'       => '77d6f6da4e15c3389ef9c8b09e679edc',
                        'md5_gz'        => '09ca0e0654a686037957f343c62677d8',
                        'md5_xz'        => '40171c6257097371fbd23096e77aeffc',
                        'sha256_bz2'    => 'f084bcbf26cdbd5fa56ba3b396f0d4e8d2dcf94e593f0629d080dc11a67e18cc',
                        'sha256_gz'     => 'e772fc95e67fa5e01972228d6a65626fb84f3ef3ee28d13c509f5ab0eafb662e',
                        'sha256_xz'     => '4f815f49ddc32f250b6fd5e812145ddf0c25c3f714577a30f9a84a1d033ab55d',
                        'date'          => '22 Jun 2017',
                        'baseurl'       => 'http://downloads.php.net/~pollita/',
                ),
        ),
);

// This is a list of the possible checksum values that can be supplied with a QA release. Any 
// new algorithm is read from the $QA_RELEASES array under the 'release' index for each version 
// in the form of "$algorithm_$filetype".
//
// For example, if SHA512 were to be supported, the following indices would have to be added:
//
// 'sha512_bz2' => 'xxx',
// 'sha512_gz'	=> 'xxx',
// 'sha512_xz'	=> 'xxx',

$QA_CHECKSUM_TYPES = [ 'md5', 'sha256' ];

/*** End Configuration *******************************************************************/

// $QA_RELEASES eventually contains just about everything, also for external use
// release  : These are encouraged for use (e.g., linked at qa.php.net)
// reported : These are allowed to report @ the php.qa.reports mailing list

$qa_releases_process = function () use (&$QA_RELEASES, $QA_CHECKSUM_TYPES) {
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

};
$qa_releases_process();

/* Content */
function show_release_qa($QA_RELEASES) {
	// The checksum configuration array
	global $QA_CHECKSUM_TYPES;

	echo "<!-- RELEASE QA -->\n";
	
	if (!empty($QA_RELEASES['releases'])) {
		
		$plural = count($QA_RELEASES['releases']) > 1 ? 's' : '';
		
		// QA Releases
		echo "<span class='lihack'>\n";
		echo "Providing QA for the following <a href='/rc.php'>test release{$plural}</a>:<br> <br>\n";
		echo "</span>\n";
		echo "<table>\n";

		foreach ($QA_RELEASES['releases'] as $pversion => $info) {

			echo "<tr>\n";
			echo "<td colspan=\"" . (sizeof($QA_CHECKSUM_TYPES) + 1) . "\">\n";
			echo "<h3 style=\"margin: 0px;\">{$info['version']}</h3>\n";
			echo "</td>\n";
			echo "</tr>\n";

			foreach ($info['files'] as $file_type => $file_info) {
				echo "<tr>\n";
				echo "<td width=\"20%\"><a href=\"{$file_info['path']}\">php-{$info['version']}.tar.{$file_type}</a></td>\n";

				foreach ($QA_CHECKSUM_TYPES as $algo) {
					echo '<td>';
					echo '<strong>' . strtoupper($algo) . ':</strong> ';

					if (isset($file_info[$algo]) && strlen($file_info[$algo])) {
						echo $file_info[$algo];
					} else {
						echo '(<em><small>No checksum value available</small></em>)&nbsp;';
					}

					echo "</td>\n";
				}

				echo "</tr>\n";
			}
		}

		echo "</table>\n";
	}

	echo "<!-- END -->\n";
}
