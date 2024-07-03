<?php
session_start();
require "connection.php";
if (isset($_SESSION["customer"])) {
    $customer = $_SESSION["customer"];
}
$pid = $_GET["pid"];
if (isset($_SESSION["customer"])) {
    $wishlist_rs = Database::search("SELECT * FROM `wishlist` WHERE `product_product_id`=" . $pid . " AND `customer_email`='" . $customer["email"] . "'");
    $wishlist_num = $wishlist_rs->num_rows;
    if ($wishlist_num == 1) {
        echo ("Product already exist in wishlist.");
    } else {
        Database::iud("INSERT INTO `wishlist` (`product_product_id`,`customer_email`) VALUES ('" . $pid . "','" . $customer["email"] . "')");
        echo ("Product added to your wishlist.");
    }
} else {
    echo ("Sign in into your account first.");
}
