<?php

include_once("check_login.php");
require_once('include.php');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
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

<frameset cols="150,*">
<!--
<frame src="leftframe.php?<?=SID?>" name="tablelist" scrolling="auto" />
<frame src="mainframe.php?<?=SID?>" name="mainframe" scrolling="auto" />
-->
<frame src="leftframe.php" name="tablelist" scrolling="auto" />
<frame src="mainframe.php" name="mainframe" scrolling="auto" />
</frameset>

</html>
