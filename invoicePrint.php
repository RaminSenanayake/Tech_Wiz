<?php
session_start();
require "connection.php";
if (isset($_SESSION["customer"])) {
    $orderId = "#".$_GET["orderId"];
    $invoice_rs = Database::search("SELECT `order_id`,`issued_date`,`fname`,`lname`,`billing_address_id` FROM `customer` INNER JOIN 
    `invoice` ON invoice.customer_email=customer.email WHERE `order_id`='".$orderId."'");
    $invoice_personal_data = $invoice_rs->fetch_assoc();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tech Wiz | Invoice</title>

    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="bootstrap.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" />
    <link rel="icon" href="resources/gadgets.svg" />
</head>

<body class="container-fluid" onload="setTimeout(() => {printInvoice()}, 5);">
    <div class="col-12 invoicePadding" id="invoice">
        <div class="row">
            <div class="col-12">
                <a class="icon-link icon-link-hover backToHome" style="--bs-icon-link-transform: translate3d(-.25em, 0, 0);" href="orderSummary.php">
                    <i class="bi bi-arrow-left"></i>
                    back to order summary
                </a>
                <button type="button" class="btn btn-secondary float-end" onclick="printInvoice()">Print</button>
            </div>
        </div>
        <div id="mainInvoiceContent">
            <div class="row border-bottom border-dark-subtle mb-3">
                <div class="col-6">
                    <h1 class="display-2">Invoice</h1>
                </div>
                <div class="col-6 lh-1">
                    <p class="comp_title text-end text-primary" style="font-size: 80px;">Tech Wiz</p>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="fs-4 fw-bold">Order Id:</div>
                    <p><?php echo $invoice_personal_data["order_id"] ?></p>
                </div>
                <div class="col-6 text-end">
                    <div class="fs-4 fw-bold">Issued date:</div>
                    <p><?php echo $invoice_personal_data["issued_date"] ?></p>
                </div>
                <div class="col-6">
                    <?php
                    $address_rs = Database::search("SELECT address.*,`district_name`,`province_name` FROM `address` INNER JOIN `district` ON address.district_district_id=district.district_id INNER JOIN `province` ON province.province_id=district.province_province_id WHERE `address_id`=".$invoice_personal_data["billing_address_id"]);
                    $address_data = $address_rs->fetch_assoc();
                    ?>
                    <div class="fs-4 fw-bold">Billed to:</div>
                    <p><?php echo $address_data["full_name"] ?><br><?php echo $address_data["line_1"] . " " . $address_data["line_2"] . " " . $address_data["city"] ?>.<br><?php echo $address_data["district_name"] . " " . $address_data["province_name"] . " " . $address_data["zipcode"] ?></p>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <table class="table">
                        <thead class="table-secondary">
                            <tr>
                                <th scope="col" class="text-center">#</th>
                                <th scope="col">Product Name</th>
                                <th scope="col" class="text-center">Qty</th>
                                <th scope="col" class="text-center">Item Price</th>
                                <th scope="col" class="text-center">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $subtotal = $totalShipping = 0.0;
                            $invoice_products_rs = Database::search("SELECT `product_name`,`colour_name`,`item_price`,`total_shipping`,invoice_has_product.qty AS `qty` FROM `product` INNER JOIN `colour` ON 
                            product.colour_colour_id=colour.colour_id INNER JOIN `invoice_has_product` ON invoice_has_product.product_product_id=product.product_id 
									 INNER JOIN `invoice` ON invoice.order_id=invoice_has_product.invoice_order_id WHERE `invoice_order_id`='" . $invoice_personal_data["order_id"] . "'");
                            $invoice_products_num = $invoice_products_rs->num_rows;
                            for ($x = 1; $x <= $invoice_products_num; $x++) {
                                $invoice_products_data = $invoice_products_rs->fetch_assoc();
                                $itemTotal = $invoice_products_data["item_price"] * $invoice_products_data["qty"];
                            ?>
                                <tr>
                                    <th scope="row" class="text-center"><?php echo $x ?></th>
                                    <td><?php echo $invoice_products_data["product_name"] . " - " . $invoice_products_data["colour_name"] ?></td>
                                    <td class="text-center"><?php echo $invoice_products_data["qty"] ?></td>
                                    <td class="text-end">Rs. <?php echo number_format($invoice_products_data["item_price"], 2) ?></td>
                                    <td class="text-end">Rs. <?php echo number_format($itemTotal, 2) ?></td>
                                </tr>
                            <?php
                                $subtotal = $subtotal + $itemTotal;
                            }
                            $totalShipping = $invoice_products_data["total_shipping"];
                            ?>
                        </tbody>
                        <tfoot class="table-group-divider">
                            <tr>
                                <td colspan="3" class="border-0"></td>
                                <th class="text-end border-0">Subtotal</th>
                                <td class="border-0 text-end">Rs. <?php echo number_format($subtotal, 2) ?></td>
                            </tr>
                            <tr>
                                <td colspan="3" class="border-0"></td>
                                <th class="text-end">Total Shipping</th>
                                <td class="text-end">Rs. <?php echo number_format($totalShipping, 2) ?></td>
                            </tr>
                            <tr>
                                <td colspan="3" class="border-0"></td>
                                <th scope="row" class="text-end table-group-divider" style="border-bottom: 5px;border-style: double;">Total</th>
                                <td class="table-group-divider text-end" style="border-bottom: 5px;border-style: double;">Rs. <?php echo number_format($subtotal + $totalShipping, 2) ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12">
                    <h3>Thank you for shopping with us!</h3>
                </div>
            </div>
        </div>
    </div>
    <script src="script.js"></script>
</body>

</html>