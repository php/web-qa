<?php

$a = array("0", "1", "01", "02", "2");
sort($a);
while (list ($key, $value) = each ($a)) {
    echo "$key: $value\n";
}

echo "\n";
$a = array("0", "1", "01", "02", "2");
rsort($a);
while (list ($key, $value) = each ($a)) {
    echo "$key: $value\n";
}


$a = array("0", "1", "2", "01", "02", "03", "23","044");
// first test sort()
echo "sort\n";
sort($a);
while (list ($key, $value) = each ($a)) {
    echo "$key: $value\n";
}

$a = array("0", "1", "2", "01", "02", "03", "23","044");
echo "rsort\n";
rsort($a);
while (list ($key, $value) = each ($a)) {
    echo "$key: $value\n";
}

$a = array("0", "1", "2", "01", "02", "03", "23","044");
echo "asort\n";
asort($a);
while (list ($key, $value) = each ($a)) {
    echo "$key: $value\n";
}

$a = array("0", "1", "2", "01", "02", "03", "23","044");
echo "arsort\n";
arsort($a);
while (list ($key, $value) = each ($a)) {
    echo "$key: $value\n";
}

$a = array("0", "1", "2", "01", "02", "03", "23","044");
echo "ksort\n";
ksort($a);
while (list ($key, $value) = each ($a)) {
    echo "$key: $value\n";
}

$a = array("able", "baker", "charlie", "ant", "Bill", "Rob", "2luv3","044");
// first test sort()
echo "sort\n";
sort($a);
while (list ($key, $value) = each ($a)) {
    echo "$key: $value\n";
}

$a = array("able", "baker", "charlie", "ant", "Bill", "Rob", "2luv3","044");
echo "rsort\n";
rsort($a);
while (list ($key, $value) = each ($a)) {
    echo "$key: $value\n";
}

$a = array("able", "baker", "charlie", "ant", "Bill", "Rob", "2luv3","044");
echo "asort\n";
asort($a);
while (list ($key, $value) = each ($a)) {
    echo "$key: $value\n";
}

$a = array("able", "baker", "charlie", "ant", "Bill", "Rob", "2luv3","044");
echo "arsort\n";
arsort($a);
while (list ($key, $value) = each ($a)) {
    echo "$key: $value\n";
}

$a = array("able", "baker", "charlie", "ant", "Bill", "Rob", "2luv3","044");
echo "ksort\n";
ksort($a);
while (list ($key, $value) = each ($a)) {
    echo "$key: $value\n";
}
echo "\n\n";

?>







