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
        <title>Tech Wiz | Add Product</title>

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
                                    <h5 class="display-4 d-xl-none">Add Product</h5>
                                    <div class="row d-flex justify-content-center">
                                        <form name="addProductForm" class="col-12" method="post" autocomplete="off">
                                            <div class="row">

                                                <div class="col-12 order-1 col-xl-4 order-xl-0 mt-lg-3 mt-xl-0">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <h5 class="display-4 d-none d-xl-block">Add Product</h5>
                                                        </div>
                                                        <div class="col-12">
                                                            <label for="PdName" class="form-label">Product Name</label>
                                                            <input type="text" name="productName" class="form-control" id="PdName" required>
                                                        </div>
                                                        <div class="col-12 mt-2">
                                                            <?php
                                                            $cat_rs = Database::search("SELECT * FROM `category`");
                                                            $cat_num = $cat_rs->num_rows;
                                                            ?>
                                                            <label for="category" class="form-label">Category</label>
                                                            <select name="category" id="category" class="form-select selector1" onchange="selectChange(1);brandSelectChange(this.value)" required>
                                                                <option value="" disabled selected>Select a category</option>
                                                                <?php
                                                                for ($i = 0; $i < $cat_num; $i++) {
                                                                    $cat_data = $cat_rs->fetch_assoc();
                                                                ?>
                                                                    <option value="<?php echo $cat_data["category_id"] ?>"><?php echo $cat_data["category_name"] ?></option>
                                                                <?php
                                                                }
                                                                ?>
                                                                <option value="Other">Other</option>
                                                            </select>
                                                            <input type="text" name="categoryText" class="form-control mt-2 other1 d-none" placeholder="Enter the category" >
                                                        </div>
                                                        <div class="col-12 mt-2">
                                                            <label for="brand" class="form-label">Brand</label>
                                                            <select name="brand" id="brand" class="form-select selector2" onchange="selectChange(2);modelSelectChange(this.value)" required>
                                                                <option value="" disabled selected id="firstBrandOption">Select a brand</option>
                                                                <option value="Other" id="lastBrandOption">Other</option>
                                                            </select>
                                                            <input type="text" name="brandText" class="form-control mt-2 other2 d-none" placeholder="Enter the brand" >
                                                        </div>
                                                        <div class="col-12 mt-2">
                                                            <label for="model" class="form-label">Model</label>
                                                            <select name="model" id="model" class="form-select selector3" onchange="selectChange(3)" required>
                                                                <option value="" id="firstModelOption" disabled selected>Select a model</option>
                                                                <option value="Other" id="lastModelOption">Other</option>
                                                            </select>
                                                            <input type="text" name="modelText" class="form-control mt-2 other3 d-none" placeholder="Enter the model" >
                                                        </div>
                                                        <div class="col-12 mt-2">
                                                            <label for="shipping" class="form-label">Shipping</label>
                                                            <div class="input-group">
                                                                <span class="input-group-text">Rs.</span>
                                                                <input type="text" name="shipping" class="form-control" id="shipping" pattern="[0-9]+" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12 order-0 col-xl-8 order-xl-1">
                                                    <div class="row row-cols-4">

                                                        <div class="col-12 mb-2">
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="modelProductRadio" id="inlineRadio1" value="1" oninput="radioChange()" required>
                                                                <label class="form-check-label" for="inlineRadio1">One product of the model</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="modelProductRadio" id="inlineRadio2" value="multiple" oninput="radioChange()" required>
                                                                <label class="form-check-label" for="inlineRadio2">Multiple products of the model</label>
                                                            </div>
                                                        </div>

                                                        <?php
                                                        for ($x = 0; $x < 4; $x++) {
                                                        ?>
                                                            <div class="col row-gap-1 d-grid" id="productImgContainer<?php echo $x ?>">
                                                                <div class="row">
                                                                    <div class="col-12">
                                                                        <div class="card">
                                                                            <div class="card-body productImg" style="background-image: url('resources/icons8-upload.gif');" onclick="addProductImgs()"></div>
                                                                        </div>
                                                                    </div>
                                                                </div>


                                                                <div class="row">
                                                                    <div class="col-12">
                                                                        <?php
                                                                        $colour_rs = Database::search("SELECT * FROM `colour`");
                                                                        $colour_num = $colour_rs->num_rows;
                                                                        ?>
                                                                        <label for="colorSelect<?php echo $x ?>" class="form-label">Colour:</label>
                                                                        <select name="colorSelect<?php echo $x ?>" id="colorSelect<?php echo $x ?>" class="form-select selector<?php echo ($x + 4); ?>" onchange="selectChange(<?php echo ($x + 4); ?>)" required disabled>
                                                                            <option value="" disabled selected>Select a color</option>
                                                                            <?php
                                                                            for ($y = 0; $y < $colour_num; $y++) {
                                                                                $colour_data = $colour_rs->fetch_assoc();
                                                                            ?>
                                                                                <option value="<?php echo $colour_data["colour_id"] ?>"><?php echo $colour_data["colour_name"] ?></option>
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                            <option value="Other">Other</option>
                                                                        </select>
                                                                        <div class="input-group mt-2 d-none other<?php echo ($x + 4); ?>">
                                                                            <input type="color" name="colourCode<?php echo $x ?>" id="colourCode<?php echo $x ?>" class="form-control form-control-color">
                                                                            <input type="text" name="colourName<?php echo $x ?>" id="colourName<?php echo $x ?>" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-12 col-xl-6">
                                                                        <label for="qty<?php echo $x ?>" class="form-label">Qty:</label>
                                                                        <input type="number" name="qty<?php echo $x ?>" id="qty<?php echo $x ?>" min="1" class="form-control" pattern="[0-9]+" required disabled>
                                                                    </div>
                                                                    <div class="col-12 col-xl-6">
                                                                        <label for="disc<?php echo $x ?>" class="form-label">Discount(%):</label>
                                                                        <input type="number" class="form-control" name="disc<?php echo $x ?>" min="0" id="disc<?php echo $x ?>" pattern="[0-9]+" required disabled>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-12">
                                                                        <?php
                                                                        $condition_rs = Database::search("SELECT * FROM `condition`");
                                                                        $condition_num = $condition_rs->num_rows;
                                                                        ?>
                                                                        <label for="conditionSelect<?php echo $x ?>" class="form-label">Condition:</label>
                                                                        <select name="conditionSelect<?php echo $x ?>" id="conditionSelect<?php echo $x ?>" class="form-select" required disabled>
                                                                            <option value="" disabled selected>Select a condition</option>
                                                                            <?php
                                                                            for ($d = 0; $d < $condition_num; $d++) {
                                                                                $condition_data = $condition_rs->fetch_assoc();
                                                                            ?>
                                                                                <option value="<?php echo $condition_data["condition_id"] ?>"><?php echo $condition_data["condition_name"] ?></option>
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-12">
                                                                        <label for="price<?php echo $x ?>" class="form-label">Price:</label>
                                                                        <div class="input-group">
                                                                            <span class="input-group-text">Rs.</span>
                                                                            <input type="text" name="price<?php echo $x ?>" id="price<?php echo $x ?>" min="1" pattern="[0-9]+" class="form-control" required disabled>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php
                                                        }
                                                        ?>
                                                        <input type="file" class="visually-hidden" name="productImgs" id="productImgsSelect" min="1" max="4" accept="image/jpg, image/jpeg, image/png, image/svg+xml" multiple disabled>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="row mt-2">
                                                <div class="col-12">
                                                    <div class="row">
                                                        <p class="fs-4">Description</p>
                                                    </div>
                                                    <div class="row mt-2 specContainer" id="spec0Container">
                                                        <div class="col-3">
                                                            <input type="text" name="spec0" id="spec0" class="form-control" required>
                                                        </div>
                                                        <div class="col-8">
                                                            <textarea name="spec0Text" id="spec0Text" rows="2" class="form-control" required></textarea>
                                                        </div>
                                                        <div class="col-1 d-flex align-items-center">
                                                            <button class="btn btn-danger d-none" id="deleteSpecBtn0" onclick="deleteSpec(this)">X</button>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-2" id="addNewSpecContainer">
                                                        <div class="col-12">
                                                            <button type="button" class="btn btn-outline-dark col-12" onclick="addNewSpec()">Add new spec</button>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="numOfProducts" value="1">
                                                    <input type="hidden" name="numOfDescriptions" value="1">
                                                    <div class="row mt-2">
                                                        <div class="col-12">
                                                            <button type="button" class="btn btn-outline-success float-end" onclick="addProductFormSubmission()">Add product</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </form>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="toast position-absolute bottom-0 end-0" id="productAddedToast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <img src="resources/gadgets1.svg" width="20" class="rounded me-2">
                <strong class="me-auto">Tech Wiz</strong>
                <small>Just now</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                Product added.
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="bootstrap.js"></script>
        <script src="bootstrap.bundle.js"></script>
        <script src="adminScript.js"></script>
        <script src="https://kit.fontawesome.com/9b3fff4c52.js" crossorigin="anonymous"></script>
    </body>

    </html>
<?php
}
?>