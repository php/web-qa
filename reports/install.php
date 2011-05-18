<?php
error_reporting(E_ALL);
header('Content-Type: text/plain');

// First install !
$DBFILE = dirname(__FILE__).'/db/reports.sqlite';

if (file_exists($DBFILE)) {
	exit('install already done !');
}

echo date('[d-m-y H:i:s]')."Downloading first version of DB ...\n";
$data = file_get_contents('http://phpqa.ajeux.net/reports.sqlite');
echo date('[d-m-y H:i:s]')."OK (Filesize: ".strlen($data)."\n";
echo date('[d-m-y H:i:s]')."Putting data to sqlite file ...\n";
file_put_contents($DBFILE, $data);
echo date('[d-m-y H:i:s]')."OK\n";
echo date('[d-m-y H:i:s]')."Changing chmod ...\n";
chmod($DBFILE, 0755);
chmod(dirname($DBFILE), 0755);
echo date('[d-m-y H:i:s]')."Done\n";
