<?php

include_once("login.class.php");

$obj =& new login($_POST['user'], $_POST['pass']);
$obj->SPSQLite("phpsla.sqlite");

if ((isset($_GET['logoff'])) && ($_GET['logoff'] == '1')) {
	$obj->logOff();
}

if (isset($_POST['empty'])) {
	$obj->register($_POST['realname'], $_POST['email']);
} elseif (isset($_POST['notempty'])) {
	if ($obj->checkLogin()) {
		header("Location: index.php");
		exit();
	}
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<title>phpSQLiteAdmin - Login</title>
	<meta http-equiv="expires" content="0">
	<link href="phpsla.css" rel="stylesheet" type="text/css">
</head>
<body class="right" onload="document.login.user.focus();">

<h1>phpSQLiteAdmin 0.3</h1>
<p>Running on <em><?=$_SERVER['HTTP_HOST']?></em></p>

<form name="login" method="post" action="<?=$_SERVER['PHP_SELF']?>">
<table>
<tr>
<td>Username:</td>
<td><input type="text" name="user"></td>
</tr>
<tr>
<td>Password:</td>
<td><input type="password" name="pass">
<?php

if ($obj->isEmpty()) {
	echo "</td></tr>";
	echo "<tr><td>Realname:</td><td><input type=\"text\" name=\"realname\"></td></tr>\n";
	echo "<tr><td>Email:</td><td><input type=\"text\" name=\"email\">\n";
	echo "<input type=\"hidden\" name=\"empty\">\n";
} else {
	echo "<input type=\"hidden\" name=\"notempty\">\n";
}

?>
&nbsp;<input type="submit" value="Login">
</td>
</tr>
</table>
</form>
</body>
</html>
