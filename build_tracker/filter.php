<?php include 'functions.php'; ?>
<html>
<head>
<title>
PHP|QAT: PHP Build and Install Tracker
</title>
</head>
<body bgcolor="#FFFFFF" text="#000000" link="#990000" vlink="#999900">
<font face="Tahoma, Arial, Helvetica, Sans Serif">
<form action="harvest.php" method="POST">
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
			<?= generate_row (array ('&nbsp;<b>3.2 (a)</b> What kind of operating system did you install PHP on?', file2select ('os'))) ?>
			<?= generate_row (array ('&nbsp;<b>3.2 (b)</b> What version of the above operating system are you using?', '<input type="text" name="field[os_version]" value="'.htmlentities (stripslashes ($field[os_version])).'" size="32" maxlength="56" />')) ?>
			<tr bgcolor="#F0F0F0"><td colspan="2"><font face="Tahoma, Arial, Helvetica, sans-serif">&nbsp;<b>3.3</b> What web server(s) do you use with this build of PHP?</font></td></tr>
			<tr bgcolor="#F0F0F0"><td colspan="2"><?= file2cb_column ('server') ?></td></tr>
			<?= generate_row (array ('&nbsp;<b>3.4</b> If you compiled PHP, please enter the configure line here:', '<textarea name="field[configure]" rows="2" cols="30" wrap="virtual">'.$field[configure].'</textarea>')) ?>
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
