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

$QA_RELEASES = [
    '7.1.25' => [
        'active'  => true,
        'release' => [
            'type'       => 'RC',
            'number'     => 0,
            'sha256_bz2' => '',
            'sha256_gz'  => '',
            'sha256_xz'  => '',
            'date'       => '06 Dec 2018',
            'baseurl'    => 'https://downloads.php.net/~pollita/',
        ],
    ],

    '7.2.20' => [
        'active'  => true,
        'release' => [
            'type'       => 'RC',
            'number'     => 3,
            'sha256_bz2' => 'e4eb9b171f6e980e9962bbe22fe7bead598fc66ecd2f476fa56c9274fbec48a8',
            'sha256_gz'  => 'a2f55a764e363310465a619988031b18115d1937a827f64b747477beba4f374d',
            'sha256_xz'  => '7cb6d972c6b4a982451d276ff4786237d61cc619bde62640ccd2a241b7e2c068',
            'date'       => '20 Jun 2019',
            'baseurl'    => 'https://downloads.php.net/~remi/',
        ],
    ],

    '7.3.7' => [
        'active'  => true,
        'release' => [
            'type'       => 'RC',
            'number'     => 3,
            'sha256_bz2' => '4e5263e5922634e7d664bed4dda14316d8e798ec34af6bf548a65515b6471632',
            'sha256_gz'  => '3685e13057550e3b595f008705b539657a7fe71b7150b7b3bcd2fb0c8443c204',
            'sha256_xz'  => '23f99ae50f072e20d4c2b58e2d3b203c10790e2214c9da83a8dad9733bb9318d',
            'date'       => '20 Jun 2019',
            'baseurl'    => 'https://downloads.php.net/~cmb/',
        ],
    ],

    '7.4.0' => [
        'active'  => true,
        'release' => [
            'type'       => 'alpha',
            'number'     => 1,
            'sha256_bz2' => 'b431ac5c35946657be97294951f88fe251a279f0a9eaac3d445b61b71674db36',
            'sha256_gz'  => 'b199158e0cd2823b4e39379c7f83f41e7e8142b268f48acfc5bb6d48437a1ef1',
            'sha256_xz'  => '378400b6eced6e358f5db750413a7f9959517b0daef6580b16d640190b7dc364',
            'date'       => '13 Jun 2019',
            'baseurl'    => 'https://downloads.php.net/~derick/',
        ],
    ],
];

/*** End Configuration *******************************************************************/

// This is a list of the possible checksum values that can be supplied with a QA release. Any
// new algorithm is read from the $QA_RELEASES array under the 'release' index for each version
// in the form of "$algorithm_$filetype".
//
// For example, if SHA512 were to be supported, the following indices would have to be added:
//
// 'sha512_bz2' => 'xxx',
// 'sha512_gz'  => 'xxx',
// 'sha512_xz'  => 'xxx',
$QA_CHECKSUM_TYPES = ['sha256'];

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
