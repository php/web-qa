<?php
include("include/functions.php");

$TITLE = "Writing Tests [PHP-QAT: Quality Assurance Team]";
$SITE_UPDATE = date("D M d H:i:s Y T", filectime($SCRIPT_FILENAME));
/* $Id$ */

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
<h2>phpt Test Basics</h2>
<ul>
	<li>
  		<b>So what are phpt tests?</b>  
		<p>A phpt test is a little script used by the php internal and quality 
assurance teams to test PHP's functionality.  It can be used with new releases to make 
sure they can do all the things that previous releases can, or to help find bugs in current 
releases.  By writing phpt tests you are helping to make PHP stabler.</p>
	</li>

	<li>
		<b>What skills are needed to write a phpt test?</b>  
		<p>All that is really needed to write a phpt test 
is a basic understanding of the PHP language, a text editor, and a way to get the results
of your code.  That is it.  So if you have been writing and running PHP scripts already - 
you have everything you need.</p>
	</li>

	<li>
		<b>What do you write phpt tests on?</b>  
		<p>Basically you can write a phpt test on one of the various 
php functions available.  You can  write a test on a basic language function (a string 
function or an array function) , or a function provided by one of PHP's numerous extensions 
(a mysql function or a image function or a mcrypt function).  You can find out what functions
already have phpt tests on them by looking in the <a href="http://cvs.php.net/viewvc.cgi/">html 
version</a> of the cvs (php-src/ext/standard/tests/ is a good place to start looking - though
<i>all</i> the tests currently written are NOT in there).  After that - you 
can pick any function you want.  If you want more guidance than that - you can always ask
the PHP Quality Assurance Team on their mailing list 
(<a href="mailto:php-qa@lists.php.net">php-qa@lists.php.net</a>) where they 
would like you to direct your attentions.</p>
	</li>

	<li>
		<b>How is a phpt test is used?</b>  
		<p>When a test is called by the run-test.php script it takes various 
parts of the phpt file to name and create a .php file.  That .php file is then executed.  The 
output of the .php file is then compared to a different section of the phpt file.  If the output of
the script "matches" the output provided in the phpt script - it passes.</p>
	</li>

	<li>
		<b>What should a phpt test do?</b>
	  	<p>Basically - it should try and break the PHP function.  It should check not
only the functions normal parameters, but it should also check edge cases.  Intentionally generating
an error is allowed.</p>
	</li>
</ul>

<h2>Writing phpt Tests</h2>
<h3>Naming Conventions</h3>
<p>Phpt tests follow a very strict naming convention.  This is done to easily identify what each phpt
test is for.  Tests should be named according to the following list:
	<ul type="none">
		<li><i>Tests for bugs</i><br />
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <!-- Give me some space! -->
		    bug&lt;bugid&gt;.phpt (bug17123.phpt)</li>
		<li><i>Tests for functions</i><br />
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  <!-- Give me some space! -->
		    &lt;functionname&gt;.phpt (dba_open.phpt)</li>
		<li><i>General tests for extensions</i><br />
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  <!-- Give me some space! -->
			&lt;extname&gt;&lt;no&gt;.phpt (dba_003.phpt)</li>
	</ul>
</p>

<h3>Basic Format</h3>
<p>A test must contain the sections TEST, FILE and either EXPECT or EXPECTF at a minimum.  The example 
below illustrates a minimal test.</p>
<i>ext/standard/tests/strings/strtr.phpt</i>
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

<p>As you can see the file is divided into several sections.  The TEST section holds a one line comment
about the phpt test. The phpt files name is used when generating a .php file.  The FILE section is used 
as the body of the .php file, so don't forget to open and close your php tags.  The EXPECT section is 
the part used as a comparison to see if the test passes.  It is a
good idea to generate output with var_dump() calls.</p>

<h3>All Sections</h3>
A phpt test can have many more parts then just the minimum.  In fact some of the manditory parts have
alternatives that may be used if the situation warrents it.
<dl>
<dt>--TEST--</dt>
<dd>title of the test. (required)</dd>

<dt>--SKIPIF--</dt>
<dd>a condition when to skip this test. (optional)</dd>

<dt>--POST--</dt>
<dd>POST variables to be passed to the test script. (optional)</dd>

<dt>--GET--</dt>
<dd>GET variables to be passed to the test script. (optional)</dd>

<dt>--INI--</dt>
<dd>to be used if you need a specific php.ini setting for the test.  
	Each line contains an ini setting   e.g. foo=bar. (optional)</dd>

<dt>--ARGS--</dt>
<dd>a single line defining the arguments passed to php. (optional)</dd>

<dt>--ENV--</dt>
<dd>configures the environment to be used for php. (optional)</dt>

<dt>--FILEEOF--</dt>
<dd>an alternative to --FILE-- where any trainling line break is omitted. 
(alternative to --FILE--)</dd>

<dt>--EXPECT--</dt>
<dd>the expected output from the test script. (required)</dd>

<dt>--EXPECTF--</dt>
<dd>an alternative of --EXPECT--. The difference is that this form uses
sscanf for output validation. (alternative to --EXPECT--)</dd>

