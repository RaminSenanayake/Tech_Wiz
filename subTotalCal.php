<?php
session_start();
require "connection.php";
Database::iud("UPDATE `cart` SET `qty`=" . $_GET["cartQty"] . " WHERE `product_product_id`=" . $_GET["pid"] . " AND `customer_email`='" . $_SESSION["customer"]["email"] . "'");
$subtotal = $sub = $shippingTot = $tot = 0.0;
$cartTotalItemsNum = 0;
$display_item_price = $display_item_shipping = "";
$cart_items_rs = Database::search("SELECT `price`,`product_product_id`,cart.qty AS `cart_qty`,`shipping` FROM cart INNER JOIN product ON product.product_id=cart.product_product_id INNER JOIN `brand_has_model` ON brand_has_model.id = product.brand_has_model_id WHERE `customer_email`='" . $_SESSION["customer"]["email"] . "'");
$cart_items_num = $cart_items_rs->num_rows;
for ($i = 0; $i < $cart_items_num; $i++) {
    $cart_items_data = $cart_items_rs->fetch_assoc();
    $item_price = $cart_items_data["price"] * $cart_items_data["cart_qty"];
    $shipping = $cart_items_data["shipping"] * $cart_items_data["cart_qty"];
    if ($cart_items_data["product_product_id"] == $_GET["pid"]) {
        $display_item_price = number_format($item_price,2);
        $display_item_shipping = number_format($shipping,2);
    }
    $sub = $sub + $item_price;
    $shippingTot = $shippingTot + $shipping;
    $tot = $sub + $shippingTot;
    $cartTotalItemsNum = $cartTotalItemsNum + $cart_items_data["cart_qty"];
}
$subtotal = number_format($sub,2);
$shippingTotal = number_format($shippingTot,2);
$total = number_format($tot,2);
$cart[0] = $display_item_price;
$cart[1] = $display_item_shipping;
$cart[2] = $subtotal;
$cart[3] = $shippingTotal;
$cart[4] = $total;
$cart[5] = $cartTotalItemsNum;
$cart[6] = $shippingTot;
echo json_encode($cart);
?>