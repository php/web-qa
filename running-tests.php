<?php
include("include/functions.php");

$TITLE = "Submit Build Test [PHP-QAT: Quality Assurance Team]";
$SITE_UPDATE = date("D M d H:i:s Y T", filectime(__FILE__));
/* $Id$ */

common_header();
?>
   <h1>Test framework tests</h1>
   <p>
    Please run the tests from our test framework. You can do this by typing
    <code>make test</code> after you compiled PHP with <code>make</code>.
   </p>

   <p>
    When <code>make test</code> finished running tests, and if there are any
    failed tests, the script asks to send the logs to the PHP QA mailinglist. 
    Please answer "y" to this question so that we can efficiently process the results, 
    entering your e-mail address (which will not be transmitted in plaintext to any list)
    enables us to ask you some more information if a test failed. Note that this script 
    also uploads php -i output so your hostname may be transmitted.
   </p>

   <p>
    Specific tests can also be executed, like running tests for a certain extension. To do 
    this you can do like so (for example the standard library): 
    <code>make test TESTS=ext/standard</code>. Where <code>TESTS=</code> points to a 
    directory containing <code>.phpt</code> files or a single <code>.phpt</code> file like: 
    <code>make test TESTS=tests/basic/001.phpt</code>. You can also pass options directly 
    to the underlaying script that runs the test suite (<code>run-tests.phpt</code>) using 
    <code>TESTS=</code>, for example to check for memory leaks using Valgrind, the <code>-m</code> 
    option can be passed along: <code>make test TESTS="-m Zend/"</code>. For a full list 
    of options that can be passed along, then run <code>make test TESTS=-h</code>.
   </p>

   <p>
    <strong>Windows users:</strong> On Windows the make command is called <code>nmake</code> 
    instead of <code>make</code>. This means that on Windows you will have to run 
    <code>nmake test</code>, to run the test suite.
   </p>
<?php
common_footer();
?>
