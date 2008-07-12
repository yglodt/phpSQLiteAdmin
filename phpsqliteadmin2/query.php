<?php

require_once('include.php');

?>
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
<?php

if ($_POST['object'] != '') $current_table = $_POST['object'];
if ($_GET['object'] != '') $current_table = $_GET['object'];

//$table = new table($current_table);
print_top_links($current_table);

if ($_POST['sql'] != '') {
	if (get_magic_quotes_gpc()) {
		$_POST['sql'] = stripslashes($_POST['sql']);
	}
	$show = trim($_POST['sql']);
} else {
	$show = "select * from $current_table";
}

print "<h3>SQL Query</h3>\n";

?>

<form name="query" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<input type="hidden" name="object" value="<?php echo $current_table; ?>" />
<textarea name="sql" rows="8" cols="80">
<?php echo $show; ?>
</textarea><br />
<input type="checkbox" name="multiquery" value="1"> Execute multiple queries (for non SELECT queries).<br />
<input type="submit" name="submit" value="Execute SQL" />
</form>

<?php

if ($_POST['sql'] != '') {
	print "<br /><table>\n";
	if (get_magic_quotes_gpc()) {
		$_POST['sql'] = stripslashes($_POST['sql']);
	}
	//$_POST['sql'] = sqlite_escape_string($_POST['sql']);
	// Note: The query will return funky errors if a row by a certain id exists, or a table already exists, and so on...
	if ($_POST['multiquery'] == "1") {
		// (Procedural sqlite_exec function called because I'm too lazy to edit the sqlite class.)
		$result = sqlite_exec($userdbh->_conn, trim($_POST['sql']));
		$rows_affected = sqlite_changes($userdbh->_conn);
		if ($rows_affected != 0) {
			print $rows_affected. " rows affected.";
		}
	} else {
		$userdbh->query(trim($_POST['sql']));
		$rows_affected = $userdbh->affectedRows();
		if ($rows_affected != 0) {
			print $rows_affected. " rows affected.";
		} else {
			print $userdbh->numRows(). " rows returned.";
		}
	}
	while($row = $userdbh->fetchArray()) {
		$nr_fields = count($row);
		print "<tr>\n";
		for ($i=0; $i<$nr_fields; $i++) {
			if (strlen($row[$i]) > 50) {
				print '<td>'.substr(htmlentities($row[$i],ENT_QUOTES,$encoding),0,50)."...</td>\n";
			} else {
				print "<td>".htmlentities($row[$i],ENT_QUOTES,$encoding)."</td>\n";
			}
		}
		print "</tr>\n";
	}
	print "</table>\n";
}


print "</body>\n";
print "</html>\n";


?>
