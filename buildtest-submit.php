<?php
include("functions.php");

$TITLE = "How To Help [PHP-QAT: Quality Assurance Team]";
$SITE_UPDATE = date("D M d H:i:s Y T", filectime($SCRIPT_FILENAME))."<br>
/* $Id$ */";

common_header();
?>

<h1>Build Tracker</h1>
<hr>
<form action="buildtest-submit.php" method="post">
<h2>Meta</h2>
<table>
<tr>
	<th>Name:</th>
	<td><input type="text" name="name"></td>
</tr>
<tr>
	<th>E-mail:</th>
	<td><input type="text" name="email"></td>
</tr>
<tr>
	<th>Package:</th>
	<td>
		<select name="package">
			<option value="420dev">4.2.0dev (provide date in remark section)</option>
			<option value="420RC1">4.2.0RC1</option>
		</select>
	</td>
</tr>
<tr>
	<th>Build status:</th>
	<td>
		<select name="status">
			<option value="1">Good</option>
			<option value="0">Minor problems</option>
			<option value="-1">Failure</option>
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
			<option value="lnxi386">Linux/i386</option>
			<option value="lnxoth">Linux/other</option>
			<option value="fbsd43">FreeBSD 4.3</option>
			<option value="fbsd43">FreeBSD 4.4</option>
			<option value="openbsd">OpenBSD</option>
			<option value="macosx">MacOSX</option>
			<option value="hpux">HPUX</option>
			<option value="irix">Irix</option>
			<option value="win9598">Windows 95/98</option>
			<option value="winme">Windows ME</option>
			<option value="winnt2k">Windows NT/2000</option>
			<option value="winxp">Windows XP</option>
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
			<option value="apa1dso">Apache 1.3.x Module (DSO)</option>
			<option value="apa1sta">Apache 1.3.x Module (static)</option>
			<option value="apa2dso">Apache 2.x Module (DSO)</option>
			<option value="isapi">ISAPI</option>
			<option value="fastcgi">Fast CGI</option>
			<option value="other">other</option>
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
			<option value="252">2.52</option>
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
			<option value="140">1.4</option>
			<option value="141">1.4.1</option>
			<option value="142">1.4.2</option>
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

<hr>
<input type="submit" value="submit" />
</form>

<?php
common_footer();
?>
