<?php

# file2select
# Author: j.a.greant 2000/08/23 zak@php.net

# A simple function for generating select boxes from formatted text files
# format for text files is:  option value::option display name
# each entry should be separated by a newline
# blank lines and lines that start with a single # are ignored

function file2select ($field_name)
{
	$field[$field_name] = $GLOBALS[field][$field_name];
	$selected[$field[$field_name]] = ' selected';

	foreach (file ($field_name.'_list.txt') as $temp)
	{
		$temp = trim ($temp);
		if (! $temp || $temp[0] == '#') continue;	# ignore blanks and comments


		list ($value, $option) = explode ('::', $temp);
		$output .= sprintf ('<option value="%s"%s>%s</option>'."\n", $value, $selected[$value], $option);
	}

	return '<select name="field[' . $field_name . ']">' . "\n$output" .	'</select>';
}

# generate_row
# Author: j.a.greant 2000/08/23 zak@php.net

# A simple function for generating formatted rows with a varying # of columns

function generate_row ($column_data, $no_of_columns = 2)
{
	$row = '<tr bgcolor="#F0F0F0">';

	for ($index=0; $index < $no_of_columns; ++$index)
	{
		$row .= '<td><font face="Tahoma, Arial, Helvetica, sans-serif">';
		$row .= $column_data[$index];
		$row .= '</font></td>';
	}

	$row .= '</tr>';

	return $row;
}
?>
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
		1.0 USER INFORMATION
		</b></font>

		<table width="100%">
			<?= generate_row (array ('&nbsp;<b>1.1</b> Name', '<input type="text" name="field[user_name]" value="'.$field[user_name].'" size="32" maxlength="56" />')) ?>
			<?= generate_row (array ('&nbsp;<b>1.2</b> Email', '<input type="text" name="field[user_email]" value="'. $field[user_email] .'" size="32" maxlength="112" />')) ?>
		</table>

		</td>
	</tr>
</table>

<table cellpadding="3" cellspacing="3" border="0" width="620">
<tr bgcolor="#E0E0E0">
		<td><font face="Tahoma, Arial, Helvetica, sans-serif"><b>
		2.0 GENERAL INFORMATION
		</b></font>

		<table width="100%">
			<?= generate_row (array ('&nbsp;<b>2.1</b> What information are you reporting?', file2select ('topic'))) ?>
		</table>

		</td>
	</tr>
</table>

<table cellpadding="3" cellspacing="3" border="0" width="620">
<tr bgcolor="#E0E0E0">
		<td><font face="Tahoma, Arial, Helvetica, sans-serif"><b>
		3.0 BUILD AND INSTALL INFORMATION
		</b></font>

		<table width="100%">
			<?= generate_row (array ('&nbsp;<b>3.1</b> How did you get your copy of PHP?', file2select ('php_source'))) ?>
			<?= generate_row (array ('&nbsp;<b>3.2</b> What kind of operating system did you install PHP on?', file2select ('os_families'))) ?>
			<?= generate_row (array ('&nbsp;<b>3.3</b> How many different types of servers are you using with this install of PHP?', file2select ('count_servers'))) ?>
			<?= generate_row (array ('&nbsp;<b>3.4</b> How many different types databases are you using with this install of PHP?', file2select ('count_databases'))) ?>
		</table>

		</td>
	</tr>
</table>

<table cellpadding="3" cellspacing="3" border="0" width="620">
	<tr bgcolor="#E0E0E0">
		<td><font face="Tahoma, Arial, Helvetica, sans-serif">
			<table width="100%">
			<tr bgcolor="#F0F0F0">
				<td align="right"><font face="Tahoma, Arial, Helvetica, sans-serif">
				<input type="submit" value="Next &gt;&gt;&gt;" />
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
