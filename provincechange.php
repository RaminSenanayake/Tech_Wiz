<?php
require "connection.php";
$provId = $_GET["provID"];
$result["districtID"] = array();
$result["districtName"] = array();
$resultset = Database::search("SELECT `district_id`,`district_name` FROM `district` WHERE `province_province_id`=".$provId);
$resultset_num = $resultset->num_rows;
for ($i=0; $i < $resultset_num; $i++) { 
    $resultset_data = $resultset->fetch_assoc();
    $result["districtID"][$i] = $resultset_data["district_id"];
    $result["districtName"][$i] = $resultset_data["district_name"];
}
echo json_encode($result);
?>