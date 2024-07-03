<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tech Wiz | Advanced Search</title>

    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="bootstrap.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" />
    <link rel="icon" href="resources/gadgets.svg" />
</head>

<body>
    <div class="container-fluid">
        <?php
        session_start();
        require "connection.php";
        include "header.php";
        ?>
        <div class="col-12 col-md-10 offset-md-1 d-flex justify-content-center" style="min-height: 75vh;" id="bodyContent">
            <div class="row">
                <nav class="pt-3 lh-1" style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Advanced Search</li>
                    </ol>
                </nav>
                <p class="display-4 lh-1">Advanced Search</p>
                <form action="searchresult.php" method="get" class="z-0 col-12 pt-2" autocomplete="off">
                    <input type="hidden" name="search" value="advSearch">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label class="form-label fw-bold">Enter keywords</label>
                            <input type="text" name="asKeyword" class="form-control" id="enterKeywords" placeholder="Enter keywords" required>
                        </div>
                        <div class="col-12 col-sm-6">
                            <label class="form-label fw-bold">Select category</label>
                            <select name="asCategory" class="form-control" id="selectCategory">
                                <option value="0" selected>All categories</option>
                                <?php
                                $categories_rs = Database::search("SELECT * FROM `category`");
                                $categories_num = $categories_rs->num_rows;
                                for ($i = 0; $i < $categories_num; $i++) {
                                    $categories_data = $categories_rs->fetch_assoc();
                                ?>
                                    <option value="<?php echo $categories_data["category_id"]; ?>"><?php echo $categories_data["category_name"]; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-12 col-lg-6 mt-4">
                            <label class="form-label fw-bold">Select brand</label>
                            <select name="asBrand" class="form-control" id="selectBrand">
                                <option value="0" selected>All brands</option>
                                <?php
                                $brand_rs = Database::search("SELECT * FROM `brand`");
                                $brand_num = $brand_rs->num_rows;
                                for ($i = 0; $i < $brand_num; $i++) {
                                    $brand_data = $brand_rs->fetch_assoc();
                                ?>
                                    <option value="<?php echo $brand_data["brand_id"]; ?>"><?php echo $brand_data["brand_name"]; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-12 col-lg-6 mt-4">
                            <label class="form-label fw-bold lh-1">Price</label>
                            <div class="row px-2">
                                <div class="form-check col-auto ms-1 pe-0 my-auto">
                                    <input type="checkbox" class="form-check-input" id="priceRange" onclick="priceRangeCheck();">
                                    <label for="priceRange" class="form-check-label">Show items priced from Rs.</label>
                                </div>
                                <div class="col-2 col-sm-3 col-lg-2 col-xxl-3">
                                    <input type="text" name="asMinPrice" class="form-control form-control-sm" id="fromPrice" placeholder="Min price" disabled required>
                                </div>
                                <div class="col-auto my-auto px-0">
                                    <label for="fromPrice" class="form-check-label">to Rs. </label>
                                </div>
                                <div class="col-2 col-sm-3 col-lg-2 col-xxl-3">
                                    <input type="text" name="asMaxPrice" class="form-control form-control-sm" id="toPrice" placeholder="Max price" disabled required>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6 mt-4">
                            <label class="form-label fw-bold">Rating</label>
                            <div class="row">
                                <div class="col-12">
                                    <input type="range" name="asRating" min="1" max="4" value="1" class="form-range" list="ranges" id="ratingRange" oninput="ratingRangeInput();">
                                    <datalist id="ranges" class="justify-content-between d-flex">
                                        <option value="1">1+</option>
                                        <option value="2" style="color: transparent;">2+</option>
                                        <option value="3" style="color: transparent;">3+</option>
                                        <option value="4" style="color: transparent;">4+</option>
                                    </datalist>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6 mt-4">
                            <label class="form-label fw-bold">Condition</label>
                            <div class="row">
                                <div class="col-12">
                                    <?php
                                    $condition_rs = Database::search("SELECT * FROM `condition`");
                                    $condition_num = $condition_rs->num_rows;
                                    for ($y = 0; $y < $condition_num; $y++) {
                                        $condition_data = $condition_rs->fetch_assoc();
                                    ?>
                                        <div class="form-check form-check-inline">
                                            <input type="checkbox" value="<?php echo $condition_data["condition_id"] ?>" name="asCondition<?php echo $y ?>" id="conditionCheck<?php echo $y ?>" class="form-check-input" oninput="asConditionCheck();" required>
                                            <label for="conditionCheck<?php echo $y ?>" class="form-check-label"><?php echo $condition_data["condition_name"] ?></label>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 my-4">
                            <input type="submit" value="Search" class="btn btn-outline-primary">
                            <input type="reset" value="Clear options" class="btn btn-link link-dark">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <?php include "footer.php" ?>
    </div>

    <script src="script.js"></script>
    <script src="bootstrap.js"></script>
</body>

</html>