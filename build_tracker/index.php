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
<h2>Index of Built|Installed PHP Releases</h2>
 - placeholder for short instructions<br />
 - link to build|install report page<br />
<br clear="all" />

<font color="#ff0000"><b>This form is not yet active - please do not use it!</b></font><br /><br />

<b>User Information</b>
<table width="100%" cellpadding="4" cellspacing="0" border="0" bgcolor="#CCCCCC">
	<tr>
		<td align="right" width="25%"><font face="Tahoma, Arial, Helvetica, Sans Serif">
		Name
		</font></td>

		<td><font face="Tahoma, Arial, Helvetica, Sans Serif">
		<input type="text" name="field['']" value="<?= $field[''] ?>" size="32" maxlength="32" />
		</font></td>
	</tr>

	<tr>
		<td align="right" width="25%"><font face="Tahoma, Arial, Helvetica, Sans Serif">
		E-Mail Address
		</font></td>

		<td><font face="Tahoma, Arial, Helvetica, Sans Serif">
		<input type="text" name="field['']" value="<?= $field[''] ?>" size="32" maxlength="32" />
		</font></td>
	</tr>
</table><br />

<b>PHP Version</b>
<table width="100%" cellpadding="4" cellspacing="0" border="0" bgcolor="#CCCCCC">
	<tr>
		<td align="right" width="25%"><font face="Tahoma, Arial, Helvetica, Sans Serif">
		Version of Source or Binary
		</font></td>

		<td><font face="Tahoma, Arial, Helvetica, Sans Serif">
		<select name="field[version]">
		<?
			$selected_version[$field[version]] = ' selected';
			foreach (file ($php_version_list) as $option)
				printf ('<option%s>%s</option>', $selected_version[$option], $option);
		?>
		</select>
		</font></td>
	</tr>

	<tr>
		<td align="right" width="25%"><font face="Tahoma, Arial, Helvetica, Sans Serif">
		CVS Source
		</font></td>

		<td><font face="Tahoma, Arial, Helvetica, Sans Serif">
		<select name="field[cvs_source]">
		<option> -- I did not get the source code from CVS --</option>
		<?
			$selected_cvs_source[$field[cvs_source]] = ' selected';

			$day = 60 * 60 * 24;
			$date = time ();
			$end = $date - 29 * $day;
			while ($date > $end)
			{
				$date_string = date ('Y/m/d', $date);
				printf ('<option%s>%s</option>', $selected_cvs_source[$date_string], $date_string);
				$date -= $day;
			}
		?>
		</select>
		</font></td>
	</tr>

	<tr>
		<td align="right" width="25%"><font face="Tahoma, Arial, Helvetica, Sans Serif">
		Snapshot Date
		</font></td>

		<td><font face="Tahoma, Arial, Helvetica, Sans Serif">
		<select name="field[snapshot]">
		<option> -- I did not use a snapshot --</option>
		<?
			$selected_snapshot[$field[snapshot]] = ' selected';

			$day = 60 * 60 * 24;
			$date = time ();
			$end = $date - 29 * $day;
			while ($date > $end)
			{
				$date_string = date ('Y/m/d', $date);
				printf ('<option%s>%s</option>', $selected_snapshot[$date_string], $date_string);
				$date -= $day;
			}
		?>
		</select>
		</font></td>
	</tr>

	<tr>
		<td align="right" width="25%"><font face="Tahoma, Arial, Helvetica, Sans Serif">
		PHP Server API
		</font></td>

		<td><font face="Tahoma, Arial, Helvetica, Sans Serif">
		<select name="field[sapi]">
		<?
			$selected_sapi[$field[sapi]] = ' selected';
			foreach (file ($sapi_list) as $option)
				printf ('<option%s>%s</option>', $selected_sapi[$option], $option);
		?>
		</select>
		</font></td>
	</tr>

</table><br />

<b>Platform</b>
<table width="100%" cellpadding="4" cellspacing="0" border="0" bgcolor="#CCCCCC">

	<tr>
		<td align="right" width="25%"><font face="Tahoma, Arial, Helvetica, Sans Serif">
		Operating System
		</font></td>

		<td><font face="Tahoma, Arial, Helvetica, Sans Serif">
		<input type="text" name="field[os_name]" value="<?= $field[os_name] ?>" size="32" maxlength="32" />
		<input type="text" name="field[os_version]" value="<?= $field[os_version] ?>" size="32" maxlength="32" />
		</font></td>
	</tr>
	<tr>
		<td align="right" width="25%"><font face="Tahoma, Arial, Helvetica, Sans Serif">
		Server Software
		</font></td>

		<td><font face="Tahoma, Arial, Helvetica, Sans Serif">
		<input type="text" name="field[server_name]" value="<?= $field[server_name] ?>" size="32" maxlength="32" />
		<input type="text" name="field[server_version]" value="<?= $field[server_version] ?>" size="32" maxlength="32" />
		</font></td>
	</tr>

</table><br />

