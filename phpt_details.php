<?php
include("include/functions.php");

$TITLE = "PHPT Test File Layout [PHP-QAT: Quality Assurance Team]";
$SITE_UPDATE = date("D M d H:i:s Y T", filectime(__FILE__));

common_header();
?>

<div style="padding: 10px">
<h1>PHPT - Test File Layout.</h1>
<p>Below is a reference manual for PHPT test file layouts.</p>
<dl>

<dt>Section Summary List.</dt>
<dd>
<p>[] indicates optional sections.</p>
<p><a href="#test_section">--TEST--</a><br/>
[<a href="#description_section">--DESCRIPTION--</a>]<br/>
[<a href="#credits_section">--CREDITS--</a>]<br/>
[<a href="#skipif_section">--SKIPIF--</a>]<br/>
[<a href="#conflicts_section">--CONFLICTS--</a>]<br/>
[<a href="#whitespace_sensitive_section">--WHITESPACE_SENSITIVE--</a>]<br/>
[<a href="#capture_stdio_section">--CAPTURE_STDIO--</a>]<br/>
[<a href="#extensions_section">--EXTENSIONS--</a>]<br/>
[<a href="#post_section">--POST--</a> | <a href="#put_section">--PUT--</a> | <a href="#post_raw_section">--POST_RAW--</a> | <a href="#gzip_post_section">--GZIP_POST--</a> | <a href="#deflate_post_section">--DEFLATE_POST--</a> | <a href="#get_section">--GET--</a>]<br/>
[<a href="#cookie_section">--COOKIE--</a>]<br/>
[<a href="#stdin_section">--STDIN--</a>]<br/>
[<a href="#ini_section">--INI--</a>]<br/>
[<a href="#args_section">--ARGS--</a>]<br/>
[<a href="#env_section">--ENV--</a>]<br/>
[<a href="#phpdbg_section">--PHPDBG--</a>]<br/>
<a href="#file_section">--FILE--</a> | <a href="#fileeof_section">--FILEEOF--</a> | <a href="#file_external_section">--FILE_EXTERNAL--</a> | <a href="#redirecttest_section">--REDIRECTTEST--</a><br/>
[<a href="#cgi_section">--CGI--</a>]<br/>
[<a href="#xfail_section">--XFAIL--</a>]<br/>
[<a href="#expectheaders_section">--EXPECTHEADERS</a>--]<br/>
<a href="#expect_section">--EXPECT--</a> | <a href="#expectf_section">--EXPECTF--</a> | <a href="#expectregex_section">--EXPECTREGEX--</a>
| <a href="#expect_external_section">--EXPECT_EXTERNAL--</a> | <a href="#expectf_external_section">--EXPECTF_EXTERNAL--</a> | <a href="#expectregex_external_section">--EXPECTREGEX_EXTERNAL--</a>
<br/>
[<a href="#clean_section">--CLEAN--</a>]
</dd>

<dt id="test_section">--TEST--</dt>
<dd>
<p><b>Description:</b><br/>
Title of test as a single line short description.</p>
<p><b>Required:</b><br/>
Yes</p>
<p><b>Format:</b><br/>
Plain text. We recommend a single line only.</p>
<p><b>Example 1 (snippet):</b><br/>
<pre>--TEST--
Test filter_input() with GET and POST data.</pre>
</p>
<p><b>Example 1 (full):</b> <a href="sample_tests/sample001.php">sample001.phpt</a></p>
</dd>

<dt id="description_section">--DESCRIPTION--</dt>
<dd>
<p><b>Description:</b><br/>
If your test requires more than a single line title to adequately describe it,
you can use this section for further explanation. Multiple lines are allowed and
besides being used for information, this section is completely ignored by the
test binary.</p>
<p><b>Required:</b><br/>
No</p>
<p><b>Format:</b><br/>
Plain text, multiple lines.</p>
<p><b>Example 1 (snippet):</b><br/>
<pre>--DESCRIPTION--
This test covers both valid and invalid usages of
filter_input() with INPUT_GET and INPUT_POST data
and several different filter sanitizers.</pre>
</p>
<p><b>Example 1 (full):</b> <a href="sample_tests/sample001.php">sample001.phpt</a></p>
</dd>

<dt id="credits_section">--CREDITS--</dt>
<dd>
<p><b>Description:</b><br/>
Used to credit contributors without CVS commit rights, who put their name and email on the first line.
If the test was part of a TestFest event, then # followed by the name of the event
and the date (YYYY-MM-DD) on the second line.</p>
<p><b>Required:</b><br/>
No. For newly created tests this section should no longer be included, as test authorship is already
accurately tracked by Git. If multiple authors should be credited, the `Co-authored-by` tag in the
commit message may be used.</p>
<p><b>Format:</b><br/>
Name Email<br/>
[Event]</p>
<p><b>Example 1 (snippet):</b><br/>
<pre>--CREDITS--
Felipe Pena <felipe@php.net></pre>
</p>
<p><b>Example 1 (full):</b> <a href="sample_tests/sample001.php">sample001.phpt</a></p>
<p><b>Example 2 (snippet):</b><br/>
<pre>--CREDITS--
Zoe Slattery zoe@php.net
# TestFest Munich 2009-05-19</pre>
</p>
<p><b>Example 2 (full):</b> <a href="sample_tests/sample002.php">sample002.phpt</a></p>
</dd>

