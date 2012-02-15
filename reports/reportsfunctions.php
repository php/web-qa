<?php
#  +----------------------------------------------------------------------+
#  | PHP QA Website                                                       |
#  +----------------------------------------------------------------------+
#  | Copyright (c) 1997-2011 The PHP Group                                |
#  +----------------------------------------------------------------------+
#  | This source file is subject to version 3.01 of the PHP license,      |
#  | that is bundled with this package in the file LICENSE, and is        |
#  | available through the world-wide-web at the following url:           |
#  | http://www.php.net/license/3_01.txt                                  |
#  | If you did not receive a copy of the PHP license and are unable to   |
#  | obtain it through the world-wide-web, please send a note to          |
#  | license@php.net so we can mail you a copy immediately.               |
#  +----------------------------------------------------------------------+
#  | Author: Olivier Doucet <odoucet@php.net>                             |
#  |         Johannes Schlüter <johannes@php.net>                         |
#  +----------------------------------------------------------------------+
#   $Id$

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

class RCFilterIterator extends WhitelistedFilterIterator
{
    public function accept()
    {
        return $this->inWhitelist() || !preg_match(',RC[0-9]+$,', $this->key());
    }
}

class devFilterIterator extends WhitelistedFilterIterator
{
    public function accept()
    {
        return $this->inWhitelist() || substr($this->key(), -4) != '-dev';
    }
}

const QA_REPORT_FILTER_NONE = 0;
const QA_REPORT_FILTER_RC   = 1;
const QA_REPORT_FILTER_DEV  = 2;

const QA_REPORT_FILTER_ALL  = 3;

/**
 * Analyse sqlite files and retrieve data from it
 * @return array
 */
function get_summary_data($mode = QA_REPORT_FILTER_ALL)
{
    global $QA_RELEASES;

    $data = array();
    $it = new QaReportIterator(new DirectoryIterator(__DIR__.'/db/'));

    if ($mode & QA_REPORT_FILTER_RC) {
        $it = new RCFilterIterator($it, $QA_RELEASES['reported']);
    }
    if ($mode & QA_REPORT_FILTER_DEV) {
        $it = new devFilterIterator($it, $QA_RELEASES['reported']);
    }

    foreach ($it as $version => $database_file) {
	$database = new SQLite3($database_file, SQLITE3_OPEN_READONLY); 
        //retrieve data
        $query = $database->query(
            "SELECT COUNT(*) AS nbReports, MAX(`date`) AS lastReport FROM reports"
        );
        if (!$query)
            die("An error occured when reading a DB file.");
        $row = $query->fetchArray(SQLITE3_ASSOC);
        $data[$version] = $row;
            
        $query = $database->query(
            "select count(distinct test_name) as nbFailingTests, count(*) as nbFailures from failed"
        );
        if (!$query)
            die("An error occured when reading a DB file.");
        $row = $query->fetchArray(SQLITE3_ASSOC);
        $data[$version]['nbFailingTests'] = $row['nbFailingTests'];
        $data[$version]['nbFailures'] = $row['nbFailures'];
            
        $database->close();
    }
    return $data;
}