<b>Additional Packages</b>
<table width="100%" cellpadding="4" cellspacing="0" border="0" bgcolor="#CCCCCC">

	<tr>
		<td align="right" width="25%"><font face="Tahoma, Arial, Helvetica, Sans Serif">
		Installed Software
		</font></td>

		<td><font face="Tahoma, Arial, Helvetica, Sans Serif">
		<textarea name="field['']" cols="32" rows="4" wrap="virtual" /><?= $field[''] ?></textarea>
		</font></td>
	</tr>


</table><br />

<b>Built from Source</b> (If you built PHP from source, please complete this section)
<table width="100%" cellpadding="4" cellspacing="0" border="0" bgcolor="#CCCCCC">
	<tr>
		<td align="right" width="25%"><font face="Tahoma, Arial, Helvetica, Sans Serif">
		Configure Options
		</font></td>

		<td><font face="Tahoma, Arial, Helvetica, Sans Serif">
		<textarea name="field['']" cols="32" rows="4" wrap="virtual" /><?= $field[''] ?></textarea>
		</font></td>
	</tr>

	<tr>
		<td align="right" width="25%"><font face="Tahoma, Arial, Helvetica, Sans Serif">
		Build Tools<br />
		i.e. Bison, Make, m4, etc...
		</font></td>

		<td><font face="Tahoma, Arial, Helvetica, Sans Serif">
		<textarea name="field['']" cols="32" rows="4" wrap="virtual" /><?= $field[''] ?></textarea>
		</font></td>
	</tr>

	<tr>
		<td align="right" width="25%"><font face="Tahoma, Arial, Helvetica, Sans Serif">
		</font></td>

		<td><font face="Tahoma, Arial, Helvetica, Sans Serif">
		</font></td>
	</tr>

</table><br />

<b>Installed a Binary</b> (If you installed a binary of PHP, please complete this section)
<table width="100%" cellpadding="4" cellspacing="0" border="0" bgcolor="#CCCCCC">
	<tr>
		<td align="right" width="25%"><font face="Tahoma, Arial, Helvetica, Sans Serif">
		Where did you get the binary?
		</font></td>

		<td><font face="Tahoma, Arial, Helvetica, Sans Serif">
		<input type="text" name="field['']" value="<?= $field[''] ?>" size="32" maxlength="32" />
		</font></td>
	</tr>

	<tr>
		<td align="right" width="25%"><font face="Tahoma, Arial, Helvetica, Sans Serif">
		What modules were included in the binary?
		</font></td>

		<td><font face="Tahoma, Arial, Helvetica, Sans Serif">
		<?
			$modules     = file ($module_list);
			$no_of_cells = count ($modules);

			for ($n=0, $col = 0, $row = 0; $n < $no_of_cells; ++$n)
			{
				$module = trim ($modules[$n]);
				$line  = '<td><font face="Tahoma, Arial, Helvetica, Sans Serif" SIZE="2">';
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

			print '<table border="1" WIDTH="90%">';

			for ($row = 0; $cell[0][$row]; ++$row)
				print '<tr>'.$cell[0][$row].$cell[1][$row].$cell[2][$row].$cell[3][$row].'</tr>';

			print '</table>';
		?>
		</select>
		</font></td>
	</tr>

</table><br />

<b>Configuration</b>
<table width="100%" cellpadding="4" cellspacing="0" border="0" bgcolor="#CCCCCC">

	<tr>
		<td align="right" width="25%"><font face="Tahoma, Arial, Helvetica, Sans Serif">
		Paste your php.ini here &gt;
		</font></td>

		<td><font face="Tahoma, Arial, Helvetica, Sans Serif">
		<textarea name="field['']" cols="32" rows="4" wrap="virtual" /><?= $field[''] ?></textarea>
		</font></td>
	</tr>

</table><br />

<b>Additional Information</b>
<table width="100%" cellpadding="4" cellspacing="0" border="0" bgcolor="#CCCCCC">
	<tr>
		<td align="right" width="25%"><font face="Tahoma, Arial, Helvetica, Sans Serif">
		Output of ./configure and make scripts
		</font></td>

		<td><font face="Tahoma, Arial, Helvetica, Sans Serif">
		<textarea name="field['']" cols="32" rows="4" wrap="virtual" /><?= $field[''] ?></textarea>
		</font></td>
	</tr>

	<tr>
		<td align="right" width="25%"><font face="Tahoma, Arial, Helvetica, Sans Serif">
		Notes and Comments
		</font></td>

		<td><font face="Tahoma, Arial, Helvetica, Sans Serif">
		<textarea name="field['']" cols="32" rows="4" wrap="virtual" /><?= $field[''] ?></textarea>
		</font></td>
	</tr>
</table><br />

<table width="100%" cellpadding="4" cellspacing="0" border="0">
	<tr>
		<td align="right" width="25%"><font face="Tahoma, Arial, Helvetica, Sans Serif">
		&nbsp;
		</font></td>

		<td><font face="Tahoma, Arial, Helvetica, Sans Serif">
		<input type="submit" name="action" value="Submit Form" />
		</font></td>
	</tr>

</table><br />
<PRE>
<? print_r ($HTTP_POST_VARS) ?>
</form>
</font>
</body>
</html>