<dt id="skipif_section">--SKIPIF--</dt>
<dd>
<p><b>Description:</b><br/>
A condition or set of conditions used to determine if a test should be skipped.
Tests that are only applicable to a certain platform, extension or PHP version
are good reasons for using a --SKIPIF-- section.</p>
<p>A common practice for extension tests is to write your --SKIPIF-- extension
criteria into a file call skipif.inc and then including that file in the
--SKIPIF-- section of all your extension tests. This promotes the DRY principle
and reduces future code maintenance.</p>
<p><b>Required:</b><br/>
No.</p>
<p><b>Format:</b><br/>
PHP code enclosed by PHP tags. If the output of this scripts starts with "skip",
the test is skipped. If the output starts with "xfail", the test is marked as
expected failure. The "xfail" convention is supported as of PHP 7.2.0.</p>
<p><b>Example 1 (snippet):</b><br/>
<pre>--SKIPIF--
&lt;?php if (!extension_loaded("filter")) die("Skipped: filter extension required."); ?&gt;</pre>
</p>
<p><b>Example 1 (full):</b> <a href="sample_tests/sample001.php">sample001.phpt</a></p>
<p><b>Example 2 (snippet):</b><br/>
<pre>--SKIPIF--
&lt;?php include('skipif.inc'); ?&gt;</pre>
</p>
<p><b>Example 2 (full):</b> <a href="sample_tests/sample003.php">sample003.phpt</a></p>
<p><b>Example 3 (snippet):</b><br/>
<pre>--SKIPIF--
&lt;?php if (getenv('SKIP_ASAN')) die('xfail Startup failure leak'); ?&gt;</pre>
</p>
<p><b>Example 3 (full):</b> <a href="sample_tests/xfailif.php">xfailif.phpt</a></p>
</dd>

<dt id="conflicts_section">--CONFLICTS--</dt>
<dd>
<p><b>Description:</b><br/>
<p>This section is only relevant for parallel test execution (available as of
PHP 7.4.0), and allows to specify conflict keys. While a test that conflicts
with key K is running, no other test that conflicts with K is run.
For tests conflicting with "all", no other tests are run in parallel.</p>
<p>An alternative to have a --CONFLICTS-- section is to add a file named
CONFLICTS to the directory containing the tests. The contents of the CONFLICTS
file must have the same format as the contents of the --CONFLICTS-- section.
</p>
<p><b>Required:</b><br/>
No.</p>
<p><b>Format:</b><br/>
One conflict key per line. Comment lines starting with # are also allowed.</p>
<p><b>Example 1 (snippet):</b><br/>
<pre>--CONFLICTS--
server</pre>
</p>
<p><b>Example 1 (full):</b> <a href="sample_tests/conflicts_1.php">conflicts_1.phpt</a></p>
</dd>

<dt id="whitespace_sensitive_section">--WHITESPACE_SENSITIVE--</dt>
<dd>
<p><b>Description:</b><br/>
<p>This flag is used to indicate that the test should not be changed by
automated formatting changes. Available as of PHP 7.4.3.
</p>
<p><b>Required:</b><br/>
No.</p>
<p><b>Format:</b><br/>
No value, just the --WHITESPACE_SENSITIVE-- statement.</p>
</dd>

<dt id="capture_stdio_section">--CAPTURE_STDIO--</dt>
<dd>
<p><b>Description:</b><br/>
This section enables which I/O streams the run-tests.php test script will use
when comparing executed file to the expected output. The STDIN is the standard
input stream. When STDOUT is enabled, the test script will also check the
contents of the standard output. When STDERR is enabled, the test script will
also compare the contents of the standard error I/O stream.</p>
<p>If this section is left out of the test, by default, all three streams are
enabled, so the tests without this section capture all and is the same as enabling
all three manually.</p>
<p><b>Required:</b><br/>
No.</p>
<p><b>Format:</b><br/>
A case-insensitive space, newline or otherwise delimited list of one or more
strings of STDIN, STDOUT, and/or STDERR.
</p>
<p><b>Example 1 (snippet):</b><br/>
<pre>--CAPTURE_STDIO--
STDIN STDERR
</pre>
</p>
<p><b>Example 1 (full):</b> <a href="sample_tests/capture_stdio_1.php">capture_stdio_1.phpt</a></p>
<p><b>Example 2 (snippet):</b><br/>
<pre>--CAPTURE_STDIO--
STDIN STDOUT</pre>
</p>
<p><b>Example 2 (full):</b> <a href="sample_tests/capture_stdio_2.php">capture_stdio_2.phpt</a></p>
<p><b>Example 3 (snippet):</b><br/>
<pre>--CAPTURE_STDIO--
STDIN STDOUT STDERR</pre>
</p>
<p><b>Example 3(full):</b> <a href="sample_tests/capture_stdio_3.php">capture_stdio_3.phpt</a></p>

<dt id="extensions_section">--EXTENSIONS--</dt>
<dd>
<p><b>Description:</b><br/>
Additional required shared extensions to be loaded when running the test. When
the run-tests.php script is executed it loads all the extensions that are
available and enabled for that particular PHP at the time. If the test requires
additional extension to be loaded and they aren't loaded prior to running the
test, this section loads them.</p>
<p><b>Required:</b><br/>
No.</p>
<p><b>Format:</b><br/>
A case-sensitive newline separated list of extension names.</p>
<p><b>Example 1 (snippet):</b><br/>
<pre>--EXTENSIONS--
curl
imagick
tokenizer
</pre>
</p>
<p><b>Example 1 (full):</b> <a href="sample_tests/extensions.php">extensions.phpt</a></p>
</dd>

