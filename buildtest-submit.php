<?php
include("functions.php");

$TITLE = "Submit Build Test [PHP-QAT: Quality Assurance Team]";
$SITE_UPDATE = date("D M d H:i:s Y T", filectime($SCRIPT_FILENAME))."<br>
/* $Id$ */";

common_header();
?>
      <table width="70%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="10"><img src="gfx/spacer.gif" width="10" height="1"></td>
          <td width="100%">
<h1>Build Tracker</h1>
<hr />
Where you have specified "other" for any category, please enter what it is in the Remarks section. 
<form action="buildtest-action.php" method="post">
<h2>General</h2>
<p>
    This information is require for us to validate your report, please
    do not fill in Bogus information.
</p>
<table>
<tr>
    <th>Name:</th>
    <td><input type="text" name="user_name"></td>
</tr>
<tr>
    <th>E-mail:</th>
    <td><input type="text" name="email"></td>
</tr>
<tr>
    <th>Package:</th>
    <td>
        <select name="package">
            <option value="4.3.0-pre1" selected>4.3.0-pre1</option>
        </select>
    </td>
</tr>
<tr>
    <th>Build status:</th>
    <td>
        <select name="status">
            <option value="Good">Good</option>
            <option value="Minor Problems">Minor problems</option>
            <option value="Fail">Failure</option>
        </select>
    </td>
</tr>
</table>

<h2>Platform</h2>
<table border="0">
<tr>
    <th>Operating System</th>
    <td>
        <select name="os">
            <option value="Linux i386">Linux/i386</option>
            <option value="Linux other">Linux/other</option>
            <option value="FreeBSD 4.3">FreeBSD 4.3</option>
            <option value="FreeBSD 4.4">FreeBSD 4.4</option>
               <option value="FreeBSD 4.5">FreeBSD 4.5</option>
               <option value="FreeBSD 4.6">FreeBSD 4.6</option>
               <option value="FreeBSD 4.7">FreeBSD 4.7</option>
            <option value="OpenBSD">OpenBSD</option>
            <option value="Mac OS X">Mac OS X</option>
            <option value="HPUX">HPUX</option>
            <option value="Irix">Irix</option>
            <option value="Solaris">Solaris</option>
            <option value="Windows 95/98">Windows 95/98</option>
            <option value="Windows Me">Windows ME</option>
            <option value="Windows NT/2K">Windows NT/2000</option>
            <option value="Windows XP">Windows XP</option>
            <option value="other">other</option>
        </select>
    </td>
</tr>
<tr>
    <th>Extra OS version addition:</th>
    <td><input type="text" name="os-extra"></td>
</tr>
<tr>
    <th>Server (sapi)</th>
    <td>
        <select name="sapi">
            <option value="cli">CLI</option>    
            <option value="cgi">CGI</option>
            <option value="Apache 1.3.x DSO">Apache 1.3.x Module (DSO)</option>
            <option value="Apache 1.3.x Static">Apache 1.3.x Module (static)</option>
            <option value="Apache 2.x DSO">Apache 2.x Module (DSO)</option>
            <option value="ISAPI">ISAPI</option>
            <option value="FastCGI">Fast CGI</option>
            <option value="Other">other</option>
        </select>
    </td>
</tr>
</table>

<h2>Build tools</h2>
<table border="0">
<tr>
<tr>
    <th>Automake version</th>
    <td>
        Use 'automake --version' to show it<br />
        <select name="automake">
            <option value="1.4">1.4</option>
            <option value="1.5">1.5</option>
            <option value="1.6">1.6</option>
            <option value="other">other</option>
        </select>
    </td>
</tr>
<tr>
    <th>Autoconf version</th>
    <td>
        Use 'autoconf --version' to show it<br />
        <select name="autoconf">
            <option value="2.1.3" selected="yes">2.13</option>
            <option value="2.5.2">2.52</option>
            <option value="2.5.3">2.53</option>
            <option value="other">other</option>
        </select>
    </td>
</tr>
<tr>
    <th>Libtool version</th>
    <td>
        Use 'libtool --version' to show it<br />
        <select name="libtool">
            <option value="1.3.4">1.3.4</option>
            <option value="1.3.5">1.3.5</option>
            <option value="1.4.0" selected="yes">1.4</option>
            <option value="1.4.1">1.4.1</option>
            <option value="1.4.2">1.4.2</option>
            <option value="other">other</option>
        </select>
    </td>
