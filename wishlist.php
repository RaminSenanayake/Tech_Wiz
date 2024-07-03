<?php
session_start();
require "connection.php";

if (isset($_SESSION["customer"])) {
    $wishlist_rs = Database::search("SELECT `product_id`,`product_name`,`colour_name`,`condition_name`,`brand_has_model_id`,`qty`,`discount` FROM `wishlist` 
    INNER JOIN `product` ON wishlist.product_product_id=product.product_id INNER JOIN `colour` ON colour.colour_id=product.colour_colour_id 
    INNER JOIN `condition` ON `condition`.condition_id=product.condition_condition_id WHERE `customer_email`='" . $_SESSION["customer"]["email"] . "'");
    $wishlist_num = $wishlist_rs->num_rows;

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tech Wiz | Wishlist</title>

        <link rel="stylesheet" href="style.css" />
        <link rel="stylesheet" href="bootstrap.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" />
        <link rel="icon" href="resources/gadgets.svg" />
    </head>

    <body>
        <div class="container-fluid">
            <?php
            include "header.php";
            ?>
            <div class="col-12 col-md-10 offset-md-1" style="min-height: 60vh;" id="bodyContent">
                <div class="row">
                    <div class="vertical-menu col-12 mt-4 text-nowrap" id="menulist" onmouseenter="menuwidthup();" onmouseleave="menuwidthdown();">
                        <div class="row">
                            <a href="myAccount.php" class="col-6 col-sm-auto"><i class="bi bi-person"></i>&emsp;My account</a>
                            <a href="#" class="active col-6 col-sm-auto"><i class="bi bi-heart"></i>&emsp;Wishlist</a>
                            <a href="orderSummary.php" class="col-6 col-sm-auto"><i class="bi bi-clipboard2-data"></i>&emsp;Summary</a>
                        </div>
                    </div>
                    <div id="mainBodyContent" class="mainBodyContent">
                        <?php
                        if ($wishlist_num >= 1) {
                        ?>
                            <div class="form-check form-check-inline col-12 mt-3 wishlistProductSelectAllCheckContainer fs-2 lead position-relative">
                                <div class="row column-gap-1">
                                    <div class="col-auto">
                                        <input class="form-check-input border border-dark-subtle" type="checkbox" id="wishlistSelectAllCheck" oninput="wishlistSelectAllCheckFunction(this);wishlistBtnRemoveDisability();">
                                        <label class="form-check-label" for="wishlistSelectAllCheck">
                                            Select all
                                        </label>
                                    </div>
                                    <button class="btn btn-outline-primary col-auto rounded-0" id="wlAddToCheckoutBtn" disabled onclick="addToCartFromWishlist();">Add to checkout</button>
                                    <button class="btn btn-outline-secondary col-auto rounded-0" id="removeFromWishlistBtn" disabled onclick="removeMultipleWishlistItems();">Remove from wishlist</button>
                                </div>
                            </div>
                            <?php
                            for ($i = 0; $i < $wishlist_num; $i++) {
                                $wishlist_data = $wishlist_rs->fetch_assoc();
                                $prodImg_rs = Database::search("SELECT * FROM `product_img` WHERE `product_product_id`=" . $wishlist_data["product_id"]);
                                $prodImg = $prodImg_rs->fetch_assoc();
                            ?>
                                <div class="card my-3 searchResultCard" id="wishlistItemCard<?php echo $wishlist_data["product_id"]; ?>">
                                    <div class="form-check h2 wishlistProductSelectCheck position-absolute">
                                        <input class="form-check-input position-relative z-1 border border-dark-subtle wlSelectChecks" type="checkbox" id="<?php echo $wishlist_data["product_id"]; ?>" oninput="wishlistProductCheck();wishlistBtnRemoveDisability();">
                                    </div>
                                    <div class="row g-0" style="transform: rotate(0);">
                                        <div class="col-12 col-md-4 text-center align-self-center">
                                            <img src="<?php echo $prodImg["img_path"] ?>" class="img-fluid rounded-start" style="height: 250px;">
                                        </div>
                                        <div class="col-12 col-md-8 align-self-center">
                                            <div class="card-body col-12">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <a href="<?php echo "product.php?bhm_id=" . ($wishlist_data["brand_has_model_id"]) . "&pid=" . ($wishlist_data["product_id"]) ?>" class="card-title stretched-link display-6"><?php echo $wishlist_data["product_name"] ?></a>
                                                        <div class="card-text lead"><?php echo $wishlist_data["colour_name"] ?></div>
                                                        <div class="card-text lead"><?php echo $wishlist_data["condition_name"] ?></div>
                                                        <div>
                                                            <?php
                                                            if ($wishlist_data["qty"] > 0) {
                                                                if ($wishlist_data["qty"] > 1) {
                                                            ?>
                                                                    <span class="badge bg-primary"><?php echo $wishlist_data["qty"] ?> items left</span>
                                                                <?php
                                                                } else {
                                                                ?>
                                                                    <span class="badge bg-danger">last item</span>
                                                                <?php
                                                                }
                                                                if ($wishlist_data["discount"] != null) {
                                                                ?>
                                                                    <span class="badge bg-success"><?php echo $wishlist_data["discount"] ?>% off</span>
                                                                <?php
                                                                }
                                                            } else {
                                                                ?>
                                                                <span class="badge bg-danger">sold out</span>
                                                                <?php
                                                                if ($wishlist_data["discount"] != null) {
                                                                ?>
                                                                    <span class="badge bg-success-subtle"><?php echo $wishlist_data["discount"] ?>% off</span>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </div>
                                                        <div class="text-warning pt-3" id="wlproductAlreadyAddedText<?php echo $wishlist_data["product_id"]; ?>" style="display: none;"><i class="bi bi-info-circle"></i> Product is already added to the cart</div>
                                                    </div>
                                                </div>
                                                <div class="position-absolute cartItemRemove">
                                                    <a href="#" class="position-relative z-1" onclick="removeWishlistItem(<?php echo $wishlist_data['product_id'] ?>);return false;">remove</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                        <?php
                        } else {
                        ?>
                            <div class="align-content-center pb-4">
                                <dotlottie-player src="https://lottie.host/8b71ee6c-016b-491e-9793-7caaeb4f0aa5/UfMFskhnbb.json" background="transparent" speed="1" style="width: 400px; height: 400px;margin: 0 auto" loop autoplay></dotlottie-player>
                                <div class="col-12 text-center" style="line-height: 40px;margin-top: -80px;">
                                    <p class="subtitle">No items added to the wishlist.</p>
                                    <button onclick="history.back();" class="btn btn-lg fw-bold btn-outline-primary rounded rounded-5 col-11 col-sm-9 col-md-8 col-lg-7 col-xl-4 position-relative z-1">Go back</button>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
            <?php include "footer.php" ?>
        </div>
        <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>
        <script src="script.js"></script>
        <script src="bootstrap.js"></script>
    </body>

    </html>
<?php
} else {
?>
    <script>
        window.location = "home.php";
    </script>
<?php
}
?>