<dt id="post_section">--POST--</dt>
<dd>
<p><b>Description:</b><br/>
POST variables or data to be passed to the test script. This section forces the
use of the CGI binary instead of the usual CLI one.</p>
<p><b>Required:</b><br/>
No.</p>
<p><b>Requirements:</b><br/>
PHP CGI binary.</p>
<p><b>Format:</b><br/>
Follows the HTTP post data format.</p>
<p><b>Example 1 (snippet):</b><br/>
<pre>--POST--
c=&lt;p&gt;string&lt;/p&gt;&amp;d=12345.7</pre>
</p>
<p><b>Example 1 (full):</b> <a href="sample_tests/sample001.php">sample001.phpt</a></p>
<p><b>Example 2 (snippet):</b><br/>
<pre>--POST--
&lt;SOAP-ENV:Envelope
  SOAP-ENV:encodingStyle=&quot;http://schemas.xmlsoap.org/soap/encoding/&quot;
  xmlns:SOAP-ENV=&quot;http://schemas.xmlsoap.org/soap/envelope/&quot;
  xmlns:xsd=&quot;http://www.w3.org/2001/XMLSchema&quot;
  xmlns:xsi=&quot;http://www.w3.org/2001/XMLSchema-instance&quot;
  xmlns:si=&quot;http://soapinterop.org/xsd&quot;&gt;
  &lt;SOAP-ENV:Body&gt;
    &lt;ns1:test xmlns:ns1=&quot;http://testuri.org&quot; /&gt;
  &lt;/SOAP-ENV:Body&gt;
&lt;/SOAP-ENV:Envelope&gt;</pre></p>
<p><b>Example 2 (full):</b> <a href="sample_tests/sample005.php">sample005.phpt</a></p>
</dd>

<dt id="post_raw_section">--POST_RAW--</dt>
<dd>
<p><b>Description:</b><br/>
Raw POST data to be passed to the test script. This differs from the section
above because it doesn't automatically set the Content-Type, this leaves you
free to define your own within the section. This section forces the use of the
CGI binary instead of the usual CLI one.</p>
<p><b>Required:</b><br/>
No.</p>
<p><b>Requirements:</b><br/>
PHP CGI binary.</p>
<p><b>Test Script Support:</b><br/>
run-tests.php</p>
<p><b>Format:</b><br/>
Follows the HTTP post data format.</p>
<p><b>Example 1 (snippet):</b><br/>
<pre>--POST_RAW--
Content-type: multipart/form-data, boundary=AaB03x

--AaB03x
content-disposition: form-data; name=&quot;field1&quot;

Joe Blow
--AaB03x
content-disposition: form-data; name=&quot;pics&quot;; filename=&quot;file1.txt&quot;
Content-Type: text/plain

abcdef123456789
--AaB03x--</pre></p>
<p><b>Example 1 (full):</b> <a href="sample_tests/sample006.php">sample006.phpt</a></p>
</dd>

<dt id="put_section">--PUT--</dt>
<dd>
<p><b>Description:</b><br/>
Similar to the section above, PUT data to be passed to the test script.
This section forces the use of the CGI binary instead of the usual CLI one.</p>
<p><b>Required:</b><br/>
No.</p>
<p><b>Requirements:</b><br/>
PHP CGI binary.</p>
<p><b>Test Script Support:</b><br/>
run-tests.php</p>
<p><b>Format:</b><br/>
Raw data optionally preceded by a Content-Type header.</p>
<p><b>Example 1 (snippet):</b><br/>
<pre>--PUT--
Content-Type: text/json

{"name":"default output handler","type":0,"flags":112,"level":0,"chunk_size":0,"buffer_size":16384,"buffer_used":3}</pre>
</p>
</dd>

<dt id="gzip_post_section">--GZIP_POST--</dt>
<dd>
<p><b>Description:</b><br/>
When this section exists, the POST data will be gzencode()'d. This section
forces the use of the CGI binary instead of the usual CLI one.</p>
<p><b>Required:</b><br/>
No.</p>
<p><b>Test Script Support:</b><br/>
run-tests.php</p>
<p><b>Format:</b><br/>
Just add the content to be gzencode()'d in the section.</p>
<p><b>Example 1 (snippet):</b><br/>
<pre>--GZIP_POST--
&lt;SOAP-ENV:Envelope
  SOAP-ENV:encodingStyle=&quot;http://schemas.xmlsoap.org/soap/encoding/&quot;
  xmlns:SOAP-ENV=&quot;http://schemas.xmlsoap.org/soap/envelope/&quot;
  xmlns:xsd=&quot;http://www.w3.org/2001/XMLSchema&quot;
  xmlns:xsi=&quot;http://www.w3.org/2001/XMLSchema-instance&quot;
  xmlns:si=&quot;http://soapinterop.org/xsd&quot;&gt;
  &lt;SOAP-ENV:Body&gt;
    &lt;ns1:test xmlns:ns1=&quot;http://testuri.org&quot; /&gt;
  &lt;/SOAP-ENV:Body&gt;
&lt;/SOAP-ENV:Envelope&gt;
</p></pre>
<p><b>Example 1 (full):</b> <a href="sample_tests/sample005.php">sample005.phpt</a></p>
</dd>

