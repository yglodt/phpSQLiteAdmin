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

print "<h3>Table '".$_GET['object']."'</h3>\n";
print "<table>\n";

$userdbh->query('select * from '.$_GET['object']);

print "<tr>\n";

for ($i=0; $i<$userdbh->numFields(); $i++) {
    print "<th>" . $userdbh->fieldName($i)  . "</th>\n";
}

print "</tr>\n";

while($row = $userdbh->fetchArray()) {
	$nr_fields = count($row);
	//$rows = $userdbh->returnRows('num');
	//$table->print_header();
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


print "</body>\n";
print "</html>\n";


?>