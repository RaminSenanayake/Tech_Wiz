<?php
session_start();
require "connection.php";
$customer = $_SESSION["customer"];
$prod_ids = json_decode($_GET["pids"]);
$insertQueries = "";
$deleteQueries = "";
$array["cart_product_added"] = array();
$cart_product_added_num = 0;
$array["cart_already_added"] = array();
$cart_already_added_num = 0;
for ($i=0; $i < $_GET["arrayLength"]; $i++) { 
    $pid = intval($prod_ids[$i]);
    $cart_rs = Database::search("SELECT * FROM `cart` WHERE `product_product_id`=".$pid." AND `customer_email`='".$customer["email"]."'");
    $cart_num = $cart_rs->num_rows;
    if ($cart_num>=1) {
        $array["cart_already_added"][$cart_already_added_num] = $pid;
        $cart_already_added_num++;
    } else {
        $insertQueries .= "INSERT INTO `cart` (`product_product_id`,`customer_email`,`qty`) VALUES (".$pid.",'".$customer["email"]."',1); ";
        $deleteQueries .= "DELETE FROM `wishlist` WHERE `product_product_id`=".$pid." AND `customer_email`='".$customer["email"]."';";
        $array["cart_product_added"][$cart_product_added_num] = $pid;
        $cart_product_added_num++;
    }
}
$queries = $insertQueries . $deleteQueries;
if ($queries != null) {
    Database::iudMultiple($queries);
}
echo json_encode($array);
?>