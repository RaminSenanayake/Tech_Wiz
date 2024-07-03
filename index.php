<?php
if (isset($_COOKIE["email"]) && $_COOKIE["password"]) {
?>
    <script>
        window.location = "home.php"
    </script>
<?php
}
if (isset($_GET["hid"])) {
    $hid = $_GET["hid"];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tech Wiz</title>

    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="bootstrap.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" />
    <link rel="icon" href="resources/gadgets.svg" />
</head>

<body class="bg-body-tertiary" <?php if (isset($_GET["hid"])) { ?>onload="header(<?php echo $hid ?>);" <?php } ?>>

    <div class="container-fluid d-flex min-vh-100 justify-content-center">
        <div class="row align-content-center" id="signInBox">
            <div class="col-12">
                <div class="row text-center fw-bold lh-1">
                    <div class="col-12 logo mb-2"></div>
                    <div style="line-height: 30px;">
                        <h1 class="display-5">Welcome to</h1>
                        <div class="col-10 offset-1 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4 mb-3">
                            <a href="home.php" class="comp_title text-decoration-none">Tech Wiz</a>
                        </div>
                    </div>
                    <h3 class="mb-3">Sign In</h1>
                </div>
            </div>

            <div class="col-10 offset-1 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                <div class="row">
                    <div class="col-12 mb-3">
                        <div class="form-floating">
                            <input class="form-control" type="email" id="signInEmail" placeholder="" />
                            <label for="signInEmail">Email Address</label>
                        </div>
                    </div>

                    <div class="col-12 mb-2">
                        <div class="input-group">
                            <div class="form-floating">
                                <input class="form-control" type="password" id="signInPassword" placeholder="" />
                                <label for="signInPassword">Password</label>
                            </div>
                            <span class="input-group-text" type="button" id="viewSignInPasswordButton" onclick="viewSignInPassword();"><i class="bi bi-eye"></i></span>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="rememberMe" />
                            <label for="rememberMe">Remember Me</label>
                        </div>
                    </div>

                    <div class="col-6 text-end mb-2">
                        <a href="#" class="text-decoration-none" onclick="forgotPasswordModal();">Forgot Password</a>
                    </div>

                    <div class="col-12">
                        <button class="btn btn-primary col-12" id="signInButton" onclick="signIn();">Sign In</button>
                    </div>

                    <div class="col-12 text-center mt-2">
                        <p>New to Tech Wiz? <a href="#" onclick="changeView();" class="text-decoration-none">Create a new account</a></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row align-content-center d-none" id="signUpBox">
            <div class="col-12 mb-3">
                <div class="row text-center fw-bold">
                    <div class="col-12 logo mb-2"></div>
                    <div style="line-height: 30px;">
                        <h1 class="display-5">Welcome to</h1>
                        <div class="col-10 offset-1 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4 mb-3">
                            <a href="home.php" class="comp_title text-decoration-none">Tech Wiz</a>
                        </div>
                    </div>
                    <h3 class="mb-2">Create an account</h1>
                </div>
            </div>

            <div class="col-10 offset-1 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                <div class="row g-2" novalidate>
                    <div class="col-6 ">
                        <div class="form-floating">
                            <input class="form-control" type="text" id="signUpFname" placeholder="" required autocomplete="off"/>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback" id="signUpFnameValidation">
                                Please enter your first name.
                            </div>
                            <label for="signUpFname">First Name</label>
                        </div>

                    </div>

                    <div class="col-6">
                        <div class="form-floating">
                            <input class="form-control" type="text" id="signUpLname" placeholder="" required autocomplete="off" />
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback" id="signUpLnameValidation">
                                Please enter your last name.
                            </div>
                            <label for="signUpLname">Last Name</label>
                        </div>
                    </div>

                    <div class="col-12 ">
                        <div class="form-floating">
                            <input class="form-control" type="email" id="signUpEmail" placeholder="" required />
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback" id="signUpEmailValidation">
                                Please enter your email address.
                            </div>
                            <label for="signUpEmail">Email Address</label>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-floating">
                            <input class="form-control" type="password" id="signUppassword1" placeholder="" required />
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback" id="password1Validation">
                                Please enter your password to register.
                            </div>
                            <label for="signUppassword1">Password</label>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-floating">
                            <input class="form-control" type="password" id="signUppassword2" placeholder="" required />
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback" id="password2Validation">
                                Please re-enter your password to confirm.
                            </div>
                            <label for="signUppassword2">Retype Password</label>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-floating">
                            <input class="form-control" type="tel" id="mobile" placeholder="" pattern="07[0-2,4,5-8]{1}[0-9]{7}" required />
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback" id="suMobileValidation">
                                Please enter your mobile number.
                            </div>
                            <label for="mobile">Mobile Number (+94)</label>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-floating">
                            <select class="form-select" id="gender" aria-label="gender" required>
                                <option value="0" selected disabled>Select your gender</option>
                                <?php
                                require "connection.php";
                                $gender_rs = Database::search("SELECT * FROM `gender`");
                                $gender_num = $gender_rs->num_rows;

                                for ($x = 0; $x < $gender_num; $x++) {
                                    $gender_data = $gender_rs->fetch_assoc();
                                ?>
                                    <option value="<?php echo $gender_data["gender_id"]; ?>"><?php echo $gender_data["gender_name"]; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                            <div class="invalid-feedback">
                                Please select your gender.
                            </div>
                            <label for="gender">Gender</label>
                        </div>
                    </div>

                    <div class="col-12">
                        <button class="btn btn-outline-primary col-12" id="signUpButton" onclick="signUp();">Create Account</button>
                    </div>

                    <div class="col-12 text-center ">
                        <p>Already have an account? <a href="#" onclick="changeView();" class="text-decoration-none">Sign In</a></p>
                    </div>
                </div>
            </div>
        </div>
        <!-- successfully registered modal -->
        <div class="modal fade" id="srModal" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content align-items-center">
                    <div class="modal-body">
                        <h3>Registered Successfully</h3>
                        <div class="row">
                            <img id="sricon" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- successfully registered modal -->
        <!-- forgot password modal -->
        <div class="modal fade" id="fpModal" tabindex="-1" aria-labelledby="forgotPasswordModal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="forgotPasswordModal">Reset Password</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <label for="fpemail" class="col-form-label">Please enter your email address</label>
                        <input type="email" id="fpemail" class="form-control" autocomplete="off" />
                        <div class="invalid-feedback" id="fpemailValidity">
                            Invalid email address.
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="fpModalSubmitButton" class="btn btn-primary" onclick="fpEmailValidation();">Next</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- forgot password modal -->
        <!-- verification code modal -->
        <div class="modal fade" id="fpverificationCodeModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="fpverificationCodeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="fpverificationCodeModalLabel">Enter Verification Code</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12 col-sm-10 offset-sm-1">
                                <div class="row row-cols-6 mt-2" id="enterVerificationCode">
                                    <?php
                                    for ($x = 1; $x <= 6; $x++) {
                                    ?>
                                        <div class="col">
                                            <input type="text" class="form-control" id="verification<?php echo $x; ?>" pattern="[0-9]" maxlength="1" onkeyup="verificationkeyCheck(event);" autocomplete="off" />
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <div><label id="invalidvcodemsg" class="col-form-label text-danger d-none">Incorrect verification code <i class="bi bi-exclamation-circle"></i></label></div>
                                <div><label id="verificationCodeExpiration" class="col-form-label">Verification code will expire in:&nbsp;</label></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="verificationCodeValidationbtn" onclick="verificationCodeValidation()" disabled>Next</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- verification code modal -->
        <!-- reset password modal -->
        <div class="modal fade" id="resetPassword" data-bs-backdrop="static" tabindex="-1" aria-labelledby="resetPasswordLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="resetPasswordLabel">Reset password</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div>
                            <label for="resetPassword1" class="form-label">New password</label>
                            <div class="input-group">
                                <input class="form-control" type="password" id="resetPassword1" placeholder="" />
                                <span class="input-group-text" type="button" id="viewResetPasswordButton1" onclick="viewResetPassword1();"><i class="bi bi-eye"></i></span>
                            </div>
                            <label for="resetPassword1" id="rpvalidity1" class="form-label text-danger d-none"></label>
                        </div>
                        <div>
                            <label for="resetPassword2" class="col-form-label mt-2">Retype new password</label>
                            <div class="input-group">
                                <input class="form-control" type="password" id="resetPassword2" placeholder="" />
                                <span class="input-group-text" type="button" id="viewResetPasswordButton2" onclick="viewResetPassword2();"><i class="bi bi-eye"></i></span>
                            </div>
                            <label for="resetPassword2" id="rpvalidity2" class="form-label text-danger d-none"></label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="rpBtn" class="btn btn-primary" onclick="resetPasswordbtn();">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- reset password modal -->
        <!-- password reset success toast -->
        <div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div id="rpSuccess" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                    <img src="resources/gadgets.svg" width="20" class="rounded me-2">
                    <strong class="me-auto">Tech Wiz</strong>
                    <small>Just now</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body fs-6">
                    Password reset is successful.
                </div>
            </div>
        </div>
        <!-- password reset success toast -->

        <div class="toast-container position-fixed bottom-0 end-0 p-3">

            <div id="signInAlert" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                    <img src="resources/gadgets.svg" width="20" class="rounded me-2">
                    <strong class="me-auto">Tech Wiz</strong>
                    <small>Just now</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body fs-6" id="signInAlertText"></div>
            </div>

        </div>
    </div>
    <div class="text-center border-top" style="height: 50px;">
        <p class="mt-2 text-body-secondary">&copy; Tech Wiz</p>
    </div>
    <script src="bootstrap.js"></script>
    <script src="script.js"></script>
</body>

</html>