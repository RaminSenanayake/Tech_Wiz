<?php
session_start();
if (isset($_SESSION["customer"])) {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tech Wiz | Shopping cart</title>

        <link rel="stylesheet" href="style.css" />
        <link rel="stylesheet" href="bootstrap.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" />
        <link rel="icon" href="resources/gadgets.svg" />
    </head>

    <body onload="stickyHeader();" onresize="stickyHeader();">
        <div class="container-fluid">
            <?php
            require "connection.php";
            include "header.php";
            $subtotal;
            $shippingTotal;

            $cart_items_rs = Database::search("SELECT `product_id`,`product_name`,product.qty AS `product_qty`,`price`,`colour_name`,`condition_name`,`brand_has_model_id`,cart.qty AS `cart_qty`,`shipping` FROM `cart` 
            INNER JOIN `product` ON cart.product_product_id=product.product_id INNER JOIN `colour` ON colour.colour_id=product.colour_colour_id 
            INNER JOIN `condition` ON `condition`.condition_id=product.condition_condition_id INNER JOIN `brand_has_model` ON brand_has_model.id = product.brand_has_model_id WHERE `customer_email`='" . $_SESSION["customer"]["email"] . "'");
            $cart_items_num = $cart_items_rs->num_rows;
            if ($cart_items_num >= 1) {
            ?>
                <div class="col-12 col-md-10 offset-md-1 min-vh-100 cartItems" id="bodyContent">
                    <form name="cartForm" action="checkout.php" method="post" class="row">
                        <div class="col-12 col-xl-8">
                            <input type="hidden" name="cart" value="cart">
                            <input type="hidden" name="numOfItems" value="<?php echo $cart_items_num; ?>">
                            <?php
                            for ($i = 0; $i < $cart_items_num; $i++) {
                                $cart_items_data = $cart_items_rs->fetch_assoc();
                                $prodImg_rs = Database::search("SELECT * FROM `product_img` WHERE `product_product_id`=" . $cart_items_data["product_id"]);
                                $prodImg = $prodImg_rs->fetch_assoc();
                            ?>
                                <input type="hidden" name="productId<?php echo $i ?>" value="<?php echo $cart_items_data["product_id"] ?>">
                                <div class="card my-3 searchResultCard" id="cartItemCard<?php echo $i; ?>">
                                    <div class="row g-0">
                                        <div class="col-12 col-md-4 text-center align-self-center">
                                            <img src="<?php echo $prodImg['img_path'] ?>" class="img-fluid rounded-start" style="height: 250px;">
                                        </div>
                                        <input type="hidden" id="prodImg<?php echo $i; ?>" name="prodImg<?php echo $i; ?>" value="<?php echo $prodImg['img_path'] ?>">
                                        <div class="col-12 col-md-8 align-self-center">
                                            <div class="card-body col-12">
                                                <div class="row">
                                                    <div class="col-4 col-sm-5 col-md-4 col-xl-5 col-xxl-5">
                                                        <a href="<?php echo "product.php?bhm_id=" . ($cart_items_data["brand_has_model_id"]) . "&pid=" . ($cart_items_data["product_id"]) ?>" class="card-title stretched-link display-6"><?php echo $cart_items_data["product_name"] ?></a>
                                                        <div class="card-text lead"><?php echo $cart_items_data["colour_name"] ?></div>
                                                        <div class="card-text lead"><?php echo $cart_items_data["condition_name"] ?></div>
                                                        <input type="hidden" id="productName<?php echo $i; ?>" name="productName<?php echo $i; ?>" value="<?php echo ($cart_items_data["product_name"] . " - " . $cart_items_data["colour_name"]); ?>">
                                                    </div>
                                                    <div class="col-8 col-sm-7 col-md-8 col-xl-7 col-xxl-7">
                                                        <div class="row">
                                                            <div class="col-2 col-xl-2 col-xxl-2 pe-0">
                                                                <label for="qtyselect<?php echo $i ?>" class="lead fw-semibold">Qty</label>
                                                            </div>
                                                            <div class="col-3 col-xl-2 col-xxl-3">
                                                                <?php
                                                                $itemprice = $cart_items_data["price"];
                                                                $shipping = $cart_items_data["shipping"];
                                                                if ($cart_items_data["product_qty"] <= 1) {
                                                                ?>
                                                                    <label class="col-form-label border col-12 rounded ps-3"><?php echo $cart_items_data["product_qty"] ?></label>
                                                                    <input type="hidden" id="qtyselect<?php echo $i ?>" name="qty<?php echo $i; ?>" value="<?php echo $cart_items_data["product_qty"] ?>">
                                                                <?php
                                                                } else {
                                                                ?>
                                                                    <select name="qty<?php echo $i; ?>" id="qtyselect<?php echo $i ?>" class="form-select position-relative z-1" onchange="subCal(<?php echo $cart_items_data['product_id'] ?>,<?php echo $i ?>);">
                                                                        <?php
                                                                        for ($x = 1; $x <= $cart_items_data["product_qty"]; $x++) {
                                                                        ?>
                                                                            <option value="<?php echo $x ?>" <?php
                                                                                                                if ($cart_items_data["cart_qty"] == $x) {
                                                                                                                    $itemprice = $itemprice * $x;
                                                                                                                    $shipping = $shipping * $x;
                                                                                                                ?>selected<?php
                                                                                                                        }
                                                                                                                            ?>><?php echo $x ?></option>
                                                                        <?php
                                                                        }
                                                                        $subtotal = $subtotal + $itemprice;
                                                                        $cartTotalItemsNum = $cartTotalItemsNum + $cart_items_data["cart_qty"];
                                                                        $shippingTotal = $shippingTotal + $shipping;
                                                                        ?>
                                                                    </select>
                                                                <?php
                                                                }
                                                                ?>
                                                            </div>
                                                            <div class="col-7 col-xl-8 col-xxl-7 fs-4 fw-semibold text-end" id="itemPrice<?php echo $i ?>">
                                                                Rs.<?php echo number_format($itemprice, 2) ?>
                                                            </div>
                                                            <input type="hidden" id="itemPriceInput<?php echo $i; ?>" name="itemPrice<?php echo $i; ?>" value="<?php echo $cart_items_data["price"]; ?>">
                                                        </div>
                                                        <div class="row pt-2 text-body-secondary">
                                                            <div class="col-5">
                                                                Shipping
                                                            </div>
                                                            <div class="col-7 text-end" id="itemShippingInput<?php echo $i ?>">
                                                                +Rs.<?php echo number_format($shipping, 2) ?>
                                                            </div>
                                                            <input type="hidden" id="itemShipping<?php echo $i; ?>" name="itemShipping<?php echo $i; ?>" value="<?php echo number_format($shipping, 2) ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="position-absolute cartItemRemove">
                                                    <a href="#" class="position-relative z-1" onclick="removeCartItem(<?php echo $i ?>,<?php echo $cart_items_data['product_id'] ?>);return false;">remove</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                        <div class="col-12 col-xl-4">
                            <div class="card mt-3 z-1" id="cartCheckout">
                                <div class="card-body pb-1">
                                    <table class="table table-borderless">
                                        <tbody class="fs-6">
                                            <tr>
                                                <th id="itemNum">Subtotal (items <?php echo $cartTotalItemsNum ?>)</th>
                                                <td class="text-end" id="cartSubtotal">Rs.<?php echo number_format($subtotal, 2) ?></td>
                                                <input type="hidden" name="subTotal" value="<?php echo number_format($subtotal, 2) ?>">
                                            </tr>
                                            <tr>
                                                <th>Shipping</th>
                                                <td class="text-end" id="cardShippingTotal">Rs.<?php echo number_format($shippingTotal, 2) ?></td>
                                                <input type="hidden" name="totalShipping" value="<?php echo $shippingTotal; ?>">
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <hr class="my-0">
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot class="fs-5">
                                            <?php
                                            $total = $subtotal + $shippingTotal;
                                            ?>
                                            <tr>
                                                <th>Total</th>
                                                <td class="text-end" id="cardTotal">Rs.<?php echo number_format($total, 2) ?></td>
                                                <input type="hidden" name="cartTotal" value="<?php echo number_format($total, 2) ?>">
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <button type="submit" class="btn btn-lg rounded rounded-5 col-12 btn-primary">Go to checkout</button>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="checkout" value="checkout">
                    </form>
                </div>
            <?php
            } else {
            ?>
                <div class="col-12 col-md-10 offset-md-1 justify-content-center pb-4" id="bodyContent">
                    <div class="row align-content-center" style="min-height: 60vh;">
                        <div class="col-12">
                            <dotlottie-player src="https://lottie.host/7e5bcddc-1599-470b-ab3a-325cf7c4ec64/um6v02FzAt.json" background="transparent" speed="0.75" style="width: 300px; height: 300px;margin: 0 auto;" loop autoplay></dotlottie-player>
                        </div>
                        <div class="col-12 text-center z-1" style="line-height: 40px;margin-top: -30px;">
                            <p class="subtitle">No items in the shopping cart.<br />Let's go shopping!</p>
                            <a href="home.php" class="btn btn-lg fw-bold btn-primary rounded rounded-5 col-11 col-sm-9 col-md-8 col-lg-7 col-xl-4">Start Shopping</a>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
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