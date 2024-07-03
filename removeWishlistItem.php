<?php
session_start();
require "connection.php";
Database::iud("DELETE FROM `wishlist` WHERE `product_product_id`=".$_GET["pid"]." AND `customer_email`='".$_SESSION["customer"]["email"]."'");
$wishlist_items_rs = Database::search("SELECT `product_product_id` FROM `wishlist` WHERE `customer_email`='" . $_SESSION["customer"]["email"] . "'");
$wishlist_items_num = $wishlist_items_rs->num_rows;
if ($wishlist_items_num < 1) {
    echo("noItems");
}
?>