<dt id="deflate_post_section">--DEFLATE_POST--</dt>
<dd>
<p><b>Description:</b><br/>
When this section exists, the POST data will be gzcompress()'ed. This section
forces the use of the CGI binary instead of the usual CLI one.</p>
<p><b>Required:</b><br/>
No.</p>
<p><b>Requirements:</b><br/>
<p><b>Test Script Support:</b><br/>
run-tests.php</p>
<p><b>Format:</b><br/>
Just add the content to be gzcompress()'ed in the section.</p>
<p><b>Example 1 (snippet):</b><br/>
<pre>--DEFLATE_POST--
&lt;?xml version=&quot;1.0&quot; encoding=&quot;ISO-8859-1&quot;?&gt;
&lt;SOAP-ENV:Envelope
  SOAP-ENV:encodingStyle=&quot;http://schemas.xmlsoap.org/soap/encoding/&quot;
  xmlns:SOAP-ENV=&quot;http://schemas.xmlsoap.org/soap/envelope/&quot;
  xmlns:xsd=&quot;http://www.w3.org/2001/XMLSchema&quot;
  xmlns:xsi=&quot;http://www.w3.org/2001/XMLSchema-instance&quot;
  xmlns:si=&quot;http://soapinterop.org/xsd&quot;&gt;
  &lt;SOAP-ENV:Body&gt;
    &lt;ns1:test xmlns:ns1=&quot;http://testuri.org&quot; /&gt;
  &lt;/SOAP-ENV:Body&gt;
&lt;/SOAP-ENV:Envelope&gt;
</pre></p>
<p><b>Example 1 (full):</b> <a href="sample_tests/sample007.php">sample007.phpt</a></p>
</dd>

<dt id="get_section">--GET--</dt>
<dd>
<p><b>Description:</b><br/>
GET variables to be passed to the test script. This section forces the use of
the CGI binary instead of the usual CLI one.</p>
<p><b>Required:</b><br/>
No.</p>
<p><b>Requirements:</b><br/>
PHP CGI binary.</p>
<p><b>Format:</b><br/>
A single line of text passed as the GET data to the script.</p>
<p><b>Example 1 (snippet):</b><br/>
<pre>--GET--
a=&lt;b&gt;test&lt;/b&gt;&amp;b=http://example.com</pre></p>
<p><b>Example 1 (full):</b> <a href="sample_tests/sample001.php">sample001.phpt</a></p>
<p><b>Example 2 (snippet):</b><br/>
<pre>--GET--
ar[elm1]=1234&amp;ar[elm2]=0660&amp;a=0234</pre></p>
<p><b>Example 2 (full):</b> <a href="sample_tests/sample008.php">sample008.phpt</a></p>
</dd>

<dt id="cookie_section">--COOKIE--</dt>
<dd>
<p><b>Description:</b><br/>
Cookies to be passed to the test script. This section forces the use of the CGI
binary instead of the usual CLI one.</p>
<p><b>Required:</b><br/>
No.</p>
<p><b>Requirements:</b><br/>
PHP CGI binary.</p>
<p><b>Test Script Support:</b><br/>
run-tests.php</p>
<p><b>Format:</b><br/>
A single line of text in a valid HTTP cookie format.</p>
<p><b>Example 1 (snippet):</b><br/>
<pre>--COOKIE--
hello=World;goodbye=MrChips</pre></p>
<p><b>Example 1 (full):</b> <a href="sample_tests/sample002.php">sample002.phpt</a></p>
</dd>

<dt id="stdin_section">--STDIN--</dt>
<dd>
<p><b>Description:</b><br/>
Data to be fed to the test script's standard input.</p>
<p><b>Required:</b><br/>
No.</p>
<p><b>Test Script Support:</b><br/>
run-tests.php</p>
<p><b>Format:</b><br/>
Any text within this section is passed as STDIN to PHP.</p>
<p><b>Example 1 (snippet):</b><br/>
<pre>--STDIN--
fooBar
use this to input some thing to the php script</pre></p>
<p><b>Example 1 (full):</b> <a href="sample_tests/sample009.php">sample009.phpt</a></p>
</dd>

<dt id="ini_section">--INI--</dt>
<dd>
<p><b>Description:</b><br/>
To be used if you need a specific php.ini setting for the test.</p>
<p><b>Required:</b><br/>
No.</p>
<p><b>Format:</b><br/>
Key value pairs including automatically replaced tags. One setting per line. Content that is not a valid ini setting may cause failures.</p>
<p>The following is a list of all tags and what they are used to represent:</p>
<ul>
<li>{PWD}: Represents the directory of the file containing the --INI-- section.</li>
<li>{TMP}: Represents the system's temporary directory. Available as of PHP 7.2.19 and 7.3.6.</li>
</ul>
<p><b>Example 1 (snippet):</b><br/>
<pre>--INI--
precision=14</pre></p>
<p><b>Example 1 (full):</b> <a href="sample_tests/sample001.php">sample001.phpt</a></p>
<p><b>Example 2 (snippet):</b><br/>
<pre>--INI--
session.use_cookies=0
session.cache_limiter=
register_globals=1
session.serialize_handler=php
session.save_handler=files</pre></p>
<p><b>Example 2 (full):</b> <a href="sample_tests/sample003.php">sample003.phpt</a></p>
</dd>

<dt id="args_section">--ARGS--</dt>
<dd>
<p><b>Description:</b><br/>
A single line defining the arguments passed to php.</p>
<p><b>Required:</b><br/>
No.</p>
<p><b>Format:</b><br/>
A single line of text that is passed as the argument(s) to the PHP CLI.</p>
<p><b>Example 1 (snippet):</b><br/>
<pre>--ARGS--
--arg value --arg=value -avalue -a=value -a value</pre></p>
<p><b>Example 1 (full):</b> <a href="sample_tests/sample010.php">sample010.phpt</a></p>
</dd>

