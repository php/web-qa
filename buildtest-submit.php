<?php
include("functions.php");

$TITLE = "Submit Build Test [PHP-QAT: Quality Assurance Team]";
$SITE_UPDATE = date("D M d H:i:s Y T", filectime($SCRIPT_FILENAME))."<br>
/* $Id$ */";

common_header();
?>

<h1>Build Tracker</h1>
<hr />
Where you have specified "other" for any category, please enter what it is in the Remarks section. 
<form action="buildtest-action.php" method="post">
<h2>General</h2>
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
			<option value="4.2.0-dev">4.2.0-dev (DON'T USE CVS, download RC1)</option>
			<option value="4.2.0-RC1" selected="yes">4.2.0-RC1</option>
		</select>
	</td>
</tr>
<tr>
	<th>Testcase:</th>
	<td>
		<select name="testcase">
			<option value="0">no testcase</option>
			<option value="b1">b1: Building with CLI</option>
			<option value="b2">b2: MacOSX building</option>
			<option value="b3">b3: iconv support</option>
			<option value="b4">b4: pspell building</option>
			<option value="c1">c1: HTTP File Uploads</option>
			<option value="c2">c2: Output buffering</option>
			<option value="c3a">c3a: Sessions with register globals = Off</option>
			<option value="c3b">c3b: Sessions with register globals = On</option>
			<option value="c4">c4: safe mode</option>
			<option value="c5">c5: count()</option>
			<option value="c6">c6: ksort() and krsort()</option>
			<option value="e1">e1: PostgreSQL</option>
			<option value="e3">e3: Overload extension</option>
			<option value="e4">e4: DIO</option>
			<option value="e5">e5: preg_grep</option>
			<option value="e6">e6: pow()</option>
			<option value="e7">e7: The DomXML extension</option>
			<option value="e8">e8: Dbase extension</option>
			<option value="e9">e9: ncurses extension</option>
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
			<option value="OpenBSD">OpenBSD</option>
			<option value="Mac OS X">Mac OS X</option>
			<option value="HPUX">HPUX</option>
			<option value="Irix">Irix</option>
			<option value="Windows 95/98">Windows 95/98</option>
			<option value="Windows Me">Windows ME</option>
			<option value="Windows NT/2K">Windows NT/2000</option>
			<option value="Windows XP">Windows XP</option>
			<option value="other">other</option>
		</select>
	</td>
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
		<select name="automake">
			<option value="14">1.4</option>
			<option value="15">1.5</option>
			<option value="16">1.6</option>
			<option value="other">other</option>
		</select>
	</td>
</tr>
<tr>
	<th>Autoconf version</th>
	<td>
		<select name="autoconf">
			<option value="213">2.13</option>
			<option value="252" selected="yes">2.52</option>
			<option value="253">2.53</option>
			<option value="other">other</option>
		</select>
	</td>
</tr>
<tr>
	<th>Libtool version</th>
	<td>
		<select name="libtool">
			<option value="134">1.3.4</option>
			<option value="135">1.3.5</option>
			<option value="140" selected="yes">1.4</option>
			<option value="141">1.4.1</option>
			<option value="142">1.4.2</option>
			<option value="other">other</option>
		</select>
	</td>
</tr>
<tr>
	<th>Bison version</th>
	<td>
		<select name="bison">
			<option value="128">1.28</option>
			<option value="129">1.29</option>
            <option value="130">1.30</option>
			<option value="132">1.32</option>
			<option value="other">other</option>
		</select>
	</td>
</tr>
</table>

<h2>Extensions</h2>

<table>
	<tr>
		<td><input type="checkbox" name="aspell">aspell</input></td>
		<td><input type="checkbox" name="bcmath">bcmath</input></td>
		<td><input type="checkbox" name="bz2">bz2</input></td>
		<td><input type="checkbox" name="calendar">calendar</input></td>
		<td><input type="checkbox" name="ccvs">ccvs</input></td>
		<td><input type="checkbox" name="com">com</input></td>
		<td><input type="checkbox" name="cpdf">cpdf</input></td>
		<td><input type="checkbox" name="crack">crack</input></td>
	</tr>
	<tr>
		<td><input type="checkbox" name="ctype">ctype</input></td>
		<td><input type="checkbox" name="curl">curl</input></td>
		<td><input type="checkbox" name="cybercash">cybercash</input></td>
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
		<td><input type="checkbox" name="mbstring">mbstring</input></td>
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
		<td><input type="checkbox" name="mysql">mysql</input></td>
		<td><input type="checkbox" name="ncurses">ncurses</input></td>
		<td><input type="checkbox" name="notes">notes</input></td>
	</tr>
	<tr>
		<td><input type="checkbox" name="oci8">oci8</input></td>
		<td><input type="checkbox" name="odbc">odbc</input></td>
		<td><input type="checkbox" name="openssl">openssl</input></td>
		<td><input type="checkbox" name="oracle">oracle</input></td>
		<td><input type="checkbox" name="overload">overload</input></td>
		<td><input type="checkbox" name="ovrimos">ovrimos</input></td>
		<td><input type="checkbox" name="pcntl">pcntl</input></td>
		<td><input type="checkbox" name="pcre">pcre</input></td>
	</tr>
	<tr>
		<td><input type="checkbox" name="pdf">pdf</input></td>
		<td><input type="checkbox" name="pfpro">pfpro</input></td>
		<td><input type="checkbox" name="pgsql">pgsql</input></td>
		<td><input type="checkbox" name="posix">posix</input></td>
		<td><input type="checkbox" name="pspell">pspell</input></td>
		<td><input type="checkbox" name="qtdom">qtdom</input></td>
		<td><input type="checkbox" name="readline">readline</input></td>
		<td><input type="checkbox" name="recode">recode</input></td>
	</tr>
	<tr>
		<td><input type="checkbox" name="satellite">satellite</input></td>
		<td><input type="checkbox" name="session">session</input></td>
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
		<td><input type="checkbox" name="tokenizer">tokenizer</input></td>
		<td><input type="checkbox" name="vpopmail">vpopmail</input></td>
		<td><input type="checkbox" name="w32api">w32api</input></td>
		<td><input type="checkbox" name="wddx">wddx</input></td>
		<td><input type="checkbox" name="xml">xml</input></td>
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

<h2>Additional</h2>
<table>
<tr>
	<th>Tests done:</th>
	<td><textarea cols="80" rows="10" name="test"></textarea></td>
</tr>
<tr>
	<th>Problems:</th>
	<td><textarea cols="80" rows="10" name="problems"></textarea></td>
</tr>
<tr>
	<th>Related bug ids:</th>
	<td><input type="text" name="name"></td>
</tr>
<tr>
	<th>Remarks:</th>
	<td><textarea cols="80" rows="10" name="remarks"></textarea></td>
</tr>
</table>

<hr />
<input type="submit" value="submit" />
</form>

<?php
common_footer();
?>
