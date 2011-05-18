<?php

// First install !
$DBFILE = dirname(__FILE__).'/db/reports.sqlite';

if (file_exists($DBFILE)) {
	exit('install already done !');
}

file_put_contents($DBFILE, file_get_contents('http://phpqa.ajeux.net/reports.sqlite'));
