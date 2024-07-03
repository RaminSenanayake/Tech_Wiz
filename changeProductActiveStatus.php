<?php
require "connection.php";
Database::iud("UPDATE `product` SET `status_status_id`=".$_POST["activeId"]." WHERE `product_id`=".$_POST["prodId"]);
?>