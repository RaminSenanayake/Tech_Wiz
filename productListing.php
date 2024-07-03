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
        <title>Tech Wiz | Product Listing</title>

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
                        <?php
                        $query = "SELECT `product_id`,`product_name`,`colour_name`,`qty`,`price`,`condition_name`,`status_id`,`status_name` FROM `product` INNER JOIN `colour` 
                        ON product.colour_colour_id=colour.colour_id INNER JOIN `condition` ON product.category_category_id=condition.condition_id INNER JOIN 
                        `status` ON product.status_status_id=`status`.status_id ORDER BY `added_datetime` ASC";
                        $prod_rs = Database::search($query);
                        $prod_num = $prod_rs->num_rows;
                        ?>
                        <div class="col-12 mt-2">
                            <?php
                            if ($prod_num >= 1) {

                                if (isset($_GET["page"])) {
                                    $page_no = $_GET["page"];
                                } else {
                                    $page_no = 1;
                                }

                                $results_per_page = 10;
                                $num_of_pages = ceil($prod_num / $results_per_page);

                                $page_results = ($page_no - 1) * $results_per_page;
                                $selected_rs = Database::search($query . " LIMIT " . $results_per_page . " OFFSET " . $page_results . " ");
                                $selected_num = $selected_rs->num_rows;
                            ?>
                                <table class="table table-light table-hover manageUserTable">
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
                                        if (isset($_GET["page"])) {
                                            $prodlistNum = ($_GET["page"] - 1) * $results_per_page;
                                        } else {
                                            $prodlistNum = 0;
                                        }
                                        for ($i = 1; $i <= $selected_num; $i++) {
                                            $prod_data = $selected_rs->fetch_assoc();
                                        ?>
                                            <tr>
                                                <th scope="row" class="text-center"><?php echo ($i + $prodlistNum) ?></th>
                                                <td><?php echo $prod_data["product_name"] . " - " . $prod_data["colour_name"] ?></td>
                                                <td class="text-center"><?php echo $prod_data["qty"] ?></td>
                                                <td class="text-end"><?php echo number_format($prod_data["price"],2) ?></td>
                                                <td class="text-center"><?php echo $prod_data["condition_name"] ?></td>
                                                <td class="text-center"><button id="prodActiveBtn<?php echo $i ?>" class="btn <?php if ($prod_data["status_id"] == 1) { ?>btn-success<?php } else { ?>btn-danger<?php } ?> " value="<?php echo $prod_data["status_id"] ?>" onclick="changeProductActiveStatus(<?php echo $i ?>,<?php echo $prod_data['product_id'] ?>)"><?php echo $prod_data["status_name"] ?></button></td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination justify-content-center">
                                        <li class="page-item <?php if ($page_no <= 1) { ?>disabled<?php } ?>">
                                            <a class="page-link" href="javascript:void(0)" <?php if ($page_no > 1) { ?>onclick="prodListChangePage(<?php echo ($page_no - 1) ?>)" <?php } ?>>Previous</a>
                                        </li>
                                        <?php
                                        for ($p = 1; $p <= $num_of_pages; $p++) {
                                            if ($p == $page_no) {
                                        ?>
                                                <li class="page-item active"><a class="page-link" href="javascript:void(0)" onclick="prodListChangePage(<?php echo ($p) ?>)"><?php echo $p ?></a></li>
                                            <?php
                                            } else {
                                            ?>
                                                <li class="page-item"><a class="page-link" href="javascript:void(0)" onclick="prodListChangePage(<?php echo ($p) ?>)"><?php echo $p ?></a></li>
                                            <?php
                                            }

                                            ?>
                                        <?php
                                        }
                                        ?>
                                        <li class="page-item <?php if ($page_no >= $num_of_pages) { ?>disabled<?php } ?>">
                                            <a class="page-link" href="javascript:void(0)" <?php if ($page_no < $num_of_pages) { ?>onclick="prodListChangePage(<?php echo ($page_no + 1) ?>)" <?php } ?>>Next</a>
                                        </li>
                                    </ul>
                                </nav>
                            <?php
                            } else {
                            ?>
                                <div class="card" style="height: 87vh;">
                                    <div class="card-body d-flex justify-content-center align-items-center">
                                        <h3 class="display-3">No product has added yet.</h3>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
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