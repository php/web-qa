<?php
include("include/functions.php");

$TITLE = "How To Help [PHP-QAT: Quality Assurance Team]";
$SITE_UPDATE = date("D M d H:i:s Y T", filectime($SCRIPT_FILENAME))."<br>
/* $Id$ */";

common_header();
?>
	<table width="70%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="10"><img src="gfx/spacer.gif" width="10" height="1"></td>
          <td width="100%"> 
            <h1>Creating new test files</h1>
          </td>
          <td width="10"><img src="gfx/spacer.gif" width="10" height="1"></td>
        </tr>
        <tr> 
          <td width="10">&nbsp;</td>
          <td width="100%">
<p>Writing a test file is very easy if you are used to PHP. 
Here is an actual test file from standard module:</p>

<h3>ext/standard/tests/strings/strtr.phpt</h3>
<pre>
--TEST--
strtr() function
--FILE--
&lt;?php
/* Do not change this test it is a REATME.TESTING example. */
$trans = array("hello"=&gt;"hi", "hi"=&gt;"hello", "a"=&gt;"A", "world"=&gt;"planet");
var_dump(strtr("# hi all, I said hello world! #", $trans));
?&gt;
--EXPECT--
string(32) "# hello All, I sAid hi planet! #"
</pre>

<p>As you can see the file is devided into several sections. Below is a
list of all possible sections:</p>

<dl>
<dt>--TEST--</dt>
<dd>title of the test (required)</dd>

<dt>--SKIPIF--</dt>
<dd>is condition when to skip this test (optional)</dd>

<dt>--POST--</dt>
<dd>is POST variable passed to test script (optional)</dd>

<dt>--GET--</dt>
<dd>is GET variable passed to test script (optional)</dd>

<dt>--INI--</dt>
<dd>each line contains an ini setting e.g. foo=bar (optional)</dd>

<dt>--FILE--</dt>
<dd>the test script (required)</dd>

<dt>--EXPECT--</dt>
<dd>the expected output from the test script (required)</dd>

<dt>--EXPECTF--</dt>
<dd>an alternative of --EXPECT--. The difference is that this form uses
sscanf for output validation (alternative)</dd>

<dt>--EXPECTREGEX--</dt>
<dd>an alternative of --EXPECT--. This form allows the tester to specify the
result in a regular expression (alternative)</dd>
</dl>

<p>A test must at least contain the sections TEST, FILE and either EXPECT
or EXPECTF. When a test is called run-test.php takes the name from the
TEST section and writes the FILE section into a ".php" file with the 
same name as the ".phpt" file. This ".php" file will then be executed
and its output compared to the contents of the EXPECT section. It is a
good idea to generate output with var_dump() calls.</p>

<p>/ext/standard/tests/strings/str_shuffle.phpt is a good example for using 
EXPECTF instead of EXPECT. From time to time the algorithm used for shuffle 
changed and sometimes the machine used to execute the code has influence 
on the result of shuffle. But it always returns a three character string 
detectable by %s. Other scan-able forms are %i for integers, %d for numbers
only, %f for floating point values, %c for single characters and %x for 
hexadecimal values.</p>

<h3>/ext/standard/tests/strings/str_shuffle.phpt</h3>
<pre>
--TEST--
Testing str_shuffle.
--FILE--
&lt;?php
/* Do not change this test it is a REATME.TESTING example. */
$s = '123';
var_dump(str_shuffle($s));
var_dump($s);
?&gt;
--EXPECTF--
string(3) %s
string(3) "123"
</pre>

<p>/ext/standard/tests/strings/strings001.phpt is a good example for using 
EXPECTREGEX instead of EXPECT. This test also shows that in EXPECTREGEX 
some characters need to be escaped since otherwise they would be 
interpreted as a regular expression.</p>

<h3>/ext/standard/tests/strings/strings001.phpt</h3>
<pre>
--TEST--
Test whether strstr() and strrchr() are binary safe.
--FILE--
&lt;?php
/* Do not change this test it is a REATME.TESTING example. */
$s = "alabala nica".chr(0)."turska panica";
var_dump(strstr($s, "nic"));
var_dump(strrchr($s," nic"));
?&gt;
--EXPECTREGEX--
string\(18\) \"nica\x00turska panica\"
string\(19\) \" nica\x00turska panica\"
</pre>

<p>Some tests depend on modules or functions available only in certain versions 
or they even require minimum version of php or zend. These tests should be 
skipped when the requirement cannot be fullfilled. To achieve this you can
use the SKIPIF section. To tell run-test.php that your test should be skipped
the SKIPIF section must print out the word "skip" followed by a reason why
the test should skip.</p>

<h3>/ext/exif/tests/exif005.phpt</h3>
<pre>
--TEST--
Check for exif_read_data, unusual IFD start
--SKIPIF--
&lt;?php 
	if (!extension_loaded('exif')) print 'skip exif extension not available';
?&gt;
--FILE--
&lt;?php
/* Do not change this test it is a REATME.TESTING example.
 * test5.jpg is a 1*1 image that contains an Exif section with ifd = 00000009h
 */
$image  = exif_read_data('./ext/exif/tests/test5.jpg','',true,false);
var_dump($image['IFD0']);
?&gt;
--EXPECT--
array(2) {
  ["ImageDescription"]=>
  string(11) "Ifd00000009"
  ["DateTime"]=>
  string(19) "2002:10:18 20:06:00"
}
</pre>

<p>Test script and SKIPIF code should be directly written into *.phpt. However, 
it is recommended to use include files when more test scripts depend on the 
same SKIPIF code or when certain test files need the same values for some 
input. But no file used by any test should have one of the following 
extensions: ".php", ".log", ".exp", ".out" or ".diff".</p>

<p>Tests should be named according to the following list:
<dl>
<dt>Tests for bugs</dt>
<dd>bug&lt;bugid&gt;.phpt (bug17123.phpt)</dd>

<dt>Tests for functions</dt>
<dd>&lt;functionname&gt;.phpt (dba_open.phpt)</dd>

<dt>General tests for extensions</dt>
<dd>&lt;extname&gt;&lt;no&gt;.phpt (dba3.phpt)</dd>
</dl>
</p>

<p>When you use an include file for the SKIPIF section it should be named
"skipif.inc" and an include file used in the FILE section of many tests
should be named "test.inc".</p>

<p><b>NOTE:</b> All tests should run correctly with error_reporting(E_ALL) and
display_errors=1. This is the default when called from run-test.php.  If you
have a good reason for lowering the error reporting, use --INI-- section and
comment this in your testcode.</p>

<p><b>NOTE:</b> If your test intentionally generates a PHP warning message use
$php_errormsg variable, which you can then output. This will result in a
consistent error message output across all platforms and PHP configurations,
preventing your test from failing due inconsistencies in the error message
content.</p>
<p></p>
          </td>
          <td width="10">&nbsp;</td>
        </tr>
      </table>
<?php

common_footer();
?>
