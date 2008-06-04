<?php
include("include/functions.php");

$TITLE = "Writing Tests [PHP-QAT: Quality Assurance Team]";
$SITE_UPDATE = date("D M d H:i:s Y T", filectime(__FILE__));
/* $Id$ */

common_header();
?>
	<table width="70%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="10"><img src="gfx/spacer.gif" width="10" height="1"></td>
          <td width="100%"> 
            <h1>Details of PHPT format</h1>
          </td>
          <td width="10"><img src="gfx/spacer.gif" width="10" height="1"></td>
        </tr>
        <tr> 
          <td width="10">&nbsp;</td>
          <td width="100%">
<dl>
<dt>--TEST--</dt>
<dd>title of the test. (required)</dd>

<dt>--CREDITS--</dt>
<dd>if you don't have CVS commit rights, put your name and  email on the first line. If 
the test is part of a TesFest event, then # followed by the name of the event and the date (YYYY-MM-DD) 
on the second line. (optional)</dd>

<dt>--SKIPIF--</dt>
<dd>a condition when to skip this test. (optional)</dd>

<dt>--POST--</dt>
<dd>POST variables to be passed to the test script. This section forces the
use of the CGI binary instead of the usual CLI one. (optional)</dd>

<dt>--GZIP_POST--</dt>
<dd>When this section exists, the POST data will be gzencode()'d. (optional)</dd>

<dt>--DEFLATE_POST--</dt>
<dd>When this section exists, the POST data will be gzcompress()'ed. (optional)</dd>

<dt>--POST_RAW--</dt>
<dd>RAW POST data to be passed to the test script. This differs from the section
above because it doesn't set the Content-Type, which can be set manually in
this section. This section forces the use of the CGI binary instead of the
usual CLI one. (optional)</dd>

<dt>--GET--</dt>
<dd>GET variables to be passed to the test script. This section forces the
use of the CGI binary instead of the usual CLI one. (optional)</dd>

<dt>--COOKIE--</dt>
<dd>Cookies to be passed to the test script. This section forces the
use of the CGI binary instead of the usual CLI one. (optional)</dd>

<dt>--STDIN--</dt>
<dd>data to be fed to the test script's standard input. (optional)</dd>

<dt>--INI--</dt>
<dd>to be used if you need a specific php.ini setting for the test.  
	Each line contains an ini setting   e.g. foo=bar. (optional)</dd>

<dt>--ARGS--</dt>
<dd>a single line defining the arguments passed to php. (optional)</dd>

<dt>--ENV--</dt>
<dd>configures the environment to be used for php. (optional)</dd>

<dt>--FILE--</dt>
<dd>the test source-code. (required)</dd>

<dt>--FILEEOF--</dt>
<dd>an alternative to --FILE-- where any trailing line break is omitted.</dd>

<dt>--FILE_EXTERNAL--</dt>
<dd>an alternative to --FILE--. This is used to specify that an external
file should be used as the contents of the test file, and is designed
for running the same test file with different ini, environment, post/get
or other external inputs. The file must be in the same directory as the
test file, or a subdirectory.</dd>

<dt>--EXPECT--</dt>
<dd>the expected output from the test script. (required)</dd>

<dt>--UEXPECT--</dt>
<dd>same as above, but for Unicode mode (PHP &gt;= 6 only, optional)</dd>

<dt>--EXPECTF--</dt>
<dd>an alternative of --EXPECT--. The difference is that this form uses
sscanf for output validation. (alternative to --EXPECT--)</dd>

<dt>--UEXPECTF--</dt>
<dd>same as above, but for Unicode mode (PHP &gt;= 6 only, optional)</dd>

<dt>--EXPECTREGEX--</dt>
<dd>an alternative of --EXPECT--. This form allows the tester to specify the
result in a regular expression. (alternative to --EXPECT--)</dd>

<dt>--UEXPECTREGEX--</dt>
<dd>same as above, but for Unicode mode (PHP &gt;= 6 only, optional)</dd>

<dt>--REDIRECTTEST--</dt>
<dd>this block allows to redirect from one test to a bunch of other tests.
(alernative to --FILE--)</dd>

<dt>--HEADERS--</dt>
<dd>header to be used when sending the request. Currently only available with
server-tests.php (optional)</dd>

<dt>--EXPECTHEADERS--</dt>
<dd>the expected headers. Any header specified here must exist in the 
response and have the same value. Additional headers do not matter. (optional)
</dd>

<dt>--CLEAN--</dt>
<dd>code that is executed after the test has run. Using run-tests.php switch 
--no-clean you can prevent its execution to inspect generated data/files that
were normally removed after the test. (optional)</dd>

<dt>--XFAIL--</dt>
<dd>a test that is expected to fail. Any text added in this section should simply explain why the 
test is expected to fail. This section is intented as a convenience to developers who
may wish to distinguish between tests that they know will fail, because the function they 
test is not implemented yet, and tests which should pass. As soon as the function
is implemented the XFAIL section should be removed from the test. XFAIL sections should
not appear in tests associated with released levels of PHP.

<dt>===DONE===</dt>
<dd>This is only available in the --FILE-- section. Any part after this line
is not going into the actual test script (optional).</dd>
</dl>

<p><strong>Note:</strong> The Uxx sections (such as UEXPECT) are only needed if
the output of the test differs in Unicode and non-Unicode mode.</p>
