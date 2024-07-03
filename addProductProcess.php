<?php
require "connection.php";
$length = sizeof($_FILES);
if ($length == 0) {
    echo ("Please input product images.");
} else {

    $productName = ucfirst($_POST["productName"]);

    if ($_POST["category"] == "Other") {
        Database::iud("INSERT INTO `category` (`category_name`) VALUES ('" . ucwords($_POST["categoryText"]) . "')");
        $categoryId = Database::$connection->insert_id;
    } else {
        $categoryId = $_POST["category"];
    }

    if ($_POST["brand"] == "Other") {
        Database::iud("INSERT INTO `brand` (`brand_name`) VALUES ('" . ucwords($_POST["brandText"]) . "')");
        $brandId = Database::$connection->insert_id;
        Database::iud("INSERT INTO `category_has_brand` (`category_category_id`,`brand_brand_id`) VALUES ('" . $categoryId . "','" . $brandId . "')");
    } else {
        $brandId = $_POST["brand"];
    }

    if ($_POST["model"] == "Other") {
        Database::iud("INSERT INTO `model` (`model_name`) VALUES ('" . ucwords($_POST["modelText"]) . "')");
        $modelId = Database::$connection->insert_id;
    } else {
        $modelId = $_POST["model"];
    }

    $bhm_rs = Database::search("SELECT * FROM `brand_has_model` WHERE `brand_brand_id`=" . $brandId . " AND `model_model_id`=" . $modelId);
    $bhm_num = $bhm_rs->num_rows;
    $description = '';
    for ($a = 0; $a < $_POST["numOfDescriptions"]; $a++) {
        $description .= '<dt class="col-3">' . ucwords($_POST["spec" . $a]) . '</dt><dd class="col-9">' . $_POST["spec" . $a . "Text"] . '</dd>';
    }
    if ($bhm_num > 0) {
        $bhm_data = $bhm_rs->fetch_assoc();
        $bhm_id = $bhm_data["id"];
        Database::iud("UPDATE `brand_has_model` SET `description`='" . $description . "', `shipping`=" . floatval($_POST["shipping"]) . " WHERE `id`=" . $bhm_id);
    } else {
        Database::iud("INSERT INTO `brand_has_model` (`brand_brand_id`,`model_model_id`,`description`,`shipping`) VALUES (" . $brandId . "," . $modelId . ",'" . $description . "'," . floatval($_POST["shipping"]) . ")");
        $bhm_id = Database::$connection->insert_id;
    }

    for ($i = 0; $i < $_POST["numOfProducts"]; $i++) {
        if ($_POST["colorSelect" . $i] == "Other") {
            Database::iud("INSERT INTO `colour` (`colour_name`,`colour_code`) VALUES ('" . $_POST["colourCode" . $i] . "','" . $_POST["colourName" . $i] . "')");
            $colour_id = Database::$connection->insert_id;
        } else {
            $colour_id = $_POST["colorSelect" . $i];
        }
        $status = 1;

        $d = new DateTime();
        $tz = new DateTimeZone("Asia/Colombo");
        $d->setTimezone($tz);
        $date = $d->format("Y-m-d H:i:s");

        if ($_POST["disc" . $i] == 0) {
            $discount = 'NULL';
        } else {
            $discount = $_POST["disc" . $i];
        }
        

        Database::iud("INSERT INTO `product` (`product_name`,`qty`,`price`,`discount`,`category_category_id`,`brand_has_model_id`,`added_datetime`,`colour_colour_id`,`status_status_id`,`condition_condition_id`) VALUES 
            ('" . $productName . "'," . $_POST["qty" . $i] . "," . floatval($_POST["price" . $i]) . "," . $discount . "," . $categoryId . "," . $bhm_id . ",'" . $date . "'," . $colour_id . "," . $status . "," . $_POST["conditionSelect" . $i] . ")");
        $pid = Database::$connection->insert_id;


        if ($length <= 4 && $length > 0) {
            $allowed_img_extentions = array("image/jpg", "image/jpeg", "image/png", "image/svg+xml", "image/webp");

            if ($_POST["numOfProducts"] == 1) {

                for ($x = 0; $x < $length; $x++) {
                    if (isset($_FILES["img" . $x])) {

                        $img_file = $_FILES["img" . $x];
                        $file_extension = $img_file["type"];

                        if (in_array($file_extension, $allowed_img_extentions)) {

                            $new_img_extension = "";

                            if ($file_extension == "image/jpg") {
                                $new_img_extension = ".jpg";
                            } elseif ($file_extension == "image/jpeg") {
                                $new_img_extension = ".jpeg";
                            } elseif ($file_extension == "image/png") {
                                $new_img_extension = ".png";
                            } elseif ($file_extension == "image/svg+xml") {
                                $new_img_extension = ".svg";
                            } elseif ($file_extension == "image/webp") {
                                $new_img_extension = ".webp";
                            }

                            $file_name = "resources/products/" . $productName . $x . $new_img_extension;
                            move_uploaded_file($img_file["tmp_name"], $file_name);

                            Database::iud("INSERT INTO `product_img`(`img_path`,`product_product_id`) VALUES ('" . $file_name . "','" . $pid . "')");
                        } else {
                            echo ("Not an allowed image type");
                        }
                    }
                }
            } else {
                if (isset($_FILES["img" . $i])) {
                    $img_file = $_FILES["img" . $i];
                    $file_extension = $img_file["type"];

                    if (in_array($file_extension, $allowed_img_extentions)) {

                        $new_img_extension = "";

                        if ($file_extension == "image/jpg") {
                            $new_img_extension = ".jpg";
                        } elseif ($file_extension == "image/jpeg") {
                            $new_img_extension = ".jpeg";
                        } elseif ($file_extension == "image/png") {
                            $new_img_extension = ".png";
                        } elseif ($file_extension == "image/svg+xml") {
                            $new_img_extension = ".svg";
                        } elseif ($file_extension == "image/webp") {
                            $new_img_extension = ".webp";
                        }

                        $file_name = "resources/products/" . $productName . $i . $new_img_extension;
                        move_uploaded_file($img_file["tmp_name"], $file_name);

                        Database::iud("INSERT INTO `product_img`(`img_path`,`product_product_id`) VALUES ('" . $file_name . "','" . $pid . "')");
                    } else {
                        echo ("Not an allowed image type");
                    }
                }
            }
        } else {
            echo ("Invalid Image Count");
        }
    }
    echo ("success");
}
?>