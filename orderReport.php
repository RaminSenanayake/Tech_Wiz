<?php
session_start();
require "connection.php";
if ($_SESSION["admin"]) {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Tech Wiz | Order Report</title>

        <link rel="stylesheet" href="style.css" />
        <link rel="stylesheet" href="bootstrap.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" />
        <link rel="icon" href="resources/gadgets1.svg" />

    </head>

    <body class="container-fluid d-flex justify-content-center overflow-hidden">

        <?php include "adminSidebar.php" ?>
        <div class="mainAdminContent" id="mainAdminContent">
            <?php include "adminHeader.php" ?>
            <div class="row bg-body-secondary">
                <div class="col-12 overflow-y-scroll" style="height:90vh">
                    <div class="row">
                        <div class="col-12 mt-2">
                            <div class="card">
                                <div class="card-body">
                                    <?php
                                    $orders_rs = Database::search("SELECT `order_id`,`issued_date`,`total_shipping`,`order_status_id`,`order_status_name` FROM `invoice` 
                                    INNER JOIN `order` ON order.invoice_order_id=invoice.order_id INNER JOIN `order_status` ON order.order_status_id=order_status.id");
                                    $orders_num = $orders_rs->num_rows;
                                    ?>
                                    <button class="btn btn-secondary float-end" onclick="reportPrint()">Print</button>
                                    <div id="reportTable">
                                        <table class="table table-bordered manageUserTable caption-top">
                                            <caption class="card-title h3">Order Report</caption>
                                            <thead>
                                                <tr>
                                                    <th scope="col">Order ID</th>
                                                    <th scope="col">Order placed date</th>
                                                    <th scope="col" class="text-end">Total (Rs.)</th>
                                                    <th scope="col" class="text-center">Order status</th>
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
                                                    <tr>
                                                        <th scope="row"><?php echo $orders_data["order_id"] ?></th>
                                                        <td><?php echo $orders_data["issued_date"] ?></td>
                                                        <td class="text-end"><?php echo number_format($total, 2) ?></td>
                                                        <td class="text-center"><?php echo $orders_data["order_status_name"] ?></td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="bootstrap.js"></script>
        <script src="bootstrap.bundle.js"></script>
        <script src="adminScript.js"></script>
        <script src="https://kit.fontawesome.com/9b3fff4c52.js" crossorigin="anonymous"></script>
    </body>

    </html>
<?php
}
?>