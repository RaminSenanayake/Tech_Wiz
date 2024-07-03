<?php

require 'vendor/autoload.php';

$pid;
$stripe = new \Stripe\StripeClient('sk_test_51PLUJm04pOx9oXS1RB0IWuuUpWvcYRpkUhgP9ezpAQRUsdEg2AJXX3XYOShxUAq0WZ3te2y65saxTiD5P5ZHlO9q004aSnyd3l');
for ($i = 0; $i < $_POST["numOfItems"]; $i++) {
    $cartitems[$i] = ['price_data' => ['currency' => 'LKR', 'product_data' => ['name' => $_POST["productName" . $i]], 'unit_amount' => $_POST["itemPrice" . $i] * 100], 'quantity' => $_POST["qty" . $i]];
    $pid["pids"][$i] = $_POST["pid" . $i];
    $pid["qty"][$i] = $_POST["qty" . $i];
    $pid["itemPrice"][$i] = $_POST["itemPrice" . $i];
}
$pid["totalShipping"] = $_POST["totalShipping"];
$cartitems[] = [
    'price_data' => [
        'currency' => 'LKR',
        'product_data' => [
            'name' => 'Total shipping',
        ],
        'unit_amount' => intval($_POST["totalShipping"] * 100),
    ],
    'quantity' => 1,
];
if (isset($_POST["cart"])) {
    $cart = $_POST["cart"];
}else{
    $cart = "single";
}
$oid = uniqid();
$pids = serialize($pid);
$checkout_session = $stripe->checkout->sessions->create([
    'line_items' => $cartitems,
    'mode' => 'payment',
    'success_url' => 'http://localhost/tech_wiz/invoice.php?orderId=' . $oid.'&prods='.$pids.'&numOfItems='.$_POST["numOfItems"].'&cart='.$cart."&billingAddId=".$_POST["billingAddId"],
    'cancel_url' => 'http://localhost/tech_wiz/home.php',
]);

header("HTTP/1.1 303 See Other");
header("Location: " . $checkout_session->url);
?>