<?php

require_once('include.php');

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

<a href="editdb.php">Add a new database alias</a>

<h3>Available databases:</h3>
EOT;


print "<table>\n";
print "<tr><th>Alias</th><th>Database file</th><th>Description</th></tr>\n";
$sysdbh->query('select alias,path,description from databases order by alias');
while($row = $sysdbh->fetchArray()) {
	print "<tr><td><a href=\"editdb.php?alias=$row[0]\">$row[0]</a></td><td>$row[1]</td><td>$row[2]</td></tr>\n";
}
print "</table>\n";


print "</body>\n";
print "</html>\n";

?>