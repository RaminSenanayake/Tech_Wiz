<?php
require "connection.php";

$fname = ucfirst($_POST["fname"]);
$lname = ucfirst($_POST["lname"]);
$email = $_POST["email"];
$password1 = $_POST["password1"];
$password2 = $_POST["password2"];
$mobile = $_POST["mobile"];
$gender = $_POST["gender"];

if (empty($fname)) {
    echo ("Please enter your first name.");
} elseif (strlen($fname) > 20) {
    echo ("First name must have less than 20 characters.");
} elseif (empty($lname)) {
    echo ("Please enter your last name.");
} elseif (strlen($lname) > 20) {
    echo ("Last name must have less than 20 characters.");
} elseif (empty($email)) {
    echo ("Please enter your email address.");
} elseif (strlen($email) > 45) {
    echo ("Email address must have less than 45 characters.");
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo ("Invalid email address.");
} elseif (empty($password1)) {
    echo ("Please enter your password.");
} elseif (strlen($password1) < 5 || strlen($password1) > 20) {
    echo ("Password length must be between 5 - 20 characters.");
} elseif (empty($password2)) {
    echo ("Please re-enter your password to confirm.");
} elseif ($password2 != $password1) {
    echo ("Password does not match.");
} elseif (empty($mobile)) {
    echo ("Please enter your mobile number.");
} elseif (strlen($mobile) != 10 || !preg_match("/07[0,1,2,4,5,6,7,8][0-9]/", $mobile)) {
    echo ("Invalid Mobile Number.");
} elseif ($gender == 0) {
    echo ("Please select your gender");
} else {
    $rs = Database::search("SELECT * FROM `customer` WHERE `email`='" . $email . "'");
    $n = $rs->num_rows;

    if ($n > 0) {
        echo ("An user account already exists under this email address.");
    } else {
        $d = new DateTime();
        $tz = new DateTimeZone("Asia/Colombo");
        $d->setTimezone($tz);
        $date = $d->format("Y-m-d H:i:s");

        Database::iud("INSERT INTO `customer` (`fname`,`lname`,`email`,`password`,`mobile`,`gender_gender_id`,`joined_datetime`,`customer_active_status_id`) 
        VALUES ('" . $fname . "','" . $lname . "','" . $email . "','" . $password1 . "','" . $mobile . "','" . $gender . "','" . $date . "',1)");

        echo ("success");
    }
}
?>