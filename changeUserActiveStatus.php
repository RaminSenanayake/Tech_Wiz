<?php
require "connection.php";
Database::iud("UPDATE `customer` SET `customer_active_status_id`=".$_POST["activeId"]." WHERE `email`='".$_POST["user_email"]."'");
?>