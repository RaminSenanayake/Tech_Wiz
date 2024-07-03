<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tech Wiz | Home</title>

    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="bootstrap.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" />
    <link rel="icon" href="resources/gadgets.svg" />
</head>

<body>
    <div class="container-fluid">
        <?php
        session_start();
        require "connection.php";
        include "header.php"
        ?>
        <div class="col-12 col-md-10 offset-md-1 min-vh-100" id="bodyContent">
            <div class="row">
                <!-- Carousel -->
                <div id="carouselExampleControls" class="carousel slide carousel-fade mt-3" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <div class="card mb-3 text-bg-dark">
                                <div class="row g-0">
                                    <div class="col-12 col-md-5">
                                        <img src="resources/laptop.jpg" class="img-fluid col-12 rounded-start">
                                    </div>
                                    <div class="col-12 col-md-7">
                                        <div class="card-body">
                                            <h5 class="card-title">Newest laptops</h5>
                                            <p class="card-text">Brand new laptops are available in our store right
                                                now.</p>
                                            <a href="#" class="btn btn-outline-primary">Check
                                                them out</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="card mb-3" style="background-color: rgba(169,201,212,255);">
                                <div class="row g-0">
                                    <div class="col-12 col-md-7">
                                        <div class="card-body text-end">
                                            <h5 class="card-title">All new smartphones</h5>
                                            <p class="card-text">A brand new batch of smartphones just arrived.
                                                Check them out before stocks run out.</p>
                                            <a href="#" class="btn btn-outline-dark">Check them
                                                out</a>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-5 text-end">
                                        <img src="resources/phones.jpg" class="img-fluid col-12 rounded-end">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="card mb-3" style="background-color: rgba(221,188,66,255);">
                                <div class="row g-0">
                                    <div class="row g-0">
                                        <div class="col-12 col-md-7">
                                            <div class="card-body text-start">
                                                <h5 class="card-title">Big mid year sale!</h5>
                                                <p class="card-text">Upto 20% off of selected devices. Limited time
                                                    only.</p>
                                                <a href="#" class="btn btn-outline-success">Shop now</a>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-5 text-end">
                                            <img src="resources/phones1.jpg" class="img-fluid col-12 rounded-end">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
                <!-- End of carousel -->

                <div class="col-12 mt-3">
                    <a class="icon-link icon-link-hover lh-1 tdtitle subtitle" href="#">Today's Deals <i class="bi bi-arrow-right fs-1"></i></a>
                    <div class="row">
                        <div class="col-12 column-gap-5 px-3 d-inline-flex overflow-x-scroll" style="padding-top: 30px; padding-bottom: 20px;">
                            <?php
                            $td_rs = Database::search("SELECT * FROM `product` WHERE `discount`>0 AND `status_status_id`=1 LIMIT 10");
                            $td_num = $td_rs->num_rows;
                            for ($i = 0; $i < $td_num; $i++) {
                                $td_data = $td_rs->fetch_assoc();
                                $td_price = $td_data["price"];
                                $td_discount = $td_data["discount"];
                                $td_actual_price = $td_price + (($td_price * $td_discount) / 100);
                                $td_prod_img_rs = Database::search("SELECT `img_path` FROM `product_img` WHERE `product_product_id`=" . $td_data["product_id"]);
                                $td_prod_img = $td_prod_img_rs->fetch_assoc();
                            ?>
                                <div class="card col-auto productcard shadow" style="height: 400px;">
                                    <img src="<?php echo $td_prod_img["img_path"] ?>" class="card-img-top" height="250">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo $td_data["product_name"] ?></h5>
                                        <p class="card-text"><b>Rs.<?php echo number_format($td_price) ?></b> <small class="text-decoration-line-through">Rs.<?php echo number_format($td_actual_price) ?></small></p>
                                        <a href="<?php echo "product.php?bhm_id=" . ($td_data["brand_has_model_id"]) . "&pid=" . ($td_data["product_id"]) ?>" class="btn btn-outline-primary stretched-link">Buy now</a>
                                        <button class="btn btn-outline-success z-1 position-relative" onclick="addToCart('<?php echo $td_data['product_id'] ?>');"><i class="bi bi-cart2"></i></button>
                                        <button class="btn btn-outline-danger z-1 position-relative" onclick="addToWishlist(<?php echo $td_data['product_id']; ?>);"><i class="bi bi-heart"></i></button>
                                    </div>
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success"><?php echo $td_discount ?>% off</span>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-12 mt-5">
                    <a class="icon-link icon-link-hover lh-1 tdtitle subtitle" href="#">Brand new releases <i class="bi bi-arrow-right fs-1"></i></a>
                    <div class="row">
                        <div class="col-12 column-gap-5 px-3 d-inline-flex overflow-x-scroll" style="padding-top: 30px; padding-bottom: 20px;">
                            <?php
                            $bnl_rs = Database::search("SELECT * FROM `product` WHERE `status_status_id`=1 AND `condition_condition_id`=1 ORDER BY `added_datetime` DESC LIMIT 10");
                            $bnl_num = $bnl_rs->num_rows;
                            for ($x = 0; $x < $bnl_num; $x++) {
                                $bnl_data = $bnl_rs->fetch_assoc();
                                $bnl_price = $bnl_data["price"];
                                $bnl_discount = $bnl_data["discount"];
                                if ($bnl_discount != null) {
                                    $bnl_actual_price = $bnl_price + (($bnl_price * $bnl_discount) / 100);
                                }
                                $bnl_prod_img_rs = Database::search("SELECT `img_path` FROM `product_img` WHERE `product_product_id`=" . $bnl_data["product_id"]);
                                $bnl_prod_img = $bnl_prod_img_rs->fetch_assoc();
                            ?>
                                <div class="card col-auto productcard shadow" style="height: 400px;">
                                    <img src="<?php echo $bnl_prod_img["img_path"] ?>" class="card-img-top" height="250">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo $bnl_data["product_name"] ?></h5>
                                        <p class="card-text"><b>Rs.<?php echo number_format($bnl_price) ?></b>
                                            <?php
                                            if ($bnl_discount != null) {
                                            ?>
                                                <small class="text-decoration-line-through">Rs.<?php echo number_format($bnl_actual_price) ?></small>
                                            <?php
                                            }
                                            ?>
                                        </p>
                                        <a href="<?php echo "product.php?bhm_id=" . ($bnl_data["brand_has_model_id"]) . "&pid=" . ($bnl_data["product_id"]) ?>" class="btn btn-outline-primary stretched-link">Buy now</a>
                                        <button class="btn btn-outline-success z-1 position-relative" onclick="addToCart(<?php echo $bnl_data['product_id']; ?>);"><i class="bi bi-cart2"></i></button>
                                        <button class="btn btn-outline-danger z-1 position-relative" onclick="addToWishlist(<?php echo $bnl_data['product_id']; ?>);"><i class="bi bi-heart"></i></button>
                                    </div>
                                    <?php
                                    if ($bnl_discount != null) {
                                    ?>
                                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success"><?php echo $bnl_discount ?>% off</span>
                                    <?php
                                    }
                                    ?>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-12 my-3">
                    <div class="card text-dark">
                        <img src="resources/cardbackground.jpg" class="card-img shadow-lg">
                        <div class="card-img-overlay">
                            <h5 class="card-title">New? Old? We have it all!</h5>
                            <p class="card-text">From brand new to used devices in mint condition, you can get it all
                                from us to a very low price.</p>
                        </div>
                    </div>
                </div>
                <div class="toast-container position-fixed bottom-0 end-0 p-3" id="hometoastcontainer1">

                </div>
                <div class="toast-container position-fixed bottom-0 end-0 p-3" id="hometoastcontainer2">

                    <div id="addToCartSignIn" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="toast-header">
                            <img src="resources/gadgets.svg" width="20" class="rounded me-2">
                            <strong class="me-auto">Tech Wiz</strong>
                            <small>Just now</small>
                            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                        <div class="toast-body fs-6" id="addToCartSignInText"></div>
                    </div>

                    <div id="addToWishlistSignIn" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="toast-header">
                            <img src="resources/gadgets.svg" width="20" class="rounded me-2">
                            <strong class="me-auto">Tech Wiz</strong>
                            <small>Just now</small>
                            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                        <div class="toast-body fs-6" id="addToWishlistSignInText"></div>
                    </div>

                </div>
            </div>
            <?php include "footer.php" ?>
        </div>

        <script src="script.js"></script>
        <script src="bootstrap.js"></script>
</body>

</html>