<dt id="env_section">--ENV--</dt>
<dd>
<p><b>Description:</b><br/>
Configures environment variables such as those found in the $_SERVER global
array.</p>
<p><b>Required:</b><br/>
No.</p>
<p><b>Format:</b><br/>
Key value pairs. One setting per line.</p>
<p><b>Example 1 (snippet):</b><br/>
<pre>--ENV--
SCRIPT_NAME=/frontcontroller10.php
REQUEST_URI=/frontcontroller10.php/hi
PATH_INFO=/hi</pre></p>
<p><b>Example 1 (full):</b> <a href="sample_tests/sample018.php">sample018.phpt</a></p>
</dd>

<dt id="phpdbg_section">--PHPDBG--</dt>
<dd>
<p><b>Description:</b><br/>
This section takes arbitrary phpdbg commands and executes the test file
according to them as it would be run in the phpdbg prompt.</p>
<p><b>Required:</b><br/>
No.</p>
<p><b>Format:</b><br/>
arbitrary phpdbg commands</p>
<p><b>Example 1 (snippet):</b><br/>
<pre>--PHPDBG--
b 4
b del 0
b 5
r
b del 1
r
y
q
</pre></p>
<p><b>Example 1 (full):</b> <a href="sample_tests/phpdbg_1.php">phpdbg_1.phpt</a></p>
</dd>

<dt id="file_section">--FILE--</dt>
<dd>
<p><b>Description:</b><br/>
The test source code.</p>
<p><b>Required:</b><br/>
One of the FILE type sections is required.</p>
<p><b>Format:</b><br/>
PHP source code enclosed by PHP tags.</p>
<p><b>Example 1 (snippet):</b><br/>
<pre>--FILE--
&lt;?php
ini_set('html_errors', false);
var_dump(filter_input(INPUT_GET, &quot;a&quot;, FILTER_SANITIZE_STRIPPED));
var_dump(filter_input(INPUT_GET, &quot;b&quot;, FILTER_SANITIZE_URL));
var_dump(filter_input(INPUT_GET, &quot;a&quot;, FILTER_SANITIZE_SPECIAL_CHARS, array(1,2,3,4,5)));
var_dump(filter_input(INPUT_GET, &quot;b&quot;, FILTER_VALIDATE_FLOAT, new stdClass));
var_dump(filter_input(INPUT_POST, &quot;c&quot;, FILTER_SANITIZE_STRIPPED, array(5,6,7,8)));
var_dump(filter_input(INPUT_POST, &quot;d&quot;, FILTER_VALIDATE_FLOAT));
var_dump(filter_input(INPUT_POST, &quot;c&quot;, FILTER_SANITIZE_SPECIAL_CHARS));
var_dump(filter_input(INPUT_POST, &quot;d&quot;, FILTER_VALIDATE_INT));
var_dump(filter_var(new stdClass, &quot;d&quot;));
var_dump(filter_input(INPUT_POST, &quot;c&quot;, &quot;&quot;, &quot;&quot;));
var_dump(filter_var(&quot;&quot;, &quot;&quot;, &quot;&quot;, &quot;&quot;, &quot;&quot;));
var_dump(filter_var(0, 0, 0, 0, 0));
echo &quot;Done\n&quot;;
?&gt;</pre></p>
<p><b>Example 1 (full):</b> <a href="sample_tests/sample001.php">sample001.phpt</a></p>
</dd>

