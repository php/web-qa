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
