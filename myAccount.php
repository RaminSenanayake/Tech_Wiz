<?php
session_start();
require "connection.php";

if (isset($_SESSION["customer"])) {
    $myAccinfo = Database::search("SELECT `fname`,`lname`,`email`,`mobile`,`dob`,`gender_id`,`gender_name` FROM `customer` INNER JOIN `gender` ON customer.gender_gender_id=gender.gender_id
    WHERE `email`='" . $_SESSION["customer"]["email"] . "'");
    $myAccinfo_data = $myAccinfo->fetch_assoc();
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tech Wiz | My Account</title>

        <link rel="stylesheet" href="style.css" />
        <link rel="stylesheet" href="bootstrap.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" />
        <link rel="icon" href="resources/gadgets.svg" />
    </head>

    <body onload="addressListResize()" onresize="addressListResize(); accordionContentResize()">
        <div class="container-fluid">
            <?php
            include "header.php";
            ?>
            <div class="col-12 col-md-10 offset-md-1 d-flex justify-content-center px-2 px-md-0" style="min-height: 60vh;" id="bodyContent">
                <div class="row">
                    <div class="vertical-menu col-12 mt-4 text-nowrap" id="menulist" onmouseenter="menuwidthup();" onmouseleave="menuwidthdown();">
                        <div class="row">
                            <a href="#" class="active col-6 col-sm-auto"><i class="bi bi-person"></i>&emsp;My account</a>
                            <a href="wishlist.php" class="col-6 col-sm-auto"><i class="bi bi-heart"></i>&emsp;Wishlist</a>
                            <a href="orderSummary.php" class="col-6 col-sm-auto"><i class="bi bi-clipboard2-data"></i>&emsp;Summary</a>
                        </div>
                    </div>
                    <div id="mainBodyContent" class="mainBodyContent">
                        <div class="myAccountAccordion row mt-4 mb-3 ms-lg-1">
                            <div class="myAccountAccordionTitle col-12 lead" onclick="myAccAccordion(this)">
                                Personal Info
                            </div>
                            <div class="myAccountAccordionContent col-12 personalInfo myAccountAccordionCollapse">
                                <div class="row">
                                    <?php
                                    $displayAddress = Database::search("SELECT * FROM `address` INNER JOIN `district` ON address.district_district_id=district.district_id INNER JOIN `province` 
                                    ON district.province_province_id=province.province_id WHERE `customer_email`='" . $_SESSION["customer"]["email"] . "' AND `address_type`='Home'");
                                    $displayAddressNum = $displayAddress->num_rows;
                                    if ($displayAddressNum == 1) {
                                        $displayAddressData = $displayAddress->fetch_assoc();
                                    } else {
                                        $displayAddress = Database::search("SELECT * FROM `address` INNER JOIN `district` ON address.district_district_id=district.district_id INNER JOIN `province` 
                                    ON district.province_province_id=province.province_id WHERE `customer_email`='" . $_SESSION["customer"]["email"] . "' LIMIT 1");
                                        $displayAddressNum = $displayAddress->num_rows;
                                        $displayAddressData = $displayAddress->fetch_assoc();
                                    }
                                    $profilePicRs = Database::search("SELECT * FROM `profile_img` WHERE `customer_email`='" . $_SESSION["customer"]["email"] . "'");
                                    $profilePic = $profilePicRs->fetch_assoc();
                                    if (!empty($profilePic["path"])) {
                                        $profilePic = $profilePic["path"];
                                    } else {
                                        $profilePic = "resources/gadgets.svg";
                                    }
                                    ?>
                                    <div class="col-12 col-sm-5 lead p-3 mt-sm-auto mb-sm-auto" id="PIdisplay">
                                        <div class="profileImg mb-2" id="profileImg" style="background-image: url('<?php echo $profilePic;?>');" onclick="profilePicUpload()">
                                            <div class="profileImgCover">
                                                <i class="bi bi-camera fs-1 text-white"></i>
                                            </div>
                                            <input type="file" name="" id="profileImgUploader" style="visibility: hidden;" accept="image/jpg, image/jpeg, image/png, image/svg+xml">
                                        </div>
                                        <p class="fs-3 fw-semibold"><?php echo $myAccinfo_data["fname"] . " " . $myAccinfo_data["lname"] ?></p>
                                        <?php
                                        if ($displayAddressNum == 1) {
                                        ?>
                                            <p><?php echo $displayAddressData["line_1"], " " . $displayAddressData["line_2"], " " . $displayAddressData["city"] . ".", "<br/>" . $displayAddressData["district_name"], " " . $displayAddressData["province_name"], " " . $displayAddressData["zipcode"] ?></p>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                    <div class="col-12 col-sm-7 myAccPersonalInfoDiv">
                                        <form name="myAccPersonalInfo" method="post" class="row row-gap-2 p-3" onsubmit="myAccPIsubmission();return false" novalidate>
                                            <div class="col-6">
                                                <label for="myAccFirstName" class="form-label">First Name</label>
                                                <input type="text" name="myAccFname" class="form-control" id="myAccFirstName" value="<?php echo $myAccinfo_data["fname"] ?>" placeholder="Enter your First name" maxlength="20" pattern="[A-Za-z]+" oninput="this.className = 'form-control';" required>
                                                <div class="valid-feedback" id="myAccFirstNameValidation">
                                                    Looks good!
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <label for="myAccLastName" class="form-label">Last Name</label>
                                                <input type="text" name="myAccLname" class="form-control" id="myAccLastName" value="<?php echo $myAccinfo_data["lname"] ?>" placeholder="Enter your last name" maxlength="20" pattern="[A-Z,a-z]+" oninput="this.className = 'form-control';" required>
                                                <div class="valid-feedback" id="myAccLastNameValidation">
                                                    Looks good!
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <label for="myAccEmail" class="form-label">Email Address</label>
                                                <div class="input-group">
                                                    <input type="email" class="form-control border-end-0" id="myAccEmail" value="<?php echo $myAccinfo_data["email"] ?>" readonly>
                                                    <a href="#ResetEandMbN" style="background-color: inherit;" class="input-group-text text-primary text-decoration-none" onclick="removeHash();">change</a>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <label for="myAccMobile" class="form-label">Mobile Number</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control border-end-0" id="myAccMobile" value="<?php echo substr_replace($myAccinfo_data["mobile"], "******", 2, 6) ?>" readonly>
                                                    <a href="#ResetEandMbN" style="background-color: inherit;" class="input-group-text text-primary text-decoration-none" onclick="removeHash();">change</a>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <label for="myAccGender" class="form-label">Gender</label>
                                                <select name="myAccGender" id="myAccGender" class="form-select" onchange="this.className = 'form-select';" required>
                                                    <option value="0" disabled>Select a gender</option>
                                                    <?php
                                                    $gender = Database::search("SELECT * FROM `gender`");
                                                    $gender_num = $gender->num_rows;
                                                    for ($i = 0; $i < $gender_num; $i++) {
                                                        $gender_data = $gender->fetch_assoc();
                                                    ?>
                                                        <option value="<?php echo $gender_data["gender_id"] ?>" <?php
                                                                                                                if ($myAccinfo_data["gender_id"] == $gender_data["gender_id"]) {
                                                                                                                ?>selected<?php
                                                                                                                        }
                                                                                                                            ?>><?php echo $gender_data["gender_name"] ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                                <div class="valid-feedback" id="MyAccGenderValidation">
                                                    Looks good!
                                                </div>
                                                <?php
                                                ?>
                                            </div>
                                            <div class="col-6">
                                                <label for="myAccDOB" class="form-label">Date of Birth</label>
                                                <input type="date" name="myAccDOB" class="form-control" id="myAccDOB" value="<?php echo $myAccinfo_data["dob"] ?>" min="1930-01-01" onfocus="this.max=new Date().toISOString().split('T')[0]" onchange="this.className = 'form-control';" required>
                                                <div class="valid-feedback" id="MyAccDOBValidation">
                                                    Looks good!
                                                </div>
                                            </div>
                                            <div class="col-12 mt-2">
                                                <button type="submit" class="btn btn-outline-primary col-auto">Save Changes</button>
                                                <button type="reset" class="btn btn-outline-secondary col-auto ">Reset</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="myAccountAccordionTitle col-12 lead z-1" onclick="myAccAccordion(this)" id="addAddresses">
                                Add Addresses
                            </div>
                            <?php
                            $address = Database::search("SELECT * FROM `address` INNER JOIN `district` ON address.district_district_id=district.district_id INNER JOIN `province` 
                            ON district.province_province_id=province.province_id WHERE `customer_email`='" . $_SESSION["customer"]["email"] . "'");
                            $addressNum = $address->num_rows;
                            ?>
                            <div class="myAccountAccordionContent col-12 myAccountAccordionCollapse" id="addressForm">
                                <div class="row">
                                    <div class="col-12 col-md-4 addressList" id="addressList">
                                        <div class="row">
                                            <?php
                                            if ($addressNum >= 1) {
                                                for ($a = 0; $a < $addressNum; $a++) {
                                                    $addressData = $address->fetch_assoc();
                                            ?>
                                                    <a href="javascript:void(0);" class="lead" id="<?php echo $addressData["address_id"] ?>" onclick="myAccCallAddress(this.id,1)"><?php echo $addressData["address_type"] ?></a>
                                                <?php
                                                }
                                            } else {
                                                ?>
                                                <p class="lead">Add new addresses to your address book.</p>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-8 addressListForm">
                                        <form name="myAccAddressForm" method="post" class="row row-gap-2 p-3" onreset="myAccAddressSubmissionFormReset(); document.getElementById('addressForm').style.height = this.scrollHeight+'px'; newAddressForm();" onsubmit="myAccAddressSubmission(); document.getElementById('addressForm').style.height = this.scrollHeight+'px';return false" novalidate>
                                            <div class="col-12">
                                                <label for="myAccAddFullName" class="form-label">Full Name</label>
                                                <input type="text" name="myAccAddFullName" class="form-control" id="myAccAddFullName" placeholder="Enter full name" maxlength="45" oninput="this.className = 'form-control';" pattern="^([a-zA-Z]+\s)*[a-zA-Z]+$" required>
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <label for="myAccAddline1" class="form-label">Address line 1</label>
                                                <input type="text" name="myAccAddline1" class="form-control" id="myAccAddline1" placeholder="Enter address line 1" maxlength="45" oninput="this.className = 'form-control';" pattern="^([a-zA-Z0-9\/]+,\s){1}([a-zA-Z0-9,]+\s)*[a-zA-Z0-9]+,$" required>
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <label for="myAccAddline2" class="form-label">Address line 2 (optional)</label>
                                                <input type="text" name="myAccAddline2" class="form-control" id="myAccAddline2" placeholder="Enter address line 2 (optional)" maxlength="45" oninput="this.className = 'form-control';" pattern="^([a-zA-Z0-9,]+\s)*[a-zA-Z0-9]+,$">
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <label for="myAccCity" class="form-label">Town/city</label>
                                                <input type="text" name="myAccCity" class="form-control" id="myAccCity" placeholder="Enter the town/city" maxlength="20" oninput="this.className = 'form-control';" pattern="^([a-zA-Z0-9]+\s)*[a-zA-Z0-9]+$" required>
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <label for="myAccProvince" class="form-label">Province</label>
                                                <?php
                                                $province = Database::search("SELECT * FROM `province`");
                                                $province_num = $province->num_rows;
                                                ?>
                                                <select id="myAccProvince" class="form-select" onchange="myAccProvinceDropdownChange(); this.className = 'form-select';" required>
                                                    <option value="0" disabled selected>Select your province</option>
                                                    <?php
                                                    for ($x = 0; $x < $province_num; $x++) {
                                                        $province_data = $province->fetch_assoc();
                                                    ?>
                                                        <option value="<?php echo $province_data["province_id"] ?>"><?php echo $province_data["province_name"] ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <label for="myAccDistrict" class="form-label">District</label>
                                                <select name="myAccAddDistrict" id="myAccDistrict" class="form-select" onchange="this.className = 'form-select';" required>
                                                    <option id="myAccDistrictfirst" value="0" disabled selected>Select your district</option>
                                                </select>
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <label for="myAccZipcode" class="form-label">Zip code</label>
                                                <input type="text" name="myAccAddZipcode" class="form-control" id="myAccZipcode" placeholder="Enter your zip code" maxlength="5" pattern="[0-9]{5}" oninput="this.className = 'form-control';" required>
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                            </div>
                                            <div class="col-12 mt-2 ms-3">
                                                <div class="row">
                                                    <div class="form-check form-check-inline col-auto my-auto">
                                                        <input class="form-check-input myAccAddressInlineRadios" type="radio" name="myAccAddressInlineRadioOptions" id="myAccAddressinlineRadio1" value="Home" oninput="showInputText(this)" required>
                                                        <label class="form-check-label" for="myAccAddressinlineRadio1">Home</label>
                                                    </div>
                                                    <div class="form-check form-check-inline col-auto my-auto">
                                                        <input class="form-check-input myAccAddressInlineRadios" type="radio" name="myAccAddressInlineRadioOptions" id="myAccAddressinlineRadio2" value="Office" oninput="showInputText(this)" required>
                                                        <label class="form-check-label" for="myAccAddressinlineRadio2">Office</label>
                                                    </div>
                                                    <div class="form-check form-check-inline col-auto my-auto">
                                                        <input class="form-check-input myAccAddressInlineRadios" type="radio" name="myAccAddressInlineRadioOptions" id="myAccAddressinlineRadio3" oninput="showInputText(this)" maxlength="220" required>
                                                        <label class="form-check-label" for="myAccAddressinlineRadio3">Other</label>
                                                        <div class="valid-feedback" id="myAccAddRadioValidity">
                                                            Looks good!
                                                        </div>
                                                    </div>
                                                    <div class="col col-xl-auto ps-0 my-xxl-auto" id="myAccAddressinlineRadio3TextContainer">
                                                        <input type="text" class="form-control" id="myAccAddressinlineRadio3Text" oninput="this.className = 'form-control'; radioClassReset()" pattern="^([\S]+\s)*[\S]+$" disabled required>
                                                    </div>
                                                    <div class="col-auto col-sm-12 col-xxl">
                                                        <span class="form-text text-wrap">
                                                            *Home address will be selected as the default address.
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" name="myAccAddressID" value="new">
                                            <div class="col-12 mt-2">
                                                <button id="myAccAddSubmitBtn" type="submit" class="btn btn-outline-primary col-auto">Add Address</button>
                                                <button type="reset" id="myAccAddResetFormBtn" class="btn btn-outline-secondary col-auto">Reset Form</button>
                                                <button type="button" id="myAccNewAddressBtn" class="btn btn-outline-success float-sm-end float-md-none float-lg-end d-none">Add New Address</button>
                                                <button type="button" id="myAccAddressDeleteBtn" class="btn btn-outline-danger mt-2 mt-sm-0 me-sm-1 mt-md-2 mt-lg-0 me-md-0 me-lg-1 float-sm-end float-md-none float-lg-end d-none" onclick="myAccCallAddress(this.value,2)">Delete Address</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            </div>

                            <div class="myAccountAccordionTitle col-12 lead" onclick="myAccAccordion(this)">
                                Reset Mobile Number
                            </div>
                            <div class="myAccountAccordionContent col-12 myAccountAccordionCollapse">
                                <form action="#" method="post" class="row row-gap-3 p-3">
                                    <div class="col-6 col-lg-4 col-xxl-3">
                                        <label for="myAccResetMbNum" class="form-label">Mobile number</label>
                                        <input type="tel" class="form-control" id="myAccResetMbNum" placeholder="Enter your new mobile number" pattern="07[0-2,4,5-8]{1}[0-9]{7}" required>
                                    </div>
                                    <div class="col-6 col-lg-4 col-xxl-3">
                                        <label for="myAccResetVerification" class="form-label">Verification code</label>
                                        <input type="password" class="form-control" id="myAccResetVerification" placeholder="Enter verification code" required>
                                    </div>
                                    <div class="col-12 col-lg-4 col-xxl-3 mt-xxl-auto">
                                        <button type="submit" class="btn btn-outline-primary col-auto">Save Changes</button>
                                        <button type="reset" class="btn btn-outline-secondary col-auto ">Reset</button>
                                    </div>
                                </form>
                            </div>

                            <div class="myAccountAccordionTitle col-12 lead" onclick="myAccAccordion(this)" id="ResetEandMbN">
                                Reset Password
                            </div>
                            <div class="myAccountAccordionContent col-12 myAccountAccordionCollapse">
                                <form action="#" method="post" class="row p-3">
                                    <div class="col-6 col-lg-4 col-xxl-3">
                                        <label for="myAccRP" class="form-label">New password</label>
                                        <input type="password" class="form-control" id="myAccRP" placeholder="Enter your new password" required>
                                    </div>
                                    <div class="col-6 col-lg-4 col-xxl-3">
                                        <label for="myAccRPConfirm" class="form-label">Confirm new password</label>
                                        <input type="password" class="form-control" id="myAccRPConfirm" placeholder="Re-enter your new password" required>
                                    </div>
                                    <div class="col-auto mt-3 mt-lg-auto">
                                        <button type="submit" class="btn btn-outline-primary col-auto">Save Changes</button>
                                        <button type="reset" class="btn btn-outline-secondary col-auto ">Reset</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php include "footer.php" ?>
        </div>
        <div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                    <img src="resources/gadgets.svg" width="20" class="rounded me-2">
                    <strong class="me-auto">Tech wiz</strong>
                    <small>Just now</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body" id="myAccToastBody">
                    Successfully updated.
                </div>
            </div>
        </div>
        <script>
            function removeHash() {
                setTimeout(() => {
                    history.replaceState('', document.title, window.location.origin + window.location.pathname + window.location.search);
                }, 1);
            }

            function addressListResize() {
                if (window.outerWidth >= 768) {
                    document.getElementById('addressList').style.maxHeight = document.myAccAddressForm.scrollHeight + 'px';
                } else {
                    document.getElementById('addressList').style.maxHeight = "170px"
                }
            }

            function radioClassReset() {
                var radios = document.getElementsByClassName("myAccAddressInlineRadios");
                for (var i = 0; i < radios.length; i++) {
                    radios[i].className = "form-check-input myAccAddressInlineRadios";
                }
            }
        </script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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