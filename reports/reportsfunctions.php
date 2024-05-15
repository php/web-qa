<?php
#  +----------------------------------------------------------------------+
#  | PHP QA Website                                                       |
#  +----------------------------------------------------------------------+
#  | Copyright (c) 1997-2011 The PHP Group                                |
#  +----------------------------------------------------------------------+
#  | This source file is subject to version 3.01 of the PHP license,      |
#  | that is bundled with this package in the file LICENSE, and is        |
#  | available through the world-wide-web at the following url:           |
#  | https://php.net/license/3_01.txt                                     |
#  | If you did not receive a copy of the PHP license and are unable to   |
#  | obtain it through the world-wide-web, please send a note to          |
#  | license@php.net so we can mail you a copy immediately.               |
#  +----------------------------------------------------------------------+
#  | Author: Olivier Doucet <odoucet@php.net>                             |
#  |         Johannes Schlüter <johannes@php.net>                         |
#  +----------------------------------------------------------------------+

class QaReportIterator extends FilterIterator
{
    public function __construct(DirectoryIterator $inner)
    {
        parent::__construct($inner);
    }

    public function accept()
    {
        return substr(parent::current(), -7) == '.sqlite';
    }

    public function key()
    {
        return substr(parent::current(), 0, -7);
    }

    public function current()
    {
	return __DIR__.'/db/'.parent::current();
    }
}

abstract class WhitelistedFilterIterator extends FilterIterator
{
    private $whitelist;

    public function __construct(Traversable $inner, array $whitelist)
    {
        parent::__construct($inner);
	$this->whitelist = $whitelist;
    }

    public function inWhitelist()
    {
        return in_array($this->key(), $this->whitelist);
    }
}

class keywordFilterIterator extends WhitelistedFilterIterator
{
    private $keyword;

    public function __construct(Traversable $inner, $keyword, array $whitelist)
    {
        parent::__construct($inner, $whitelist);
	$this->keyword = preg_quote($keyword, ',');
    }

    public function accept()
    {
        return $this->inWhitelist() || !preg_match(','.$this->keyword.'[0-9]+$,', $this->key());
    }
}

class devFilterIterator extends WhitelistedFilterIterator
{
    public function accept()
    {
        return $this->inWhitelist() || substr($this->key(), -4) != '-dev';
    }
}

class specificVersionFilterIterator extends WhitelistedFilterIterator
{
    private $keyword;

    public function __construct(Traversable $inner, $keyword)
    {
        parent::__construct($inner, []);
        if (!is_array($keyword))
            $this->keyword = [$keyword];
        else
            $this->keyword = $keyword;
    }

    public function accept()
    {
        return $this->inWhitelist() || !in_array($this->key(), $this->keyword);
    }
}

class minVersionFilterIterator extends FilterIterator
{
    private $min;

    public function __construct(Traversable $inner, $minversion)
    {
        parent::__construct($inner);
        $this->min = $minversion;
    }

    public function accept()
    {
        return version_compare($this->min, $this->key(), '<=');
    }
}

const QA_REPORT_FILTER_NONE  = 0;
const QA_REPORT_FILTER_ALPHA = 1;
const QA_REPORT_FILTER_BETA  = 2;
const QA_REPORT_FILTER_RC    = 4;
const QA_REPORT_FILTER_DEV   = 8;
const QA_REPORT_FILTER_CURRENT_RELEASES = 16;

define('QA_REPORT_FILTER_ALL', QA_REPORT_FILTER_ALPHA|QA_REPORT_FILTER_BETA|QA_REPORT_FILTER_CURRENT_RELEASES);

/**
 * Analyse sqlite files and retrieve data from it
 * @return array
 */
