<?php

include_once("login.class.php");

$obj =& new login($_POST['user'], $_POST['pass']);
$obj->SPSQLite("phpsla.sqlite");

if ((isset($_GET['logoff'])) && ($_GET['logoff'] == 1)) {
    $obj->logOff();
}

if (isset($_POST['empty'])) {
    $obj->register($_POST['realname'], $_POST['email']);
} elseif (isset($_POST['notempty'])) {
    if ($obj->checkLogin()) {
        header("Location: index.php");
    }
}

?>
<html>
<head>
<title>phpSQLiteAdmin - Login</title>
</head>
<body>
<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<table>
<tr>
<td>
User:
</td>
<td>
<input type="text" name="user">
</td>
</tr>
<tr>
<td>
Pass:
</td>
<td>
<input type="password" name="pass">
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
<input type="submit" value="login" >
</td>
</tr>
</table>
</form>
</body>
</html>
