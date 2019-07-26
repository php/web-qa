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

    '7.2.21' => [
        'active'  => true,
        'release' => [
            'type'       => 'RC',
            'number'     => 1,
            'sha256_bz2' => 'e0bf546960eddce54656ccb4df26bf4f05f575209d5499754c936a1b841b8f6c',
            'sha256_gz'  => '4e92a232113aed96a6513536e3e3e4e9c663026b67254bb249c7dc3e5a8e60a6',
            'sha256_xz'  => '0760b427896d460ec011278a9e84b5657550ef3bb244ac6ef4e46eb76ec4082b',
            'date'       => '18 Jul 2019',
            'baseurl'    => 'https://downloads.php.net/~remi/',
        ],
    ],

    '7.3.8' => [
        'active'  => true,
        'release' => [
            'type'       => 'RC',
            'number'     => 1,
            'sha256_bz2' => 'dee4ff4f260a9d06af0724d62146ca3518c3d340179272c2b6494876b3faa4f4',
            'sha256_gz'  => '57c69541a6a7058da0f56211e4e2942de9d4ec2b1f103a34fa20249f42f5f1b3',
            'sha256_xz'  => 'b65eca05f59ee5cfe48d92a3630f08bd6f593d6129e9cb3e29e85b4fce3bc8a5',
            'date'       => '18 Jul 2019',
            'baseurl'    => 'https://downloads.php.net/~cmb/',
        ],
    ],

    '7.4.0' => [
        'active'  => true,
        'release' => [
            'type'       => 'beta',
            'number'     => 1,
            'sha256_bz2' => 'e9760571837a92f33fe82610df6269f2b4c15d39e269ddeeb4c66adbcde033e5',
            'sha256_gz'  => 'e6d18850fe5ccc25b908bfad18707b97a6f6b3132df52560b64914841a3dea46',
            'sha256_xz'  => '399727399ac3c98c981e623ce2f4e55940ee1f99829cfcbca914d878a6910d30',
            'date'       => '25 Jul 2019',
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
