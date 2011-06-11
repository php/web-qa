<?php
#  +----------------------------------------------------------------------+
#  | PHP QA Website                                                       |
#  +----------------------------------------------------------------------+
#  | Copyright (c) 2005-2006 The PHP Group                                |
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
#  +----------------------------------------------------------------------+
#   $Id$

/**
 * Analyse sqlite files and retrieve data from it
 * @return array
 */
function get_summary_data()
{
    $data = array();
    $d = dir (dirname(__FILE__).'/db/');
    while (false !== ($entry = $d->read())) {
        if (substr($entry, -7) == '.sqlite') {
            //extract version from filename
            $version = substr($entry, 0, -7);
            
            // open database file
            $database = new SQLite3(dirname(__FILE__).'/db/'.$entry, SQLITE3_OPEN_READONLY);
            
            //retrieve data
            $query = $database->query("SELECT COUNT(*) AS nbReports, MAX(`date`) AS lastReport 
                     FROM reports");
            if (!$query)
                die("An error occured when reading a DB file.");
            $row = $query->fetchArray(SQLITE3_ASSOC);
            $data[$version] = $row;
            
            $query = $database->query("select count(distinct test_name) as nbFailingTests, count(*) as nbFailures from failed");
            if (!$query)
                die("An error occured when reading a DB file.");
            $row = $query->fetchArray(SQLITE3_ASSOC);
            $data[$version]['nbFailingTests'] = $row['nbFailingTests'];
            $data[$version]['nbFailures'] = $row['nbFailures'];
            
            $database->close();
            
            // we will use dbsize elsewhere. Record it now somewhere
            $data[$version]['dbsize'] = filesize(dirname(__FILE__).'/db/'.$entry);
        }
    }
    return $data;
}
