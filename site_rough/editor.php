<?php
#
# PHP.net news, site and project content manager.
#

# Connect to database
mysql_connect ('dev.nucleus.com', 'php', '')
    or die ('Could not connect to database.');
mysql_select_db ('php');

#
# Define functions
#

# Basic http authentication
function auth ($realm = 'PHP Content Admin', $failed_auth_message = 'Authentication Failed')
{
    global $PHP_AUTH_USER, $PHP_AUTH_PW;

    # Check user credentials against admin database
    $query = "SELECT 1 FROM admin WHERE handle='$PHP_AUTH_USER' AND password = password('$PHP_AUTH_PW')";

    if ( ! mysql_num_rows (mysql_query ($query)))
      {
        header ("WWW-Authenticate: Basic realm=\"$realm\"");
        header ("HTTP/1.0 401 Unauthorized");
        die ($failed_auth_message);
      }
}

#
# Force Authentication
#
if ($login || $PHP_AUTH_USER)
    auth ();

/*
    Generate an html select box from a list of items in a file
    Each line in the file should contain one item
    Blank lines, as well as lines that start with a # are ignored
*/
function file2select ($site_name, $list)
{
    $selected_item = $GLOBALS[$site_name];
    foreach ($list as $value)
      {
        $value = trim ($value);
        if ($value == '' or substr ($value, 0, 1) == '#')
            continue;
        $return .= sprintf ('<option%s>%s</option>', $value == $selected_item and ' SELECTED', $value);
      }
    return "<select name=\"$site_name\">$return</select>";
}

# Generate a select list of all available items from a given category
function show_items ($category)
{
    $selected_item = $GLOBALS['field']['id'];
    $return = '<option>Unapproved Items</option>';

    # get unapproved items
    $query = "SELECT id, title FROM content WHERE category = '$category' and approved = 'no' ORDER BY time_stamp DESC";
    $result = mysql_query ($query);

    while (list ($id, $title) = @ mysql_fetch_row ($result))
        $return .= sprintf ('<option value="%s"%s> - %s</option>'."\n", $id, $id == $selected_item ? ' SELECTED':'', htmlentities ($title));

    $return .= '<option></option><option>Approved Items</option>';
    # get approved items
    $query = "SELECT id, title FROM content WHERE category = '$category' and approved = 'yes' ORDER BY time_stamp DESC";
    $result = mysql_query ($query);
    while (list ($id, $title) = @ mysql_fetch_row ($result))
        $return .= sprintf ('<option value="%s"%s> - %s</option>'."\n", $id, $id == $selected_item ? ' SELECTED':'', htmlentities ($title));

    return '<select name="field[id]" onChange="submit()">' . $return . '</select>';
}


# Handle form actions
if ($action == 'Save')
  {
    # Error checking
    trim ($field['title'])
        or print $error = 'Please enter a title.';

    trim ($field['url'])
        or print $error = 'Please enter a URL for the article.';

    trim ($field['description'])
        or print $error = 'Please enter a description for the article.';

    # Update entry
    if (! $error)
      {
        if (! $PHP_AUTH_USER)
          {
            $field['approved'] == 'no';
            $field['time_stamp'] == date ('Y/m/d H:j:s');
          }
        else if ($field['approved'] == 'yes')
            $field['approved_by'] = $PHP_AUTH_USER;

        $columns = implode (',', array_keys ($field));
        $values  = "'" . implode ("','", array_values ($field)) . "'";
        $query = "REPLACE INTO content ($columns) VALUES ($values)";
        mysql_query ($query);
        $field['id'] = mysql_insert_id ();

		if (! $PHP_AUTH_USER)
			die ('Thank you for your suggestion!');
      }
  }
else if ($action == 'Delete' && $PHP_AUTH_USER)
  {
    if ($confirm == 'yes')
      {
        $query = "DELETE FROM content WHERE id='$field[id]'";
        mysql_query ($query);
        unset ($field);
      }
    else
      {
        print "Are you sure that you want to delete this item? <a href=\"$PHP_SELF?field[id]=$field[id]&confirm=yes&action=Delete\">Yes</a> <a href=\"$PHP_SELF\">No</a><br />";
      }
  }

