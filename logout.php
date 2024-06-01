<?php
session_start();
if (!isset($_SESSION["user_login"]) && !isset($_SESSION["user_id"])) {
    header("location: login.php");
}

$_SESSION = array();
session_unset();
header("Location: login.php");
exit();
?>