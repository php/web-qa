<?php
/**
 * Test case for dbase_add_record submitted by support@webapteka.ru.
 *
 * This only works for Unix boxen right now, due to the use of /tmp...
 * there's probably a better way to do the same thing.
 */
print "Before anything that should crash us...\n";
$dbname = "/tmp/price.dbf";

  $def =
    array(
        array("code",     "C",  12),
        array("name_g",   "C",  200),
        array("name_r",   "C",  200),
        array("ao_dm",    "N",  10, 2),
        array("ao_dm",    "N",  10, 2)
    );

  if (!dbase_create($dbname, $def))
    {print "Create DBF Error !\n";exit(1);}

  chmod($dbname,0777);

  $dbf = dbase_open($dbname, 2);

  if (!$dbf)
    {print "Open DBF Error !\n";exit(2);}

      $row = array( "test", "test2", "test3", 1, 2 );
	array_keys($row);

      dbase_add_record($dbf, $row);
      dbase_add_record($dbf, $row);
      dbase_add_record($dbf, $row);
      dbase_add_record($dbf, $row);

  dbase_close($dbf);

/**
 * OK, now to compare...
 */

$dbf_c = dbase_open($dbname, 2);

for ($i = 1; $i <= dbase_numrecords($dbf_c); $i++)
{
     $dbf_row[$i] = dbase_get_record_with_names($dbf_c, $i);
}
dbase_close($dbf_c);
unlink($dbname);

var_dump($dbf_row);



print "After anything that should crash us...\n";
?>
