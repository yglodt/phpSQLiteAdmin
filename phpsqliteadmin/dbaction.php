<?php

require_once('include.php');


$object = $_GET['object'];
$action = $_GET['action'];


if ($action == 'drop_table') {
    $userdbh->query("drop table '$object'");
    header("Location: index.php");
	exit;
}


if ($action == 'empty_table') {
	$userdbh->query("delete from '$object'");
	header("Location: index.php");
	exit;
}


if ($action == 'drop_index') {
	$userdbh->query("drop index '$object'");
	header("Location: index.php");
	exit;
}


if ($action == 'vacuum') {
	$userdbh->vacuum();
	header("Location: index.php");
	exit;
}


if ($action == 'schema') {
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
</head>
<body class="right">
<div id="currentdb">Database: {$_SESSION['phpSQLiteAdmin_currentdb']}</div>
<p class="sqliteversion">SQLite version: $sqliteversion</p>
<br />
<a href="mainframe.php" target="mainframe">Back</a>\n
EOT;
	print "<h3>Database schema</h3>\n";
	print "<pre>\n";
	$userdbh->query('select sql from sqlite_master');
	while($row = $userdbh->fetchArray()) {
		print $row[0]."\n";
	}
	print "</pre>\n";
	print "</body>\n";
	print "</html>\n";
}


if ($action == 'drop') {
	// system db may not be dropped
	if ($current_db == 'db/phpsla.sqlite') {
        header("Location: index.php");
		exit;
	}

	$alias = new dbalias;
	$alias->user = $current_user;
	$alias->path = $current_db;
	$sysdbh->query("select alias from databases where user = {$alias->user} and path = '{$alias->path}'");
	while($row = $sysdbh->fetchArray()) {
		$alias->alias = $row[0];
	}

	$sysdbh->query("delete from databases where user = {$alias->user} and alias = '{$alias->alias}'");
	unset($userdbh);
	unlink($current_db);
	$_SESSION['phpSQLiteAdmin_currentdb'] = 'db/phpsla.sqlite';
	header("Location: index.php");
	exit;
}


if ($action == '') {
	header("Location: index.php");
	exit;
}


?>