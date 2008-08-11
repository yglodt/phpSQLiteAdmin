<?php

require_once('include.php');

$title = 'Add new database alias:';
$action = 'insert';
$createdb = 'read-only';

$alias = new dbalias;
$alias->user = $current_user;
$alias->alias = $_POST['alias'];
$alias->path = $_POST['path'];
$alias->description = $_POST['description'];


if (isset($_POST['insert'])) {
	// create the new db is case it does not exist
	if ($alias->alias == "") {
		print "An alias name needs to be provided.";
		exit();
	}
	if ($alias->path == "") {
		print "The path to the database needs to be provided.";
		exit();
	}
	if (!file_exists($alias->path)) $newdb =& new SPSQLite($alias->path);
	$sysdbh->query("insert into databases (user,alias,path,description) values ({$alias->user},'{$alias->alias}','{$alias->path}','{$alias->description}')");
	// do we really want this?
	$_SESSION['phpSQLiteAdmin_currentdb'] = $alias->path;
	header("Location: dbconfig.php");
	exit;
}


if (isset($_GET['alias'])) {
	$sysdbh->query("select user,alias,path,description from databases where user = $current_user and alias = '".$_GET[alias]."'");
	while($row = $sysdbh->fetchArray()) {
		$alias = new dbalias;
		$alias->alias = $row[1];
		$alias->path = $row[2];
		$alias->description = $row[3];
		$title = 'Edit database alias:';
		$action = 'update';
	}
}


if (isset($_POST['update'])) {
	$sysdbh->query("update databases set alias = '{$alias->alias}', path = '{$alias->path}', description = '{$alias->description}' where user = {$alias->user} and alias = '{$_POST[oldalias]}'");
	header("Location: dbconfig.php");
	exit;
}


if (isset($_POST['delete'])) {
	if ($alias->alias == "phpsla.sqlite") {
		print "The configuration table phpsla.sqlite cannot be removed.";
		exit();
	}
	$sysdbh->query("delete from databases where user = '{$alias->user}' and alias = '{$alias->alias}'");
	//unlink($alias->path); nooooooo don't do that... No, that wouldn't be good.
	$_SESSION['phpSQLiteAdmin_currentdb'] = '';
	header("Location: dbconfig.php");
	exit;
}

$type = text;

echo<<<EOT
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-15" />
	<link href="phpsla.css" rel="stylesheet" type="text/css" />
	<title>phpSQLiteAdmin</title>
	<meta http-equiv="expires" content="0" />
	<meta http-equiv="pragma" content="no-cache" />
	<meta http-equiv="cache-control" content="no-cache" />
	<script language="Javascript" src="javascript.txt" type="text/javascript"></script>
	<base target="mainframe" />
</head>
<body class="right" onload="document.adddb.alias.focus();">
<h3>$title</h3>
<form name="adddb" action="editdb.php" method="post">
<input type="hidden" name="oldalias" value="{$_GET[alias]}" />
<table>
<tr><td class="label">Alias:</td><td><input type="text" size="80" name="alias" value="{$alias->alias}" /></td></tr>
<tr><td class="label">Path on server:</td><td><input type="$type" size="80" name="path" value="{$alias->path}" /></td></tr>
<tr><td class="label">Description:</td><td><input type="text" size="80" name="description" value="{$alias->description}" /></td></tr>
<tr><td class="label"></td><td class="label"><input type="submit" name="$action" value="Save" /> <input type="button" value="Cancel" onclick="history.back();" /></td></tr>
</table>
</form>
EOT;


if (isset($_GET['alias'])) {
echo<<<EOT
<br /><br /><br /><br /><br />
<form name="delete" action="editdb.php" method="post" onsubmit="">
<input type="hidden" name="user" value="{$current_user}" />
<input type="hidden" name="alias" value="{$_GET[alias]}" />
<input type="submit" name="delete" value="Remove this alias" />
</form>
EOT;
}


print "</body>\n";
print "</html>\n";

?>
