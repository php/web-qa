<?php
// test of bug 4254
// note, this bug is not (10 Jul 2000) fixed.
// the ideal output is taken from a Perl script
// running the same code.
$var1 = 0x7FFFFFFF;
$var2 = 0xFFFFFFFF;
$var3 = 0x8FFFFFFF;
$var4 = 0x9FFFFFFF;
$var5 = 0x8FFFFFF1;
$var6 = 0x80000001;
$var7 = $var1 + 0x7FFFFFFF;
$var8 = (0x08FFFFFF << 4);
$var9 = intval("AFFFFFFF", 16);

echo $var1; echo "\n";
echo $var2; echo "\n";
echo $var3; echo "\n";
echo $var4; echo "\n";
echo $var5; echo "\n";
echo $var6; echo "\n";
echo $var7; echo "\n";
echo $var8; echo "\n";
echo $var9; echo "\n";
?>
