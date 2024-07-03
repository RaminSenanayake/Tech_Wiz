<?php

require "connection.php";

$fpemail = $_POST["fpemail"];
$np = $_POST["newPassword"];

$rs = Database::search("SELECT * FROM `customer` WHERE `email`='".$fpemail."'");
$n = $rs->num_rows;

if ($n == 1) {
    Database::iud("UPDATE `customer` SET `password`='".$np."' WHERE `email`='".$fpemail."'");

    echo("success");
}else{
    echo("something went wrong");
}

?>