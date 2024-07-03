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
        <title>Tech Wiz | Product Report</title>

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
                                    $prod_rs = Database::search("SELECT `product_id`,`product_name`,`colour_name`,`qty`,`price`,`condition_name`,`status_id`,`status_name` FROM `product` INNER JOIN `colour` 
                                    ON product.colour_colour_id=colour.colour_id INNER JOIN `condition` ON product.category_category_id=condition.condition_id INNER JOIN
                                    `status` ON product.status_status_id=`status`.status_id ORDER BY `added_datetime` ASC");
                                    $prod_num = $prod_rs->num_rows;
                                    ?>

                                    <button class="btn btn-secondary float-end" onclick="reportPrint()">Print</button>
                                    <div id="reportTable">
                                        <table class="table table-bordered manageUserTable caption-top">
                                            <caption class="card-title h3">Product Report</caption>
                                            <thead>
                                                <tr>
                                                    <th scope="col" class="text-center">#</th>
                                                    <th scope="col">Product Name</th>
                                                    <th scope="col" class="text-center">Qty</th>
                                                    <th scope="col" class="text-end">Price (Rs.)</th>
                                                    <th scope="col" class="text-center">Condition</th>
                                                    <th scope="col" class="text-center">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                for ($i = 1; $i <= $prod_num; $i++) {
                                                    $prod_data = $prod_rs->fetch_assoc();
                                                ?>
                                                    <tr>
                                                        <th scope="row" class="text-center"><?php echo $i ?></th>
                                                        <td><?php echo $prod_data["product_name"] . " - " . $prod_data["colour_name"] ?></td>
                                                        <td class="text-center"><?php echo $prod_data["qty"] ?></td>
                                                        <td class="text-end"><?php echo number_format($prod_data["price"],2) ?></td>
                                                        <td class="text-center"><?php echo $prod_data["condition_name"] ?></td>
                                                        <td class="text-center"><?php echo $prod_data["status_name"] ?></td>
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