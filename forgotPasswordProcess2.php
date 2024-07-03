<?php

require "connection.php";

$fpemail = $_POST["fpemail"];
$verificationCode = $_POST["vcode"];

$rs = Database::search("SELECT * FROM `customer` WHERE `email`='" . $fpemail . "'");
$d = $rs->fetch_assoc();

if ($verificationCode == $d["verification_code"]) {
    Database::iud("UPDATE `customer` SET `verification_code`= NULL WHERE `email`='" . $fpemail . "'");
    echo ("correct verification code");
} else {
    echo ("incorrect verification code");
}
?>