# Display Selected Item
if ($field['id'])
  {
    $query = "SELECT * FROM content WHERE id = '$field[id]'";
    $result = mysql_query ($query);
    $field = mysql_fetch_array ($result, MYSQL_ASSOC);
  }

# Allow editor login
if (! $PHP_AUTH_USER )
  {
    print "<a href=\"$PHP_SELF?login=1\">Editor Login</a>";
  }

?>

<form action="<?= $PHP_SELF ?>" method="POST">
<input type="hidden" name="field[category]" value="news" />
<input type="hidden" name="field[sub_category]" value="" />

<table>
    <tr>
        <td align="right">&nbsp;</td>
        <td><font face=""><b>
        <? if ($PHP_AUTH_USER): ?>
            Edit News Article Listing
        <? else: ?>
            Suggest News Article Listing
        <? endif; ?>
        </b></font></td>
    </tr>
<? if ($PHP_AUTH_USER): ?>
    <tr>
        <td align="right"><font face="">Select an item</font></td>
        <td><?= show_items ('news') ?> <input type="submit" value="&gt;&gt;&gt;" /></td>
    </tr>
<? endif; ?>
    <tr>
        <td align="right"><font face="">Article Title</font></td>
        <td><input type="text" name="field[title]" value="<?= htmlentities ($field['title']) ?>" size="80" maxlength="72" /></td>
    </tr>
    <tr>
        <td align="right"><font face="">Article Author</font></td>
        <td><input type="text" name="field[author]" value="<?= htmlentities ($field['author']) ?>" size="80" maxlength="72" /></td>
    </tr>
    <tr>
        <td align="right"><font face="">Author Email Address</font></td>
        <td><input type="text" name="field[email]" value="<?= htmlentities ($field['email']) ?>" size="80" maxlength="72" /></td>
    </tr>
    <tr>
        <td align="right"><font face="">Your Email Address</font></td>
        <td><input type="text" name="field[submitter_email]" value="<?= htmlentities ($field['submitter_email']) ?>" size="80" maxlength="72" /></td>
    </tr>
    <tr>
        <td align="right"><font face="">Article URL</font></td>
        <td><input type="text" name="field[url]" value="<?= htmlentities ($field['url']) ?>" size="80" maxlength="72" /></td>
    </tr>
    <tr>
        <td align="right"><font face="">Article Synopsis</font></td>
        <td><textarea name="field[description]" rows="7" cols="60" wrap="virtual"><?= htmlentities ($field['description']) ?></textarea></td>
    </tr>
<? if ($PHP_AUTH_USER): ?>
    <tr>
        <td align="right"><font face="">Article Status</font></td>
        <td>
            <font face="">
            <input type="radio" name="field[approved]" value="yes" <?= ($field['approved'] == 'yes') ? ' checked' : '' ?> />Approved <? $field['approved_by'] and print "by $field[approved_by]";  ?><br />
            <input type="radio" name="field[approved]" value="no" <?=  ($field['approved'] == 'no') ? ' checked' : '' ?> />  Not Approved<br />
        </td>
    </tr>
<? endif; ?>
    <tr>
        <td>&nbsp;</td>
        <td align="center">
            <input type="submit" name="action" value="Save" />
            <? if ($PHP_AUTH_USER): ?>
                <input type="submit" name="action" value="Delete" />
            <? endif; ?>
        </td>
    </tr>
</table>
</form>

<?

/*
    CREATE TABLE content
    (
        id              smallint unsigned not null auto_increment primary key,
        approved        enum ('no','yes') not null,
        approved_by     varchar(8) not null,

        category        enum ('news','projects','sites') not null,
        sub_category    varchar(16) not null,
        title           varchar(80) not null,
        author          varchar(80) not null,
        email           varchar(80) not null,
        submitter_email varchar(80) not null,
        url             varchar(80) not null,
        description     text not null,
        time_stamp      datetime
    )

    CREATE TABLE admin
    (
        handle          varchar(8) not null primary key,
        password        varchar(16) not null,
        user_data       text not null
    )
*/
?>
