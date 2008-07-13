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

print_top_links($_GET['object']);

//$sth = sqlite_query($link,"select * from '{$table->name}' limit 30");
//$sth = sqlite_query($link,"select * from '{$table->name}'");

print "<h3>Export Table '".$_GET['object']."'</h3>\n";

// Get table schema
$table_schema = "";
$userdbh->query('select sql from sqlite_master');
while($row = $userdbh->fetchArray()) {
	if (strpos($row[0], "table " .$_GET['object'])) {
		$table_schema = "/*\nTable structure for table '" .$_GET['object']. "'\n*/\n";
		$table_schema .= $row[0]. ";\n\n";
	}
}

// Get columns
$userdbh->query('select * from '.$_GET['object']);

for ($i=0; $i<$userdbh->numFields(); $i++) {
    $column[$i] = $userdbh->fieldName($i);
}
$columns = implode(", ", $column);

// Get row values
while($row = $userdbh->fetchArray()) {
	$nr_fields = count($row);
	/*
	for ($i=0; $i<$nr_fields; $i++) {
		//$value = htmlentities($row[$i],ENT_QUOTES,$encoding);
		$value[$i] = $row[$i];
	}
	print_r($value);
	*/
	$values = implode("', '", $row);
	$values = "'" .$values. "'";
	$queries .= "INSERT INTO " .$_GET['object']. " (" .$columns. ") VALUES
(" .$values. ");\n";
}

$queries = "/*\nSQL data dump for table '" .$_GET['object']. "'\n*/\n" .$queries;

// Generation information
$generated_by = "/*\nphpSQLiteAdmin SQL Export
-- Generated On " .date("D, j M Y H:i:s T"). "
-- SQLite Version " .$sqliteversion. "
-- PHP Version " .$sqliteversion. "\n*/\n\n";
// Show export
print "<textarea name=\"sql\" rows=\"16\" cols=\"80\">" .$generated_by. "" .$table_schema. "" .$queries. "</textarea>";

print "</body>\n";
print "</html>\n";


?>
