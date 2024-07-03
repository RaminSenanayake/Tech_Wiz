<?php
if (isset($_COOKIE["email"]) && $_COOKIE["password"]) {
    $rs = Database::search("SELECT * FROM `customer` WHERE `email`='" . $_COOKIE["email"] . "' AND `password`='" . $_COOKIE["password"] . "'");

    $n = $rs->num_rows;

    if ($n == 1) {
        $d = $rs->fetch_assoc();
        $_SESSION["customer"] = $d;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="bootstrap.css" />
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" />
</head>

<body onscroll="stickyHeader()">
    <div class="col-12 container-fluid">
        <div class="row">
            <div class="col-12 col-sm-10 offset-sm-1 fw-light hstack px-5 px-sm-0 gap-3 gap-sm-5" id="navigationbartop">
                <?php
                if (isset($_SESSION["customer"])) {
                    $session_data = $_SESSION["customer"];
                ?>
                    <small>Hello <b class="fw-medium text-primary"><?php echo $session_data["fname"] . " " . $session_data["lname"]; ?></b> | <a href="#" class="text-black hAndCtext">Help & Contact</a> | <a href="#" class="text-black signOutText" onclick="signOut();">Sign out</a></small>
                <?php
                } else {
                ?>
                    <small><a href="index.php?hid=0" class="fw-medium signInText">Sign in</a> or <a href="index.php?hid=1" class="fw-medium registerText">Register</a> | <a href="#" class="text-black hAndCtext">Help & Contact</a></small>
                <?php
                }
                ?>
                <small class="ms-auto techWizdropdown">
                    <a href="#" class="text-decoration-none text-black dropbtn">Tech Wiz <i class="bi bi-chevron-down"></i></a>
                    <div class="techWizdropdown-content">
                        <a href="#" class="px-2 py-1">About us</a>
                        <a href="#" class="px-2 py-1">Report</a>
                    </div>
                </small>
                <a href="cart.php" class="link-dark fs-5"><i class="bi bi-cart2"></i></a>
            </div>
            <hr class="mb-0" />
            <nav class="navbar col-12 col-md-10 offset-md-1 border-bottom border-dark-subtle px-2 px-xxl-4 pt-3 pt-sm-2 z-2" id="navigationbarbottom" style="background-color: #FFFFFF;">

                <div class="col-1 col-sm-auto">
                    <button class="btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions"><span class="navbar-toggler-icon"></span></button>

                    <div class="offcanvas offcanvas-start" data-bs-scroll="true" data-bs-backdrop="static" tabindex="-1" id="offcanvasWithBothOptions" aria-labelledby="offcanvasWithBothOptionsLabel">
                        <div class="offcanvas-header">
                            <h5 class="offcanvas-title comp_title" id="offcanvasWithBothOptionsLabel"><img src="resources/gadgets1.svg" height="45" /> Tech Wiz</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body px-0">
                            <ul class="list-unstyled">
                                <a href="myAccount.php" style="font-family: mago1; font-size: 45px;">
                                    <li class="px-5">My Account</li>
                                </a>
                                <a href="wishlist.php" style="font-family: mago1; font-size: 45px;">
                                    <li class="px-5">Wishlist <i class="bi bi-heart-fill" style="font-size: 25px;"></i></li>
                                </a>
                                <a href="cart.php" style="font-family: mago1; font-size: 45px;">
                                    <li class="px-5">Cart <i class="bi bi-cart2" style="font-size: 25px;"></i></li>
                                </a>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-auto">
                    <a href="home.php" class="text-decoration-none comp_title fw-semibold lh-1" style="font-size: 45px;">Tech Wiz</a>
                </div>

                <div class="d-none d-sm-block col-sm-2 col-md-auto categoryList" onmouseenter="fullWidth();" onmouseleave="wdithZero();">
                    <a href="#" class="text-decoration-none text-black shopbycatName">Shop by category <i class="bi bi-chevron-down"></i></a>
                    <div class="categoryListNames row row-cols-2 row-cols-md-3 row-cols-lg-4 mt-3 rounded rounded-3" id="categoryListNames">
                        <?php
                        $cat_rs = Database::search("SELECT * FROM `category`");
                        $cat_num = $cat_rs->num_rows;

                        for ($x = 0; $x < $cat_num; $x++) {
                            $cat_data = $cat_rs->fetch_assoc();
                        ?>
                            <ul class="categories col list-unstyled">
                                <li><a href="searchresult.php?cat_id=<?php echo $cat_data["category_id"]?>" class="text-black"><?php echo $cat_data["category_name"]; ?></a></li>
                                <ul style="list-style: none; margin-left: -20px;">
                                    <?php
                                    $chb_rs = Database::search("SELECT * FROM category_has_brand INNER JOIN brand ON category_has_brand.brand_brand_id=brand.brand_id WHERE `category_category_id`='" . $cat_data["category_id"] . "'");
                                    $chb_num = $chb_rs->num_rows;

                                    for ($y = 0; $y < $chb_num; $y++) {
                                        $chb_data = $chb_rs->fetch_assoc();
                                    ?>
                                        <li><a href="<?php echo "searchresult.php?cat_id=". $chb_data["category_category_id"]."&bid=". $chb_data["brand_brand_id"]?>" class="text-black-50"><?php echo $chb_data["brand_name"]; ?></a></li>
                                    <?php
                                    }
                                    ?>
                                </ul>
                            </ul>
                        <?php
                        }
                        ?>
                    </div>
                </div>

                <form action="searchresult.php" method="get" id="basicSearch" class="col-5 col-sm-4 col-md-4 col-lg-4 col-xl-5 col-xxl-6">
                    <input type="hidden" name="search" value="basicSearch">
                    <div class="input-group">
                        <input type="text" name="mainSearch" class="form-control" placeholder="&#128269; search" style="min-width: 100px;" />
                        <select class="form-select" name="mainCategory" style="max-width: 200px;">
                            <option value="0" selected>All categories</option>
                            <?php
                            $category_rs = Database::search("SELECT * FROM `category`");
                            $category_num = $category_rs->num_rows;
                            for ($x = 0; $x < $category_num; $x++) {
                                $category_data = $category_rs->fetch_assoc();
                            ?>
                                <option value="<?php echo $category_data["category_id"]; ?>"><?php echo $category_data["category_name"]; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </form>
                <div class="col-1 d-grid text-center">
                    <button class="btn btn-primary" form="basicSearch" type="submit" id="searchbutton"><i class="bi bi-search"></i></button>
                </div>
                <div class="d-none d-lg-block col-lg-auto">
                    <a href="advancedsearch.php" class="advancedSearchText">Advanced Search</a>
                </div>
            </nav>
        </div>
    </div>
    <script>
        var widthTimeout;
        function wdithZero(){
            widthTimeout = setTimeout(() => {
                document.getElementById("categoryListNames").style.width = 0;
            }, 1000);
        }
        function fullWidth() {
            clearTimeout(widthTimeout);
            document.getElementById("categoryListNames").style.width = "fit-content";
        }
    </script>
    <script src="bootstrap.js"></script>
    <script src="script.js"></script>
</body>

</html>