</tr>
<tr>
    <th>Bison version</th>
    <td>
        <select name="bison">
            <option value="1.2.8">1.28</option>
            <option value="1.2.9">1.29</option>
            <option value="1.3.0">1.30</option>
            <option value="1.3.2">1.32</option>
            <option value="1.3.3">1.33</option>
            <option value="other">other</option>
        </select>
    </td>
</tr>
</table>

<h2>Extensions</h2>
<p>
    Please check all extensions that you compiled with your PHP build.
</p>
<table>
    <tr>
        <td><input type="checkbox" name="aspell">aspell</input></td>
        <td><input type="checkbox" name="bcmath">bcmath</input></td>
        <td><input type="checkbox" name="bz2">bz2</input></td>
        <td><input type="checkbox" name="calendar">calendar</input></td>
        <td><input type="checkbox" name="com">com</input></td>
        <td><input type="checkbox" name="cpdf">cpdf</input></td>
        <td><input type="checkbox" name="crack">crack</input></td>
    </tr>
    <tr>
        <td><input type="checkbox" name="ctype" checked="checked">ctype</input></td>
        <td><input type="checkbox" name="curl">curl</input></td>
        <td><input type="checkbox" name="cybermut">cybermut</input></td>
        <td><input type="checkbox" name="cyrus">cyrus</input></td>
        <td><input type="checkbox" name="db">db</input></td>
        <td><input type="checkbox" name="dba">dba</input></td>
        <td><input type="checkbox" name="dbase">dbase</input></td>
    </tr>
    <tr>
        <td><input type="checkbox" name="dbplus">dbplus</input></td>
        <td><input type="checkbox" name="dbx">dbx</input></td>
        <td><input type="checkbox" name="dio">dio</input></td>
        <td><input type="checkbox" name="domxml">domxml</input></td>
        <td><input type="checkbox" name="dotnet">dotnet</input></td>
        <td><input type="checkbox" name="exif">exif</input></td>
        <td><input type="checkbox" name="ext_skel">ext_skel</input></td>
        <td><input type="checkbox" name="fbsql">fbsql</input></td>
    </tr>
    <tr>
        <td><input type="checkbox" name="fdf">fdf</input></td>
        <td><input type="checkbox" name="filepro">filepro</input></td>
        <td><input type="checkbox" name="fribidi">fribidi</input></td>
        <td><input type="checkbox" name="ftp">ftp</input></td>
        <td><input type="checkbox" name="gd">gd</input></td>
        <td><input type="checkbox" name="gettext">gettext</input></td>
        <td><input type="checkbox" name="gmp">gmp</input></td>
        <td><input type="checkbox" name="hyperwave">hyperwave</input></td>
    </tr>
    <tr>
        <td><input type="checkbox" name="icap">icap</input></td>
        <td><input type="checkbox" name="iconv">iconv</input></td>
        <td><input type="checkbox" name="imap">imap</input></td>
        <td><input type="checkbox" name="informix">informix</input></td>
        <td><input type="checkbox" name="ingres_ii">ingres_ii</input></td>
        <td><input type="checkbox" name="interbase">interbase</input></td>
        <td><input type="checkbox" name="ircg">ircg</input></td>
        <td><input type="checkbox" name="java">java</input></td>
    </tr>
    <tr>
        <td><input type="checkbox" name="ldap">ldap</input></td>
        <td><input type="checkbox" name="mailparse">mailparse</input></td>
        <td><input type="checkbox" name="mbstring" checked="checked">mbstring</input></td>
        <td><input type="checkbox" name="mcal">mcal</input></td>
        <td><input type="checkbox" name="mcrypt">mcrypt</input></td>
        <td><input type="checkbox" name="mcve">mcve</input></td>
        <td><input type="checkbox" name="mhash">mhash</input></td>
        <td><input type="checkbox" name="ming">ming</input></td>
    </tr>
    <tr>
        <td><input type="checkbox" name="mnogosearch">mnogosearch</input></td>
        <td><input type="checkbox" name="msession">msession</input></td>
        <td><input type="checkbox" name="msql">msql</input></td>
        <td><input type="checkbox" name="mssql">mssql</input></td>
        <td><input type="checkbox" name="muscat">muscat</input></td>
        <td><input type="checkbox" name="mysql" checked="checked">mysql</input></td>
        <td><input type="checkbox" name="ncurses">ncurses</input></td>
        <td><input type="checkbox" name="notes">notes</input></td>
    </tr>
    <tr>
        <td><input type="checkbox" name="oci8">oci8</input></td>
        <td><input type="checkbox" name="odbc">odbc</input></td>
        <td><input type="checkbox" name="openssl">openssl</input></td>
        <td><input type="checkbox" name="oracle">oracle</input></td>
        <td><input type="checkbox" name="overload" checked="checked">overload</input></td>
        <td><input type="checkbox" name="ovrimos">ovrimos</input></td>
        <td><input type="checkbox" name="pcntl">pcntl</input></td>
        <td><input type="checkbox" name="pcre" checked="checked">pcre</input></td>
    </tr>
    <tr>
        <td><input type="checkbox" name="pdf">pdf</input></td>
        <td><input type="checkbox" name="pfpro">pfpro</input></td>
        <td><input type="checkbox" name="pgsql">pgsql</input></td>
        <td><input type="checkbox" name="posix" checked="checked">posix</input></td>
        <td><input type="checkbox" name="pspell">pspell</input></td>
        <td><input type="checkbox" name="qtdom">qtdom</input></td>
        <td><input type="checkbox" name="readline">readline</input></td>
        <td><input type="checkbox" name="recode">recode</input></td>
    </tr>
    <tr>
        <td><input type="checkbox" name="satellite">satellite</input></td>
        <td><input type="checkbox" name="session" checked="checked">session</input></td>
        <td><input type="checkbox" name="shmop">shmop</input></td>
        <td><input type="checkbox" name="snmp">snmp</input></td>
        <td><input type="checkbox" name="sockets">sockets</input></td>
        <td><input type="checkbox" name="standard">standard</input></td>
        <td><input type="checkbox" name="swf">swf</input></td>
        <td><input type="checkbox" name="sybase">sybase</input></td>
    </tr>
    <tr>
        <td><input type="checkbox" name="sybase_ct">sybase_ct</input></td>
        <td><input type="checkbox" name="sysvsem">sysvsem</input></td>
        <td><input type="checkbox" name="sysvshm">sysvshm</input></td>
        <td><input type="checkbox" name="tokenizer" checked="checked">tokenizer</input></td>
        <td><input type="checkbox" name="vpopmail">vpopmail</input></td>
        <td><input type="checkbox" name="w32api">w32api</input></td>
        <td><input type="checkbox" name="wddx">wddx</input></td>
        <td><input type="checkbox" name="xml" checked="checked">xml</input></td>
    </tr>
    <tr>
        <td><input type="checkbox" name="xmlrpc">xmlrpc</input></td>
        <td><input type="checkbox" name="xslt">xslt</input></td>
        <td><input type="checkbox" name="yaz">yaz</input></td>
        <td><input type="checkbox" name="yp">yp</input></td>
        <td><input type="checkbox" name="zip">zip</input></td>
        <td><input type="checkbox" name="zlib">zlib</input></td>
    </tr>
