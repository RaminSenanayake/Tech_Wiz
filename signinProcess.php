<?php

session_start();
require "connection.php";

$email = $_POST["e"];
$password = $_POST["p"];
$rememberme = $_POST["r"];

if (empty($email)) {
    echo ("Please enter your email address.");
} elseif (empty($password)) {
    echo ("Please enter your password.");
} else {

    $rs = Database::search("SELECT * FROM `customer` WHERE `email`='" . $email . "' AND `password`='" . $password . "'");

    $n = $rs->num_rows;

    if ($n == 1) {
        $d = $rs->fetch_assoc();
        if ($d["customer_active_status_id"] == 1) {
            echo ("success");
            $_SESSION["customer"] = $d;

            if ($rememberme == "true") {
                setcookie("email", $email, time() + (60 * 60 * 24 * 30));
                setcookie("password", $password, time() + (60 * 60 * 24 * 30));
            } else {
                setcookie("email", "", -1);
                setcookie("password", "", -1);
            }
        } else {
            echo("This user is inactive");
        }
    } else {
        echo ("Invalid email address or password.");
    }
}
