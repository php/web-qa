<?
	# Module, SAPI and Version information for populating form fields
	# are stored in plain text files.  Each line contains one entry
	# for the appropriate select box or group of checkboxes.

	$module_list		= 'module_list.txt';
	$php_version_list 	= 'php_version_list.txt';
	$sapi_list			= 'sapi_list.txt';

	# Set default values for form fields
 	$field[os_name] or
		$field[os_name] = 'Enter OS Name';

	$field[os_version] or
		$field[os_version] = 'Enter OS Version';

	$field[server_name] or
		$field[server_name] = 'Enter Server Name';

	$field[server_version] or
		$field[server_version] = 'Enter Server Version';

?>
<html>
<head>
<title>
PHP|QAT: Compiled/Installed Version Tracker
</title>
</head>
<body bgcolor="#FFFFFF" text="#000000" link="#990000" vlink="#999900">
<font face="Tahoma, Arial, Helvetica, Sans Serif">
<form action="<?= $PHP_SELF ?>" method="POST" />
<center>
<h2>Index of Built|Installed PHP Releases</h2>

<table cellpadding="3" cellspacing="3" border="0" width="620">
<tr bgcolor="#E0E0E0">
		<td><font face="Tahoma, Arial, Helvetica, sans-serif"><b>
		0.0 INSTRUCTIONS
		</b></font>

		<table width="100%" cellpadding="2">
			<tr bgcolor="#F0F0F0">
				<td><font face="Tahoma, Arial, Helvetica, sans-serif">
				...tbd...
				</font>
				</td>
			</tr>
		</table>

		</td>
	</tr>
</table>


<table cellpadding="3" cellspacing="3" border="0" width="620">
<tr bgcolor="#E0E0E0">
		<td><font face="Tahoma, Arial, Helvetica, sans-serif"><b>
		1.0 USER INFORMATION
		</b></font>

		<table width="100%">
			<tr bgcolor="#F0F0F0">
				<td><font face="Tahoma, Arial, Helvetica, sans-serif">
				&nbsp;<b>1.1</b> Name
				</font>
				</td>

				<td><font face="Tahoma, Arial, Helvetica, sans-serif">
				<input type="text" name="field[user_name]" value="<?= $field[user_name] ?>" size="32" maxlength="56" />
				</font>
				</td>
			</tr>

			<tr bgcolor="#F0F0F0">
				<td><font face="Tahoma, Arial, Helvetica, sans-serif">
				&nbsp;<b>1.2</b> Email
				</font>
				</td>

				<td><font face="Tahoma, Arial, Helvetica, sans-serif">
				<input type="text" name="field[user_email]" value="<?= $field[user_email] ?>" size="32" maxlength="112" />
				</font>
				</td>
			</tr>
		</table>

		</td>
	</tr>
</table>

<a name="2.0"></a>
<table cellpadding="3" cellspacing="3" border="0" width="620">
<tr bgcolor="#E0E0E0">
		<td><font face="Tahoma, Arial, Helvetica, sans-serif"><b>
		2.0 PHP VERSION
		</b></font>

		<table width="100%">
			<tr bgcolor="#F0F0F0">
				<td><font face="Tahoma, Arial, Helvetica, sans-serif">
				&nbsp;<b>2.1</b> Source (<a href="#5.0">*</a>) or Binary Release (<a href="#5.0">**</a>)
				</font>
				</td>

				<td><font face="Tahoma, Arial, Helvetica, sans-serif">
				<select name="field[version]">
				<?
					$selected_version[$field[version]] = ' selected';
					foreach (file ($php_version_list) as $option)
						printf ('<option%s>%s</option>', $selected_version[$option], $option);
				?>
				</select>
				</font>
				</td>
			</tr>

			<tr bgcolor="#F0F0F0">
				<td><font face="Tahoma, Arial, Helvetica, sans-serif">
				&nbsp;<b>2.2</b> CVS Build
				</font>
				</td>

				<td><font face="Tahoma, Arial, Helvetica, sans-serif">
				<select name="field[cvs_info_date]">
				<option value=''>-- I did not get the source code from CVS --</option>
				<?
					$selected_cvs_info_date[$field[cvs_info_date]] = ' selected';

					$day = 60 * 60 * 24;
					$date = time ();
					$end = $date - 29 * $day;
					while ($date > $end)
					{
						$date_string = date ('Y/m/d', $date);
						printf ('<option%s>%s</option>', $selected_cvs_info_date[$date_string], $date_string);
						$date -= $day;
					}
				?>
				</select>
				</font>
				</td>
			</tr>

			<tr bgcolor="#F0F0F0">
				<td><font face="Tahoma, Arial, Helvetica, sans-serif">
				&nbsp;<b>2.3</b> Snapshot Build
				</font>
				</td>

				<td><font face="Tahoma, Arial, Helvetica, sans-serif">
				<select name="field[cvs_source]">
				<option value="">-- I did not use a snapshot --</option>
				<?
					$selected_snap_info_date[$field[snap_info_date]] = ' selected';

					$day = 60 * 60 * 24;
					$date = time ();
					$end = $date - 29 * $day;
					while ($date > $end)
					{
						$date_string = date ('Y/m/d', $date);
						printf ('<option%s>%s</option>', $selected_snap_info_date[$date_string], $date_string);
						$date -= $day;
					}
				?>
				</select>
				</font>
				</td>
			</tr>
		</table>

		</td>
	</tr>
