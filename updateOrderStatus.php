<?php
require "connection.php";
$orderId = "#".$_GET["orderId"];
Database::iud("UPDATE `order` SET `order_status_id`=".$_GET["orderStatus"]." WHERE `invoice_order_id`='".$orderId."'");
?>