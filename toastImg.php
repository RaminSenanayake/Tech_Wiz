<?php
require "connection.php";
$pid = $_GET["pid"];
$img_rs = Database::search("SELECT `img_path` FROM `product_img` WHERE `product_product_id`=".$pid."");
$img_data = $img_rs->fetch_assoc();
echo($img_data["img_path"]);
?>