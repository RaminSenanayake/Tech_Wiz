<?php
require "connection.php";

if ($_POST["discount"] == 0) {
    $discount = 'NULL';
} else {
    $discount = $_POST["discount"];
}

Database::iud("UPDATE `product` SET `price`=".$_POST["unitPrice"].", `qty`=".$_POST["qty"].",`discount`=".$discount." WHERE `product_id`=".$_POST["product_id"]);
echo("success");

?>