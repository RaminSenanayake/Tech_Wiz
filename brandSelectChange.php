<?php
require "connection.php";
if ($_GET["catId"]=="Other") {
    $brand_rs = Database::search("SELECT DISTINCT(`brand_id`),`brand_name` FROM `category_has_brand` INNER JOIN `brand` ON category_has_brand.brand_brand_id = brand.brand_id");
} else {
    $brand_rs = Database::search("SELECT * FROM `category_has_brand` INNER JOIN `brand` ON category_has_brand.brand_brand_id = brand.brand_id 
    WHERE `category_category_id`=".$_GET["catId"]);
}

$brand_num = $brand_rs->num_rows;
for ($i=0; $i < $brand_num; $i++) { 
    $brand_data = $brand_rs->fetch_assoc();
    $brand["value"][$i] = $brand_data["brand_id"];
    $brand["text"][$i] = $brand_data["brand_name"];
}
echo json_encode($brand);
?>