<?php
include("include/functions.php");

$TITLE = "TestFest [PHP-QAT: Quality Assurance Team]";
$SITE_UPDATE = date("D M d H:i:s Y T", filectime(__FILE__));
/* $Id: howtohelp.php,v 1.18 2006/09/14 18:41:01 nlopess Exp $ */

common_header();
?>
    <table width="70%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="10"><img src="gfx/spacer.gif" width="10" height="1"></td>
          <td width="100%">
            <h1>TestFest (May 2008)</h1>
          </td>
          <td width="10"><img src="gfx/spacer.gif" width="10" height="1"></td>
        </tr>
        <tr>
          <td width="10">&nbsp;</td>
          <td width="100%">
            <table>
              <tr>
                <td width="65%">
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
                  <a href="write-test.php">writing phpt tests</a>. The submissions will
                  then be reviewed by members of php.net before getting included in the
                  official test suite.
                </td>
                <td width="35%" align="center"><img src="gfx/testfest_big.png" width="200" /></td>
              </tr>
            </table>

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
            UGs are free to pick any timeframe in May 2008. Each local TestFest
            can last a day, a week or any other timeframe.

            <h3>Why is the timeframe so short? What if June would be a better date?</h3>
            We want to ensure that we have mentors ready and available to answer
            questions. In order to get some sort of commitment from mentors we
            cannot make this timeframe indefinitely long. That being said we
            might hold future TestFests. Also people are of course invited to
            join the QA team any time of year.

            <h3>How will local organizers be assisted?</h3>
            We will make a list of areas available of areas of PHP that need
            more testing. Along with that list we will provide contact
            information for mentors. The mentors will also review the submissions
            later on. Ideally questions regarding the testing framework itself
            will be answered by local organizers.

            <h3>I want to organize an event, but there is nobody here that
            knows how to write tests for PHP. What can I do?</h3>
            First look at the documentation on how to <a href="write-test.php">
            write phpt tests</a>. It's actually not that hard. If you still need
            help feel free to contact the <a href="mailto:php-qa@lists.php.net">
            QA mailinglist</a>.

            <h3>Where are tests submitted to?</h3>
            We will implement a simple front-end that allows people to upload
            their phpt files. People can register themselves and then upload,
            delete and modify files in their "directory". Submitters are asked
            to follow the <a href="write-test.php">phpt coding standards</a>.

            <h3>How are submissions reviewed? How do I get feedback?</h3>
            Mentors will have access to all the submissions and will review
            submissions at their own pace in their given area of expertise. We
            hope this will be done in a timely manner, but please understand
            that we cannot give any guarantees, especially if the event turns out
            to be as successful as we hope. Submittors will be able to see who
            is reviewing their submission as well as when their submission has
            been processed. If the submission led to a commit the
            interface will show any difference that might exist between the
            submission and the final committed version. Furthermore the mentor
            might provide some individual commentary.

            <h3>How do I join? How do I get more information?</h3>
            We are still in the process of building the necessary infrastructure.
            Hopefully before the end of April we will have everything in place.
            Until then please contact the <a href="mailto:php-qa@lists.php.net">
            QA mailinglist</a> if you are interested in participating or if
            you have any questions. Alternatively you can join #php.pecl on EfNet
            IRC server. There should usually be someone around to help.

            <h3>Do you also provide a smaller version of the logo?</h3>
            Yes here you go (scale as needed):<br />
            <img src="gfx/testfest_small_08.png" width="200" />
            <br /><br />
          </td>
          <td width="10">&nbsp;</td>
        </tr>
      </table>
<?php

common_footer();
?>
