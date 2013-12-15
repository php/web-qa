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
<li> A build pf PHP53
</li> <li> The file generate-phpt.phar, located in the PHP53 source under scripts/dev

</li></ul> 
<p />
<p />
<p />
<h3>Example output - a generated test case frame for the cos() function: </h3>
<p />
<div class="fragment"><pre>
--TEST--
Test function cos() by calling it with its expected arguments
--FILE--
&lt;?php


echo "*** Test by calling method or function with its expected arguments ***\n"

$number = 



var_dump(cos( $number ) );


?&gt;
--EXPECTF--

</pre></pre></div>
<p />
<p />
<p />
<h3>Completing the .phpt test file: </h3>
<p />
To turn this into a complete test case, all the developer has to do is to initialise $number to something reasonable 
and to add a section for the expected output.
<p />


<p />
<h3> Command syntax </h3>
<div class="fragment"><pre>
php generate-phpt.php  -f &lt;function_name&gt; |-c &lt;class_name&gt; -m &lt;method_name&gt; -b|e|v [-s skipif:ini:clean:done] [-k win|notwin|64b|not64b] [-x ext]
</pre></div>
<h3> Options </h3>
Use -h to list them, this is the output:
<p />
<div class="fragment"><pre>
-f function_name ................. Name of PHP function, eg cos
-c class name .....................Name of class, eg DOMDocument
-m method name ....................Name of method, eg createAttribute
-b ............................... Generate basic tests
-e ............................... Generate error tests
-v ............................... Generate variation tests
-s sections....................... Create optional sections, colon separated list
-k skipif key..................... Skipif option, only used if -s skipif is used.
-x extension.......................Skipif option, specify extension to check for
-h ............................... Print this message
</pre></div>
<h3>Implementation notes</h3>
<p>The source code is under scripts/dev/generate-phpt/src. The phar file is generated using the script gtPackage.php. 
The script works by using Reflection to work out what arguments a function or method expects and then setting up a function/method
invocation.
The catch with generating tests this way is that the script has to be run *using the level of PHP that you want to test*,
so if your were trying to write tests before doing development this script will not help. However, for filling in test gaps
in existing extensions it works fine.
<p>Return to <a href="write-test.php">write tests.</a></p>


<?php
common_footer();

