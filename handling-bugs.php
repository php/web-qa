<?php
include("include/functions.php");

$TITLE = "Handling Bug Reports [PHP-QAT: Quality Assurance Team]";
$SITE_UPDATE = date("D M d H:i:s Y T", filectime(__FILE__));

$CURRENT_PAGE = "Handling Reports";

common_header();
?>
            <h1>Handling bug reports?</h1>
<h2>Introduction</h2>

<p>
Welcome to the HOWTO on managing PHP bugs via <a
href="https://bugs.php.net/">bugs.php.net</a>.  PHP is a large project with many
bugs being submitted daily.  Bug topics range from the PHP website itself,
various PHP extensions, PEAR, etc.  This document is for all PHP developers
using the bug system.  Because there are so many members using the system it's
important we act in a consistent manner.  This HOWTO is created to solve this.
</p>

<p>If you're going to edit a bug be sure that you know the topic.  Don't make
assumptions.  If you've read the bug carefully and think of a solution or
related questions, post your answer/comments.  If you know of the solution,
solve and close the bug.</p>

<h2>Acting on a bug</h2>

<p>Never change a status if you're not sure. If you close a bug because you
think it's not really a bug and in fact it is, this makes the bug system
useless and doesn't benefit anyone.  Never close a bug because it's too old,
unless your name is Jani.  If a bug is in "feedback" status it will close
automatically if the bug reporter doesn't answer after two weeks.</p>

<p>If you want to view a bug report, enter the bug id into the url like
so (with 20406 being an example):</p>

<ul>
    <li>
        <a href="https://bugs.php.net/20406">https://bugs.php.net/20406</a>
    </li>
</ul>

<p>Which redirects to:</p>

<ul>
    <li>
        <a href="https://bugs.php.net/bug.php?id=20406">https://bugs.php.net/bug.php?id=20406</a>
    </li>
</ul>

<p>At that point you'll see a set of options.  Because you're a developer you
will choose the developer option which will then put you here:</p>

<ul>
    <li>
        <a href="https://bugs.php.net/bug.php?id=20406&amp;edit=1">https://bugs.php.net/bug.php?id=20406&amp;edit=1</a>
    </li>
</ul>

<h2>Automatic answers (quickfix)</h2>

<p>There are a set of quickfix options each of which will both insert text into
the bug report and change the bug status.  Please understand what text and
status will be used and only choose a quickfix option if an appropriate
quickfix exists.  Choosing a quickfix that's not 100% correct will confuse
and sometimes irritate the reporter.  The following table lists them (see
also <a href="https://bugs.php.net/quick-fix-desc.php">quick-fix-desc.php</a>):</p>


<h2>Manual answers</h2>

<p>If no quickfix is available you will manually choose the new status and
write some feedback.  Select the best status that corresponds to the bug.
Here are descriptions for each status:</p>

