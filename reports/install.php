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

error_reporting(E_ALL);
header('Content-Type: text/plain');

$dbfolder = dirname(__FILE__).'/db/';

if (file_exists($dbfolder.'reports.sqlite'))
	unlink($dbfolder.'reports.sqlite');

$files = glob('/home/odoucet/*.sqlite');
foreach ($files as $file) {
    $dest = basename($file);
    
    if (!file_exists($dbfolder.$dest)) {
        echo "copying file ".$file;
        copy($file, $dbfolder.$dest);
        echo "  OK\n";
        
    } else echo "skipping file ".$file."\n";
}