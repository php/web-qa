<?php include 'functions.php'; ?>
<html>
<head>
<title>
PHP|QAT: PHP Build and Install Tracker
</title>
</head>
<body bgcolor="#FFFFFF" text="#000000" link="#990000" vlink="#999900">
<font face="Tahoma, Arial, Helvetica, Sans Serif">
<form action="<?= $PHP_SELF ?>" method="POST">
<center>
<h3>PHP Build and Install Tracker</h3>

<table cellpadding="3" cellspacing="3" border="0" width="620">
	<tr bgcolor="#E0E0E0">
		<td><font face="Tahoma, Arial, Helvetica, sans-serif"><b>
		SERVER INFORMATION
		</b></font>

		<table width="100%">
		<?
			# Add handling for 'other' server
			# discard check once error handling in place
			if ($field[server])
			foreach ($field[server] as $server)
			  {
			  	list ($version_field, $note_desc, $note_field) = widget ('server', $server, 'Server Conf File', 1);
				print generate_row (array ($server, $version_field));
				print generate_row (array ($note_desc, $note_field));
			  }
		?>
  		</table>
		</td>
	</tr>

<?php if ($field[php_source] != binary) { ?>
	<tr bgcolor="#E0E0E0">
		<td><font face="Tahoma, Arial, Helvetica, sans-serif"><b>
		BUILD INFORMATION
		</b></font>

		<table width="100%">
		<?
			if ($field[php_source] != 'release')
			  {
				I_am_so_embarrassed ('build_info', 'autobuild');
				I_am_so_embarrassed ('build_info', 'autoconf');
			  }

			I_am_so_embarrassed ('build_info', 'compiler');
			I_am_so_embarrassed ('build_info', 'bison');
			I_am_so_embarrassed ('build_info', 'flex');
			I_am_so_embarrassed ('build_info', 'm4');
			I_am_so_embarrassed ('build_info', 'make');
		?>
  		</table>
		</td>
	</tr>
	<tr bgcolor="#E0E0E0">
		<td><font face="Tahoma, Arial, Helvetica, sans-serif"><b>
		CONFIGURE INFORMATION
		</b></font>

		<table width="100%">
		<?
			I_am_so_embarrassed ('build_info', 'configure.log', 'Paste Configure Log Here',1);

			# parse config file into chunks and match to extensions
			$field[configure] = ereg_replace ('[[:space:]]+', ' ', stripslashes ($field[configure]));

			foreach (explode ('--', $field[configure]) as $line)
			  {
			  	foreach (file ('extension_list.txt') as $ext)
				  {
					list ($ext, $name) = explode ('::', $ext);
				  	if (stristr ('--'.$line, trim ($ext)))
			  		  {
						I_am_so_embarrassed ('extensions', $name);
						break;
					  }
				  }
			  }
		?>
  		</table>
		</td>
	</tr>
<?php } else { ?>
	<tr bgcolor="#E0E0E0">
		<td><font face="Tahoma, Arial, Helvetica, sans-serif"><b>
		BINARY INFORMATION
		</b></font>

		<table width="100%">
		<?
			I_am_so_embarrassed ('binary_info', 'where you got the binary');
			I_am_so_embarrassed ('build_info', 'phpinfo() output', 'Paste Output of phpinfo() here', 1);

			stristr ($field[os], 'window')
				and I_am_so_embarrassed ('where did you get your dlls', 'dll source');
		?>
  		</table>
		</td>
	</tr>

<?php } ?>
	<tr bgcolor="#E0E0E0">
		<td><font face="Tahoma, Arial, Helvetica, sans-serif"><b>
		ADDITIONAL NOTES
		</b></font>

		<table width="100%">
		<?
			I_am_so_embarrassed ('notes', 'notes', 'place any extra notes here', 1);
		?>
  		</table>
		</td>
	</tr>
</table>
</center>
</form>

<br />
<PRE>
<? print_r ($HTTP_POST_VARS) ?>
</form>
</font>
</body>
</html>
