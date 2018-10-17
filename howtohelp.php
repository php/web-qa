<?php
include("include/functions.php");

$TITLE = "How To Help [PHP-QAT: Quality Assurance Team]";
$SITE_UPDATE = date("D M d H:i:s Y T", filectime(__FILE__));

common_header();
?>
            <h1>How You Can Help</h1>
          <p>So there you sit.  A PHP coder who loves PHP.  But lately
            you find yourself wanting to help the PHP community by contributing.  Only
            one problem - you aren't a uber 1337 coder - whether it is because you have
            only recently started to learn how to program in PHP or you just don't yet
            have the experience with advanced concepts.  But you really want to help out
            and you are unsure though how to go about doing it.  You have looked at the
            various 'normal' ways of helping out with PHP but nothing seems to fit.  Your
            C coding isn't the best (if you even know how) so helping with the core or
            PECL is out, nothing in PEAR really 'calls' to you, and you don't know anything
            about the PHP docs and the software it uses.  So where does that leave you.
            Have no fear there is still a way you can help with PHP - you can help the
            PHP Quality Assurance team.<br />
          </p>
            <ul>
              <li class="lihack">You can <a href="write-test.php">Write testcases</a>:
              <ul>
                <li class="lihack">to reproduce bugs</li>
                <li class="lihack">for PHP functions where testcases do not currently exist</li>
              </ul>
              </li>
              <li class="lihack">
                Run our <a href="/running-tests.php">test suite</a> on a
                regular schedule, we're currently setting up a system to do
                this all automatically.<br /><br />
              </li>
              <li class="lihack">Give a PHP/QA Team member access to a server that
                you administrate, especially on ones running some of the more
                exotic Operation Systems.  <br /><br /> To do this, please send
                mail to the PHP/QA email list (<a
                href="mailto:php-qa@lists.php.net">php-qa@lists.php.net</a>)
                with the subject 'Guest Account for PHP/QA Team Member'. In the
                body of the message, please list the specifications on the
                machine (hardware, operating system, installed software,
                etc...). </li>
            </ul>
<?php

common_footer();
?>
