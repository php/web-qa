<?php
include("include/functions.php");

$TITLE = "Tested Methods [PHP-QAT: Quality Assurance Team]";
$SITE_UPDATE = date("D M d H:i:s Y T", filectime(__FILE__));

common_header();
?>

<script type="text/javascript">
function showHide(id){
     var e = document.getElementById(id);
     if (e.style.display == "") {
          e.style.display = "none";
     } else {
          e.style.display = "";
     }
}
</script>

    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="10"><img src="gfx/spacer.gif" width="10" height="1"></td>
          <td width="100%"> 
            <h1>Tested PHP Functions and Methods</h1>
          </td>
          <td width="10"><img src="gfx/spacer.gif" width="10" height="1"></td>
        </tr>
        <tr> 
          <td width="10">&nbsp;</td>
          <td width="100%">
            <p>This table lists core PHP functions and methods and specifies whether or not they are called from 
            a PHPT test. A "yes" in this table for a particular method is not an indication of good test coverage
             - it just means that that method is called from at least one PHPT test.</p>
            <p>The analysis used to generate this table does not differentiate between methods of the same name
            belonging to different classes. In cases where such a method call is detected, "verify" is listed
            in the Tested column, along with the list of test files containing calls to a method of that name.</p>
          </td>
          <td width="10">&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td width="10"><img src="gfx/spacer.gif" width="10" height="1"></td>
          <td width="100%">
<?php

// fields in the csv file
define("EXTENSION", 0);
define("CLASS_NAME", 1);
define("METHOD_NAME", 2);
define("TESTED", 3);
define("TESTS", 4);


$fd = fopen("coverage_data/tested_methods.csv", "r");

// print table header
echo "<table border=\"0\">\n";
echo "<th align=\"left\">Extension</th>\n";
echo "<th align=\"left\">Class</th>\n";
echo "<th align=\"left\">Method</th>\n";
echo "<th align=\"left\">Tested</th>\n";
echo "<th align=\"left\">Test Files</th>\n";

$tests_id = 0;

// print table rows
while (true) {
    $line = fgetcsv($fd);
    if ($line === false) {
        break;
    }

    if (count($line) != 5) {
        continue;
    }

    $extension = $line[EXTENSION];
    $class = $line[CLASS_NAME];
    $method = $line[METHOD_NAME];
    $tested = $line[TESTED];

    $bgcolor = "red";
    $test_files_exist = false;
    if ($tested === "yes") {
        $bgcolor = "green";
        $test_files_exist = true;
    } else if ($tested === "no") {
        $bgcolor = "red";
    } else if ($tested === "verify") {
        $bgcolor = "orange";
        $test_files_exist = true;
    }

    $tests = $line[TESTS];

    echo "<tr>";
    echo "<td>$extension</td>";
    echo "<td>$class</td>";
    echo "<td>$method</td>";
    echo "<td bgcolor=$bgcolor>$tested</td>";
    echo "<td>";
    if ($test_files_exist) {
        echo "<a href=\"#\" onClick='showHide(\"$tests_id\"); return false;'>click to show/hide test files</a>";
        echo "<div id='$tests_id' style='display:none;'>$tests</div>";
    }
    echo "</td>";
    echo "</tr>\n";

    $tests_id++;
}
echo "</table>\n";

?>
      </td>
      </tr>
      </table>
<?php
common_footer();
?>

