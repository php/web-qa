<?php
include("include/functions.php");
$TITLE = "Submit Build Test [PHP-QAT: Quality Assurance Team]";
$SITE_UPDATE = date("D M d H:i:s Y T", filectime($SCRIPT_FILENAME))."<br>
/* $Id$ */";

common_header();
?>
<h1>Build system</h1>

<h2>Case b1: Building with CLI</h2>
<p>
<b>Description:</b>
Testing of building with the new CLI
</p>
<p>
<b>Specifics:</b>
- As much SAPIs as possible<br />
- --disable-cli<br />
- Testing with a lot of extensions enabled<br />
- Tests with and without --disable-pear<br />
</p>

<h2>Case b2: MacOSX building</h2>
<p>
<b>Description:</b>
Testing of MacOSX buils with build tools used when packaging the RC
</p>

<h2>Case b3: iconv support</h2>
<p>
<b>Description:</b>
Build tests on multiple platforms, with and without libiconv
</p>
<p>
<b>Specifics:</b>
- Building on FreeBSD, OpenBSD, Windows and Linux (and others)<br />
- Having libiconv or not installed on all systems<br />
- Having libiconv in not standard locations<br />
</p>

<h2>Case b4: pspell building</h2>
<p>
<b>Description:</b>
Testing building with the pspell extension
</p>
<p>
<b>Specifics:</b>
- Building with pspell headers/libraries in weird non-standard locations
</p>


<h1>Core functions</h1>

<h2>Case c1: HTTP File Uploads</h2>
<p>
<b>Description:</b>
Testing of HTTP file uploads
</p>
<p>
<b>Specifics:</b>
- Multiple platforms/SAPIs should be tested<br />
- Both with register_globals on and off<br />
- Single and Multiple file uploads<br />
- Small and Big files<br />
</p>

<h2>Case c2: Output buffering</h2>
<p>
<b>Description:</b>
Testing of the output buffering functions and handlers
</p>
<p>
<b>Specifics:</b>
- Built-in handlers: gz_handler and mb_output_handler handlers<br />
- Both user defined and system provided handlers<br />
- ob_* functions<br />
- Nested and not nested handlers, combined with gz_handlers<br />
- Flushing system provided, user provided and mixed buffers<br />
- Flushing and ending of nested buffers<br />
</p>

<h2>Case c3a: Sessions with register globals = Off</h2>
<h2>Case c3b: Sessions with register globals = On</h2>
<p>
<b>Specifics:</b>
- invalid sesesion ids, session name, save path,<br />
- MM module under very high load (mm)<br />
- USER save handler<br />
- using references to $_SESSION/$HTTP_SESSION_VARS makes<br />
- Unsetting of session variables<br />
</p>

<h2>Case c4: safe mode</h2>
<p>
<b>Description:</b>
Testing and Building safe mode
</p>
<p>
<b>Specifics:</b>
- LOCAL INFILE patch to MySQL<br />
- copying/moving files<br />
- As much other stuff you can think of :)<br />
</p>

<h2>Case c5: count()</h2>
<p>
<b>Description:</b>
Testing the count function
</p>
<p>
<b>Specifics:</b>
- Recursive and non-recursive arrays<br />
- Empty nested arrays<br />
- Arrays contained NULL, booleans and resources<br />
</p>

<h2>Case c6: ksort() and ksort()</h2>
<p>
<b>Description:</b>
Testing these functions
</p>
<p>
<b>Specifics:</b>
- Fix bug in krsort() where an extra character was being compared<br />
</p>


<h1>Extentions</h1>

<h2>Case e1: PostgreSQL</h2>
<p>
<b>Description:</b>
Testing of the functions pg_connect, pg_exec, pg_fetch_row, pg_getlastoid,
pg_numrows in every possible way.
</p>
<p>
<b>Specifics:</b>
- As much different versions of PostgreSQL as possible.<br />
- Second parameter to pg_fetch_* as NULL, while using the 3rd parameter.
  Automatic increasing of the row number should occur now.<br />
</p>

<h2>Case e2: ODBC</h2>

<h2>Case e3: Overload extension:</h2>
<p>
<b>Description:</b>
Throrough testing of all aspects of the new overload extension.
</p>
<p>
<b>Specifics:</b>
- Try as much platforms as possible<br />
</p>

<h2>Case e4: DIO</h2>
<p>
<b>Description:</b>
Testing the balls out of this extension
</p>
<p>
<b>Specifics:</b>
- None<br />
</p>

<h2>Case e5: preg_grep</h2>
<p>
<b>Description:</b>
Testing the new preg_grep function
</p>
<p>
<b>Specifics:</b>
- small and large target strings<br />
- simple and complex regexps<br />
</p>

<h2>Case e6: pow()</h2>
<p>
<b>Description:</b>
Testing all possible ways to use pow()
</p>
<p>
<b>Specifics:</b>
- Go through the tests available for this, and check and expand them.<br />
</p>

<h2>Case e7: The DomXML extension</h2>
<p>
<b>Description:</b>
Testing new and existing functions; testing DOM conformness with the W3C
standard.
</p>
<p>
<b>Specifics:</b>
- Check the Dom tree against the W3C standard<br />
</p>

<h2>Case e8: Dbase extension</h2>
<p>
<b>Description:</b>
Testing fixes for bug #6852
</p>
<p>
<b>Specifics:</b>
- See bugs.php.net?id=6852 :)<br />
</p>

<h2>Case e9: ncurses extension</h2>
<p>
<b>Description:</b>
Testing and writing testcases for the ncurses extension
</p>
<p>
<b>Specifics:</b>
- The ncurses extension is fairly new, and currently has no tests
  in the test suite.<br />
</p>
<?php
common_footer();
?>
