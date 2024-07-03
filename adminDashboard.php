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
        <title>Tech Wiz | Admin Dashboard</title>

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
                    <div class="row row-cols-3 mt-2">
                        <div class="col">
                            <?php
                            $total_income_rs = Database::search("SELECT `qty`,`item_price` FROM `invoice_has_product`");
                            $total_income_num = $total_income_rs->num_rows;
                            $total_income = 0;
                            for ($i = 0; $i < $total_income_num; $i++) {
                                $total_income_data = $total_income_rs->fetch_assoc();
                                $total_income = $total_income + ($total_income_data["qty"] * $total_income_data["item_price"]);
                            }
                            ?>
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title text-success">Total Income</h5>
                                    <p class="card-text text-success display-5">Rs.<?php echo number_format($total_income, 2) ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <?php
                            $total_customers_rs = Database::search("SELECT * FROM `customer`");
                            $total_customers_num = $total_customers_rs->num_rows;
                            ?>
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title text-secondary">Total Customers registered</h5>
                                    <p class="card-text text-secondary display-5"><?php echo $total_customers_num ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <?php
                            $total_productsForSale_rs = Database::search("SELECT * FROM `product` WHERE `status_status_id`=1");
                            $total_productsForSale_num = $total_productsForSale_rs->num_rows;
                            ?>
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title text-danger">Total Number of Products For Sale</h5>
                                    <p class="card-text text-danger display-5"><?php echo $total_productsForSale_num ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row row-cols-2 mt-2">
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Customer Overview</h5>
                                    <?php
                                    $users_rs = Database::search("SELECT `fname`,`lname`,`email`,`gender_name`,customer_active_status.id AS `active_id`,`customer_active_status_name` FROM `customer` INNER JOIN `gender` ON 
                                    customer.gender_gender_id=gender.gender_id INNER JOIN customer_active_status ON customer.customer_active_status_id=customer_active_status.id ORDER BY `joined_datetime` ASC");
                                    $users_num = $users_rs->num_rows;
                                    ?>
                                    <div class="adminDashboardCard overflow-y-scroll" style="height: 400px;">
                                        <table class="table table-light table-hover manageUserTable">
                                            <thead>
                                                <tr>
                                                    <th scope="col" class="text-center">#</th>
                                                    <th scope="col">First Name</th>
                                                    <th scope="col">Last Name</th>
                                                    <th scope="col">Email</th>
                                                    <th scope="col">Gender</th>
                                                    <th scope="col" class="text-center">Active Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                for ($i = 1; $i <= $users_num; $i++) {
                                                    $users_data = $users_rs->fetch_assoc();
                                                ?>
                                                    <tr>
                                                        <th scope="row" class="text-center"><?php echo $i ?></th>
                                                        <td><?php echo $users_data["fname"] ?></td>
                                                        <td><?php echo $users_data["lname"] ?></td>
                                                        <td><?php echo $users_data["email"] ?></td>
                                                        <td><?php echo $users_data["gender_name"] ?></td>
                                                        <td class="text-center"><?php echo $users_data["customer_active_status_name"] ?></td>
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
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Product Overview</h5>
                                    <?php
                                    $prod_rs = Database::search("SELECT `product_id`,`product_name`,`colour_name`,`qty`,`price`,`condition_name`,`status_id`,`status_name` FROM `product` INNER JOIN `colour` 
                                    ON product.colour_colour_id=colour.colour_id INNER JOIN `condition` ON product.category_category_id=condition.condition_id INNER JOIN
                                    `status` ON product.status_status_id=`status`.status_id ORDER BY `added_datetime` ASC");
                                    $prod_num = $prod_rs->num_rows;
                                    ?>
                                    <div class="adminDashboardCard overflow-y-scroll" style="height: 400px;">
                                        <table class="table table-light table-hover manageUserTable">
                                            <thead>
                                                <tr>
                                                    <th scope="col" class="text-center">#</th>
                                                    <th scope="col">Product Name</th>
                                                    <th scope="col" class="text-center">Qty</th>
                                                    <th scope="col">Price (Rs.)</th>
                                                    <th scope="col">Condition</th>
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
                                                        <td><?php echo $prod_data["price"] ?></td>
                                                        <td><?php echo $prod_data["condition_name"] ?></td>
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

        <script src="adminScript.js"></script>
        <script src="bootstrap.js"></script>
        <script src="bootstrap.bundle.js"></script>
        <script src="https://kit.fontawesome.com/9b3fff4c52.js" crossorigin="anonymous"></script>
    </body>

    </html>
<?php
}
?>