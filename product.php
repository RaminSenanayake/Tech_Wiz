<?php
require "connection.php";
session_start();

if (isset($_GET["bhm_id"]) && isset($_GET["pid"])) {
    $bhm_id = $_GET["bhm_id"];
    $pid = $_GET["pid"];

    $pid_rs = Database::search("SELECT * FROM `product` INNER JOIN `product_img` ON product.product_id=product_img.product_product_id INNER JOIN `colour` ON product.colour_colour_id=colour.colour_id INNER JOIN 
    `category` ON product.category_category_id=category.category_id INNER JOIN `status` ON product.status_status_id=status.status_id INNER JOIN `condition` ON product.condition_condition_id=`condition`.condition_id
    INNER JOIN `brand_has_model` ON brand_has_model.id = product.brand_has_model_id WHERE `brand_has_model_id`=" . $bhm_id . " AND `product_id`=" . $pid);
    $pid_data = $pid_rs->fetch_assoc();

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tech Wiz | <?php echo $pid_data["product_name"]; ?></title>

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
            <div class="col-12 col-md-10 offset-md-1 min-vh-100" id="bodyContent">
                <nav class="my-2" style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <?php
                        $cat_rs = Database::search("SELECT DISTINCT(`category_name`),`category_id` FROM category INNER JOIN product ON product.category_category_id=category.category_id WHERE `brand_has_model_id`='" . $bhm_id . "'");
                        $pname_rs = Database::search("SELECT DISTINCT(`product_name`) FROM category INNER JOIN product ON product.category_category_id=category.category_id WHERE `brand_has_model_id`='" . $bhm_id . "'");
                        $productName = $pname_rs->fetch_assoc();
                        $category = $cat_rs->fetch_assoc();
                        ?>
                        <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="searchresult.php?search=basicSearch&mainSearch=&mainCategory=<?php echo $category["category_id"] ?>"><?php echo $category["category_name"] ?></a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo $productName["product_name"] ?></li>
                    </ol>
                </nav>
                <div class="row">
                    <div class="col-12 bg-body-secondary my-1 rounded rounded-4 shadow-lg">
                        <form class="row" <?php if (isset($_SESSION["customer"])) {?>action="checkout.php"<?php }?>  method="post">
                            <input type="hidden" name="numOfItems" value="1">
                            <input type="hidden" name="productId0" value="<?php echo $pid_data["product_id"]?>">
                            <div class="col-12 col-sm-11 offset-sm-1 col-lg-7 offset-lg-0 col-xl-6 col-xxl-5 justify-content-center">
                                <div class="row">
                                    <div class="col-12 col-sm-3 col-lg-3 offset-lg-0 order-1 order-sm-0">
                                        <div class="row">
                                            <?php
                                            $colour_rs = Database::search("SELECT * FROM `colour` INNER JOIN `product` ON product.colour_colour_id=colour.colour_id WHERE `brand_has_model_id`='" . $bhm_id . "' AND `colour_id`<>'" . $pid_data["colour_id"] . "'");
                                            $colour_num = $colour_rs->num_rows;
                                            $product_rs = Database::search("SELECT * FROM `product` INNER JOIN `product_img` ON product.product_id=product_img.product_product_id INNER JOIN `colour` ON product.colour_colour_id=colour.colour_id INNER JOIN 
                                            `category` ON product.category_category_id=category.category_id INNER JOIN `status` ON product.status_status_id=status.status_id WHERE `brand_has_model_id`='" . $bhm_id . "'");
                                            $product_num = $product_rs->num_rows;
                                            for ($i = 0; $i < $product_num; $i++) {
                                                $product_data = $product_rs->fetch_assoc();
                                                $product_img[$i] = $product_data["img_path"];
                                            ?>
                                                <img src="<?php echo $product_img[$i]; ?>" id="pImg<?php echo $i; ?>" class="col-3 col-sm-12 mt-2 rounded rounded-4 border-black" height="120" onload="focusBorder(<?php echo $i; ?>);" onmouseenter="borderOn(<?php echo $i; ?>)" onmouseleave="borderOff(<?php echo $i; ?>)" onclick="productChange(<?php echo $i; ?>,<?php echo $bhm_id; ?>,<?php echo $product_data['product_id']; ?>,<?php echo $colour_num; ?>)" />
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-8 offset-sm-0 col-lg-9 order-0 order-sm-1 py-2">
                                        <div class="row justify-content-lg-center">
                                            <img src="<?php echo $pid_data["img_path"] ?>" id="mainImg" height="520" class="col-auto rounded rounded-5">
                                        </div>
                                    </div>
                                    <input type="hidden" name="prodImg0" value="<?php echo $pid_data["img_path"] ?>">
                                </div>
                            </div>

                            <div class="col-12 text-center text-lg-start col-lg-5 offset-lg-0 col-xl-6 col-xxl-7 order-2 py-3">
                                <dl class="row justify-content-center justify-content-lg-start">
                                    <?php
                                    $rating_rs = Database::search("SELECT `rating` FROM `brand_has_model` WHERE `id`=" . $bhm_id . "");
                                    $rating_data = $rating_rs->fetch_assoc();
                                    $rating = $rating_data["rating"];
                                    $rating_fdigit = floor($rating);
                                    ?>
                                    <p class="display-6"><?php echo $pid_data["product_name"]; ?></p>
                                    <input type="hidden" id="productName0" name="productName0" value="<?php echo ($pid_data["product_name"] . " - " . $pid_data["colour_name"]); ?>">
                                    <p class="lead">
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
                                    </p>
                                    <dt class="col-4 lead fw-semibold">Condition</dt>
                                    <dd class="col-8 lead"><?php echo $pid_data["condition_name"] ?></dd>

                                    <dt class="col-4 lead fw-semibold fs-4">Price</dt>
                                    <dd class="col-8"><label class="fs-4"><?php echo "Rs." . number_format($pid_data["price"], 2); ?></label>
                                        <?php
                                        if ($pid_data["discount"] != null) {
                                            $cal_price = $pid_data["price"] + ($pid_data["price"] * $pid_data["discount"] / 100);
                                            $saving = $cal_price - $pid_data["price"];
                                        ?>
                                            <small class="text-decoration-line-through text-danger"><?php echo "Rs." . number_format($cal_price, 2); ?></small>
                                            <p class="small text-success">save Rs.<?php echo number_format($saving, 2); ?> (<?php echo $pid_data["discount"] ?>% off)</p>
                                        <?php
                                        }
                                        ?>
                                    </dd>
                                    <input type="hidden" name="itemPrice0" value="<?php echo $pid_data["price"];?>">
                                    <dl class="col-12">
                                        <div class="row justify-content-center justify-content-lg-start">
                                            <dt class="col-auto lead fw-semibold">Colour</dt>
                                            <dd class="col-7">
                                                <select id="colourOption" class="form-select" aria-label="Default select example" onchange="colourChange(<?php echo $bhm_id; ?>)">
                                                    <option value="<?php echo $pid_data["colour_id"] ?>" selected><?php echo $pid_data["colour_name"] ?></option>
                                                    <?php
                                                    for ($x = 0; $x < $colour_num; $x++) {
                                                        $colour_data = $colour_rs->fetch_assoc();
                                                    ?>
                                                        <option value="<?php echo $colour_data["product_id"] ?>"><?php echo $colour_data["colour_name"] ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </dd>
                                        </div>
                                    </dl>
                                    <dt class="col-auto lead fw-semibold">Quantity</dt>
                                    <dd class="col-auto">
                                        <input class="form-control" name="qty0" id="qtyThreshold" type="number" <?php if($pid_data["status_id"] == 2){?>value="0"<?php }else{?>value="1"<?php }?> min="1" max="<?php echo $pid_data["qty"] ?>" oninput="buyNowbuttonActiveStatus(<?php echo $pid_data['qty'] ?>)" <?php if($pid_data["status_id"] == 2){?>disabled<?php }?>>
                                    </dd>
                                    <dd class="col-auto lead <?php if($pid_data["status_id"] == 2){?>text-danger<?php }else{?>text-success<?php }?> fw-semibold align-self-center"><?php echo $pid_data["status_name"] ?></dd>
                                </dl>
                                <div class="row justify-content-center justify-content-lg-start">
                                    <button <?php if (isset($_SESSION["customer"])) {?>type="submit"<?php }else {?>type="button" onclick="spvAddToCart(<?php echo $pid; ?>)"<?php }?>  class="btn btn-lg btn-primary rounded-5 col-11 col-sm-8 mb-2" id="buyNowButton" <?php if($pid_data["status_id"] == 2){?>disabled<?php }?>>Buy Now</button>
                                </div>
                                <div class="row justify-content-center justify-content-lg-start">
                                    <?php
                                    if (isset($_SESSION["customer"])) {
                                        $cart_rs = Database::search("SELECT * FROM `cart` WHERE `product_product_id`=" . $pid . " AND `customer_email`='" . $_SESSION["customer"]["email"] . "'");
                                        $cart_num = $cart_rs->num_rows;
                                        if ($cart_num == 1) {
                                    ?>
                                            <a href="cart.php" class="btn btn-lg btn-outline-success rounded-5 col-11 col-sm-8 mb-2" id="addToCartBtn">View in cart <i class="bi bi-cart2"></i></a>
                                        <?php
                                        } else {
                                        ?>
                                            <a class="btn btn-lg btn-outline-success rounded-5 col-11 col-sm-8 mb-2 <?php if($pid_data["status_id"] == 2){?>disabled<?php }?>"  id="addToCartBtn" <?php if($pid_data["status_id"] == 1){?>onclick="spvAddToCart(<?php echo $pid; ?>)"<?php }?>>Add to cart <i class="bi bi-cart2"></i></a>
                                        <?php
                                        }
                                    } else {
                                        ?>
                                        <a class="btn btn-lg btn-outline-success rounded-5 col-11 col-sm-8 mb-2 <?php if($pid_data["status_id"] == 2){?>disabled<?php }?>"  id="addToCartBtn" <?php if($pid_data["status_id"] == 1){?>onclick="spvAddToCart(<?php echo $pid; ?>)"<?php }?>>Add to cart <i class="bi bi-cart2"></i></a>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <div class="row justify-content-center justify-content-lg-start">
                                    <?php
                                    if (isset($_SESSION["customer"])) {
                                        $wishlist_rs = Database::search("SELECT * FROM `wishlist` WHERE `product_product_id`=" . $pid . " AND `customer_email`='" . $_SESSION["customer"]["email"] . "'");
                                        $wishlist_num = $wishlist_rs->num_rows;
                                        if ($wishlist_num == 1) {
                                    ?>
                                            <a href="wishlist.php" class="btn btn-lg btn-outline-danger rounded-5 col-11 col-sm-8 mb-2" id="addToWishlistBtn">View in wishlist <i class="bi bi-heart"></i></a>
                                        <?php
                                        } else {
                                        ?>
                                            <a class="btn btn-lg btn-outline-danger rounded-5 col-11 col-sm-8 mb-2 <?php if($pid_data["status_id"] == 2){?>disabled<?php }?>" id="addToWishlistBtn" <?php if($pid_data["status_id"] == 1){?>onclick="spvAddToWishlist(<?php echo $pid; ?>)"<?php }?>>Add to wishlist <i class="bi bi-heart"></i></a>
                                        <?php
                                        }
                                    } else {
                                        ?>
                                        <a class="btn btn-lg btn-outline-danger rounded-5 col-11 col-sm-8 mb-2 <?php if($pid_data["status_id"] == 2){?>disabled<?php }?>" id="addToWishlistBtn" <?php if($pid_data["status_id"] == 1){?>onclick="spvAddToWishlist(<?php echo $pid; ?>)"<?php }?>>Add to wishlist <i class="bi bi-heart"></i></a>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <input type="hidden" name="totalShipping" value="<?php echo $pid_data["shipping"] ?>">
                            <input type="hidden" name="checkout" value="checkout">
                        </form>
                    </div>

                    <div class="col-12 mb-0 mt-5">
                        <div class="row">
                            <h4>Specifications:</h4>
                            <dl class="row specifications">
                                <?php echo $pid_data["description"]?>
                            </dl>
                        </div>
                    </div>

                    <div class="col-12 my-2 mt-5">
                        <a class="icon-link icon-link-hover tdtitle lh-1 subtitle" href="#">Related items <i class="bi bi-arrow-right fs-1"></i></a>
                        <div class="row">
                            <div class="col-12 column-gap-5 px-3 d-inline-flex overflow-x-scroll" style="padding-top: 30px; padding-bottom: 20px;">
                                <?php
                                $related_rs = Database::search("SELECT * FROM `product` INNER JOIN `product_img` ON product.product_id=product_img.product_product_id WHERE `category_category_id`='" . $pid_data["category_id"] . "' AND `brand_has_model_id`<>'" . $bhm_id . "' LIMIT 10");
                                $related_num = $related_rs->num_rows;
                                for ($y = 0; $y < $related_num; $y++) {
                                    $related_data = $related_rs->fetch_assoc();
                                    $related_price = $related_data["price"];
                                    $related_discount = $related_data["discount"];
                                    if ($related_discount != null) {
                                        $related_actual_price = $related_price + (($related_price * $related_discount) / 100);
                                    }
                                ?>
                                    <div class="card col-auto productcard shadow" style="height: 400px;">
                                        <img src="<?php echo $related_data["img_path"] ?>" class="card-img-top" height="250">
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo $related_data["product_name"] ?></h5>
                                            <p class="card-text"><b>Rs.<?php echo number_format($related_price) ?></b>
                                                <?php
                                                if ($related_discount != null) {
                                                ?>
                                                    <small class="text-decoration-line-through">Rs.<?php echo number_format($related_actual_price) ?></small>
                                                <?php
                                                }
                                                ?>
                                            </p>
                                            <a href="<?php echo "product.php?bhm_id=" . ($related_data["brand_has_model_id"]) . "&pid=" . ($related_data["product_id"]) ?>" class="btn btn-outline-primary stretched-link">Buy now</a>
                                            <button class="btn btn-outline-success z-1 position-relative" onclick="addToCart('<?php echo $related_data['product_id'] ?>');"><i class="bi bi-cart2"></i></button>
                                            <button class="btn btn-outline-danger z-1 position-relative" onclick="addToWishlist(<?php echo $related_data['product_id']; ?>);"><i class="bi bi-heart"></i></button>
                                        </div>
                                        <?php
                                        if ($related_discount != null) {
                                        ?>
                                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success"><?php echo $related_discount ?>% off</span>
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

                    <div class="toast-container position-fixed bottom-0 end-0 p-3">

                        <div id="spvAddToCartSuccess" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                            <div class="toast-header">
                                <img src="resources/gadgets.svg" width="20" class="rounded me-2">
                                <strong class="me-auto">Tech Wiz</strong>
                                <small>Just now</small>
                                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                            </div>
                            <div class="toast-body fs-6" id="spvAddToCartSuccessText"></div>
                        </div>

                        <div id="spvAddToWishlistSuccess" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                            <div class="toast-header">
                                <img src="resources/gadgets.svg" width="20" class="rounded me-2">
                                <strong class="me-auto">Tech Wiz</strong>
                                <small>Just now</small>
                                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                            </div>
                            <div class="toast-body fs-6" id="spvAddToWishlistSuccessText"></div>
                        </div>

                    </div>

                    <div class="toast-container position-fixed bottom-0 end-0 p-3" id="hometoastcontainer1">

                    </div>

                    <div class="toast-container position-fixed bottom-0 end-0 p-3">

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
            </div>
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