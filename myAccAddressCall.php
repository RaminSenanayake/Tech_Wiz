<?php
session_start();
require "connection.php";
$addressId = $_GET["addId"];
$results = array();

if ($_GET["editStatus"] == 1) {
    $search = Database::search("SELECT * FROM `address` INNER JOIN `district` ON address.district_district_id=district.district_id WHERE `customer_email`='" . $_SESSION["customer"]["email"] . "' AND `address_id`=" . $addressId);
    $resultset = $search->fetch_assoc();

    $results["full_name"] = $resultset["full_name"];
    $results["line1"] = $resultset["line_1"];
    $results["line2"] = $resultset["line_2"];
    $results["city"] = $resultset["city"];
    $results["zipcode"] = $resultset["zipcode"];
    $results["address_type"] = $resultset["address_type"];
    $results["districtId"] = $resultset["district_district_id"];
    $results["provinceId"] = $resultset["province_province_id"];

    echo json_encode($results);
} elseif ($_GET["editStatus"] == 2) {
    Database::iud("DELETE FROM `address` WHERE `customer_email`='" . $_SESSION["customer"]["email"] . "' AND `address_id`=" . $addressId);
    echo ("Address deleted.");
}
?>