<?php
// check if this update has already been done or not
if (file_exists('db/update_20120407.lock')) {
    exit('SQLite files has already been updated with new scheme (date 2012-04-07)');
}
        $queriesCreate = [
            'dropexpected' => 'DROP TABLE IF exists expectedfail',
            'expectedfail' => 'CREATE TABLE IF NOT EXISTS expectedfail (
                  `id` integer PRIMARY KEY AUTOINCREMENT,
                  `id_report` bigint(20) NOT NULL,
                  `test_name` varchar(128) NOT NULL
                )',
            'success' => 'CREATE TABLE IF NOT EXISTS success (
                  `id` integer PRIMARY KEY AUTOINCREMENT,
                  `id_report` bigint(20) NOT NULL,
                  `test_name` varchar(128) NOT NULL
                )',
        ];
header('Content-Type: text/plain');

$d = dir('db');
while (false !== ($entry = $d->read())) {
    if (substr($entry, -6) == 'sqlite') {
        printf("%-20s ", $entry);
        $dbi = new SQLite3('db/'.$entry, SQLITE3_OPEN_READWRITE) or exit('cannot open DB to record results');

        foreach ($queriesCreate as $table => $query) {
            $dbi->exec($query);
            if ($dbi->lastErrorCode() != '') echo $dbi->lastErrorMsg();
        }
        // patch add field success
        @$dbi->exec('ALTER TABLE reports ADD COLUMN success unsigned int(10) NOT NULL default 0');
        echo $dbi->lastErrorMsg();

        $dbi->close();
        echo "\n";
    }
}
$d->close();
touch('db/update_20120407.lock');
