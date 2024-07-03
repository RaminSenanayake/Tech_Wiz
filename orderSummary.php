<?php
session_start();
require "connection.php";

if (isset($_SESSION["customer"])) {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tech Wiz | Order Summary</title>

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
                            <a href="wishlist.php" class="col-6 col-sm-auto"><i class="bi bi-heart"></i>&emsp;Wishlist</a>
                            <a href="#" class="col-6 col-sm-auto active"><i class="bi bi-clipboard2-data"></i>&emsp;Summary</a>
                        </div>
                    </div>
                    <div id="mainBodyContent" class="mainBodyContent">
                        <div class="row">
                            <div class="col-12 mt-3">
                                <?php
                                $orders_rs = Database::search("SELECT `order_id`,`issued_date`,`total_shipping`,`order_status_name` FROM `invoice` 
                                INNER JOIN `order` ON order.invoice_order_id=invoice.order_id INNER JOIN `order_status`
                                ON order.order_status_id=order_status.id WHERE `customer_email`='" . $_SESSION["customer"]["email"] . "' ORDER BY `issued_date` DESC");
                                $orders_num = $orders_rs->num_rows;
                                if ($orders_num > 0) {
                                ?>
                                    <button class="float-end btn btn-secondary mb-2" onclick="invoiceTablePrint()">Print</button>
                                    <div id="invoiceTable">
                                        <table class="table table-hover table-bordered manageUserTable">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Order ID</th>
                                                    <th scope="col">Issued date</th>
                                                    <th scope="col" class="text-end">Total (Rs.)</th>
                                                    <th scope="col" class="text-center">Order status</th>
                                                    <th scope="col" id="lastTableHeading"></th>
                                                </tr>
                                            </thead>
                                            <tbody id="TableContent">
                                                <?php
                                                for ($i = 0; $i < $orders_num; $i++) {
                                                    $total = 0;
                                                    $subtotal = 0;
                                                    $orders_data = $orders_rs->fetch_assoc();
                                                    $total_rs = Database::search("SELECT * FROM invoice_has_product WHERE invoice_order_id='" . $orders_data["order_id"] . "'");
                                                    $total_num = $total_rs->num_rows;
                                                    for ($x = 0; $x < $total_num; $x++) {
                                                        $total_data = $total_rs->fetch_assoc();
                                                        $subtotal = $subtotal + ($total_data["qty"] * $total_data["item_price"]);
                                                    }
                                                    $total = $orders_data["total_shipping"] + $subtotal;
                                                ?>
                                                    <tr id="TableContent">
                                                        <th scope="row"><?php echo $orders_data["order_id"] ?></th>
                                                        <td><?php echo $orders_data["issued_date"] ?></td>
                                                        <td class="text-end"><?php echo number_format($total, 2) ?></td>
                                                        <td class="text-center"><?php echo $orders_data["order_status_name"] ?></td>
                                                        <td class="text-center"><button class="btn btn-success" onclick="invoicePrint('<?php echo $orders_data['order_id'] ?>')">Print Invoice</button></td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php
                                } else {
                                ?>
                                    <p class="text-center display-4">You have not placed any orders yet.</p>
                                <?php
                                }

                                ?>
                            </div>
                        </div>
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