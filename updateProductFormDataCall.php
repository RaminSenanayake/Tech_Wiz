<?php
require "connection.php";
$product;
$prod_rs = Database::search("SELECT `product_name`,`colour_name`,`price`,`qty`,`discount` FROM `product` INNER JOIN `colour` ON product.colour_colour_id=colour.colour_id WHERE `product_id`=".$_GET["prodId"]);
$prod_data = $prod_rs->fetch_assoc();
$product["productName"] = $prod_data["product_name"]." - ".$prod_data["colour_name"];
$product["price"] = $prod_data["price"];
$product["qty"] = $prod_data["qty"];
$product["discount"] = $prod_data["discount"];
echo json_encode($product);
?>