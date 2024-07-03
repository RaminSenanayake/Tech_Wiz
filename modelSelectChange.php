<?php
require "connection.php";
$model_rs = Database::search("SELECT * FROM `brand_has_model` INNER JOIN `model` ON brand_has_model.model_model_id = model.model_id 
WHERE `brand_brand_id`=" . $_GET["brandId"]);

$model_num = $model_rs->num_rows;
for ($i = 0; $i < $model_num; $i++) {
    $model_data = $model_rs->fetch_assoc();
    $model["value"][$i] = $model_data["model_id"];
    $model["text"][$i] = $model_data["model_name"];
}
echo json_encode($model);
?>