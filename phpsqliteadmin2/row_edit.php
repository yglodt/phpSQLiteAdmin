<?php

require_once('include.php');

// Query (form submitted) portion
if ($_POST['type'] == "edit") {

	if (!$_GET['primary_key']) {
		print "Table needs a primary key identifier.";
		exit();
	}

	//print "<h3>Edit Row</h3>";

	foreach (array_keys($_POST) as $column) {
		// Only do columns, not $_POST['type'] and so on...
		if (strstr($column, "column__") !== false) {
			$columns .= ", " .str_replace("column__", "", $column). " = '" .$_POST[$column]. "'";
		}
		//echo $column. "<br>";

	}
	// Clean up columns:
	$columns = "randomkeytoberemoved" .$columns;
	$columns = str_replace("randomkeytoberemoved, ", "", $columns);
	//print $columns;
	
	$userdbh->query("UPDATE " .$_POST['object']. " SET " .$columns. " WHERE " .$_POST['primary_key']. " = '" .$_POST['row']. "'");
	$_SESSION['phpSQLiteAdmin_currentdb'] = '';
	header("Location: table_browse.php?object=" .$_POST['object']. "");
	exit();

} else if ($_POST['type'] == "add") {

	//print "<h3>Add Row</h3>";

	foreach (array_keys($_POST) as $column) {
		// Only do columns, not $_POST['type'] and so on...
		if (strstr($column, "column__") !== false) {
			$columns .= str_replace("column__", "", $column). ", ";
			$values .= "'" .$_POST[$column]. "', ";
		}
		//echo $column. "<br>";

	}
	// Clean up columns/values:
	$columns = $columns. "randomkeytoberemoved";
	$columns = str_replace(", randomkeytoberemoved", "", $columns);
	$values = $values. "randomkeytoberemoved";
	$values = str_replace(", randomkeytoberemoved", "", $values);
	//print $columns. "<br>";
	//print $values;
	
	$userdbh->query("INSERT INTO " .$_POST['object']. "(" .$columns. ") VALUES(" .$values. ")");
	header("Location: table_browse.php?object=" .$_POST['object']. "");
	exit();

}
if ($_GET['type'] == "delete") {
	if (!$_GET['primary_key']) {
		print "Table needs a primary key identifier.";
		exit();
	}

	$userdbh->query("delete from ".$_GET['object']. " where " .$_GET['primary_key']. " = '" .$_GET['row']. "'");
	header("Location: table_browse.php?object=" .$_GET['object']. "");
	exit();
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<title>phpSQLiteAdmin</title>
	<meta http-equiv="expires" content="0">
	<script language="Javascript" src="javascript.txt" type="text/javascript"></script>
	<link href="phpsla.css" rel="stylesheet" type="text/css">
</head>
<body class="right">
<?php

print_top_links($_GET['object']);

// Show main content: add or edit a row form.
if (!$_GET['row']) {
	$type = "add";
} else {
	$type = "edit";
}

if (!$_GET['object']) {
	print "Error: No table selected.";
}

if ($type == "edit") {
	print "<h3>Edit Row from Table '{$_GET['object']}'</h3>\n";
} else {
	print "<h3>Add Row to Table '{$_GET['object']}'</h3>\n";
}

print "<form action=\"row_edit.php\" method=\"post\">";
print "<table border=\"1\">\n";
print "<tr><th>Column</th><th>Type</th><th>Value</th></tr>\n";
$userdbh->_setTableInfo($_GET['object']);
$cols = $userdbh->getColsType();
$k = 0;
while (list($key,$value) = each($cols)) {
	$col_name[$k] = $key;
	$col_value[$k] = strtolower($value);
	
	// Clean up col_value to only display databtype.
	if ($col_value[$k] == "") { $col_value[$k] = "typeless"; }
	//if (strpos(strtolower(" " .$col_value[$k]. " "), "text")) { $col_value[$k] = "text"; }
	$col_value[$k] = str_replace("not null", "", $col_value[$k]);
	$col_value[$k] = str_replace("null", "", $col_value[$k]);
	$col_value[$k] = str_replace("primary key", "", $col_value[$k]);
	$col_value[$k] = str_replace("default", "", $col_value[$k]);
	$col_value[$k] = preg_replace("/\'[^>]*\'/iU", "", $col_value[$k]);
	$col_value[$k] = preg_replace("/\"[^>]*\"/iU", "", $col_value[$k]);
	
	$k++;
}

if ($type == "edit") {
	$userdbh->query("select * from ".$_GET['object']. " where " .$_GET['primary_key']. " = '" .$_GET['row']. "'");
	//$userdbh->query('select * from '.$_GET['object']);
	while($row = $userdbh->fetchArray()) {
		$nr_fields = count($row);
		for ($i=0; $i<$nr_fields; $i++) {
		print "<tr>\n";
		print "<td>" .$col_name[$i]. "</td>\n";
		print "<td>" .$col_value[$i]. "</td>\n";
		if (strpos(" " .$col_value[$i]. " ", "text")) {
			print "<td><textarea name=\"column__" .$col_name[$i]. "\">" .$row[$i]. "</textarea></td>\n";
		} else {
			print "<td><input type=\"text\" name=\"column__" .$col_name[$i]. "\" value=\"" .$row[$i]. "\" /></td>\n";
		}
		print "</tr>\n";
		}
	}
} else {
	$nr_fields = count($col_name);
	for ($i=0; $i<$nr_fields; $i++) {
		print "<tr>\n";
		print "<td>" .$col_name[$i]. "</td>\n";
		print "<td>" .$col_value[$i]. "</td>\n";
		if (strpos(" " .$col_value[$i]. " ", "text")) {
			print "<td><textarea name=\"column__" .$col_name[$i]. "\"></textarea></td>\n";
		} else {
			print "<td><input type=\"text\" name=\"column__" .$col_name[$i]. "\" value=\"\" /></td>\n";
		}
		print "</tr>\n";
	}
}
print "<tr>\n<th></th>\n<th></th>\n<th>";
print "<input type=\"hidden\" name=\"row\" value=\"" .$_GET['row']. "\" />\n";
print "<input type=\"hidden\" name=\"primary_key\" value=\"" .$_GET['primary_key']. "\" />\n";
print "<input type=\"hidden\" name=\"object\" value=\"" .$_GET['object']. "\" />\n";
print "<input type=\"hidden\" name=\"type\" value=\"" .$type. "\" />\n";
print "<input type=\"submit\" name=\"\" value=\"Save\" />\n";
print "<input type=button value=\"Cancel\" onclick=\"history.back();\">";
print "</th>\n</table>\n";
print "</form>";

/*
print "<table border=1>\n";
print "<tr><th>Column</th><th>Type</th></tr>\n";
$userdbh->_setTableInfo($_GET['object']);
$cols = $userdbh->getColsType();
while (list($key,$value) = each($cols)) {
	print "<tr><td>$key</td><td>$value</td></tr>\n";
}
print "</table>\n";

print "<p>Rows in table: ".$userdbh->numRows($_GET['object'])."</p>\n";
*/

print "</body>\n";
print "</html>\n";


?>