<dt id="fileeof_section">--FILEEOF--</dt>
<dd>
<p><b>Description:</b><br/>
An alternative to --FILE-- where any trailing line breaks (\n || \r || \r\n
found at the end of the section) are omitted. This is an extreme edge-case
feature, so 99.99% of the time you won't need this section.</p>
<p><b>Required:</b><br/>
One of the FILE type sections is required.</p>
<p><b>Test Script Support:</b><br/>
run-tests.php</p>
<p><b>Format:</b><br/>
PHP source code enclosed by PHP tags.</p>
<p><b>Example 1 (snippet):</b><br/>
<pre>--FILEEOF--
&lt;?php
eval(&quot;echo 'Hello'; // comment&quot;);
echo &quot; World&quot;;
//last line comment</pre></p>
<p><b>Example 1 (full):</b> <a href="sample_tests/sample011.php">sample011.phpt</a></p>
</dd>

<dt id="file_external_section">--FILE_EXTERNAL--</dt>
<dd>
<p><b>Description:</b><br/>
An alternative to --FILE--. This is used to specify that an external file should
be used as the --FILE-- contents of the test file, and is designed for running
the same test file with different ini, environment, post/get or other external
inputs. Basically it allows you to DRY up some of your tests. The file must be
in the same directory as the test file, or in a subdirectory.</p>
<p><b>Required:</b><br/>
One of the FILE type sections is required.</p>
<p><b>Test Script Support:</b><br/>
run-tests.php</p>
<p><b>Format:</b><br/>
path/to/file. Single line.</p>
<p><b>Example 1 (snippet):</b><br/>
<pre>--FILE_EXTERNAL--
files/file012.inc</pre></p>
<p><b>Example 1 (full):</b> <a href="sample_tests/sample012.php">sample012.phpt</a></p>
</dd>

<dt id="redirecttest_section">--REDIRECTTEST--</dt>
<dd>
<p><b>Description:</b><br/>
This block allows you to redirect from one test to a bunch of other tests. It
also allows you to set configurations which are used on all tests in your
destination.</p>
<p><b>Required:</b><br/>
One of the FILE type sections is required.</p>
<p><b>Test Script Support:</b><br/>
run-tests.php</p>
<p><b>Format:</b><br/>
PHP source which is run through eval(). The tests destination is the value of an
array index 'TESTS'. Also, keep in mind, you cannot use a REDIRECTTEST which is
being pointed to by another test which contains a REDIRECTTEST. In other words,
no nesting.</p>
<p>The relative path declared in 'TESTS' is relative to the base directory for the
PHP source code, not relative to the current directory.</p>
<p>Last note, the array in this section must be returned to work.</p>
<p><b>Example 1 (snippet):</b><br/>
<pre>--REDIRECTTEST--
return array(
  'ENV' =&gt; array(
      'PDOTEST_DSN' =&gt; 'sqlite2::memory:'
    ),
  'TESTS' =&gt; 'ext/pdo/tests'
  );</pre></p>
<p><b>Example 1 (full):</b> <a href="sample_tests/sample013.php">sample013.phpt</a><br/>
Note: The destination tests for this example are not included. See the PDO
extension tests for reference to live tests using this section.</p>
<p><b>Example 2 (snippet):</b><br/>
<pre>--REDIRECTTEST--
# magic auto-configuration

$config = array(
  'TESTS' =&gt; 'ext/pdo/tests'
);

if (false !== getenv('PDO_MYSQL_TEST_DSN')) {
  # user set them from their shell
  $config['ENV']['PDOTEST_DSN'] = getenv('PDO_MYSQL_TEST_DSN');
  $config['ENV']['PDOTEST_USER'] = getenv('PDO_MYSQL_TEST_USER');
  $config['ENV']['PDOTEST_PASS'] = getenv('PDO_MYSQL_TEST_PASS');
  if (false !== getenv('PDO_MYSQL_TEST_ATTR')) {
    $config['ENV']['PDOTEST_ATTR'] = getenv('PDO_MYSQL_TEST_ATTR');
  }
} else {
  $config['ENV']['PDOTEST_DSN'] = 'mysql:host=localhost;dbname=test';
  $config['ENV']['PDOTEST_USER'] = 'root';
  $config['ENV']['PDOTEST_PASS'] = '';
}

return $config;</pre></p>
<p><b>Example 2 (full):</b> <a href="sample_tests/sample014.php">sample014.phpt</a><br/>
Note: The destination tests for this example are not included. See the PDO
extension tests for reference to live tests using this section.</p>
</dd>

<dt id="cgi_section">--CGI--</dt>
<dd>
<p><b>Description:</b><br/>
This section takes no value.  It merely provides a simple marker for tests that
MUST be run as CGI, even if there is no --POST-- or --GET-- sections in the test
file.  Available as of PHP 7.3.0.</p>
<p><b>Required:</b><br/>
No.</p>
<p><b>Format:</b><br/>
No value, just the --CGI-- statement.</p>
<p><b>Example 1 (snippet):</b><br/>
<pre>--CGI--</pre></p>
<p><b>Example 1 (full):</b> <a href="sample_tests/sample016.php">sample016.phpt</a></p>
</dd>

<dt id="xfail_section">--XFAIL--</dt>
<dd>
<p><b>Description:</b><br/>
This section identifies this test as one that is currently expected to fail. It
should include a brief description of why it's expected to fail. Reasons for
such expectations include tests that are written before the functionality
they are testing is implemented or notice of a bug which is due to upstream code
such as an extension which provides PHP support for some other software.</p>
<p>Please do NOT include an --XFAIL-- without providing a text description for
the reason it's being used.</p>
<p><b>Required:</b><br/>
No.</p>
<p><b>Test Script Support:</b><br/>
run-tests.php</p>
<p><b>Format:</b><br/>
A short plain text description of why this test is currently expected to fail.</p>
<p><b>Example 1 (snippet):</b><br/>
<pre>--XFAIL--
This bug might be still open on aix5.2-ppc64 and hpux11.23-ia64</pre></p>
<p><b>Example 1 (full):</b> <a href="sample_tests/sample017.php">sample017.phpt</a></p>
</dd>

<dt id="expectheaders_section">--EXPECTHEADERS--</dt>
<dd>
<p><b>Description:</b><br/>
The expected headers. Any header specified here must exist in the response and
have the same value or the test fails. Additional headers found in the actual
tests while running are ignored.</p>
<p><b>Required:</b><br/>
No.</p>
<p><b>Format:</b><br/>
HTTP style headers. May include multiple lines.</p>
<p><b>Example 1 (snippet):</b><br/>
<pre>--EXPECTHEADERS--
Status: 404</pre></p>
<p><b>Example 1 (snippet):</b><br/>
<pre>--EXPECTHEADERS--
Content-type: text/html; charset=UTF-8
Status: 403 Access Denied</pre></p>
<p><b>Example 1 (full):</b> <a href="sample_tests/sample018.php">sample018.phpt</a><br/>
Note: The destination tests for this example are not included. See the phar
extension tests for reference to live tests using this section.</p>
</dd>

<dt id="expect_section">--EXPECT--</dt>
<dd>
<p><b>Description:</b><br/>
The expected output from the test script. This must match the actual output from
the test script exactly for the test to pass.</p>
<p><b>Required:</b><br/>
One of the EXPECT type sections is required.</p>
<p><b>Format:</b><br/>
Plain text. Multiple lines of text are allowed.</p>
<p><b>Example 1 (snippet):</b><br/>
<pre>--EXPECT--
array(2) {
  [&quot;hello&quot;]=&gt;
  string(5) &quot;World&quot;
  [&quot;goodbye&quot;]=&gt;
  string(7) &quot;MrChips&quot;
}</pre></p>
<p><b>Example 1 (full):</b> <a href="sample_tests/sample002.php">sample002.phpt</a></p>
</dd>
<dt id="expect_external_section">--EXPECT_EXTERNAL--</dt>
<dd>
<p><b>Description:</b><br/>
Similar to to <a href="#expect_section">--EXPECT--</a> section, but just stating
a filename where to load the expected output from.
</p>
<p><b>Required:</b><br/>
One of the EXPECT type sections is required.</p>
<p><b>Test Script Support:</b><br/>
run-tests.php</p>
<p><b>Example 1 (snippet):</b><br/>
<pre>--EXPECT_EXTERNAL--
test001.expected.txt
</pre>
<p><b>test001.expected.txt</b>
<pre>array(2) {
  [&quot;hello&quot;]=&gt;
  string(5) &quot;World&quot;
  [&quot;goodbye&quot;]=&gt;
  string(7) &quot;MrChips&quot;
}</pre></p>
</dd>
<dt id="expectf_section">--EXPECTF--</dt>
<dd>
<p><b>Description:</b><br/>
An alternative of --EXPECT--. Where it differs from --EXPECT-- is that it uses a
number of substitution tags for strings, spaces, digits, etc. that appear in
test case output but which may vary between test runs. The most common example
of this is to use %s and %d to match the file path and line number which are
output by PHP Warnings.</p>
<p><b>Required:</b><br/>
One of the EXPECT type sections is required.</p>
<p><b>Format:</b><br/>
Plain text including tags which are inserted to represent different types of
output which are not guaranteed to have the same value on subsequent runs or
when run on different platforms.</p>
<p>The following is a list of all tags and what they are used to represent:<br/>
<ul>
<li>%e: Represents a directory separator, for example / on Linux.</li>
<li>%s: One or more of anything (character or white space) except the end of line
  character.</li>
<li>%S: Zero or more of anything (character or white space) except the end of line
  character.</li>
<li>%a: One or more of anything (character or white space) including the end of line
  character.</li>
<li>%A: Zero or more of anything (character or white space) including the end of line
  character.</li>
<li>%w: Zero or more white space characters.</li>
<li>%i: A signed integer value, for example +3142, -3142, 3142.</li>
<li>%d: An unsigned integer value, for example 123456.</li>
<li>%x: One or more hexadecimal character. That is, characters in the range 0-9, a-f,
  A-F.</li>
<li>%f: A floating point number, for example: 3.142, -3.142, 3.142E-10, 3.142e+10.</li>
<li>%c: A single character of any sort (.).</li>
<li>%r...%r: Any string (...) enclosed between two %r will be treated as a regular
  expression.</li>
</ul>
</p>
<p><b>Example 1 (snippet):</b><br/>
<pre>--EXPECTF--
string(4) &quot;test&quot;
string(18) &quot;http://example.com&quot;
string(27) &quot;&amp;#60;b&amp;#62;test&amp;#60;/b&amp;#62;&quot;

Notice: Object of class stdClass could not be converted to int in %ssample001.php on line %d
bool(false)
string(6) &quot;string&quot;
float(12345.7)
string(29) &quot;&amp;#60;p&amp;#62;string&amp;#60;/p&amp;#62;&quot;
bool(false)

Warning: filter_var() expects parameter 2 to be long, string given in %s011.php on line %d
NULL

Warning: filter_input() expects parameter 3 to be long, string given in %s011.php on line %d
NULL

Warning: filter_var() expects at most 3 parameters, 5 given in %s011.php on line %d
NULL

Warning: filter_var() expects at most 3 parameters, 5 given in %s011.php on line %d
NULL
Done</pre></p>
<p><b>Example 1 (full):</b> <a href="sample_tests/sample001.php">sample001.phpt</a></p>
<p><b>Example 2 (snippet):</b><br/>
<pre>--EXPECTF--
Warning: bzopen() expects exactly 2 parameters, 0 given in %s on line %d
NULL

Warning: bzopen(): '' is not a valid mode for bzopen(). Only 'w' and 'r' are supported. in %s on line %d
bool(false)

Warning: bzopen(): filename cannot be empty in %s on line %d
bool(false)

Warning: bzopen(): filename cannot be empty in %s on line %d
bool(false)

Warning: bzopen(): 'x' is not a valid mode for bzopen(). Only 'w' and 'r' are supported. in %s on line %d
bool(false)

Warning: bzopen(): 'rw' is not a valid mode for bzopen(). Only 'w' and 'r' are supported. in %s on line %d
bool(false)

Warning: bzopen(no_such_file): failed to open stream: No such file or directory in %s on line %d
bool(false)
resource(%d) of type (stream)
Done</pre></p>
<p><b>Example 2 (full):</b> <a href="sample_tests/sample019.php">sample019.phpt</a></p>
<p><b>Example 3 (snippet):</b><br/>
<pre>--EXPECTF--
object(DOMNodeList)#%d (0) {
}
int(0)
bool(true)
bool(true)
string(0) &quot;&quot;
bool(true)
bool(true)
bool(false)
bool(false)</pre></p>
<p><b>Example 2 (full):</b> <a href="sample_tests/sample020.php">sample020.phpt</a></p>
</dd>

