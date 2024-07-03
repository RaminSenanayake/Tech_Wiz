<?php
session_start();
require "connection.php";

$profilePic = $_FILES["pfp"];
$fileType = $profilePic["type"];

$newFileExtension;

switch ($fileType) {
    case 'image/jpg':
        $newFileExtension = ".jpg";
        break;
    case 'image/jpeg':
        $newFileExtension = ".jpeg";
        break;
    case 'image/png':
        $newFileExtension = ".png";
        break;
    case 'image/svg+xml':
        $newFileExtension = ".svg";
        break;
}

$filePath = "resources/profile_pics/".$_SESSION["customer"]["email"].rand(0000,9999).$newFileExtension;
move_uploaded_file($profilePic["tmp_name"],$filePath);

$rs = Database::search("SELECT * FROM `profile_img` WHERE `customer_email`='".$_SESSION["customer"]["email"]."'");
$num = $rs->num_rows;
if ($num != 1) {
    Database::iud("INSERT INTO `profile_img` (`customer_email`,`path`) VALUES ('".$_SESSION["customer"]["email"]."','".$filePath."')");
} else {
    $data = $rs->fetch_assoc();
    unlink($data["path"]);
    Database::iud("UPDATE `profile_img` SET `path`='".$filePath."' WHERE `customer_email`='".$_SESSION["customer"]["email"]."'");
}
echo("success");
?>