</table>

<h2>Test framework tests</h2>
<p>
Please run the tests from our testframe work. You can do this by typing
<code>make test</code> after you compiled PHP with <code>make</code>. You
can only see non-passed tests by running this instead:
<code>make test | grep -v PASS</code>. If there are "FAIL"ed tests, please
paste them in the following testbox. You can send the .log file accompanying
that test case to
<a href="mailto:php-qa@lists.php.net">php-qa@lists.php.net</a>. It's very
likely that we will contact you to check out on this failed test.
</p>
<table>
<tr>
    <th>Failed tests:</th>
    <td><textarea cols="80" rows="10" name="testframework"></textarea></td>
</tr>
</table>

<h2>Additional information</h2>
<table>
<tr>
    <th>Tested with the following applications:</th>
    <td><textarea cols="80" rows="10" name="applications"></textarea></td>
</tr>
<tr>
    <th>Problems:</th>
    <td><textarea cols="80" rows="10" name="problems"></textarea></td>
</tr>
<tr>
    <th>Related bug ids:</th>
    <td><input type="text" name="bugids"></td>
</tr>
<tr>
    <th>Remarks:</th>
    <td><textarea cols="80" rows="10" name="remarks"></textarea></td>
</tr>
</table>

<hr />
<input type="submit" value="submit" />
</form>
          </td>
          <td width="10"><img src="gfx/spacer.gif" width="10" height="1"></td>
        </tr>
      </table>
<?php
common_footer();
?>
