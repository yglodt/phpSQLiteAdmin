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
<body class="left">
<a href="index.php" target="_top">Main</a>
<br />
<a href="dbconfig.php">Alias configuration</a>
<br />
<a href="login.php?logoff=1" target="_top">Logoff</a>
<br />
<br />
EOT;

print "<div class=\"list\">\n";
print "<ul><li class=\"list_title\">Database alias</li>\n";
print "<li>\n";
print_db_selector($current_db);
print "</li></ul>\n";
print "</div>\n";


if (check_db()) {
        print "<div class=\"list\">\n<ul>\n";
        print "<li class=\"list_title\" title=\"Tables in database $current_db\">Tables</li>\n";
	$userdbh->query("select name,upper(name) from SQLITE_MASTER where type = 'table' order by 2");
	while($row = $userdbh->fetchArray()) {
		print "<li><a href=\"table_browse.php?object=".$row[0]."\"><img src=\"images/table_browse.png\" alt=\"Browse\" title=\"Browse table\" /></a> <a href=\"table_structure.php?object=".$row[0]."\">$row[0]</a></li>\n";
	}
	print "</ul>\n</div>\n";
}


print "</body>\n";
print "</html>\n";


?>
