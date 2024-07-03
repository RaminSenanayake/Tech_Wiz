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
        <title>Tech Wiz | Customer Report</title>

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
                                    $users_rs = Database::search("SELECT `fname`,`lname`,`email`,`gender_name`,customer_active_status.id AS `active_id`,`customer_active_status_name` FROM `customer` INNER JOIN `gender` ON 
                                    customer.gender_gender_id=gender.gender_id INNER JOIN customer_active_status ON customer.customer_active_status_id=customer_active_status.id ORDER BY `joined_datetime` ASC");
                                    $users_num = $users_rs->num_rows;
                                    ?>
                                    <button class="btn btn-secondary float-end" onclick="reportPrint()">Print</button>
                                    <div id="reportTable">
                                        <table class="table table-bordered manageUserTable caption-top">
                                        <caption class="card-title h3">Customer Report</caption>
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