</table>

<table cellpadding="3" cellspacing="3" border="0" width="620">
<tr bgcolor="#E0E0E0">
		<td><font face="Tahoma, Arial, Helvetica, sans-serif"><b>
		<b>3.0</b> SERVER PLATFORM
		</b></font>

		<table width="100%">
			<tr>
				<td><font face="Tahoma, Arial, Helvetica, sans-serif">
				&nbsp;
				</font>
				</td>

				<td bgcolor="#F0F0F0" align="center"><font face="Tahoma, Arial, Helvetica, sans-serif">
				Name
				</font></td>

				<td bgcolor="#F0F0F0" align="center"><font face="Tahoma, Arial, Helvetica, sans-serif">
				Version
				</font></td>
			</tr>

			<tr bgcolor="#F0F0F0">
				<td><font face="Tahoma, Arial, Helvetica, sans-serif">
				&nbsp;<b>3.1</b> Operating System
				</font>
				</td>

				<td align="center"><font face="Tahoma, Arial, Helvetica, sans-serif">
				<input type="text" name="field[os_name]" value="<?= $field[os_name] ?>" size="32" maxlength="56" />
				</font></td>

				<td align="center"><font face="Tahoma, Arial, Helvetica, sans-serif">
				<input type="text" name="field[os_version]" value="<?= $field[os_version] ?>" size="7" maxlength="28" />
				</font>
				</td>
			</tr>

			<tr bgcolor="#F0F0F0">
				<td><font face="Tahoma, Arial, Helvetica, sans-serif">
				&nbsp;<b>3.2</b> Web Server
				</font>
				</td>

				<td align="center"><font face="Tahoma, Arial, Helvetica, sans-serif">
				<input type="text" name="field[server_name]" value="<?= $field[server_name] ?>" size="32" maxlength="56" />
				</font></td>

				<td align="center"><font face="Tahoma, Arial, Helvetica, sans-serif">
				<input type="text" name="field[server_version]" value="<?= $field[server_version] ?>" size="7" maxlength="28" />
				</font>
				</td>
			</tr>

			<tr bgcolor="#F0F0F0">
				<td><font face="Tahoma, Arial, Helvetica, sans-serif">
				&nbsp;<b>3.3</b> Database
				</font>
				</td>

				<td align="center"><font face="Tahoma, Arial, Helvetica, sans-serif">
				<input type="text" name="field[database_name]" value="<?= $field[database_name] ?>" size="32" maxlength="56" />
				</font></td>

				<td align="center"><font face="Tahoma, Arial, Helvetica, sans-serif">
				<input type="text" name="field[database_version]" value="<?= $field[database_version] ?>" size="7" maxlength="28" />
				</font>
				</td>
			</tr>
		</table>

		</td>
	</tr>
</table>

