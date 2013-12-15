<?php
include("include/functions.php");

$TITLE = "TestFest [PHP-QAT: Quality Assurance Team]";
$SITE_UPDATE = date("D M d H:i:s Y T", filectime(__FILE__));
/* $Id: howtohelp.php,v 1.18 2006/09/14 18:41:01 nlopess Exp $ */

common_header();
?>
            <h1>TestFest 2009</h1>
            <p>
                  The TestFest is an event that aims at improving the
                  <a href="http://gcov.php.net">code coverage</a> of the
                  <a href="/running-tests.php">test suite</a> for the PHP language
                  itself. As part of this event, local User Groups (UG) are invited to
                  join the TestFest. These UGs can meet physically or come together
                  virtually. The point however is that people network to learn together.
                  Aside from being an opportunity for all of you to make friends with
                  like minded people in your (virtual) community, it also will hopefully
                  reduce the work load for the PHP.net mentors. All it takes is someone
                  to organize a UG to spearhead the event and to get others involved in
                  <a href="/write-test.php">writing phpt tests</a>. The submissions will
                  then be reviewed by members of php.net before getting included in the
                  official test suite.
                </p>

            <h2>Participating Users Group</h2>

            Please check the PHP.net wiki page for
            <a href="http://wiki.php.net/qa/testfest">details</a>.

            <h2>Frequently Asked Questions</h2>

            <h3>Why should I care?</h3>
            Aside from having to opportunity to help in improving the language
            itself, we will also raffle off 10
            <a href="http://flickr.com/groups/elephpants/pool/">elePHPants</a> to
            submitters. Every submission (test) that is considered helpful
            receives one entry into the raffle. Furthermore, people that show they
            are capable of writing tests entirely on their own may be given
            official PHP.net accounts with direct commit access to cvs.php.net and
            an @php.net email address. As a result participants should also read
            over the general <a href="http://www.php.net/cvs-php.php">guidelines
            for getting CVS access</a>.

            <h3>When will the TestFest take place?</h3>
            UGs are free to pick any time in April - June 2009. Each local TestFest
            can last a day, a week or any other timeframe.

            <h3>Why is the timeframe flexible?</h3>
            We want to ensure that we have mentors ready and available to answer
            questions. The timeframe for each UG needs to suite both the UG and the
            availability of mentors. 

            <h3>How will local organizers be assisted?</h3>
            We will make a list of areas available of areas of PHP that need
            more testing. Along with that list we will provide contact
            information for mentors. The mentors will also review the submissions
            later on. Ideally questions regarding the testing framework itself
            will be answered by local organizers. Please check the
            <a href="http://wiki.php.net/qa/testfest">wiki</a> to get details on
            the available mentors and focus areas.

            <h3>I want to organize an event, but there is nobody here that
            knows how to write tests for PHP. What can I do?</h3>
            First look at the documentation on how to <a href="write-test.php">
            write phpt tests</a>. It's actually not that hard. If you still need
            help feel free to contact the <a href="mailto:php-qa@lists.php.net">
            QA mailinglist</a>.

            <h3>Where are tests submitted to?</h3>
            When user groups register for an event we will create a directory in 
            a Subversion repository, members of the usr group should check in their 
            tests under that directory. The repository is:
            <p>http://testfest.php.net/repos/testfest</p>
            <p>Each usergroup lead will be given admin rights in the repository 
            and will create regular user IDs for other members of the group.
            <p>There is a directory called IndependentContributor for people 
            who are not working with a user group. If you would like access 
            to that please mail your request and a sample test case to 
            php-qa@lists.php.net
            
            
            <h3>I volunteered to be a mentor, how do I review tests?</h3>
            Look at the tests for the user group that you are mentoring
            in the subversion repository.
            Check out the tests and ensure that they run. Key review 
            points are:
            <ul>
            <li> Is the test readable? Can you understand quickly what it's 
            supposed to do? </li>
            <li> Are there appropriate SKIPIF sections? </li>
            <li> Is there a CREDITS section (should contain #PHPTestFest2009)?
            <li> If the test 'reasonably' short? Imagine it failed and you had 
            to work out why, do you think you could do it without creating
            a smaller test?
            </li>
            </ul>
            
            <p>If the test does not run or does not meet enough of these criteria
            then add your review comments and check back in to the SVN repository.
            
            <p>If the test is good, commit to PHP CVS and delete from Subversion.
            
            <h3>What version of PHP should be used?</h3>
            We prefer that the tests are made for 5.3/HEAD. You can grab a build
            of 5.3 at the <a href="http://snaps.php.net/">snaps page</a>. Source
            code and Windows builds are available. Possibly there will be a
            release candidate of PHP 5.3 available as well. If requiring PHP
            5.3/HEAD is an issue for your UG, please let us know so that we can
            see how your UG can still participate.

            <h3>How are submissions reviewed? How do I get feedback?</h3>
            Mentors will have access to all the submissions and will review
            submissions at their own pace in their given area of expertise. We
            hope this will be done in a timely manner, but please understand
            that we cannot give any guarantees, especially if the event turns out
            to be as successful as we hope. Submitters should look for review comments
            in their submitted tests, if the test dissappears from Subversion, it has been
            been processed and committed to PHP CVS. 

            <h3>How do I join? How do I get more information?</h3>
            Please contact the <a href="mailto:php-qa@lists.php.net">
            QA mailinglist</a> if you are interested in participating or if
            you have any questions. Alternatively you can join #php.pecl on
            Efnet or the #phptestfest channel on Freenode IRC server. There
            should usually be someone around to help.

            <h3>Do you also provide a smaller version of the logo?</h3>
            Yes, here you go (scale as needed):<a href="testfest_scalable.svg">
            scalable image</a><br />
<?php

common_footer();
?>
