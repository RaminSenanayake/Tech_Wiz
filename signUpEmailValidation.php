<?php
require "connection.php";

$email = $_POST["email"];

if (empty($email)) {
    echo ("Please enter your email address.");
} elseif (strlen($email) > 45) {
    echo ("Email address must have less than 45 characters.");
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo ("Invalid email address.");
} else {
    $rs = Database::search("SELECT * FROM `customer` WHERE `email`='" . $email . "'");
    $n = $rs->num_rows;

    if ($n > 0) {
        echo ("An user account already exists under this email address.");
    }
}
?>