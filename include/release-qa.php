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


$QA_RELEASES = [

    '8.1.27' => [
        'active'  => true,
        'release' => [
            'type'       => 'RC',
            'number'     => 0,
            'sha256_gz'  => '',
            'sha256_bz2' => '',
            'sha256_xz'  => '',
            'date'       => '07 Nov 2023',
            'baseurl'    => 'https://downloads.php.net/',
        ],
    ],

    '8.2.25' => [
        'active'  => true,
        'release' => [
            'type'       => 'RC',
            'number'     => 1,
            'sha256_bz2' => '5694b32c90c519805b5f8d0646254a3b5a83c614b4ff8dd63525c123f6ceaf3e',
            'sha256_gz'  => 'ffc84d71f27250fb50a8a88dc61c47ad5a12d25e20bd9ca4a9c8925ced0e7d9c',
            'sha256_xz'  => 'f85134d6ceb8c5c93ac16630134cb0766630732c89c9e9271d4104497d4fced5',
            'date'       => '10 Oct 2024',
            'baseurl'    => 'https://downloads.php.net/~sergey/',
        ],
    ],

    '8.3.13' => [
        'active'  => true,
        'release' => [
            'type'       => 'RC',
            'number'     => 1,
            'sha256_bz2' => '8f6342b354e16eb262a12c60a5ba04a011f1fca2edf950c2ae97193b7f20e3cd',
            'sha256_gz'  => '5eb82ce81b81c930f3ac406616b70a5d4b9efc0915b60411d9838933a4b2ebf6',
            'sha256_xz'  => 'e516a2cf754502ce5e97e4b559a6346111bc4465f8aead5ecb21f290c999698b',
            'date'       => '10 Oct 2024',
            'baseurl'    => 'https://downloads.php.net/~jakub/',
        ],
    ],

    '8.4.0' => [
        'active'  => true,
        'release' => [
            'type'       => 'RC',
            'number'     => 2,
            'sha256_bz2' => '4ff1e74424d3a3b20381d7d463cdbafecfa4107864525b982beaf97e36e96bc1',
            'sha256_gz'  => '351ca0e3dfbb4fef182311984e4161d20ab7df85f383b93b6c60938d08e613bf',
            'sha256_xz'  => '8361b149c25e2fa6a23bfebe22c62ceb5df956d8d298353e7c184152075f285f',
            'date'       => '10 Oct 2024',
            'baseurl'    => 'https://downloads.php.net/~calvinb/',
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
