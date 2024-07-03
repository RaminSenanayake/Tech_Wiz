<?php
require "connection.php";
$rs = Database::search("SELECT * FROM `address` INNER JOIN `district` ON address.district_district_id=district.district_id INNER JOIN `province` ON district.province_province_id=province.province_id WHERE `address_id`=".$_GET["adId"]);
$data = $rs->fetch_assoc();
echo json_encode($data);
?>