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

print "<h3>Table '{$_GET['object']}'</h3>\n";

print "<table border=\"1\">\n";
print "<tr><th>Column</th><th>Type</th></tr>\n";
$userdbh->_setTableInfo($_GET['object']);
$cols = $userdbh->getColsType();
while (list($key,$value) = each($cols)) {
	print "<tr><td>$key</td><td>$value</td></tr>\n";
}
print "</table>\n";

print "<p>Rows in table: ".$userdbh->numRows($_GET['object'])."</p>\n";


print "<h3>Indexes</h3>\n";

$userdbh->getIndexesInfo($_GET['object']);
$indexes = $userdbh->returnRows('assoc', true);

$nr_indexes = count($indexes);

/*
print("<pre>");
print_r($indexes);
print("</pre>");
exit;
*/

if($nr_indexes > 0) {
	print "<table border=\"1\">\n";
	print "<tr><th>Index name</th><th>On field(s)</th></tr>\n";
	foreach($indexes as $row) {
		if(eregi("\((.*)\)", $row['sql'], $fields)) {
			print "<tr><td>".$row['name'].'</td><td>';
			print $fields[1];
			print "</td></tr>\n";
		} else {
			print "<tr><td>".$row['name'].'</td><td>'.$row['sql']."</td></tr>\n";
		}
	}
	print "</table>\n";

} else {

	print "<em>no indexes</em>\n";

}


print "</body>\n";
print "</html>\n";


?>