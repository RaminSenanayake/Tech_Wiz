<?php
session_start();
require "connection.php";
if (isset($_SESSION["customer"]) && isset($_POST["checkout"])) {
    $addresses = Database::search("SELECT * FROM `address` INNER JOIN `district` ON address.district_district_id=district.district_id INNER JOIN `province` ON district.province_province_id=province.province_id WHERE `customer_email`='" . $_SESSION["customer"]["email"] . "' AND `address_type`='Home'");
    $addressesNum = $addresses->num_rows;
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tech Wiz | Checkout</title>

        <link rel="stylesheet" href="style.css" />
        <link rel="stylesheet" href="bootstrap.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" />
        <link rel="icon" href="resources/gadgets.svg" />
    </head>

    <body>
        <div class="container-fluid">
            <?php
            include "header.php"
            ?>
            <div class="col-12 col-md-10 offset-md-1" id="bodyContent" style="min-height: 70vh;">
                <div class="d-block justify-content-center">
                    <form name="checkoutForm" action="checkoutProcess.php" method="post" class="row py-2" onsubmit="return checkoutAddressValidity();">
                        <div class="col-8">
                            <div class="row row-cols-2 bndAdresses">
                                <?php
                                if ($addressesNum >= 1) {
                                    $addressesData = $addresses->fetch_assoc();
                                ?>
                                    <div class="col">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title">Delivery Address <a href="javascript:void(0)" class="fs-6" data-bs-toggle="modal" data-bs-target="#addressModal" onclick="document.getElementById('addressModalTitle').innerHTML = 'Delivery Address';">Change</a></h5>
                                                <h6 class="card-subtitle mb-2 text-body-secondary" id="addType1"><?php echo $addressesData["address_type"] ?></h6>
                                                <p class="card-text" id="address1"><?php echo $addressesData["full_name"] ?><br /><?php echo $addressesData["line_1"], " ", $addressesData["line_2"], " " . $addressesData["city"] ?>.<br />
                                                    <?php echo $addressesData["district_name"], " " . $addressesData["province_name"], " " . $addressesData["zipcode"] ?>.</p>
                                                <input type="hidden" name="deliveryAddId" value="<?php echo $addressesData["address_id"] ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title">Billing Address <a href="javascript:void(0)" class="fs-6" data-bs-toggle="modal" data-bs-target="#addressModal" onclick="document.getElementById('addressModalTitle').innerHTML = 'Billing Address';">Change</a></h5>
                                                <h6 class="card-subtitle mb-2 text-body-secondary" id="addType2"><?php echo $addressesData["address_type"] ?></h6>
                                                <p class="card-text" id="address2"><?php echo $addressesData["full_name"] ?><br /><?php echo $addressesData["line_1"] . " " . $addressesData["line_2"] . " " . $addressesData["city"] ?>.<br />
                                                <?php echo $addressesData["district_name"] . " " . $addressesData["province_name"] . " " . $addressesData["zipcode"] ?>.</p>
                                                <input type="hidden" name="billingAddId" value="<?php echo $addressesData["address_id"] ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                } else {
                                    $addresses = Database::search("SELECT * FROM `address` INNER JOIN `district` ON address.district_district_id=district.district_id INNER JOIN `province` ON district.province_province_id=province.province_id WHERE `customer_email`='" . $_SESSION["customer"]["email"] . "'");
                                    $addressesNum = $addresses->num_rows;
                                    if ($addressesNum >= 1) {
                                        $addressesData = $addresses->fetch_assoc();
                                        ?>
                                        <div class="col">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h5 class="card-title">Delivery address <a href="javascript:void(0)" class="fs-6" data-bs-toggle="modal" data-bs-target="#addressModal">Change</a></h5>
                                                    <h6 class="card-subtitle mb-2 text-body-secondary"><?php echo $addressesData["address_type"] ?></h6>
                                                    <p class="card-text"><?php echo $addressesData["full_name"] ?><br /><?php echo $addressesData["line_1"], " ", $addressesData["line_2"], " " . $addressesData["city"] ?>.<br />
                                                    <?php echo $addressesData["district_name"], " " . $addressesData["province_name"], " " . $addressesData["zipcode"] ?>.</p>
                                                    <input type="hidden" name="deliveryAddId" value="<?php echo $addressesData["address_id"] ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h5 class="card-title">Billing address <a href="javascript:void(0)" class="fs-6" data-bs-toggle="modal" data-bs-target="#addressModal">Change</a></h5>
                                                    <h6 class="card-subtitle mb-2 text-body-secondary"><?php echo $addressesData["address_type"] ?></h6>
                                                    <p class="card-text"><?php echo $addressesData["full_name"] ?><br /><?php echo $addressesData["line_1"] . " " . $addressesData["line_2"] . " " . $addressesData["city"] ?>.<br />
                                                    <?php echo $addressesData["district_name"] . " " . $addressesData["province_name"] . " " . $addressesData["zipcode"] ?>.</p>
                                                    <input type="hidden" name="billingAddId" value="<?php echo $addressesData["address_id"] ?>">
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    } else {
                                    ?>
                                        <div class="col">
                                            <div class="card">
                                                <div class="card-body">
                                                    <a href="myAccount.php#addAddresses" class="stretched-link"></a>
                                                    <h5 class="card-title">Add New Address</h5>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="card">
                                                <div class="card-body">
                                                    <a href="myAccount.php#addAddresses" class="stretched-link"></a>
                                                    <h5 class="card-title">Add New Address</h5>
                                                </div>
                                            </div>
                                        </div>
                                <?php
                                    }
                                }
                                ?>
                                <input type="hidden" name="numOfAddresses" value="<?php echo $addressesNum; ?>">
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <input type="hidden" name="numOfItems" value="<?php echo $_POST["numOfItems"]; ?>">
                                    <?php
                                    if (isset($_POST["cart"])) {
                                        ?>
                                        <input type="hidden" name="cart" value="<?php echo $_POST["cart"]?>">
                                        <?php
                                    }
                                    for ($i = 0; $i < $_POST["numOfItems"]; $i++) {
                                    ?>
                                        <div class="card mt-2">
                                            <input type="hidden" name="pid<?php echo $i?>" value="<?php echo $_POST['productId' . $i]; ?>">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-3 text-center">
                                                        <img src="<?php echo $_POST['prodImg' . $i]; ?>" alt="" height="130">
                                                    </div>
                                                    <div class="col-9 align-self-center">
                                                        <div class="row row-col-2">
                                                            <div class="col">
                                                                <h5 class="card-title"><?php echo $_POST['productName' . $i]; ?></h5>
                                                                <h6 class="card-subtitle mb-2 text-body-secondary">Qty: <?php echo $_POST['qty' . $i]; ?></h6>
                                                            </div>
                                                            <input type="hidden" name="productName<?php echo $i; ?>" value="<?php echo $_POST['productName' . $i]; ?>">
                                                            <div class="col text-end">
                                                                <p class="card-text float-end">Rs.<?php echo number_format($_POST['itemPrice' . $i] * $_POST['qty' . $i], 2); ?><br />(Shipping) Rs.<?php
                                                                                                                                                                                                    if (isset($_POST['itemShipping' . $i])) {
                                                                                                                                                                                                        echo $_POST['itemShipping' . $i];
                                                                                                                                                                                                    } else {
                                                                                                                                                                                                        echo number_format($_POST["totalShipping"] * $_POST['qty' . $i], 2);
                                                                                                                                                                                                    }
                                                                                                                                                                                                    ?></p>
                                                            </div>
                                                            <input type="hidden" name="itemPrice<?php echo $i; ?>" value="<?php echo $_POST['itemPrice' . $i] ?>">
                                                            <input type="hidden" name="qty<?php echo $i; ?>" value="<?php echo $_POST['qty' . $i] ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">Order Summary</h5>
                                            <div class="row row-col-2">
                                                <div class="col">
                                                    <h6 class="card-subtitle mt-1 text-body-secondary">Subtotal</h6>
                                                    <h6 class="card-subtitle mt-1 text-body-secondary">Shipping total</h6>
                                                    <h6 class="card-subtitle mt-1 text-body-secondary">Total payment</h6>
                                                </div>
                                                <div class="col text-end">
                                                    <div class="card-text"><?php
                                                                            if (isset($_POST["subTotal"])) {
                                                                                echo "Rs." . $_POST["subTotal"];
                                                                            } else {
                                                                                echo "Rs." . number_format($_POST['itemPrice0'] * $_POST['qty0'], 2);
                                                                            }
                                                                            ?></div>
                                                    <?php
                                                    if ($i == 1) {
                                                        $totalShipping = $_POST["totalShipping"] * $_POST["qty0"];
                                                    } else {
                                                        $totalShipping = $_POST["totalShipping"];
                                                    }
                                                    ?>
                                                    <div class="card-text">Rs.<?php echo number_format($totalShipping, 2); ?></div>
                                                    <input type="hidden" name="totalShipping" value="<?php echo $totalShipping; ?>">
                                                    <div class="card-text"><?php
                                                                            if (isset($_POST["cartTotal"])) {
                                                                                echo "Rs." . $_POST["cartTotal"];
                                                                            } else {
                                                                                echo "Rs." . number_format(($_POST['itemPrice0'] * $_POST['qty0']) + $totalShipping, 2);
                                                                            }
                                                                            ?></div>
                                                </div>
                                            </div>
                                            <div class="row px-2 mt-2">
                                                <button type="submit" class="btn btn-outline-primary col-12">Pay Now</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <?php include "footer.php" ?>
        </div>
        <div class="modal fade" id="addressModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="addressModalTitle">Billing Address</h1>
                        <button type="button" id="modalClose" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row row-cols-2">
                            <?php
                            $selectingAdresses = Database::search("SELECT * FROM `address` INNER JOIN `district` ON address.district_district_id=district.district_id INNER JOIN `province` ON district.province_province_id=province.province_id WHERE `customer_email`='" . $_SESSION["customer"]["email"] . "'");
                            $selectingAdressesNum = $selectingAdresses->num_rows;
                            for ($x = 0; $x < $selectingAdressesNum; $x++) {
                                $selectingAdressesData = $selectingAdresses->fetch_assoc();
                            ?>
                                <div class="col mt-2">
                                    <div class="card">
                                        <div class="card-body">
                                            <a href="javascript:void(0)" class="stretched-link" onclick="changeCheckoutAddress(<?php echo $selectingAdressesData['address_id'] ?>)"></a>
                                            <h5 class="card-title"><?php echo $selectingAdressesData["address_type"]; ?></h5>
                                            <h6 class="card-subtitle mb-2 text-body-secondary"><?php echo $selectingAdressesData["full_name"] ?></h6>
                                            <p class="card-text"><?php echo $selectingAdressesData["line_1"] . " " . $selectingAdressesData["line_2"] . " " . $selectingAdressesData["city"] ?>.<br />
                                                <?php echo $selectingAdressesData["district_name"] . " " . $selectingAdressesData["province_name"] . " " . $selectingAdressesData["zipcode"] ?>.</p>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                            <div class="col mt-2">
                                <div class="card">
                                    <div class="card-body">
                                        <a href="myAccount.php#addAddresses" class="stretched-link"></a>
                                        <h5 class="card-title">Add New Address</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="script.js"></script>
        <script src="bootstrap.js"></script>
    </body>

    </html>
<?php
}
?>