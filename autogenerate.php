<?php
include("include/functions.php");

$TITLE = "Generating tests [PHP-QAT: Quality Assurance Team]";
$SITE_UPDATE = date("D M d H:i:s Y T", filectime(__FILE__));
/* $Id$ */

common_header();
?>
<h2>Auto-generating test cases</h2>
<p>
Although it's not possible to generate a complete PHPT test, it's quite easy to generate the
 standard sections and some simple functions automatically, creating a test case "frame". 
 To do this, you need: <ul>
<li> A copy of the PHP source (download from the <a href="http://snaps.php.net">snaps site</a> )
</li> <li> A copy of the generate_phpt.php code in from scripts/dev

</li></ul> 
<p />
<p />
<p />
<h3>Example output - a generated test case frame for the cos() function: </h3>
<p />
<div class="fragment"><pre>
--TEST--
Test cos() : basic functionality 
--FILE--
&lt;?php
<font color="green">/* Prototype  : proto float cos(float number)
* Description: Returns the cosine of the number in radians 
* Source code: ext/standard/math.c
* Alias to functions: 
*/</font>

<font color="green">/*
* add comment here to indicate details of what this testcase is testing in particular
*/</font>

<font color="maroon">echo</font> "<font color="blue">*** Testing cos() : basic functionality ***\n</font>";


<font color="green">// Initialise all required variables</font>
$number = 10.5;

<font color="green">// Calling cos() with all possible arguments</font>
var_dump( <font color="maroon">cos</font>($number) );


<font color="maroon">echo</font> "<font color="blue">Done</font>"
?&gt;
--EXPECTF--
Expected output goes here
Done</pre></pre></div>
<p />
<p />
<p />
<h3>Completing the .phpt test file: </h3>
<p />
To turn this into a complete test case, all the developer has to do is to change the value of $number to something reasonable 
and to add a section for the expected output.
<p />


<p />
<h3> Command syntax </h3>
<div class="fragment"><pre>
php generate_phpt.php -s &lt;php_source_dir&gt; -f &lt;function_name&gt; -b|-e|-v  [-i &lt;include_file&gt;]</pre></pre></div>
<p />
<p />

<p />
<h3> Options </h3>
Use -h to list them, this is the output:
<p />
<div class="fragment"><pre>
-s location_of_source_code ....... Top level directory of PHP source
-f function_name ................. Name of PHP function, eg cos
-b ............................... Generate basic test
-e ............................... Generate error test
-v ............................... Generate variation test(s)
-i file_containing_include_block.. Block of PHP code. If <font color="brown">this</font> option is present no code will be generated.
-h ............................... Print <font color="brown">this</font> message</pre></pre></div>
<p />
<p />

The following sections describe each argument:
<p />
<p />
<p />
<p />
<h3>PHP source code location  ( -s &lt;php_source_dir&gt; ) </h3>
<p />
The test case frame generation script depends on being able to find the function prototype in the 
PHP implementation code - this is used to generate simple calls to the function. PHP source is most 
easily obtained by downloading from the <a href="http://snaps.php.net/">snaps site</a>. The test generation script 
expects to be given the name of the top level directory. In the following example, 
the subdirectory <strong>/home/zoe/BUILDS/php524</strong> contains the complete source for php-5.2.4.

<p />
Example: <ul>
<li> Generate a basic test case frame for the xxx() function
</li></ul> 
<div class="fragment"><pre>
php generate_phpt.php -s /home/zoe/BUILDS/php524 -f xxx -b</pre></pre></div>
<p />
<p />
<p />
<p />
<p />
<h3>Function name  ( -f &lt;function_name&gt; ) </h3>

<p />
The code will generate a test case frame for a given function.
<p />
<p />
Example: <ul>
<li> Generate a basic test case frame for the cos() function 
</li></ul> 
<div class="fragment"><pre>
php generate_phpt.php -s /home/zoe/BUILDS/php524 -f cos -b</pre></pre></div>
<p />
<p />
<p />
<p />
<p />

<p />
<h3>Test Types  ( -b | -e | -v ) </h3>
<p />
<p />
<p />
<h6> Basic  ( -b ) </h6>
<p />
<p />
<p />
This will generate test case frame(s) called &lt;function_name&gt;_basic.phpt. They will have  <ul>
<li> A title

</li> <li> Prototype and implementation location
</li> <li> Description
</li> <li> List of any alias functions
</li> <li> Initialise the number and type of arguments that the function requires
</li> <li> var_dump (function (args))
</li></ul> 
<p />

Example:  <ul>
<li> Generate a basic test case frame for the asin() function 
</li></ul> 
<div class="fragment"><pre>
php generate_phpt.php -s /home/zoe/BUILDS/php524 -f asin -b</pre></pre></div>
<p />
<p />
<p />
<h6>Error  ( -e ) </h6>
This will generate test case frame(s) called &lt;function_name&gt;_error.phpt. They will have  <ul>

<li> A title
</li> <li> Prototype and implementation location
</li> <li> Description
</li> <li> List of any alias functions
</li> <li> Initialise the number and type of arguments that the function requires
</li> <li> var_dump (function (args + 1)) - ie. tests for too many arguments

</li> <li> var_dump (function (args - 1)) - ie. tests for too few arguments
</li></ul> 
<p />
Examples: <ul>
<li> Generate an error test case frame for the hexdec() function 
</li></ul> 
<div class="fragment"><pre>
php generate_phpt.php -s /home/zoe/BUILDS/php524 -f hexdec -e</pre></pre></div>
<p />
<p />
<p />
<p />

<p />
<h6>Variation  ( -v  ) </h6>
This will generate test case frame(s) called &lt;function_name&gt;_variation.phpt. They will have  <ul>
<li> A title
</li> <li> Prototype and implementation location
</li> <li> Description
</li> <li> List of any alias functions

</li> <li> Code to cycle through each argument in the function call setting it to a different type and then calling the function.
</li></ul> 
<p />
<p />
Examples: <ul>
<li> Generate a variation test case frame for the cosh() function 
</li></ul> 
<div class="fragment"><pre>
php generate_phpt.php -s /home/zoe/BUILDS/php524 -f cosh -v</pre></pre></div>
<p />
<p />
<p />

<p />
<p />
<p />
<p />
<h6>Include blocks  ( -i <include_file> ) </h6>
<p />
It's often the case that the PHP code for the test case has already been written and tested, so all that the author needs to do is 
to turn it into standard PHPT format. In this situation, generate_phpt.php should be called with the additional -i option and 
given the name of a file which includes the PHP code for the relevant test-case.  
<p />
<p />
Example: <ul>
<li> Generate a variation-type test case frame for the tan() function, and include a block of php code taken from the 
file <strong>my_tan_test</strong>

</li></ul> 
<div class="fragment"><pre>
php generate_phpt.php -s /home/zoe/BUILDS/php524 -f tan -v -i my_tan_test</pre></pre></div><p />
<h3>Known issues with generate_phpt.php</h3>
<p>The script works by looking through the PHP implementation souce (C code) and trying to 
work out from the comments what sort of input a function expects. Because the C code isn't 
written in a completely consistent style it's sometimes impossible to work out how
to construct the test case. However - if you think it should work please raise bugs 
against it <a href="bugs.php.net">here</a> </p>
<p>Return to <a href="write-test.php">write tests.</a></p>