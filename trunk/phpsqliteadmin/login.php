<?php

include_once("login.class.php");

$obj =& new login($_POST['user'], $_POST['pass']);
$obj->SPSQLite("db/phpsla.sqlite");

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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<title>phpSQLiteAdmin - Login (<?=$_SERVER['HTTP_HOST']?>)</title>
	<meta http-equiv="expires" content="0">
	<link href="phpsla.css" rel="stylesheet" type="text/css">
</head>
<body class="right" onload="document.login.user.focus();">

<h1>Welcome to phpSQLiteAdmin</h1>
<p>Version 0.3 running on <em><?=$_SERVER['HTTP_HOST']?></em></p>

<form name="login" method="post" action="<?=$_SERVER['PHP_SELF']?>">
<table>
<tr>
<th>Username:</th>
<td><input type="text" name="user" size="24" maxlength="24"></td>
</tr>
<tr>
<th>Password:</th>
<td><input type="password" name="pass" size="24" maxlength="24">
<?php

if ($obj->isEmpty()) {
	echo "</td></tr>";
//	echo "<tr><th>Password (confirm):</td><td><input type=\"password\" name=\"realname\" size=\"24\" maxlength=\"24\"></td></tr>\n";
	echo "<tr><th>Realname:</td><td><input type=\"text\" name=\"realname\" size=\"24\" maxlength=\"24\"></td></tr>\n";
	echo "<tr><th>Email:</td><td><input type=\"text\" name=\"email\" size=\"24\" maxlength=\"24\">\n";
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
