<?php

require_once("login.class.php");

$obj =& new login($_SESSION['user'], $_SESSION['pass']);
$obj->SPSQLite("db/phpsla.sqlite");

if (!$obj->isLogged()) {
    header("Location: login.php");
}

?>