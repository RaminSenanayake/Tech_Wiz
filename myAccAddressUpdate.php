<?php
session_start();
require "connection.php";
$email = $_SESSION["customer"]["email"];
$fullName = ucwords($_POST["myAccAddFullName"]);
$line1 = ucwords($_POST["myAccAddline1"]);
if ($_POST["myAccAddline2"] != null) {
    $line2 = ucwords($_POST["myAccAddline2"]);
} else {
    $line2 = null;
}

$city = ucwords($_POST["myAccCity"]);
$addressType = ucwords($_POST["myAccAddressInlineRadioOptions"]);

if ($_POST["myAccAddressID"] == "new") {
    Database::iud("INSERT INTO `address` (`customer_email`,`full_name`,`line_1`,`line_2`,`city`,`zipcode`,`address_type`,`district_district_id`) VALUES ('" . $email . "','" . $fullName . "','" . $line1 . "','" . $line2 . "','" . $city . "','" . $_POST["myAccAddZipcode"] . "','" . $addressType . "'," . $_POST["myAccAddDistrict"] . ")");
    echo ("Successfully added new address.");
} else {
    Database::iud("UPDATE `address` SET `full_name`='" . $fullName . "', `line_1`='" . $line1 . "', `line_2`='" . $line2 . "', `city`='" . $city . "', `zipcode`='" . $_POST["myAccAddZipcode"] . "', `address_type`='" . $addressType . "', `district_district_id`=" . $_POST["myAccAddDistrict"] . " WHERE `customer_email`='" . $email . "' AND `address_id`=" . $_POST["myAccAddressID"]);
    echo ("Updated address.");
}