<p>
<dl>
        <dt>Open</dt>
        <dd>
            The bug still exists and you want to comment on it.
        </dd>

        <dt>Closed</dt>
        <dd>
            It has been fixed.  If you choose this please make sure
            it's also been documented.  Also, explain why it's closed.
        </dd>

        <dt>Duplicate</dt>
        <dd>
			This status is deprecated and can no longer be selected during
			modifications of bugs. Always use "Not a Bug" instead now. The original
			use was:
            <i>If this almost the same bug, both bugs are found 'duplicate' later
            on and have both useful information.  Also mention what bug it's a
            duplicate of with a full url to the report this is duplicate of.</i>
        </dd>

        <dt>Critical</dt>
        <dd>
            Only bugs that affect most/all users and/or are in the engine or
            ext/standard.  Only Verified and reproduced bugs in the latest
            Git revision can be marked critical.
        </dd>

        <dt>Assigned</dt>
        <dd>
            If a specific person, such as yourself, will take of this bug then
            assign it.  If you know someone else is or will take care of it then assign
            it to them but be sure to ask them first.
        </dd>

        <dt>Analyzed</dt>
        <dd>
            If you've analyzed why this bug is here and know why the bug exists, you
            have just analyzed it.  Also, add a comment.  If you are unsure why it
            exists then use 'verified' instead.
        </dd>

        <dt>Verified</dt>
        <dd>
            If you're able to reproduce this bug with the information given.
            Be sure to test with the latest Git.  Typically you aren't sure why
            it exists you just know it does and have confirmed it.
        </dd>

        <dt>Suspended</dt>
        <dd>
            Usually used when there might be a fix in future and/or it relies on
            something external to be fixed first.
        </dd>

        <dt>Wont fix</dt>
        <dd>When something is not considered a bug or the bug is not fixable.</dd>

        <dt>No feedback</dt>
        <dd>
            If no answer have been given by the reporter after we've asked them
            something.  Sometimes you will ask for an example script or ask the
            reporter to test using Git.
        </dd>

        <dt>Feedback</dt>
        <dd>
            You're asking the reporter for more information such as please use
            Git revision, and/or the smallest possible test script to reproduce the
            error, and/or a value for a certain PHP directive.
        </dd>

        <dt>Not a Bug (old: Bogus)</dt>
        <dd>
		   This bug is not a bug, support related or just an assumed bug or the
		   bug already exists in the database.  Be 100% it's really &quot;bogus&quot; and
		   also be sure it's not a documentation bug.
        </dd>
</dl>

<h2>Reclassification</h2>

<p>Sometimes you'll also want to reclassify a bug.  For example, a reporter
marks a bug as Apache2 related when really it's a MySQL bug.  Just change
the category but be 100% sure it's related to the new category.  Another
example would be changing the type to a documentation bug.  If you're
changing it to a documentation bug it will help the documentation team if you
add specific information that is to be documented including what version the
changes will take place.</p>

<p>Also note that all bugs are sent to various mailing lists with
php-bugs@lists.php.net being the default (most go here).  Here's a list:</p>

<dl>
        <dt>Default</dt>
        <dd><a href="http://news.php.net/php.bugs">php-bugs@lists.php.net</a></dd>

        <dt>Documentation</dt>
        <dd><a href="http://news.php.net/php.doc">phpdoc@lists.php.net</a></dd>

        <dt>PEAR</dt>
        <dd><a href="http://news.php.net/php.pear.dev">pear-dev@lists.php.net</a></dd>

        <dt>PHP.net Website</dt>
        <dd><a href="http://news.php.net/php.mirrors">php-mirrors@lists.php.net</a></dd>
</dl>

<p>Reclassifying will immediatly change which mailing list is used.  If you
reclassify a bug and don't leave a comment then no email is sent to the mailing list.
So, be sure to leave a comment.</p>

<h2>Tips and links</h2>
<ul>
    <li>
        The Jani JavaScript bug popup window (right click to bookmark):
        <a href='javascript:void(t=prompt("Get BUG report # ..",""));if(t){ void(top.location.href="https://bugs.php.net/bug.php?edit=1&amp;id="+t);}'>here</a>
    </li>
    <li>
        Look at the <a href="https://bugs.php.net/stats.php">raw bug stats</a>.
    </li>
    <li>
        Not leaving a comment means no email will be sent to the mailing list.
        (all quickfix options leave comments)
    </li>
    <li>
        If a version is from Git be sure to label it in the form:
        <b>x.y.z-dev</b>  An example is: 5.6.0-dev or 7.0.0-dev.
    </li>
    <li>
        If you have a question either email the
        <a href="mailto:internals@lists.php.net">internals@lists.php.net</a>
        mailing list or check out the #php.pecl channel in IRC on
        <a href="http://www.irchelp.org/networks/efnet/">EFNET</a>.
    </li>
</ul>

<h2>Conclusion</h2>

<p>If everyone maintains the bug system in a consistent manner then PHP will
be better for it.  Also, bug reporters will not get their feelings hurt
through miscommunication (e.g. a wrong quickfix or bogus status)  Thank you
for reading this HOWTO and helping make PHP better.</p>
<br />
<?php

common_footer();
?>