<dt>--EXPECTREGEX--</dt>
<dd>an alternative of --EXPECT--. This form allows the tester to specify the
result in a regular expression. (alternative to --EXPECT--)</dd>
</dl>

<dt>--REDIRECTTEST--</dt>
<dd>this block allows to redirect from one test to a bunch of other tests.
(alernative to --FILE--)</dd>

<dt>--HEADERS--</dt>
<dd>header to be used when seinding the request. Currently only available with
server-tests.php (optional)</dd>

<dt>--EXPECTHEADERS--</dt>
<dd>the expected headers. Any header specified here must exist in the 
response and have the same value. Additional headers do not matter. (optional)
</dd>

<dt>--CLEAN--</dt>
<dd>code that is executed after the test has run. Using run-tests.php switch 
--no-clean you can prevent its execution to inspect generated data/files that
were normally removed after the test. (optional)</dd>

<dt>===DONE===</dt>
<dd>This is only available in the --FILE-- section. Any part after this line
is not going into the actual test script (see below for more).</dd>

<h2>Examples</h2>

<h3>EXPECTF</h3>
<p>/ext/standard/tests/strings/str_shuffle.phpt is a good example for using 
EXPECTF instead of EXPECT. From time to time the algorithm used for shuffle 
changed and sometimes the machine used to execute the code has influence 
on the result of shuffle. But it always returns a three character string 
detectable by %s. Other scan-able forms are %i for integers, %d for numbers
only, %f for floating point values, %c for single characters and %x for 
hexadecimal values.</p>
<i>/ext/standard/tests/strings/str_shuffle.phpt</i>
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

<h3>EXPECTREGEX</h3>
<p>/ext/standard/tests/strings/strings001.phpt is a good example for using 
EXPECTREGEX instead of EXPECT. This test also shows that in EXPECTREGEX 
some characters need to be escaped since otherwise they would be 
interpreted as a regular expression.</p>

<i>/ext/standard/tests/strings/strings001.phpt</i>
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

<h3>SKIPIF</h3>
<p>Some tests depend on modules or functions available only in certain versions 
or they even require minimum version of php or zend. These tests should be 
skipped when the requirement cannot be fullfilled. To achieve this you can
use the SKIPIF section. To tell run-test.php that your test should be skipped
the SKIPIF section must print out the word "skip" followed by a reason why
the test should skip.</p>

<i>/ext/exif/tests/exif005.phpt</i>
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
input. </p>


<p>
<b>Note:</b> no file used by any test should have one of the following extensions: 
".php", ".log", ".exp", ".out" or ".diff".  When you use an include file for the 
SKIPIF section it should be named "skipif.inc" and an include file used in the 
FILE section of many tests should be named "test.inc".</p>

<h2> Final Notes</h2>
<h3>Redirecting tests</h3>
<p>Using --REDIRECTTEST-- it is possible to redirect from one test to a bunch 
of other tests. That way multiple extensions can refer to the same set of 
test scripts probably using it with a different configuration.</p>

<p>The block is eval'd and supposed to return an array describing how to 
redirect. The resulting array must contain the key 'TEST' that stores the 
redirect target as a string. This string usually is the directory where the 
test scripts are located and should be relative. Optionally you can use 
the 'ENV' as an array configuring the environment to be set when executing 
the tests. This way you can pass configuration to the executed tests.
</p>

<p>Redirect tests may especially contain --SKIPIF--, --ENV-- and --ARGS-- 
sections but they no not use any --EXPECT-- section.</p>

<p>The redirected tests themselves are just normal tests.</p>

<h3>Error reporting in tests</h3>
<p>All tests should run correctly with error_reporting(E_ALL) and
display_errors=1. This is the default when called from run-test.php.  If you
have a good reason for lowering the error reporting, use --INI-- section and
comment this in your testcode.</p>

<p>If your test intentionally generates a PHP warning message use
$php_errormsg variable, which you can then output. This will result in a
consistent error message output across all platforms and PHP configurations,
preventing your test from failing due inconsistencies in the error message
content. Alternatively you can use --EXPECTF-- and check for the message by
replacing the path of the source of the message with "%s" and the line number 
with "%d". The end of a message in a test file "example.phpt" then looks like 
"in %sexample.php on line %d". We explicitly dropped the last path devider as 
that is a system dependent character '/' or '\'.</p>

<h3>Last bit</h3>
<p>Often you want to run test scripts without run-tests.php by
simply executing them on commandline like any other php script. But sometimes
it disturbs having a long --EXPECT-- block, so that you don't see the actual 
output as it scrolls away overwritten by the blocks following the actual file
block. The workaround is to use terminate the --FILE-- section with the two 
lines "===DONE===" and "<?php echo "<\?php exit(0); ?\>"; ?>".
When doing so run-tests.php does not execute the line containing the exit call
as that would suppress leak messages. Actually run-tests.php ignores any part
after a line consisting only of "===DONE===".</p>
<p></p>
          </td>
          <td width="10">&nbsp;</td>
        </tr>
      </table>
<?php

common_footer();
?>