<dt id="expectf_external_section">--EXPECTF_EXTERNAL--</dt>
<dd>
<p><b>Description:</b><br/>
Similar to to <a href="#expectf_section">--EXPECTF--</a> section, but like the
<a href="#expect_external">--EXPECT_EXTERNAL--</a> section just stating
a filename where to load the expected output from.
</p>
<p><b>Required:</b><br/>
One of the EXPECT type sections is required.</p>
<p><b>Test Script Support:</b><br/>
run-tests.php</p>
</dd>

<dt id="expectregex_section">--EXPECTREGEX--</dt>
<dd>
<p><b>Description:</b><br/>
An alternative of --EXPECT--. This form allows the tester to specify the result
in a regular expression.</p>
<p><b>Required:</b><br/>
One of the EXPECT type sections is required.</p>
<p><b>Format:</b><br/>
Plain text including regular expression patterns which represent data that can
vary between subsequent runs of a test or when run on different platforms.</p>
<p><b>Example 1 (snippet):</b><br/>
<pre>--EXPECTREGEX--
M_E       : 2.718281[0-9]*
M_LOG2E   : 1.442695[0-9]*
M_LOG10E  : 0.434294[0-9]*
M_LN2     : 0.693147[0-9]*
M_LN10    : 2.302585[0-9]*
M_PI      : 3.141592[0-9]*
M_PI_2    : 1.570796[0-9]*
M_PI_4    : 0.785398[0-9]*
M_1_PI    : 0.318309[0-9]*
M_2_PI    : 0.636619[0-9]*
M_SQRTPI  : 1.772453[0-9]*
M_2_SQRTPI: 1.128379[0-9]*
M_LNPI    : 1.144729[0-9]*
M_EULER   : 0.577215[0-9]*
M_SQRT2   : 1.414213[0-9]*
M_SQRT1_2 : 0.707106[0-9]*
M_SQRT3   : 1.732050[0-9]*</pre></p>
<p><b>Example 1 (full):</b> <a href="sample_tests/sample021.php">sample021.phpt</a></p>
<p><b>Example 2 (snippet):</b><br/>
<pre>--EXPECTF--
*** Testing imap_append() : basic functionality ***
Create a new mailbox for test
Create a temporary mailbox and add 0 msgs
.. mailbox '%s' created
Add a couple of msgs to new mailbox {%s}INBOX.%s
bool(true)
bool(true)
Msg Count after append : 2
List the msg headers
array(2) {
  [0]=&gt;
  string(%d) &quot;%w%s       1)%s webmaster@something. Test message (%d chars)&quot;
  [1]=&gt;
  string(%d) &quot;%w%s       2)%s webmaster@something. Another test (%d chars)&quot;
}</pre></p>
<p><b>Example 2 (full):</b> <a href="sample_tests/sample025.php">sample025.phpt</a></p>
<p><b>Example 3 (snippet):</b><br/>
<pre>--EXPECTREGEX--
string\(4\) \&quot;-012\&quot;
string\(8\) \&quot;2d303132\&quot;
(string\(13\) \&quot;   4294967284\&quot;|string\(20\) \&quot;18446744073709551604\&quot;)
(string\(26\) \&quot;20202034323934393637323834\&quot;|string\(40\) \&quot;3138343436373434303733373039353531363034\&quot;)</pre></p>
<p><b>Example 3 (full):</b> <a href="sample_tests/sample023.php">sample023.phpt</a></p>
</dd>

