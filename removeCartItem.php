<?php
session_start();
require "connection.php";
Database::iud("DELETE FROM `cart` WHERE `product_product_id`=".$_GET["pid"]." AND `customer_email`='".$_SESSION["customer"]["email"]."'");
$subtotal = $sub = $shippingTot = $tot = 0.0;
$cartTotalItemsNum = 0;
$cart_items_rs = Database::search("SELECT `price`,`product_product_id`,cart.qty AS `cart_qty`,`shipping` FROM `cart` INNER JOIN product ON product.product_id=cart.product_product_id INNER JOIN `brand_has_model` ON brand_has_model.id = product.brand_has_model_id WHERE `customer_email`='" . $_SESSION["customer"]["email"] . "'");
$cart_items_num = $cart_items_rs->num_rows;
if ($cart_items_num >= 1) {
    for ($i = 0; $i < $cart_items_num; $i++) {
        $cart_items_data = $cart_items_rs->fetch_assoc();
        $item_price = $cart_items_data["price"] * $cart_items_data["cart_qty"];
        $shipping = $cart_items_data["shipping"] * $cart_items_data["cart_qty"];
        $sub = $sub + $item_price;
        $shippingTot = $shippingTot + $shipping;
        $tot = $sub + $shippingTot;
        $cartTotalItemsNum = $cartTotalItemsNum + $cart_items_data["cart_qty"];
    }
    $subtotal = number_format($sub,2);
    $shippingTotal = number_format($shippingTot,2);
    $total = number_format($tot,2);
    
    $cart[0] = $subtotal;
    $cart[1] = $shippingTotal;
    $cart[2] = $total;
    $cart[3] = $cartTotalItemsNum;
    $cart[4] = $cart_items_num;
    $cart[5] = $shippingTot;
    echo json_encode($cart);
}else {
    echo("noItems");
}
?>