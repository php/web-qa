<?php

function widget ($group_name, $field_name, $note_desc = '&nbsp;', $long_note = 0)
{
	$field[$group_name][$field_name] = $GLOBALS[field][$group_name][$field_name];
	$var_name = "field[$field_name][$name]";
	$out[] = '<input type="text" name="'.$var_name[version].'" value="'.htmlentities (${$var_name.'[version]'}).'" />';
	$out[] = '&nbsp;&nbsp;&nbsp;&nbsp;'.$note_desc;
	if ($long_note)
		$out[] = '<textarea name="'.$var_name[notes].'" rows="2" cols="30" wrap="virtual">'.htmlentities (${$var_name.'[notes]'}).'</textarea>';
	else
		$out[] = '<input type="text" name="'.$var_name[notes].'" value="'.htmlentities (${$var_name.'[notes]'}).'" />';
	return $out;
}

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
		$option
			or $option = $value;
		$output .= sprintf ('<option value="%s"%s>%s</option>'."\n", $value, $selected[$value], $option);
	}

	return '<select name="field[' . $field_name . ']">' . "\n$output" .	'</select>';
}

# file2checkbox
# Author: j.a.greant 2000/10/03 zak@php.net

# A simple function for generating one or more checkboxes from formatted text files
# format for text files is:  option value::option display name
# each entry should be separated by a newline
# blank lines and lines that start with a single # are ignored

function file2checkbox ($field_name)
{
	$field[$field_name] = $GLOBALS[field][$field_name];
	if(is_array ($field[$field_name]))
		foreach ($field[$field_name] as $item)
			$checked[$item] = ' checked';

	foreach (file ($field_name.'_list.txt') as $temp)
	{
		$temp = trim ($temp);
		if (! $temp || $temp[0] == '#') continue;	# ignore blanks and comments

		list ($value, $option) = explode ('::', $temp);
		$option
			or $option = $value;
		$output .= sprintf ('<input type="checkbox" name="field[%s]" value="%s"%s /> %s<br />'."\n", $field_name, $value, $selected[$value], $option);
	}

	return "\n$output";
}

function file2cb_column ($field_name)
{
	$field[$field_name] = $GLOBALS[field][$field_name];

	if(is_array ($field[$field_name]))
		foreach ($field[$field_name] as $item)
			$checked[$item] = ' checked';

	$modules = file ($field_name.'_list.txt');
	$no_of_cells = count ($modules);
	$row_length  = ceil ($no_of_cells/3);



	for ($n=0, $col = 0, $row = 0; $n < $no_of_cells; ++$n)
	{
		$temp = trim ($modules[$n])
			or $temp = '&nbsp';

		if (! $temp || $temp[0] == '#') continue;	# ignore blanks and comments

		list ($value, $option) = explode ('::', $temp);

		$option
			or $option = $value;

		$line  = '<td><font face="Tahoma, Arial, Helvetica, sans-serif" SIZE="2">';
		$line .= sprintf ('<input type="checkbox" name="field[%s][]" value="%s" %s /> %s ', $field_name, $value, $checked[$value], $option);
		$line .= '</font></td>';

		$cell[$col][$row] = $line;

		++$row;
		if ($row == $row_length)
		{
			$row = 0;
			++$col;
		}
	}

	for ($row = 0; $cell[0][$row]; ++$row)
		$out .= '<tr bgcolor="#F0F0F0">'.$cell[0][$row].$cell[1][$row].$cell[2][$row].'</tr>';

	return '<table border="1" width="100%">'.$out.'</table>';
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

	return $row . '</tr>';
}

function I_am_so_embarrassed ($group_name, $name, $note_desc = 'Notes', $long_note=0)
{
		  	list ($version_field, $note_desc, $note_field) = widget ($group_name, $name, $note_desc, $long_note);
			print generate_row (array ($name, $version_field));
			print generate_row (array ($note_desc, $note_field));
}
?>
