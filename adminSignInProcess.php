<?php
session_start();
require "connection.php";

$email = $_POST["adminEmail"];
$password = $_POST["adminPassword"];

if (empty($email)) {
    echo ("Please enter your email address.");
} elseif (empty($password)) {
    echo ("Please enter your password.");
} else {
    $rs = Database::search("SELECT `admin_email`,`admin_password` FROM `admin` WHERE `admin_email`='" . $email . "' AND `admin_password`='" . $password . "'");

    $n = $rs->num_rows;

    if ($n == 1) {
        $d = $rs->fetch_assoc();
        $_SESSION["admin"] = $d;
        echo ("success");
    } else {
        echo ("Invalid email address or password.");
    }
}
?>