<table cellpadding="3" cellspacing="3" border="0" width="620">
<tr bgcolor="#E0E0E0">
		<td><font face="Tahoma, Arial, Helvetica, sans-serif">
		<b>4.0 EXTENSIONS</b> ( Check all that apply )
		</font>

		<table border="1" width="100%">
			<?
				$modules     = file ($module_list);
				$no_of_cells = count ($modules);

				for ($n=0, $col = 0, $row = 0; $n < $no_of_cells; ++$n)
				{
					$module = trim ($modules[$n]);
					$line  = '<td><font face="Tahoma, Arial, Helvetica, sans-serif" SIZE="2">';
					$line .= sprintf ('<input type="checkbox" name="field[module][%s]" %s/> %s ', $module, ($field[module][$module] ? ' checked' : ''), $module);
					$line .= '</font></td>';

					$cell[$col][$row] = $line;

					++$row;
					if ($row == (int) ($no_of_cells/4))
					{
						$row = 0;
						++$col;
					}
				}

				for ($row = 0; $cell[0][$row]; ++$row)
					print '<tr bgcolor="#F0F0F0">'.$cell[0][$row].$cell[1][$row].$cell[2][$row].$cell[3][$row].'</tr>';
			?>
		</table>

		</td>
	</tr>
</table>

<a name="5.0"></a>
<table cellpadding="3" cellspacing="3" border="0" width="620">
<tr bgcolor="#E0E0E0">
		<td><font face="Tahoma, Arial, Helvetica, sans-serif"><b>
		5.0 EXTRA INFORMATION
		</b></font>
			<table width="100%">
			<tr bgcolor="#F0F0F0">
				<td><font face="Tahoma, Arial, Helvetica, sans-serif">
				&nbsp;<b>5.1</b> If you built from source, please upload your ./configure file.
				(Return to question <a href="#2.0">2.1</a>)
				</font>
				</td>

				<td><font face="Tahoma, Arial, Helvetica, sans-serif">
				<input type="file" name="configure" />
				</font></td>
			</tr>

			<tr bgcolor="#F0F0F0">
				<td><font face="Tahoma, Arial, Helvetica, sans-serif">
				&nbsp;<b>5.2</b> If you installed a binary version, where did get it from?
				(Return to question <a href="#2.0">2.1</a>)
				</font>
				</td>

				<td><font face="Tahoma, Arial, Helvetica, sans-serif">
				<input type="text" name="field[data_bin_from]" value="<?= $field[data_bin_from] ?>" size="32" maxlength="240" />
				</font></td>
			</tr>

			<tr bgcolor="#F0F0F0">
				<td><font face="Tahoma, Arial, Helvetica, sans-serif">
				&nbsp;<b>5.3</b> Please upload your php.ini file.
				</font>
				</td>

				<td><font face="Tahoma, Arial, Helvetica, sans-serif">
				<input type="file" name="php_ini" />
				</font></td>
			</tr>

			<tr bgcolor="#F0F0F0">
				<td><font face="Tahoma, Arial, Helvetica, sans-serif">
				&nbsp;<b>5.4</b> Please include information on your build tools (Bison, Make, m4, etc...)
				</font>
				</td>

				<td><font face="Tahoma, Arial, Helvetica, sans-serif">
				<textarea name="field[data_build_tools]" cols="32" rows="4" wrap="virtual" /><?= $field[data_build_tools] ?></textarea>
				</font></td>
			</tr>

			<tr bgcolor="#F0F0F0">
				<td><font face="Tahoma, Arial, Helvetica, sans-serif">
				&nbsp;<b>5.5</b> General Comments
				</font>
				</td>

				<td><font face="Tahoma, Arial, Helvetica, sans-serif">
				<textarea name="field[data_build_tools]" cols="32" rows="4" wrap="virtual" /><?= $field[data_build_tools] ?></textarea>
				</font></td>
			</tr>
			</table>

		</td>
	</tr>
</table>

<table cellpadding="3" cellspacing="3" border="0" width="620">
<tr bgcolor="#E0E0E0">
		<td><font face="Tahoma, Arial, Helvetica, sans-serif"><b>
		Thank you for your time!
		</b></font>
			<table width="100%">
			<tr bgcolor="#F0F0F0">
				<td align="center"><font face="Tahoma, Arial, Helvetica, sans-serif">
				<input type="submit" value="Send Report" />
				</font></td>
			</tr>
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
