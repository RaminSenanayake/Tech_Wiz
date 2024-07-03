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
        <title>Tech Wiz | Update Product</title>

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
                                    <h5 class="display-4 d-xl-none">Update Product</h5>
                                    <div class="row d-flex justify-content-center">
                                        <div class="col-12">
                                            <div class="row">

                                                <div class="col-12 order-1 col-xl-5 order-xl-0 mt-lg-3 mt-xl-0">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <h5 class="display-4 d-none d-xl-block">Update Product</h5>
                                                        </div>
                                                        <div class="col-12 updateProductList border" style="height: 250px;">
                                                            <div class="row">
                                                                <?php
                                                                $prodList_rs = Database::search("SELECT `product_id`,`product_name`,`colour_name` FROM `product` INNER JOIN `colour` ON product.colour_colour_id=colour.colour_id");
                                                                $prodList_num = $prodList_rs->num_rows;
                                                                for ($i = 0; $i < $prodList_num; $i++) {
                                                                    $prodList_data = $prodList_rs->fetch_assoc();
                                                                ?>
                                                                    <a href="javascript:void(0);" class="lead" id="<?php echo $prodList_data["product_id"] ?>" onclick="updateProductFormValueCall(<?php echo $prodList_data['product_id'] ?>)"><?php echo $prodList_data["product_name"] . " - " . $prodList_data["colour_name"] ?></a>
                                                                <?php
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12 order-0 col-xl-7 order-xl-1">
                                                    <div class="row">
                                                        <form name="updateProductForm" class="col-12" autocomplete="off" onsubmit="updateProduct();return false">
                                                            <div class="row">
                                                                <div class="col-4">
                                                                    <label for="prodName" class="form-control-lg col-form-label">Product Name:</label>
                                                                </div>
                                                                <div class="col-8">
                                                                    <input type="text" class="form-control-lg form-control-plaintext" id="prodName" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <label for="unitPrice" class="form-control-lg form-label">Unit price</label>
                                                                    <div class="row">
                                                                        <div class="col-12 px-4">
                                                                            <input type="text" name="unitPrice" class="form-control form-control-lg" id="unitPrice" pattern="[0-9]+" required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <label for="qty" class="form-control-lg form-label">Qty</label>
                                                                    <div class="row">
                                                                        <div class="col-12 px-4">
                                                                            <input type="number" name="qty" min="1" class="form-control form-control-lg" id="qty" required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-6">
                                                                    <label for="discount" class="form-control-lg form-label">Discount</label>
                                                                    <div class="row">
                                                                        <div class="col-12 px-4">
                                                                            <input type="number" name="discount" min="0" class="form-control form-control-lg" id="discount" required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <input type="hidden" name="product_id" id="product_id">
                                                            </div>
                                                            <button type="submit" id="discFormSubmitBtn" class="btn btn-lg me-2 btn-primary mt-4 float-end" disabled>Save Changes</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
        <div class="toast position-absolute bottom-0 end-0" id="productUpdatedToast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <img src="resources/gadgets1.svg" width="20" class="rounded me-2">
                <strong class="me-auto">Tech Wiz</strong>
                <small>Just now</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                Product updated.
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