<dt id="expectregex_external_section">--EXPECTREGEX_EXTERNAL--</dt>
<dd>
<p><b>Description:</b><br/>
Similar to to <a href="#expectregex_section">--EXPECTREGEX--</a> section, but like the
<a href="#expect_external">--EXPECT_EXTERNAL--</a> section just stating
a filename where to load the expected output from.
</p>
<p><b>Required:</b><br/>
One of the EXPECT type sections is required.</p>
<p><b>Test Script Support:</b><br/>
run-tests.php</p>
</dd>

<dt id="clean_section">--CLEAN--</dt>
<dd>
<p><b>Description:</b><br/>
Code that is executed after a test completes. It's main purpose is to allow you
to clean up after yourself. You might need to remove files created during the
test or close sockets or database connections following a test. In fact, even
if a test fails or encounters a fatal error during the test, the code found in
the --CLEAN-- section will still run.</p>
<p>Code in the clean section is run in a completely different process than the
one the test was run in. So do not try accessing variables you created in the
--FILE-- section from inside the --CLEAN-- section, they won't exist.</p>
<p>Using the switch --no-clean on run-tests.php, you can prevent the code found
in the --CLEAN-- section of a test from running. This allows you to inspect
generated data or files without them being removed by the --CLEAN-- section.</p>
<p><b>Required:</b><br/>
No.</p>
<p><b>Test Script Support:</b><br/>
run-tests.php</p>
<p><b>Format:</b><br/>
PHP source code enclosed by PHP tags.</p>
<p><b>Example 1 (snippet):</b><br/>
<pre>--CLEAN--
&lt;?php
unlink(__DIR__.&#039;/DomDocument_save_basic.tmp&#039;);
?&gt;</pre></p>
<p><b>Example 1 (full):</b> <a href="sample_tests/sample024.php">sample024.phpt</a></p>
<p><b>Example 2 (snippet):</b><br/>
<pre>--CLEAN--
&lt;?php
require_once('clean.inc');
?&gt;</pre></p>
<p><b>Example 2 (full):</b> <a href="sample_tests/sample025.php">sample025.phpt</a></p>
<p><b>Example 3 (snippet):</b><br/>
<pre>--CLEAN--
&lt;?php
$key = ftok(__DIR__.&#039;/003.phpt&#039;, 'q');
$s = shm_attach($key);
shm_remove($s);
?&gt;</pre></p>
<p><b>Example 3 (full):</b> <a href="sample_tests/sample022.php">sample022.phpt</a></p>
</dd>

</dl>
</div>

<?php
common_footer();