function get_summary_data($mode = QA_REPORT_FILTER_ALL)
{
    global $QA_RELEASES;

    $data = [];
    $it = new QaReportIterator(new DirectoryIterator(__DIR__.'/db/'));

    // temp fix
    $it = new specificVersionFilterIterator($it, ['5.3.99-dev', '5.4.0-dev']);

    if ($mode & QA_REPORT_FILTER_ALPHA) {
        $it = new keywordFilterIterator($it, 'alpha', $QA_RELEASES['reported']);
    }
    if ($mode & QA_REPORT_FILTER_BETA) {
        $it = new keywordFilterIterator($it, 'beta', $QA_RELEASES['reported']);
    }
    if ($mode & QA_REPORT_FILTER_RC) {
        $it = new keywordFilterIterator($it, 'RC', $QA_RELEASES['reported']);
    }
    if ($mode & QA_REPORT_FILTER_DEV) {
        $it = new devFilterIterator($it, $QA_RELEASES['reported']);
    }
    if ($mode & QA_REPORT_FILTER_CURRENT_RELEASES) {
        $it = new minVersionFilterIterator($it, "5.3.14");
    }


    foreach ($it as $version => $database_file) {
        if (!file_exists($database_file.'.cache') ||
            !($dataSerialize = unserialize(file_get_contents($database_file.'.cache')))) {

            $database = new SQLite3($database_file, SQLITE3_OPEN_READONLY);
            //retrieve data
            $query = $database->query(
                "SELECT COUNT(*) AS nbReports, MAX(`date`) AS lastReport FROM reports"
            );
            if (!$query)
                die("An error occurred when reading summary data from $version DB file.");
            $row = $query->fetchArray(SQLITE3_ASSOC);
            $data[$version] = $row;

            $query = $database->query(
                "select count(distinct test_name) as nbFailingTests, count(*) as nbFailures from failed"
            );
            if (!$query)
                die("An error occurred when reading failingTest data from $version DB file.");
            $row = $query->fetchArray(SQLITE3_ASSOC);
            $data[$version]['nbFailingTests'] = $row['nbFailingTests'];
            $data[$version]['nbFailures'] = $row['nbFailures'];

            $database->close();
            // write cache data
            file_put_contents($database_file.'.cache', serialize($data[$version]));
        } else {
            $data[$version] = $dataSerialize;
        }
    }
    return $data;
}


/**
 * Format date as we want
 * @param unix timestamp
 * @return string
 */
function format_readable_date($date) {
    $lastReport = time()-$date;
    $return = '';
    if ($lastReport < 3600) {
        $tmpValue = round($lastReport/60);
		$return = $tmpValue.' ';
        $return .= ($tmpValue <= 1) ? 'minute' : 'minutes';
    } elseif ($lastReport < 3600*24) {
        $tmpValue = round($lastReport/3600);
        $return = $tmpValue.' ';
        $return .= ($tmpValue == 1) ? 'hour' : 'hours';
    } elseif ($lastReport < 3600*24*60) {
        $tmpValue = round($lastReport/3600/24);
        $return = $tmpValue.' ';
        $return .= ($tmpValue == 1) ? 'day' : 'days';
    } else {
        $tmpValue = floor($lastReport/3600/24/30);
        $return = $tmpValue.' ';
        $return .= ($tmpValue == 1) ? 'month' : 'months';
    }
    return $return." ago";
}

// In a report/ or pfft script, the 'branch' parameter
// takes the form PHP_{$major}_{$minor} (i.e. PHP_7_2)
// or PHP_MASTER, indicating the current master branch
function isValidBranch(string $branch, bool $verifyExists = true): bool {
	return ($branch === 'PHP_MASTER') ||
		preg_match('@^PHP_\d{1,10}_\d{1,10}$@', $branch);
}

// In a report/ or pftt script, the 'revision' parameter
// may be either the letter 'r' followed by hexits,
// indicating a GIT hash (or possibly a SVN revision?)
// Or they may be a release version (e.g. '7.2.9', '7.3.0-beta2')
function isValidRevision(string $revision): bool {
	// 41 characters ought to be enough for any revision (haha)
	if ((strlen($revision) < 1) || (strlen($revision) > 41)) {
		return false;
	}

	// Allow r(HEXIT+) form.
	if (($revision[0] === 'r') && ctype_xdigit(substr($revision, 1))) {
		return true;
	}

	// Allow release version form.
	if (preg_match('@^\d+\.\d+\.\d+(-alpha\d+|-beta\d+|RC\d+|-dev)?$@i', $revision)) {
		return true;
	}

	return false;
}

// Generate a path from a branch name
function makeBranchPath(string $branch) /* : ?sting */ {
	if (!isValidBranch($branch)) return null;
	return __DIR__ . "/db/$branch/";
}

// Generate a path from a branch and revision
function makeRevisionPath(string $branch, string $revision) /* : ?string */ {
	$path = makeBranchPath($branch);
	if (($path === null) || !isValidRevision($revision)) { return false; }
	return "$path/$revision/";
}
