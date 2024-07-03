<?php
session_start();
require "connection.php";
if (isset($_SESSION["customer"])) {
    $customer = $_SESSION["customer"];
}
$pid = $_GET["pid"];
if (isset($_SESSION["customer"])) {
    $cart_rs = Database::search("SELECT * FROM `cart` WHERE `product_product_id`=".$pid." AND `customer_email`='".$customer["email"]."'");
    $cart_num = $cart_rs->num_rows;
    if ($cart_num == 1) {
        echo("Product already exist in cart");
    } else {
        if (isset($_GET["qty"])) {
            $qty = $_GET["qty"];
            Database::iud("INSERT INTO `cart` (`product_product_id`,`customer_email`,`qty`) VALUES (".$pid.",'".$customer["email"]."',".$qty.")");
        } else {
            Database::iud("INSERT INTO `cart` (`product_product_id`,`customer_email`,`qty`) VALUES ('".$pid."','".$customer["email"]."',1)");
        }
        echo("Product added to your shopping cart.");
    }
} else {
    echo("Sign in into your account first.");
}

?>