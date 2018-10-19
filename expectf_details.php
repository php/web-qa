<?php
include("include/functions.php");

$TITLE = "Writing Tests [PHP-QAT: Quality Assurance Team]";
$SITE_UPDATE = date("D M d H:i:s Y T", filectime(__FILE__));

common_header();
?>
            <h1>EXPECTF substitution options</h1>
<p>The --EXPECTF-- section uses a number of substitution tags for strings or digits
that appear in test case output but which may vary between test runs. The most common
example of this is to use %s and %d to match the file path and line number which are
output by PHP Warnings.</p>

<p>The substitution tags and their meanings are summarised below</p>

<table border="1">
<tr>
  <th> %code </th>
  <th> Meaning </th>
</tr>
<tr>
  <td> %e </td>
  <td> Represents a directory separator, for example / on Linux. </td>
</tr>
<tr>
  <td> %s </td>
  <td> One or more of anything (charater or white space) except the end of line character. </td>
</tr>
<tr>
  <td> %S </td>
  <td> Zero or more of anything (charater or white space) except the end of line character. </td>
</tr>
<tr>
  <td> %a </td>
  <td> One or more of anything (charater or white space) including the end of line character. </td>
</tr>
<tr>
  <td> %A </td>
  <td> Zero or more of anything (charater or white space) including the end of line character. </td>
</tr>
<tr>
  <td> %w </td>
  <td> Zero or more white space characters. </td>
</tr>
<tr>
  <td> %i </td>
  <td> A signed integer value, for example +3142, -3142. </td>
</tr>
<tr>
  <td> %d </td>
  <td> An unsigned integer value, for example 123456. </td>
</tr>
<tr>
  <td> %x </td>
  <td> One or more hexadecimal character. That is, characters in the range 0-9, a-f, A-F. </td>
</tr>
<tr>
  <td> %f </td>
  <td> A floating point number, for example: 3.142, -3.142, 3.142E-10, 3.142e+10. </td>
</tr>
<tr>
  <td> %c </td>
  <td> A single character of any sort (.) </td>
</tr>
<tr>
  <td> %r...%r</td>
  <td> Any string (...) enclosed between two %r will be treated as a regular expression </td>
</tr>
<tr>
  <td> %unicode|string% </td>
  <td> Matches the string 'unicode' in PHP6 test output and 'string' in PHP5 test output. </td>
</tr>
<tr>
  <td> %binary_string_optional% </td>
  <td> Matches 'Binary string' in PHP6 output, 'string' in PHP5 output. Used in PHP Warning messages. </td>
</tr>
<tr>
  <td> %unicode_string_optional% </td>
  <td> Matches 'Unicode string' in PHP6 output, 'string' in PHP5 output. Used in PHP Warning messages. </td>
</tr>
 <tr>
  <td> %u|b% </td>
  <td> Matches a single 'u' in PHP6 test output where the PHP5 output from the same test hs no character in that position.</td>
</tr>
</table>


<?php

common_footer();
