<?php
if (isset($_GET["search"]) || isset($_GET["cat_id"])) {
    require "connection.php";
    if (isset($_GET["asKeyword"])) {
        $asKeyword = $_GET["asKeyword"];
    }
    if (isset($_GET["asCategory"])) {
        $asCategory = $_GET["asCategory"];
    }
    if (isset($_GET["asBrand"])) {
        $asBrand = $_GET["asBrand"];
    }
    if (isset($_GET["asRating"])) {
        $asRating = $_GET["asRating"];
    }
    if (isset($_GET["asCondition0"])) {
        $asCondition0 = $_GET["asCondition0"];
    }
    if (isset($_GET["asCondition1"])) {
        $asCondition1 = $_GET["asCondition1"];
    }

    if (isset($_GET["mainSearch"])) {
        $mainSearch = $_GET["mainSearch"];
    }
    if (isset($_GET["mainCategory"])) {
        $mainCategory = $_GET["mainCategory"];
    }

    $query = "SELECT DISTINCT(`brand_has_model_id`) FROM `product` ";
    if (isset($_GET["search"])) {
        $searchtype = $_GET["search"];
        if ($searchtype == "basicSearch") {
            if ($mainCategory == 0 && $mainSearch != null) {
                $query .= "INNER JOIN `category` ON product.category_category_id=category.category_id WHERE `product_name` LIKE '%" . $mainSearch . "%' OR `category_name` LIKE '%" . $mainSearch . "%'";
            } elseif ($mainCategory != 0 && $mainSearch == null) {
                $query .= "WHERE `category_category_id`=" . $mainCategory;
            } elseif ($mainCategory != 0 && $mainSearch != null) {
                $query .= "WHERE `product_name` LIKE '%" . $mainSearch . "%' AND `category_category_id`=" . $mainCategory;
            }
        } elseif ($searchtype == "advSearch") {
            $query = "SELECT DISTINCT(`brand_has_model_id`) FROM `product` INNER JOIN `brand_has_model` ON brand_has_model.id=product.brand_has_model_id
            WHERE `product_name` LIKE '%" . $asKeyword . "%' AND `rating`>" . $asRating . " AND ";
            if (isset($_GET["asMinPrice"]) && isset($_GET["asMaxPrice"])) {
                $asMinPrice = floatval($_GET["asMinPrice"]);
                $asMaxPrice = floatval($_GET["asMaxPrice"]);
                $query .= "`price` BETWEEN " . $asMinPrice . " AND " . $asMaxPrice . " AND ";
            }
            if ($asCategory != 0) {
                $query .= "`category_category_id`=" . $asCategory . " AND ";
            }
            if ($asBrand != 0) {
                $query .= "`brand_brand_id` IN (SELECT `brand_id` FROM `brand` WHERE `brand_name`='" . $asBrand . "') AND ";
            }
            if (isset($asCondition0) && !isset($asCondition1)) {
                $query .= "`condition_condition_id`=" . $asCondition0 . "";
            } elseif (!isset($asCondition0) && isset($asCondition1)) {
                $query .= "`condition_condition_id`=" . $asCondition1 . "";
            } else {
                $query .= "`condition_condition_id` IN (" . $asCondition0 . "," . $asCondition1 . ")";
            }
        }
    } elseif (isset($_GET["cat_id"]) && !isset($_GET["bid"])) {
        $query .= "WHERE `category_category_id`=" . $_GET["cat_id"];
    } elseif (isset($_GET["cat_id"]) && isset($_GET["bid"])) {
        $query .= "WHERE `category_category_id`=" . $_GET["cat_id"] . " AND `brand_has_model_id` IN (SELECT `id` FROM `brand_has_model` WHERE `brand_brand_id`=" . $_GET["bid"] . ")";
    }
    $searchResult_rs = Database::search($query);
    $searchResult_num = $searchResult_rs->num_rows;
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tech Wiz | Search</title>

        <link rel="stylesheet" href="style.css" />
        <link rel="stylesheet" href="bootstrap.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" />
        <link rel="icon" href="resources/gadgets.svg" />
    </head>

    <body>
        <div class="container-fluid">
            <?php
            include "header.php";

            if ($searchResult_num >= 1) {

                if (isset($_GET["page"])) {
                    $page_no = $_GET["page"];
                } else {
                    $page_no = 1;
                }

                $results_per_page = 5;
                $num_of_pages = ceil($searchResult_num / $results_per_page);

                $page_results = ($page_no - 1) * $results_per_page;
                $selected_rs = Database::search($query . " LIMIT " . $results_per_page . " OFFSET " . $page_results . " ");
                $selected_num = $selected_rs->num_rows;

            ?>
                <div class="col-12 col-md-10 offset-md-1 justify-content-center min-vh-100" id="bodyContent">
                    <div class="row">
                        <div class="col-12">
                            <?php
                            for ($i = 0; $i < $selected_num; $i++) {
                                $searchResult_data = $selected_rs->fetch_assoc();
                                $bhm_id =  $searchResult_data["brand_has_model_id"];
                                $product_imgs_rs = Database::search("SELECT * FROM product_img WHERE product_product_id IN (SELECT product_id FROM product WHERE brand_has_model_id=" . $bhm_id . ")");
                                $product_imgs_num = $product_imgs_rs->num_rows;
                            ?>
                                <div class="card my-3 searchResultCard">
                                    <div class="row g-0">
                                        <div class="col-12 col-md-5 text-center">
                                            <?php
                                            for ($a = 0; $a < $product_imgs_num; $a++) {
                                                $product_imgs_data = $product_imgs_rs->fetch_assoc();
                                                $product_imgs[$a] = $product_imgs_data["img_path"];
                                                $product_ids[$a] = $product_imgs_data["product_product_id"];
                                            }
                                            ?>
                                            <img src="<?php echo $product_imgs[0]; ?>" id="searchResultimg<?php echo $a ?>" class="img-fluid rounded-start" style="height: 300px;">
                                        </div>
                                        <div class="col-12 col-md-7">
                                            <div class="card-body">
                                                <?php
                                                $product_name_rs = Database::search("SELECT DISTINCT(`product_name`) FROM `product` WHERE `brand_has_model_id`=" . $bhm_id . "");
                                                $product_name_data = $product_name_rs->fetch_assoc();
                                                ?>
                                                <h5 class="card-title display-6"><?php echo $product_name_data["product_name"] ?></h5>
                                                <p class="card-text lh-1">
                                                    <?php
                                                    $rating_rs = Database::search("SELECT `rating` FROM `brand_has_model` WHERE `id`=" . $bhm_id . "");
                                                    $rating_data = $rating_rs->fetch_assoc();
                                                    $rating = $rating_data["rating"];
                                                    $rating_fdigit = floor($rating);
                                                    ?>
                                                    <small class="text-body-secondary">
                                                        <?php
                                                        for ($x = 0; $x < $rating_fdigit; $x++) {
                                                        ?>
                                                            <i class="bi bi-star-fill text-warning"></i>
                                                            <?php
                                                        }
                                                        for ($y = 0; $y < 5 - $rating_fdigit; $y++) {
                                                            if (($rating - $rating_fdigit) - $y > 0) {
                                                            ?>
                                                                <i class="bi bi-star-half text-warning"></i>
                                                            <?php
                                                            } else {
                                                            ?>
                                                                <i class="bi bi-star text-warning"></i>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                        | <?php echo $rating; ?> rating | 45 ratings and reviews
                                                    </small>
                                                </p>
                                                <?php
                                                $condition_rs = Database::search("SELECT DISTINCT(`condition_name`) FROM `product` INNER JOIN `condition` ON product.condition_condition_id=condition.condition_id WHERE `brand_has_model_id`=" . $bhm_id . "");
                                                $condition_num = $condition_rs->num_rows;
                                                for ($b = 0; $b < $condition_num; $b++) {
                                                    $condition_data = $condition_rs->fetch_assoc();
                                                    $condition[$b] = $condition_data["condition_name"];
                                                }
                                                if ($condition_num == 1) {
                                                ?>
                                                    <p class="card-text lh-1 lead fs-4"><?php echo $condition[0] ?></p>
                                                <?php
                                                } else {
                                                ?>
                                                    <p class="card-text lh-1 lead fs-4"><?php echo $condition[0] ?> and <?php echo $condition[1] ?></p>
                                                <?php
                                                }
                                                ?>
                                                <p class="card-text lh-1 lead text-nowrap">Colours:&nbsp;
                                                    <?php
                                                    $colour_rs = Database::search("SELECT `colour_code` FROM `colour` WHERE `colour_id` IN (SELECT `colour_colour_id` FROM `product` WHERE `brand_has_model_id`=" . $bhm_id . ")");
                                                    $colour_num = $colour_rs->num_rows;
                                                    for ($c = 0; $c < $colour_num; $c++) {
                                                        $colour_data = $colour_rs->fetch_assoc();
                                                    ?>
                                                        <span class="colours position-absolute border border-dark-subtle" style="background-color: <?php echo $colour_data["colour_code"] ?>;">
                                                            <span class="visually-hidden">colour</span>
                                                        </span>&emsp;
                                                    <?php
                                                    }
                                                    ?>
                                                </p>
                                                <?php
                                                $minmax_price_discount_rs = Database::search("SELECT MIN(`price`) AS `min_price`,MAX(`price`) AS `max_price`, MAX(`discount`) AS `max_discount` FROM `product` WHERE brand_has_model_id=" . $bhm_id . "");
                                                $minmax_price_discount_data = $minmax_price_discount_rs->fetch_assoc();
                                                if ($minmax_price_discount_data["min_price"] == $minmax_price_discount_data["max_price"]) {
                                                ?>
                                                    <div class="card-text lh-1 h3 mb-md-4">Rs.<?php echo number_format($minmax_price_discount_data["min_price"]); ?></div>
                                                <?php
                                                } else {
                                                ?>
                                                    <div class="card-text lh-1 h3 mb-md-4">Rs.<?php echo number_format($minmax_price_discount_data["min_price"]); ?> <small class="h4">to</small> Rs.<?php echo number_format($minmax_price_discount_data["max_price"]); ?>&ensp;<small class="lead fs-4 text-success">Upto <?php echo ($minmax_price_discount_data["max_discount"]); ?>% off</small></div>
                                                <?php
                                                }

                                                ?>
                                                <a href="<?php echo "product.php?bhm_id=" . $bhm_id . "&pid=" . $product_ids[0] ?>" class="stretched-link btn btn-outline-primary">Buy now</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-center">
                                    <li class="page-item <?php if ($page_no <= 1) { ?>disabled<?php } ?>">
                                        <a class="page-link" href="javascript:void(0)" <?php if ($page_no > 1) { ?>onclick="pagination(<?php echo ($page_no - 1) ?>)" <?php } ?>>Previous</a>
                                    </li>
                                    <?php
                                    for ($p = 1; $p <= $num_of_pages; $p++) {
                                        if ($p == $page_no) {
                                    ?>
                                            <li class="page-item active"><a class="page-link" href="javascript:void(0)" onclick="pagination(<?php echo ($p) ?>)"><?php echo $p ?></a></li>
                                        <?php
                                        } else {
                                        ?>
                                            <li class="page-item"><a class="page-link" href="javascript:void(0)" onclick="pagination(<?php echo ($p) ?>)"><?php echo $p ?></a></li>
                                        <?php
                                        }

                                        ?>
                                    <?php
                                    }
                                    ?>
                                    <li class="page-item <?php if ($page_no >= $num_of_pages) { ?>disabled<?php } ?>">
                                        <a class="page-link" href="javascript:void(0)" <?php if ($page_no < $num_of_pages) { ?>onclick="pagination(<?php echo ($page_no + 1) ?>)" <?php } ?>>Next</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            <?php
            } else {
            ?>
                <div class="col-12 col-md-10 offset-md-1 justify-content-center" id="noResultPage">
                    <div class="row text-center align-content-center" style="min-height: 61vh;">
                        <div class="crashlogo col-12"></div>
                        <p class="subtitle">Oops! No results for searched item.</p>
                    </div>
                </div>
            <?php
            }
            ?>
            <?php include "footer.php" ?>
        </div>
        <script src="script.js"></script>
        <script src="bootstrap.js"></script>
    </body>

    </html>
<?php
} else {
?>
    <script>
        window.location = "home.php"
    </script>
<?php
}
?>