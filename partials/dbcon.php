<?php
$con = mysqli_connect("localhost", "root", "", "chitkit");
if (!$con) {
    die("Database connection was unsuccessful! Error: " . mysqli_connect_error());
}
?>