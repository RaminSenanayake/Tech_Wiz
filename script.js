//change view between signin and signup
function changeView() {
    var signInBox = document.getElementById("signInBox");
    var signUpBox = document.getElementById("signUpBox");

    signInBox.classList.toggle("d-none");
    signUpBox.classList.toggle("d-none");
}

//change visibility of signin password
function viewSignInPassword() {
    var signInPassword = document.getElementById("signInPassword");
    var viewSignInPasswordButton = document.getElementById("viewSignInPasswordButton");

    if (signInPassword.type == "password") {
        signInPassword.type = "text";
        viewSignInPasswordButton.innerHTML = '<i class="bi bi-eye-slash"></i>';
    } else {
        signInPassword.type = "password";
        viewSignInPasswordButton.innerHTML = '<i class="bi bi-eye"></i>';
    }
}

//signup validations
var su = new FormData();
var fname = document.getElementById("signUpFname");
var fnameValidation = document.getElementById("signUpFnameValidation");
fname.oninput = function () {

    if (fname.value.length == 0) {
        fname.className = "form-control is-invalid";
        fnameValidation.innerHTML = "Please enter your first name."
    } else if (fname.value.length > 20) {
        fname.className = "form-control is-invalid";
        fnameValidation.innerHTML = "First name must have less than 20 characters."
    } else {
        fname.className = "form-control is-valid";
    }
}
fname.onblur = function () {
    if (fname.value.length == 0) {
        fname.className = "form-control is-invalid";
    }
}

var lname = document.getElementById("signUpLname");
var lnameValidation = document.getElementById("signUpLnameValidation");
lname.oninput = function () {

    if (lname.value.length == 0) {
        lname.className = "form-control is-invalid";
        lnameValidation.innerHTML = "Please enter your last name."
    } else if (lname.value.length > 20) {
        lname.className = "form-control is-invalid";
        lnameValidation.innerHTML = "Last name must have less than 20 characters."
    } else {
        lname.className = "form-control is-valid";
    }
}
lname.onblur = function () {
    if (lname.value.length == 0) {
        lname.className = "form-control is-invalid";
    }
}

var email = document.getElementById("signUpEmail");
var emailValidation = document.getElementById("signUpEmailValidation");
document.getElementById("signUpEmail").onblur = function () {

    var fe = new FormData();
    fe.append("email", email.value);

    var re = new XMLHttpRequest();

    re.onreadystatechange = function () {
        if (re.readyState == 4 && re.status == 200) {
            var t = re.responseText;

            if (t == "Please enter your email address.") {
                email.className = "form-control is-invalid";
                emailValidation.innerHTML = t;
            } else if (t == "Email address must have less than 45 characters.") {
                email.className = "form-control is-invalid";
                emailValidation.innerHTML = t;
            } else if (t == "Invalid email address.") {
                email.className = "form-control is-invalid";
                emailValidation.innerHTML = t;
            } else if (t == "An user account already exists under this email address.") {
                email.className = "form-control is-invalid";
                emailValidation.innerHTML = t;
            } else {
                email.className = "form-control is-valid";
            }
        }
    }

    re.open("POST", "signUpEmailValidation.php", true);
    re.send(fe);
}

var suPassword1 = document.getElementById("signUppassword1");
var suPassword2 = document.getElementById("signUppassword2");
var password1Validation = document.getElementById("password1Validation");
var password2Validation = document.getElementById("password2Validation");
suPassword1.oninput = function () {

    if (suPassword1.value.length == 0) {
        suPassword1.className = "form-control is-invalid";
        password1Validation.innerHTML = "Please enter your password to register.";
    } else if (suPassword1.value.length < 5 || suPassword1.value.length > 20) {
        suPassword1.className = "form-control is-invalid";
        password1Validation.innerHTML = "Password length must be between 5 - 20 characters.";
    } else {
        suPassword1.className = "form-control is-valid";

        suPassword2.oninput = function () {
            if (suPassword2.value == 0) {
                suPassword2.className = "form-control is-invalid";
                password2Validation.innerHTML = "Please re-enter your password to confirm.";
            } else if (suPassword2.value != suPassword1.value) {
                suPassword2.className = "form-control is-invalid";
                password2Validation.innerHTML = "Password does not match.";
            } else {
                suPassword2.className = "form-control is-valid";
            }
        }
    }
}
suPassword1.onblur = function () {

    if (suPassword1.value.length == 0) {
        suPassword1.className = "form-control is-invalid";
    }
}

suPassword2.onblur = function () {
    if (suPassword2.value.length == 0) {
        suPassword2.className = "form-control is-invalid";
    }
}

var suMobile = document.getElementById("mobile");
var mobileValidation = document.getElementById("suMobileValidation");
suMobile.oninput = function () {

    var fm = new FormData();
    fm.append("mobile", suMobile.value);

    var rm = new XMLHttpRequest();

    rm.onreadystatechange = function () {
        if (rm.readyState == 4 && rm.status == 200) {
            var t = rm.responseText;

            if (t == "Please enter your mobile number.") {
                suMobile.className = "form-control is-invalid";
                mobileValidation.innerHTML = t;
            } else if (t == "Invalid mobile number.") {
                suMobile.className = "form-control is-invalid";
                mobileValidation.innerHTML = t;
            } else {
                suMobile.className = "form-control is-valid";
            }
        }
    }
    rm.open("POST", "signUpMobileValidation.php", true);
    rm.send(fm);
}

suMobile.onblur = function () {
    if (suMobile.value.length == 0) {
        suMobile.className = "form-control is-invalid";
    }
}

var gender = document.getElementById("gender");
gender.onclick = function () {
    if (gender.value == 1 || gender.value == 2) {
        gender.className = "form-select is-valid";
    }
}

//signup process
function signUp() {
    if (fname.value == 0) {
        fname.className = "form-control is-invalid";
    }
    if (lname.value == 0) {
        lname.className = "form-control is-invalid";
    }
    if (email.value == 0) {
        email.className = "form-control is-invalid";
    }
    if (suPassword1.value == 0) {
        suPassword1.className = "form-control is-invalid";
    }
    if (suPassword2.value == 0) {
        suPassword2.className = "form-control is-invalid";
    }
    if (suMobile.value == 0) {
        suMobile.className = "form-control is-invalid";
    }
    if (gender.value == 0) {
        gender.className = "form-control is-invalid";
    }
    su.append("fname", fname.value);
    su.append("lname", lname.value);
    su.append("email", email.value);
    su.append("password1", suPassword1.value);
    su.append("password2", suPassword2.value);
    su.append("mobile", suMobile.value);
    su.append("gender", gender.value);
    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4 & r.status == 200) {
            var t = r.responseText;
            if (t == "success") {
                srModal();
            }
        }
    }
    r.open("POST", "signUpProcess.php", true);
    r.send(su);

}

//successfully registered modal
var sricon = document.getElementById("sricon");
function srModal() {
    var srbm;
    var sr = document.getElementById("srModal");
    srbm = new bootstrap.Modal(sr);
    srbm.show()
    var check = setInterval(checkmark, 45);
    var checkmarknum = 0;
    function checkmark() {
        checkmarknum++;
        if (checkmarknum == 31) {
            clearInterval(check);
            setTimeout(() => {
                window.location.reload();
            }, 500);
        }
        sricon.src = "resources/sricon/frame-" + checkmarknum + ".png";
    }
}

//signin process
var siemail = document.getElementById("signInEmail");
var sipassword = document.getElementById("signInPassword");
function signIn() {
    var rememberme = document.getElementById("rememberMe");

    var f = new FormData();
    f.append("e", siemail.value);
    f.append("p", sipassword.value);
    f.append("r", rememberme.checked);

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            if (t == "success") {
                window.location = "home.php";
            } else {
                var toastDiv = document.getElementById("signInAlert");
                var toast = bootstrap.Toast.getOrCreateInstance(toastDiv)
                document.getElementById("signInAlertText").innerHTML = t;
                toast.show();
            }
        }
    }

    r.open("POST", "signinProcess.php", true);
    r.send(f);
}

//forgot password modal 1
var fpbm1;
var fpemail = document.getElementById("fpemail")
function forgotPasswordModal() {
    if (fpemail.classList.contains("is-invalid")) {
        fpemail.classList.remove("is-invalid");
    }
    fpemail.value = siemail.value;
    var forgotPasswordmodal1 = document.getElementById("fpModal");
    fpbm1 = new bootstrap.Modal(forgotPasswordmodal1);
    fpbm1.show();
}

//forgot password email verification and opening of verification code entering modal
var fpbm2;
var verification1 = document.getElementById("verification1");
var verification2 = document.getElementById("verification2");
var verification3 = document.getElementById("verification3");
var verification4 = document.getElementById("verification4");
var verification5 = document.getElementById("verification5");
var verification6 = document.getElementById("verification6");
var verificationCodeExpiration = document.getElementById("verificationCodeExpiration");
var countdown;
function fpEmailValidation() {
    var fpemailValidity = document.getElementById("fpemailValidity");
    if (fpemail.value == 0) {
        fpemail.classList.add("is-invalid");
        fpemailValidity.innerHTML = "Please enter your email address.";
    } else {
        var f = new FormData();
        f.append("fpemail", fpemail.value);
        f.append("status", 0);
        var r = new XMLHttpRequest();
        r.onreadystatechange = function () {
            if (r.readyState == 4 && r.status == 200) {
                var t = r.responseText;
                if (t == "Invalid email address.") {
                    fpemail.classList.add("is-invalid");
                    fpemailValidity.innerHTML = t;
                } else {
                    fpbm1.hide();
                    var end = document.cookie.substring(20);
                    var endTime = parseInt(end);
                    countdown = setInterval(() => {
                        var nowTime = new Date().getTime() / 1000;
                        var timeDifference = endTime - nowTime;

                        var minutes = Math.floor(timeDifference / 60);
                        var seconds = Math.floor((timeDifference % 60));

                        if (seconds < 10) {
                            seconds = "0" + seconds;
                        }

                        if (verificationCodeExpiration.classList.contains("text-danger")) {
                            verificationCodeExpiration.classList.remove("text-danger");
                        }
                        verificationCodeExpiration.innerHTML = "Verification code will expire in: " + minutes + ":" + seconds;

                        if (timeDifference < 0) {
                            clearInterval(countdown);
                            verificationCodeExpiration.classList.add("text-danger");
                            verificationCodeExpiration.innerHTML = 'Verification code expired. <a href="#" onclick="resendFpVerificationCode();">Retry</a>';
                            var f1 = new FormData();
                            f1.append("status", 1);
                            f1.append("fpemail", fpemail.value)
                            var re = new XMLHttpRequest();
                            re.open("POST", "forgotPasswordProcess1.php", true);
                            re.send(f1);
                        }
                    }, 1000);
                    if (invalidvcodemsg.classList.contains("d-none") == false) {
                        invalidvcodemsg.classList.add("d-none");
                        verificationCodeExpiration.className = "col-form-label";
                    }
                    setTimeout(() => {
                        verification1.focus();
                    }, 500);
                    const varinputs = document.querySelectorAll("#verification1,#verification2,#verification3,#verification4,#verification5,#verification6");
                    for (var i = 0; i < varinputs.length; i++) {
                        varinputs[i].value = null;
                    }
                    var forgotPasswordmodal2 = document.getElementById("fpverificationCodeModal");
                    fpbm2 = new bootstrap.Modal(forgotPasswordmodal2);
                    fpbm2.show();
                }
            }
        }
        r.open("POST", "forgotPasswordProcess1.php", true);
        r.send(f);
    }
}

//resend forgot password veriication code
function resendFpVerificationCode() {
    var f = new FormData();
    f.append("fpemail", fpemail.value);
    f.append("status", 0);
    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {

            var end = document.cookie.substring(20);
            var endTime = parseInt(end);
            countdown = setInterval(() => {
                var nowTime = new Date().getTime() / 1000;
                var timeDifference = endTime - nowTime;

                var minutes = Math.floor(timeDifference / 60);
                var seconds = Math.floor((timeDifference % 60));

                if (seconds < 10) {
                    seconds = "0" + seconds;
                }

                if (verificationCodeExpiration.classList.contains("text-danger")) {
                    verificationCodeExpiration.classList.remove("text-danger");
                }
                verificationCodeExpiration.innerHTML = "Verification code will expire in: " + minutes + ":" + seconds;

                if (timeDifference < 0) {
                    clearInterval(countdown);
                    verificationCodeExpiration.classList.add("text-danger");
                    verificationCodeExpiration.innerHTML = 'Verification code expired. <a href="#" onclick="resendFpVerificationCode();">Retry</a>';
                    var f1 = new FormData();
                    f1.append("status", 1);
                    f1.append("fpemail", fpemail.value)
                    var re = new XMLHttpRequest();
                    re.open("POST", "forgotPasswordProcess1.php", true);
                    re.send(f1);
                }
            }, 1000);
            if (invalidvcodemsg.classList.contains("d-none") == false) {
                invalidvcodemsg.classList.add("d-none");
                verificationCodeExpiration.className = "col-form-label";
            }
            setTimeout(() => {
                verification1.focus();
            }, 500);
            const varinputs = document.querySelectorAll("#verification1,#verification2,#verification3,#verification4,#verification5,#verification6");
            for (var i = 0; i < varinputs.length; i++) {
                varinputs[i].value = null;
            }

        }
    }
    r.open("POST", "forgotPasswordProcess1.php", true);
    r.send(f);
}

fpemail.oninput = function () {
    if (fpemail.classList.contains("is-invalid")) {
        fpemail.classList.remove("is-invalid");
    }
}

//verification code entering sequence
var vc;
function verificationkeyCheck(event) {
    invalidvcodemsg.classList.add("d-none");
    document.getElementById("verificationCodeExpiration").className = "col-form-label";
    var activeinput = document.activeElement;
    if (event.key == "Backspace" || event.key == "Delete") {
        if (activeinput == verification6) {
            verification5.focus();
            if (verification5.value != null) {
                verification5.select();
            }
        }
        if (activeinput == verification5) {
            verification4.focus();
            if (verification4.value != null) {
                verification4.select();
            }
        }
        if (activeinput == verification4) {
            verification3.focus();
            if (verification3.value != null) {
                verification3.select();
            }
        }
        if (activeinput == verification3) {
            verification2.focus();
            if (verification2.value != null) {
                verification2.select();
            }
        }
        if (activeinput == verification2) {
            verification1.focus();
            if (verification1.value != null) {
                verification1.select();
            }
        }
        if (activeinput == verification1) {
            verification1.focus();
            if (verification1.value != null) {
                verification1.select();
            }
        }
    } else {
        if (activeinput == verification1) {
            verification2.focus();
            if (verification2.value != null) {
                verification2.select();
            }
        }
        if (activeinput == verification2) {
            verification3.focus();
            if (verification3.value != null) {
                verification3.select();
            }
        }
        if (activeinput == verification3) {
            verification4.focus();
            if (verification4.value != null) {
                verification4.select();
            }
        }
        if (activeinput == verification4) {
            verification5.focus();
            if (verification5.value != null) {
                verification5.select();
            }
        }
        if (activeinput == verification5) {
            verification6.focus();
            if (verification6.value != null) {
                verification6.select();
            }
        }
        if (activeinput == verification6) {
            verification6.focus();
        }
    }
    vc = verification1.value + verification2.value + verification3.value + verification4.value + verification5.value + verification6.value;
    if (vc.length == 6) {
        document.getElementById("verificationCodeValidationbtn").disabled = false;
    } else {
        document.getElementById("verificationCodeValidationbtn").disabled = true;
    }
}

//reset password modal
var fpbm3;
var invalidvcodemsg = document.getElementById("invalidvcodemsg");
function verificationCodeValidation() {
    var f = new FormData();
    f.append("fpemail", fpemail.value);
    f.append("vcode", vc);
    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            if (t == "correct verification code") {
                document.cookie = "vcodeExpirationTime=; expires=Thu, 01 Jan 1970 00:00:00 UTC";
                clearInterval(countdown);
                verificationCodeExpiration.innerHTML = "";
                fpbm2.hide();
                if (rpvalidity1.classList.contains("d-none") == false) {
                    rpvalidity1.classList.add("d-none");
                }
                if (rpvalidity2.classList.contains("d-none") == false) {
                    rpvalidity2.classList.add("d-none");
                }
                resetPassword1.value = null;
                resetPassword2.value = null;
                var resetPasswordmodal = document.getElementById("resetPassword");
                fpbm3 = new bootstrap.Modal(resetPasswordmodal);
                fpbm3.show();
            } else {
                invalidvcodemsg.classList.remove("d-none");
                document.getElementById("verificationCodeExpiration").className = "form-label";
            }
        }
    }
    r.open("POST", "forgotPasswordProcess2.php", true);
    r.send(f);
}

//view reset password
var resetPassword1 = document.getElementById("resetPassword1");
function viewResetPassword1() {
    var viewResetPasswordButton1 = document.getElementById("viewResetPasswordButton1");

    if (resetPassword1.type == "password") {
        resetPassword1.type = "text";
        viewResetPasswordButton1.innerHTML = '<i class="bi bi-eye-slash"></i>';
    } else {
        resetPassword1.type = "password";
        viewResetPasswordButton1.innerHTML = '<i class="bi bi-eye"></i>';
    }
}
var resetPassword2 = document.getElementById("resetPassword2");
function viewResetPassword2() {
    var viewResetPasswordButton2 = document.getElementById("viewResetPasswordButton2");

    if (resetPassword2.type == "password") {
        resetPassword2.type = "text";
        viewResetPasswordButton2.innerHTML = '<i class="bi bi-eye-slash"></i>';
    } else {
        resetPassword2.type = "password";
        viewResetPasswordButton2.innerHTML = '<i class="bi bi-eye"></i>';
    }
}

//process of resetting password
var rpvalidity1 = document.getElementById("rpvalidity1");
var rpvalidity2 = document.getElementById("rpvalidity2");
function resetPasswordbtn() {
    if (resetPassword1.value == 0) {
        rpvalidity1.classList.remove("d-none");
        rpvalidity1.innerHTML = 'Please enter your new password <i class="bi bi-exclamation-circle"></i>';
    } else if (resetPassword1.value.length < 5 || resetPassword1.value.length > 20) {
        rpvalidity1.classList.remove("d-none");
        rpvalidity1.innerHTML = 'New password length must be between 5 and 20 <i class="bi bi-exclamation-circle"></i>';

        rpvalidity2.classList.remove("d-none");
        rpvalidity2.innerHTML = 'New password length must be between 5 and 20 <i class="bi bi-exclamation-circle"></i>';
    }
    if (resetPassword2.value == 0) {
        rpvalidity2.classList.remove("d-none");
        rpvalidity2.innerHTML = 'Please re-enter your new password <i class="bi bi-exclamation-circle"></i>';
    } else if (resetPassword1.value != resetPassword2.value) {
        rpvalidity1.classList.remove("d-none");
        rpvalidity1.innerHTML = 'Password does not match <i class="bi bi-exclamation-circle"></i>';

        rpvalidity2.classList.remove("d-none");
        rpvalidity2.innerHTML = 'Password does not match <i class="bi bi-exclamation-circle"></i>';
    }
    if (resetPassword1.value == resetPassword2.value && resetPassword1.value.length >= 5 && resetPassword1.value.length <= 20) {
        var f = new FormData();
        f.append("newPassword", resetPassword1.value);
        f.append("fpemail", fpemail.value);
        var r = new XMLHttpRequest();
        r.onreadystatechange = function () {
            if (r.readyState == 4 && r.status == 200) {
                var t = r.responseText;
                if (t == "success") {
                    fpbm3.hide();
                    var rpSuccess = document.getElementById("rpSuccess");
                    var rpSuccessToast = new bootstrap.Toast(rpSuccess);
                    rpSuccessToast.show();
                }
            }
        }
        r.open("POST", "resetPasswordProcess.php", true);
        r.send(f);
    }
}

resetPassword1.oninput = function () {
    if (rpvalidity1.classList.contains("d-none") == false) {
        rpvalidity1.classList.add("d-none");
    }
}
resetPassword2.oninput = function () {
    if (rpvalidity2.classList.contains("d-none") == false) {
        rpvalidity2.classList.add("d-none");
    }
}

//sign out process
function signOut() {
    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            if (t == "success") {
                window.location = "index.php";
            } else {
                alert(t);
            }
        }
    }
    r.open("GET", "signoutProcess.php", true);
    r.send();
}

//switch between signin and signup in the navbar
function header(x) {
    var signInBox = document.getElementById("signInBox");
    var signUpBox = document.getElementById("signUpBox");
    if (x == 1) {
        signInBox.classList.toggle("d-none");
        signUpBox.classList.toggle("d-none");
    }
}

//product change by clicking on product img
function productChange(imgid, bhmid, pid, colourNum) {
    var previewImg = document.getElementById("pImg" + imgid).src;
    var mainImg = document.getElementById("mainImg");
    mainImg.src = previewImg;
    if (colourNum != 0) {
        window.location = "product.php?bhm_id=" + bhmid + "&pid=" + pid;
    }
}

//product change by changing the colour
function colourChange(bhm_id) {
    var colour = document.getElementById("colourOption");

    window.location = "product.php?bhm_id=" + bhm_id + "&pid=" + colour.value;
}

//add and remove border upon moving cursor to the product img
function borderOn(i) {
    if (document.getElementById("pImg" + i).classList.contains("border") == false) {
        document.getElementById("pImg" + i).classList.add("border");
    }
}
function borderOff(i) {
    var previewImg = document.getElementById("pImg" + i);
    var mainImg = document.getElementById("mainImg").src;
    if (previewImg.src != mainImg) {
        previewImg.classList.remove("border");
    }
}

//border of selected product
function focusBorder(imgId) {
    var previewImg = document.getElementById("pImg" + imgId);
    var mainImg = document.getElementById("mainImg").src;

    if (previewImg.src == mainImg) {
        previewImg.classList.add("border");
        previewImg.classList.add("border-2");
    }
}

//navbar and total checkout box stickyness upon scroll
function stickyHeader() {
    var navigationbartop = document.getElementById("navigationbartop");
    var navigationbarbottom = document.getElementById("navigationbarbottom");
    var bodyContent = document.getElementById("bodyContent");
    var cartCheckout = document.getElementById("cartCheckout");
    if (window.scrollY >= navigationbartop.offsetHeight) {
        bodyContent.style.paddingTop = navigationbarbottom.offsetHeight + "px";
        navigationbarbottom.classList.add("sticky", "row");
        navigationbarbottom.classList.remove("col-md-10", "offset-md-1");
        if (window.innerWidth >= 1200) {
            cartCheckout.classList.add("cartCheckoutSticky");
            cartCheckout.classList.remove("mt-3");
            if (cartCheckout.classList.contains("position-absolute")) {
                cartCheckout.classList.replace("position-absolute", "position-fixed");
            } else {
                cartCheckout.classList.add("position-fixed");
            }
            cartCheckout.classList.remove("fixed-bottom");
        } else {
            cartCheckout.classList.remove("cartCheckoutSticky");
            cartCheckout.classList.remove("mt-3");
            if (cartCheckout.classList.contains("position-absolute")) {
                cartCheckout.classList.replace("position-absolute", "fixed-bottom");
            } else {
                cartCheckout.classList.add("fixed-bottom");
            }
        }
    } else {
        bodyContent.style.paddingTop = "0px";
        navigationbarbottom.classList.remove("sticky", "row");
        navigationbarbottom.classList.add("col-md-10", "offset-md-1");
        if (window.innerWidth >= 1200) {
            cartCheckout.classList.add("cartCheckoutSticky");
            cartCheckout.classList.add("mt-3");
            if (cartCheckout.classList.contains("position-fixed")) {
                cartCheckout.classList.replace("position-fixed", "position-absolute");
            } else {
                cartCheckout.classList.add("position-absolute");
            }
            cartCheckout.classList.remove("fixed-bottom");
        } else {
            cartCheckout.classList.remove("cartCheckoutSticky");
            cartCheckout.classList.remove("mt-3");
            if (cartCheckout.classList.contains("position-absolute")) {
                cartCheckout.classList.replace("position-absolute", "fixed-bottom");
            } else {
                cartCheckout.classList.add("fixed-bottom");
            }
        }
    }
}

//max and min price range form activation and deactivation in advanced search
function priceRangeCheck() {
    var fromPrice = document.getElementById("fromPrice");
    var toPrice = document.getElementById("toPrice");
    if (document.getElementById("priceRange").checked) {
        fromPrice.disabled = false;
        toPrice.disabled = false;
    } else {
        fromPrice.value = null;
        toPrice.value = null;
        fromPrice.disabled = true;
        toPrice.disabled = true;
    }
}

//change displayed value when range is dragged in advanced search
function ratingRangeInput() {
    var ranges = document.querySelectorAll("datalist#ranges > option");
    var ratingRange = document.getElementById("ratingRange");
    ranges.forEach((ranges) => {
        if (ranges.value == ratingRange.value) {
            ranges.style.color = "inherit";
        } else {
            ranges.style.color = "transparent";
        }
    });
}

//remove compulsory requirement on both checkboxes when either brand new or used checkbox is checked in advanced search
function asConditionCheck() {
    if (document.getElementById("conditionCheck0").checked || document.getElementById("conditionCheck1").checked) {
        document.getElementById("conditionCheck0").required = false;
        document.getElementById("conditionCheck1").required = false;
    }
}

//button deactivation when the product quantity is not within the threshold in single product view
function buyNowbuttonActiveStatus(x) {
    var buyNowButton = document.getElementById("buyNowButton");
    var qtyThreshold = document.getElementById("qtyThreshold").value;
    if (qtyThreshold < 1 || qtyThreshold > x) {
        buyNowButton.disabled = true;
    } else {
        buyNowButton.disabled = false;
    }
}

//click function upon pressing enter
var enterPress = document.querySelectorAll("input");
for (var e = 0; e < enterPress.length; e++) {
    enterPress[e].addEventListener("keypress", (event) => {
        if (event.key === "Enter") {
            document.getElementById("signInButton").click();
            document.getElementById("signUpButton").click();
            document.getElementById("searchbutton").click();
        }
    });
}

//add to cart function in single product view
function spvAddToCart(pid) {
    var addToCartBtn = document.getElementById("addToCartBtn");
    var cartSuccess = document.getElementById("spvAddToCartSuccess");
    var cartToastText = document.getElementById("spvAddToCartSuccessText");
    var qty = document.getElementById("qtyThreshold");
    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            if (t == "Product added to your shopping cart.") {
                cartToastText.innerHTML = t;
                var cartSuccessToast1 = new bootstrap.Toast(cartSuccess);
                cartSuccessToast1.show();
                addToCartBtn.innerHTML = 'View in cart <i class="bi bi-cart2"></i>';
                addToCartBtn.setAttribute("href", "cart.php");
            } else if (t = "Sign in into your account first.") {
                cartToastText.innerHTML = t;
                var cartSuccessToast2 = new bootstrap.Toast(cartSuccess);
                cartSuccessToast2.show();
            }
        }
    }
    r.open("GET", "addToCartProcess.php?pid=" + pid + "&qty=" + qty.value, true);
    r.send();
}

//add to cart and already added to cart function (except in single product view)
function addToCart(pid) {

    //toast header
    var toastheader = document.createElement("div");
    toastheader.classList.add("toast-header");
    var toastcompanylogo = document.createElement("img");
    toastcompanylogo.src = "resources/gadgets.svg";
    toastcompanylogo.setAttribute("width", "20");
    toastcompanylogo.classList.add("rounded", "me-2");
    var toastcompanyname = document.createElement("strong");
    toastcompanyname.className = "me-auto";
    toastcompanyname.innerHTML = "Tech Wiz";
    var justnow = document.createElement("small");
    justnow.innerHTML = "Just now";
    var toastCloseBtn = document.createElement("button");
    toastCloseBtn.type = "button";
    toastCloseBtn.className = "btn-close";
    toastCloseBtn.setAttribute("data-bs-dismiss", "toast");
    toastCloseBtn.setAttribute("aria-label", "Close");
    toastheader.append(toastcompanylogo, toastcompanyname, justnow, toastCloseBtn);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            if (t == "Product added to your shopping cart.") {
                //cart success div
                var addToCartSuccessDiv = document.createElement("div");
                addToCartSuccessDiv.id = "addToCartSuccess" + pid;
                addToCartSuccessDiv.classList.add("toast");
                addToCartSuccessDiv.setAttribute("role", "alert");
                addToCartSuccessDiv.setAttribute("aria-live", "assertive");
                addToCartSuccessDiv.setAttribute("aria-atomic", "true");

                //appending toastheader to toast
                addToCartSuccessDiv.appendChild(toastheader);

                //creating toast body
                var toastbody = document.createElement("div");
                toastbody.classList.add("toast-body", "fs-6");
                var row = document.createElement("div");
                row.className = "row";

                //creating toast body img conatiner
                var prodimgcontainer = document.createElement("div");
                prodimgcontainer.classList.add("col-3", "text-center");

                //creating toast body img (without src)
                var prodimg = document.createElement("img");
                prodimg.id = "addToCartSuccessImg" + pid;
                prodimg.setAttribute("width", "55");

                //appending img to container
                prodimgcontainer.append(prodimg);

                //creating toastbody text div 
                var toastbodytext = document.createElement("div");
                toastbodytext.classList.add("col-9", "text-start", "align-self-center");
                toastbodytext.id = "addToCartSuccessText" + pid;

                //appending img container and toastbodytext to toastbody
                row.append(prodimgcontainer, toastbodytext);
                toastbody.append(row);

                //appending toastbody to toast
                addToCartSuccessDiv.appendChild(toastbody);

                //appending toast to toast container
                document.getElementById("hometoastcontainer1").append(addToCartSuccessDiv);

                var cartSuccess = document.getElementById("addToCartSuccess" + pid);
                document.getElementById("addToCartSuccessText" + pid).innerHTML = t;
                var cartSuccessToast = new bootstrap.Toast(cartSuccess);
                toastImgChange(pid, 1);
                cartSuccessToast.show();
            } else if (t == "Product already exist in cart") {

                //cart already added div
                var cartAlreadyAddedDiv = document.createElement("div");
                cartAlreadyAddedDiv.id = "addToCartAlreadyAdded" + pid;
                cartAlreadyAddedDiv.setAttribute("class", "toast");
                cartAlreadyAddedDiv.setAttribute("role", "alert");
                cartAlreadyAddedDiv.setAttribute("aria-live", "assertive");
                cartAlreadyAddedDiv.setAttribute("aria-atomic", "true");

                //appending toastheader to toast
                cartAlreadyAddedDiv.appendChild(toastheader);

                //creating toast body
                var toastbody = document.createElement("div");
                toastbody.classList.add("toast-body", "fs-6");
                var row = document.createElement("div");
                row.className = "row";

                //creating toast body img conatiner
                var prodimgcontainer = document.createElement("div");
                prodimgcontainer.classList.add("col-3", "text-center");

                //creating toast body img (without src)
                var prodimg = document.createElement("img");
                prodimg.id = "addToCartAlreadyAddedImg" + pid;
                prodimg.setAttribute("width", "55");

                //appending img to container
                prodimgcontainer.append(prodimg);

                //creating toastbody text div 
                var toastbodytext = document.createElement("div");
                toastbodytext.classList.add("col-9", "text-start", "align-self-center");
                toastbodytext.id = "addToCartAlreadyAddedText" + pid;

                //appending img container and toastbodytext to toastbody
                row.append(prodimgcontainer, toastbodytext);
                toastbody.append(row);

                //appending toastbody to toast
                cartAlreadyAddedDiv.appendChild(toastbody);

                //appending toast to toast container
                document.getElementById("hometoastcontainer1").append(cartAlreadyAddedDiv);

                var cartAlreadyAdded = document.getElementById("addToCartAlreadyAdded" + pid);
                document.getElementById("addToCartAlreadyAddedText" + pid).innerHTML = t;
                var cartAlreadyAddedToast = new bootstrap.Toast(cartAlreadyAdded);
                cartAlreadyAddedToast.show();
                toastImgChange(pid, 2);
            } else {
                var cartSignInalert = document.getElementById("addToCartSignIn");
                document.getElementById("addToCartSignInText").innerHTML = t;
                var cartSignInToast = new bootstrap.Toast(cartSignInalert);
                cartSignInToast.show();
            }
        }
    }
    r.open("GET", "addToCartProcess.php?pid=" + pid, true);
    r.send();
}

//add to cart and already added to cart toasts img importing
function toastImgChange(prod_id, responsenum) {
    var cartSuccessImg = document.getElementById("addToCartSuccessImg" + prod_id);
    var cartAlrAddedImg = document.getElementById("addToCartAlreadyAddedImg" + prod_id);
    var wishlistSuccessImg = document.getElementById("addToWishlistSuccessImg" + prod_id);
    var wislistAlrAddedImg = document.getElementById("addToWishlistAlreadyAddedImg" + prod_id);
    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            if (responsenum == 1) {
                cartSuccessImg.src = t;
            } else if (responsenum == 2) {
                cartAlrAddedImg.src = t;
            } else if (responsenum == 3) {
                wishlistSuccessImg.src = t;
            } else {
                wislistAlrAddedImg.src = t;
            }
        }
    }
    r.open("GET", "toastImg.php?pid=" + prod_id, true);
    r.send();
}

//calculations of totals in the cart checkout total box
function subCal(itemId, cartCardid) {
    var cartqty = document.getElementById("qtyselect" + cartCardid);
    var cartFormInputs = document.cartForm;
    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            var cart = JSON.parse(t)
            document.getElementById("itemPrice" + cartCardid).innerHTML = "Rs." + cart[0];
            document.getElementById("itemShippingInput" + cartCardid).innerHTML = "Rs." + cart[1];
            document.getElementById("cartSubtotal").innerHTML = "Rs." + cart[2];
            cartFormInputs.subTotal.value = cart[2];
            document.getElementById("cardShippingTotal").innerHTML = "Rs." + cart[3];
            document.getElementById("cardTotal").innerHTML = "Rs." + cart[4];
            cartFormInputs.cartTotal.value = cart[4];
            document.getElementById("itemNum").innerHTML = "Subtotal (items " + cart[5] + ")";
            cartFormInputs.totalShipping.value = cart[6];
            document.getElementById("itemShipping" + cartCardid).value = cart[1];
        }
    }
    r.open("GET", "subTotalCal.php?pid=" + itemId + "&cartQty=" + cartqty.value, true);
    r.send();
}

//recalculation in cart checkout total box upon removing an item
function removeCartItem(cartItemId, product_id) {
    var cartItem = document.getElementById("cartItemCard" + cartItemId);
    var cartFormInputs = document.cartForm;
    cartItem.remove();
    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            if (t == "noItems") {
                window.location.reload();
            } else {
                var cart = JSON.parse(t)
                document.getElementById("cartSubtotal").innerHTML = "Rs." + cart[0];
                cartFormInputs.subTotal.value = cart[0];
                document.getElementById("cardShippingTotal").innerHTML = "Rs." + cart[1];
                cartFormInputs.totalShipping.value = cart[5];
                document.getElementById("cardTotal").innerHTML = "Rs." + cart[2];
                cartFormInputs.cartTotal.value = cart[2];
                document.getElementById("itemNum").innerHTML = "Subtotal (items " + cart[3] + ")";
                cartFormInputs.numOfItems.value = cart[4];
                for (var x = 0; x < cart[4] + 1; x++) {
                    if (x > cartItemId) {
                        document.getElementById("productName" + x).name = "productName" + (x - 1);
                        document.getElementById("qtyselect" + x).name = "qty" + (x - 1);
                        document.getElementById("itemPriceInput" + x).name = "itemPrice" + (x - 1);
                        document.getElementById("itemShipping" + x).name = "itemShipping" + (x - 1);
                        document.getElementById("prodImg" + x).name = "prodImg" + (x - 1);
                    }
                }
            }
        }
    }
    r.open("GET", "removeCartItem.php?pid=" + product_id, true);
    r.send();
}

//add to wishlist function in single product view
function spvAddToWishlist(pid) {
    var addToWishlisttBtn = document.getElementById("addToWishlistBtn");
    var wishlistSuccess = document.getElementById("spvAddToWishlistSuccess");
    var wishlistToastText = document.getElementById("spvAddToWishlistSuccessText");
    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            if (t == "Product added to your wishlist.") {
                wishlistToastText.innerHTML = t;
                var wishlistSuccessToast1 = new bootstrap.Toast(wishlistSuccess);
                wishlistSuccessToast1.show();
                addToWishlisttBtn.innerHTML = 'View in wishlist <i class="bi bi-heart"></i>';
                addToWishlisttBtn.setAttribute("href", "wishlist.php");
            } else if (t = "Sign in into your account first.") {
                wishlistToastText.innerHTML = t;
                var wishlisttSuccessToast2 = new bootstrap.Toast(wishlistSuccess);
                wishlisttSuccessToast2.show();
            }
        }
    }
    r.open("GET", "addToWishlistProcess.php?pid=" + pid, true);
    r.send();
}

//add to wishlist and already added to wishlist function (except in single product view)
function addToWishlist(pid) {

    //toast header
    var toastheader = document.createElement("div");
    toastheader.classList.add("toast-header");
    var toastcompanylogo = document.createElement("img");
    toastcompanylogo.src = "resources/gadgets.svg";
    toastcompanylogo.setAttribute("width", "20");
    toastcompanylogo.classList.add("rounded", "me-2");
    var toastcompanyname = document.createElement("strong");
    toastcompanyname.className = "me-auto";
    toastcompanyname.innerHTML = "Tech Wiz";
    var justnow = document.createElement("small");
    justnow.innerHTML = "Just now";
    var toastCloseBtn = document.createElement("button");
    toastCloseBtn.type = "button";
    toastCloseBtn.className = "btn-close";
    toastCloseBtn.setAttribute("data-bs-dismiss", "toast");
    toastCloseBtn.setAttribute("aria-label", "Close");
    toastheader.append(toastcompanylogo, toastcompanyname, justnow, toastCloseBtn);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            if (t == "Product added to your wishlist.") {
                //wishlist success div
                var addToWishlistSuccessDiv = document.createElement("div");
                addToWishlistSuccessDiv.id = "addToWishlistSuccess" + pid;
                addToWishlistSuccessDiv.classList.add("toast");
                addToWishlistSuccessDiv.setAttribute("role", "alert");
                addToWishlistSuccessDiv.setAttribute("aria-live", "assertive");
                addToWishlistSuccessDiv.setAttribute("aria-atomic", "true");

                //appending toastheader to toast
                addToWishlistSuccessDiv.appendChild(toastheader);

                //creating toast body
                var toastbody = document.createElement("div");
                toastbody.classList.add("toast-body", "fs-6");
                var row = document.createElement("div");
                row.className = "row";

                //creating toast body img conatiner
                var prodimgcontainer = document.createElement("div");
                prodimgcontainer.classList.add("col-3", "text-center");

                //creating toast body img (without src)
                var prodimg = document.createElement("img");
                prodimg.id = "addToWishlistSuccessImg" + pid;
                prodimg.setAttribute("width", "55");

                //appending img to container
                prodimgcontainer.append(prodimg);

                //creating toastbody text div 
                var toastbodytext = document.createElement("div");
                toastbodytext.classList.add("col-9", "text-start", "align-self-center");
                toastbodytext.id = "addToWishlistSuccessText" + pid;

                //appending img container and toastbodytext to toastbody
                row.append(prodimgcontainer, toastbodytext);
                toastbody.append(row);

                //appending toastbody to toast
                addToWishlistSuccessDiv.appendChild(toastbody);

                //appending toast to toast container
                document.getElementById("hometoastcontainer1").append(addToWishlistSuccessDiv);

                var wishlistSuccess = document.getElementById("addToWishlistSuccess" + pid);
                document.getElementById("addToWishlistSuccessText" + pid).innerHTML = t;
                var wishlistSuccessToast = new bootstrap.Toast(wishlistSuccess);
                toastImgChange(pid, 3);
                wishlistSuccessToast.show();
            } else if (t == "Product already exist in wishlist.") {

                //wishlist already added div
                var wishlistAlreadyAddedDiv = document.createElement("div");
                wishlistAlreadyAddedDiv.id = "addToWishlistAlreadyAdded" + pid;
                wishlistAlreadyAddedDiv.setAttribute("class", "toast");
                wishlistAlreadyAddedDiv.setAttribute("role", "alert");
                wishlistAlreadyAddedDiv.setAttribute("aria-live", "assertive");
                wishlistAlreadyAddedDiv.setAttribute("aria-atomic", "true");

                //appending toastheader to toast
                wishlistAlreadyAddedDiv.appendChild(toastheader);

                //creating toast body
                var toastbody = document.createElement("div");
                toastbody.classList.add("toast-body", "fs-6");
                var row = document.createElement("div");
                row.className = "row";

                //creating toast body img conatiner
                var prodimgcontainer = document.createElement("div");
                prodimgcontainer.classList.add("col-3", "text-center");

                //creating toast body img (without src)
                var prodimg = document.createElement("img");
                prodimg.id = "addToWishlistAlreadyAddedImg" + pid;
                prodimg.setAttribute("width", "55");

                //appending img to container
                prodimgcontainer.append(prodimg);

                //creating toastbody text div 
                var toastbodytext = document.createElement("div");
                toastbodytext.classList.add("col-9", "text-start", "align-self-center");
                toastbodytext.id = "addToWishlistAlreadyAddedText" + pid;

                //appending img container and toastbodytext to toastbody
                row.append(prodimgcontainer, toastbodytext);
                toastbody.append(row);

                //appending toastbody to toast
                wishlistAlreadyAddedDiv.appendChild(toastbody);

                //appending toast to toast container
                document.getElementById("hometoastcontainer1").append(wishlistAlreadyAddedDiv);

                var wishlistAlreadyAdded = document.getElementById("addToWishlistAlreadyAdded" + pid);
                document.getElementById("addToWishlistAlreadyAddedText" + pid).innerHTML = t;
                var wishlistAlreadyAddedToast = new bootstrap.Toast(wishlistAlreadyAdded);
                wishlistAlreadyAddedToast.show();
                toastImgChange(pid, 4);
            } else {
                var wishlistSignInalert = document.getElementById("addToWishlistSignIn");
                document.getElementById("addToWishlistSignInText").innerHTML = t;
                var wishlistSignInToast = new bootstrap.Toast(wishlistSignInalert);
                wishlistSignInToast.show();
            }
        }
    }
    r.open("GET", "addToWishlistProcess.php?pid=" + pid, true);
    r.send();
}

//removal of items from the wishlist
function removeWishlistItem(product_id) {
    var wishlisttItem = document.getElementById("wishlistItemCard" + product_id);
    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            if (t == "noItems") {
                window.location.reload();
            } else {
                wishlisttItem.remove();
            }
        }
    }
    r.open("GET", "removeWishlistItem.php?pid=" + product_id, true);
    r.send();
}
function removeMultipleWishlistItems() {
    var checks = document.getElementsByClassName("wlSelectChecks");
    for (var i = 0; i < checks.length; i++) {
        if (checks[i].checked) {
            removeWishlistItem(checks[i].id);
        }
    }
}

//resizing of main body content box when cursor is brought to the vertical menu (containing wishlist, my account etc.) 
function menuwidthup() {
    if (window.matchMedia("(min-width:992px)").matches) {
        document.getElementById("mainBodyContent").style.width = "calc(100% - 230px)";
    }
}
function menuwidthdown() {
    if (window.matchMedia("(min-width:992px)").matches) {
        document.getElementById("mainBodyContent").style.width = "calc(100% - 50px)";
    }
}

//selecting all wishlist cards with select all check
function wishlistSelectAllCheckFunction(check) {
    var checkboxes = document.getElementsByClassName("wlSelectChecks");
    for (var x = 0; x < checkboxes.length; x++) {
        checkboxes[x].checked = check.checked;
    }
}

//select all check is checked when all wishlist products are selected
function wishlistProductCheck() {
    var allCheckboxesChecked = 1;
    var selectAllCheck = document.getElementById("wishlistSelectAllCheck");
    var checks = document.getElementsByClassName("wlSelectChecks");
    for (var i = 0; i < checks.length; i++) {
        if (checks[i].checked) {
            allCheckboxesChecked = allCheckboxesChecked * 1;
        } else {
            allCheckboxesChecked = allCheckboxesChecked * 0;
        }
    }
    if (allCheckboxesChecked == 1) {
        selectAllCheck.checked = true;
    } else {
        selectAllCheck.checked = false;
    }
}

//removing the disability from the wishlist buttons when one or more product is selected
function wishlistBtnRemoveDisability() {
    var checks = document.getElementsByClassName("wlSelectChecks");
    var atcBtn = document.getElementById("wlAddToCheckoutBtn");
    var rfwBtn = document.getElementById("removeFromWishlistBtn");
    for (var i = 0; i < checks.length; i++) {
        if (checks[i].checked) {
            atcBtn.disabled = rfwBtn.disabled = false;
            break;
        } else {
            atcBtn.disabled = rfwBtn.disabled = true;
        }
    }
}

function addToCartFromWishlist() {
    var checks = document.getElementsByClassName("wlSelectChecks");
    var pids = new Array();
    var cardNum = 0;
    for (var i = 0; i < checks.length; i++) {
        if (checks[i].checked) {
            pids[cardNum] = checks[i].id;
            cardNum++;
        }
    }
    var prod_ids = JSON.stringify(pids);
    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var responseArrays = JSON.parse(request.responseText);
            if (responseArrays["cart_product_added"] != null) {
                for (var x = 0; x < responseArrays["cart_product_added"].length; x++) {
                    document.getElementById("wishlistItemCard" + responseArrays["cart_product_added"][x]).remove();
                }
            }
            if (responseArrays["cart_already_added"] != null) {
                for (var y = 0; y < responseArrays["cart_already_added"].length; y++) {
                    document.getElementById("wlproductAlreadyAddedText" + responseArrays["cart_already_added"][y]).style.display = "block";
                }
            }
            if (checks.length == 0) {
                window.location.reload();
            }
        }
    }
    request.open("GET", "addToCartFromWishlistProcess.php?pids=" + prod_ids + "&arrayLength=" + pids.length, true);
    request.send();
}

//My account accordion 
function myAccAccordion(element) {
    if (element.nextElementSibling.style.height == element.nextElementSibling.scrollHeight + "px") {
        element.nextElementSibling.style.height = "0";
    } else {
        element.nextElementSibling.style.height = element.nextElementSibling.scrollHeight + "px";
        var accordionContentDivs = document.querySelectorAll(".myAccountAccordionContent:not(.personalInfo)");
        for (let index = 0; index < accordionContentDivs.length; index++) {
            if (element.nextElementSibling != accordionContentDivs[index]) {
                accordionContentDivs[index].style.height = "0";
            }
        }
    }
}

function myAccProvinceDropdownChange() {
    var provID = document.getElementById("myAccProvince").value;
    var request = new XMLHttpRequest();
    var option;
    var districtDropdown = document.getElementById("myAccDistrict");
    while (districtDropdown.children.length > 1) {
        districtDropdown.removeChild(districtDropdown.lastElementChild);
    }
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var districts = JSON.parse(request.responseText);
            for (var index = 0; index < districts["districtID"].length; index++) {
                option = document.createElement("option");
                option.value = districts["districtID"][index];
                option.innerHTML = districts["districtName"][index];
                districtDropdown.appendChild(option);
            }
        }
    }
    request.open("GET", "provincechange.php?provID=" + provID, true);
    request.send();
}

function myAccPIsubmission() {
    var form = document.myAccPersonalInfo;
    var request = new XMLHttpRequest();
    if (form.myAccFname.validity.valueMissing) {
        form.myAccFname.nextElementSibling.className = "invalid-feedback";
        form.myAccFname.nextElementSibling.innerHTML = "Enter your first name.";
        form.myAccFname.classList.add("is-invalid");
    } else if (form.myAccFname.validity.patternMismatch) {
        form.myAccFname.nextElementSibling.className = "invalid-feedback";
        form.myAccFname.nextElementSibling.innerHTML = "Enter a valid first name.";
        form.myAccFname.classList.add("is-invalid");
    } else if (form.myAccFname.validity.tooLong) {
        form.myAccFname.nextElementSibling.className = "invalid-feedback";
        form.myAccFname.nextElementSibling.innerHTML = "First Name must be less than 20 characters.";
        form.myAccFname.classList.add("is-invalid");
    } else {
        form.myAccFname.nextElementSibling.className = "valid-feedback";
        form.myAccFname.nextElementSibling.innerHTML = "Looks good!";
        form.myAccFname.classList.add("is-valid");
    }

    if (form.myAccLname.validity.valueMissing) {
        form.myAccLname.nextElementSibling.className = "invalid-feedback";
        form.myAccLname.nextElementSibling.innerHTML = "Enter your last name.";
        form.myAccLname.classList.add("is-invalid");
    } else if (form.myAccLname.validity.patternMismatch) {
        form.myAccLname.nextElementSibling.className = "invalid-feedback";
        form.myAccLname.nextElementSibling.innerHTML = "Enter a valid last name.";
        form.myAccLname.classList.add("is-invalid");
    } else if (form.myAccLname.validity.tooLong) {
        form.myAccLname.nextElementSibling.className = "invalid-feedback";
        form.myAccLname.nextElementSibling.innerHTML = "Last Name must be less than 20 characters.";
        form.myAccLname.classList.add("is-invalid");
    } else {
        form.myAccLname.nextElementSibling.className = "valid-feedback";
        form.myAccLname.nextElementSibling.innerHTML = "Looks good!";
        form.myAccLname.classList.add("is-valid");
    }

    if (form.myAccGender.value == 0) {
        form.myAccGender.nextElementSibling.className = "invalid-feedback";
        form.myAccGender.nextElementSibling.innerHTML = "Please choose a gender.";
        form.myAccGender.classList.add("is-invalid");
    } else {
        form.myAccGender.nextElementSibling.className = "valid-feedback";
        form.myAccGender.nextElementSibling.innerHTML = "Looks good!";
        form.myAccGender.classList.add("is-valid");
    }

    if (!form.myAccDOB.checkValidity()) {
        form.myAccDOB.nextElementSibling.className = "invalid-feedback";
        form.myAccDOB.nextElementSibling.innerHTML = "Please choose your date of birth.";
        form.myAccDOB.classList.add("is-invalid");
    } else {
        form.myAccDOB.nextElementSibling.className = "valid-feedback";
        form.myAccDOB.nextElementSibling.innerHTML = "Looks good!";
        form.myAccDOB.classList.add("is-valid");
    }
    if (form.checkValidity()) {
        var f = new FormData(form);
        request.onreadystatechange = function () {
            if (request.readyState == 4 && request.status == 200) {
                var toast = document.getElementById("liveToast");
                document.getElementById("myAccToastBody").innerHTML = request.responseText;
                var liveToast = new bootstrap.Toast(toast);
                liveToast.show();

                setTimeout(() => {
                    window.location.reload();
                }, 5000);
            }
        }
        request.open("POST", "myAccPIupdate.php", true);
        request.send(f);
    }
}


function showInputText(element) {
    var textInput = document.getElementById("myAccAddressinlineRadio3Text");
    var radio = document.getElementById("myAccAddressinlineRadio3");
    var AddRadios = document.getElementsByClassName("myAccAddressInlineRadios");
    if (element == radio) {
        textInput.disabled = false;
        textInput.focus();
    } else {
        textInput.disabled = true;
        textInput.value = null;
    }
    for (var i = 0; i < AddRadios.length; i++) {
        AddRadios[i].classList.remove("is-invalid", "is-valid");
    }
}


function myAccAddressSubmission() {
    var form = document.myAccAddressForm;
    var myAccAddradios = document.getElementsByName("myAccAddressInlineRadioOptions");
    var radioValidity = document.getElementById("myAccAddRadioValidity");
    var radioTextInput = document.getElementById("myAccAddressinlineRadio3Text");
    var province = document.getElementById("myAccProvince");
    var request = new XMLHttpRequest();

    if (form.myAccAddFullName.validity.valueMissing) {
        form.myAccAddFullName.nextElementSibling.className = "invalid-feedback";
        form.myAccAddFullName.nextElementSibling.innerHTML = "Enter Full name.";
        form.myAccAddFullName.classList.add("is-invalid");
    } else if (form.myAccAddFullName.validity.patternMismatch) {
        form.myAccAddFullName.nextElementSibling.className = "invalid-feedback";
        form.myAccAddFullName.nextElementSibling.innerHTML = "Cannot contain numbers and cannot contain spaces at the beginning and end.";
        form.myAccAddFullName.classList.add("is-invalid");
    } else if (form.myAccAddFullName.validity.tooLong) {
        form.myAccAddFullName.nextElementSibling.className = "invalid-feedback";
        form.myAccAddFullName.nextElementSibling.innerHTML = "Full Name must be less than 45 characters.";
        form.myAccAddFullName.classList.add("is-invalid");
    } else {
        form.myAccAddFullName.nextElementSibling.className = "valid-feedback";
        form.myAccAddFullName.nextElementSibling.innerHTML = "Looks good!";
        form.myAccAddFullName.classList.add("is-valid");
    }

    if (form.myAccAddline1.validity.valueMissing) {
        form.myAccAddline1.nextElementSibling.className = "invalid-feedback";
        form.myAccAddline1.nextElementSibling.innerHTML = "Enter Address Line 1.";
        form.myAccAddline1.classList.add("is-invalid");
    } else if (form.myAccAddline1.validity.patternMismatch) {
        form.myAccAddline1.nextElementSibling.className = "invalid-feedback";
        form.myAccAddline1.nextElementSibling.innerHTML = "Cannot contain spaces at the beginning and end and must contain a comma followed by a space.";
        form.myAccAddline1.classList.add("is-invalid");
    } else if (form.myAccAddline1.validity.tooLong) {
        form.myAccAddline1.nextElementSibling.className = "invalid-feedback";
        form.myAccAddline1.nextElementSibling.innerHTML = "Address Line 1 must be less than 45 characters.";
        form.myAccAddline1.classList.add("is-invalid");
    } else {
        form.myAccAddline1.nextElementSibling.className = "valid-feedback";
        form.myAccAddline1.nextElementSibling.innerHTML = "Looks good!";
        form.myAccAddline1.classList.add("is-valid");
    }

    if (form.myAccAddline2.validity.valueMissing) {
        form.myAccAddline2.nextElementSibling.className = "invalid-feedback";
        form.myAccAddline2.nextElementSibling.innerHTML = "Enter Address Line 2.";
        form.myAccAddline2.classList.add("is-invalid");
    } else if (form.myAccAddline2.validity.patternMismatch) {
        form.myAccAddline2.nextElementSibling.className = "invalid-feedback";
        form.myAccAddline2.nextElementSibling.innerHTML = "Cannot contain spaces at the beginning and end and must contain a comma followed by a space.";
        form.myAccAddline2.classList.add("is-invalid");
    } else if (form.myAccAddline2.validity.tooLong) {
        form.myAccAddline2.nextElementSibling.className = "invalid-feedback";
        form.myAccAddline2.nextElementSibling.innerHTML = "Address Line 2 must be less than 45 characters.";
        form.myAccAddline2.classList.add("is-invalid");
    } else {
        form.myAccAddline2.nextElementSibling.className = "valid-feedback";
        form.myAccAddline2.nextElementSibling.innerHTML = "Looks good!";
        form.myAccAddline2.classList.add("is-valid");
    }

    if (form.myAccCity.validity.valueMissing) {
        form.myAccCity.nextElementSibling.className = "invalid-feedback";
        form.myAccCity.nextElementSibling.innerHTML = "Enter city/town.";
        form.myAccCity.classList.add("is-invalid");
    } else if (form.myAccCity.validity.patternMismatch) {
        form.myAccCity.nextElementSibling.className = "invalid-feedback";
        form.myAccCity.nextElementSibling.innerHTML = "Cannot contain spaces at the beginning and end.";
        form.myAccCity.classList.add("is-invalid");
    } else if (form.myAccCity.validity.tooLong) {
        form.myAccCity.nextElementSibling.className = "invalid-feedback";
        form.myAccCity.nextElementSibling.innerHTML = "City/town name must be less than 20 characters.";
        form.myAccCity.classList.add("is-invalid");
    } else {
        form.myAccCity.nextElementSibling.className = "valid-feedback";
        form.myAccCity.nextElementSibling.innerHTML = "Looks good!";
        form.myAccCity.classList.add("is-valid");
    }

    if (province.value == 0) {
        province.nextElementSibling.className = "invalid-feedback";
        province.nextElementSibling.innerHTML = "Select a province.";
        province.classList.add("is-invalid");
    } else {
        province.nextElementSibling.className = "valid-feedback";
        province.nextElementSibling.innerHTML = "Looks good!";
        province.classList.add("is-valid");
    }

    if (form.myAccAddDistrict.value == 0) {
        form.myAccAddDistrict.nextElementSibling.className = "invalid-feedback";
        form.myAccAddDistrict.nextElementSibling.innerHTML = "Select a district.";
        form.myAccAddDistrict.classList.add("is-invalid");
    } else {
        form.myAccAddDistrict.nextElementSibling.className = "valid-feedback";
        form.myAccAddDistrict.nextElementSibling.innerHTML = "Looks good!";
        form.myAccAddDistrict.classList.add("is-valid");
    }

    if (form.myAccAddZipcode.validity.valueMissing) {
        form.myAccAddZipcode.nextElementSibling.className = "invalid-feedback";
        form.myAccAddZipcode.nextElementSibling.innerHTML = "Enter the zipcode of the address.";
        form.myAccAddZipcode.classList.add("is-invalid");
    } else if (form.myAccAddZipcode.validity.patternMismatch) {
        form.myAccAddZipcode.nextElementSibling.className = "invalid-feedback";
        form.myAccAddZipcode.nextElementSibling.innerHTML = "Enter a valid zipcode.";
        form.myAccAddZipcode.classList.add("is-invalid");
    } else {
        form.myAccAddZipcode.nextElementSibling.className = "valid-feedback";
        form.myAccAddZipcode.nextElementSibling.innerHTML = "Looks good!";
        form.myAccAddZipcode.classList.add("is-valid");
    }

    if (form.myAccAddressInlineRadioOptions[2].checked == true) {
        form.myAccAddressInlineRadioOptions[2].value = radioTextInput.value;
    }

    var radioTextInputPattern = /^([\S]+\s)*[\S]+$/

    for (var a = 0; a < myAccAddradios.length; a++) {
        if (myAccAddradios[a].checked == true) {
            if (a == 2) {
                if (radioTextInput.value == "") {
                    radioValidity.className = "invalid-feedback";
                    radioValidity.innerHTML = "Enter a category";
                    for (var b = 0; b < myAccAddradios.length; b++) {
                        if (myAccAddradios[b].classList.contains("is-valid")) {
                            myAccAddradios[b].classList.replace("is-valid", "is-invalid");
                        } else {
                            myAccAddradios[b].classList.add("is-invalid");
                        }
                    }
                    break;
                } else if (radioTextInput.value.length > 20) {
                    radioValidity.className = "invalid-feedback";
                    radioValidity.innerHTML = "Character length must be less than 20.";
                    for (var c = 0; c < myAccAddradios.length; c++) {
                        if (myAccAddradios[c].classList.contains("is-valid")) {
                            myAccAddradios[c].classList.replace("is-valid", "is-invalid");
                        } else {
                            myAccAddradios[c].classList.add("is-invalid");
                        }
                    }
                    break;
                } else if (radioTextInputPattern.test(radioTextInput.value) == false) {
                    radioValidity.className = "invalid-feedback";
                    radioValidity.innerHTML = "Category cannot contain spaces at the beginning and end.";
                    for (var d = 0; d < myAccAddradios.length; d++) {
                        if (myAccAddradios[d].classList.contains("is-valid")) {
                            myAccAddradios[d].classList.replace("is-valid", "is-invalid");
                        } else {
                            myAccAddradios[d].classList.add("is-invalid");
                        }
                    }
                    break;
                } else {
                    radioValidity.className = "valid-feedback";
                    radioValidity.innerHTML = "Looks good!";
                    for (var e = 0; e < myAccAddradios.length; e++) {
                        if (myAccAddradios[e].classList.contains("is-invalid")) {
                            myAccAddradios[e].classList.replace("is-invalid", "is-valid");
                        } else {
                            myAccAddradios[e].classList.add("is-valid");
                        }
                    }
                    break;
                }
            } else {
                radioValidity.className = "valid-feedback";
                radioValidity.innerHTML = "Looks good!";
                for (var y = 0; y < myAccAddradios.length; y++) {
                    if (myAccAddradios[y].classList.contains("is-invalid")) {
                        myAccAddradios[y].classList.replace("is-invalid", "is-valid");
                    } else {
                        myAccAddradios[y].classList.add("is-valid");
                    }
                }
                break;
            }
        } else {
            radioValidity.className = "invalid-feedback";
            radioValidity.innerHTML = "Select a option.";
            for (var x = 0; x < myAccAddradios.length; x++) {
                if (myAccAddradios[x].classList.contains("is-valid")) {
                    myAccAddradios[x].classList.replace("is-valid", "is-invalid");
                } else {
                    myAccAddradios[x].classList.add("is-invalid");
                }
            }
        }
    }

    if (form.checkValidity()) {
        var f = new FormData(form);
        request.onreadystatechange = function () {
            if (request.readyState == 4 && request.status == 200) {
                var t = request.responseText;
                var toast = document.getElementById("liveToast");
                if (t == "Successfully added new address.") {
                    document.getElementById("myAccToastBody").innerHTML = t;
                } else if (t == "Updated address.") {
                    document.getElementById("myAccToastBody").innerHTML = t;
                } else {
                    alert(t);
                }
                var liveToast = new bootstrap.Toast(toast);
                liveToast.show();

                setTimeout(() => {
                    window.location.reload();
                }, 3000);
            }
        }
        request.open("POST", "myAccAddressUpdate.php", true);
        request.send(f)
    }

}

function myAccAddressSubmissionFormReset() {
    var inputs = document.myAccAddressForm.querySelectorAll("input[type='text']");
    var selects = document.myAccAddressForm.getElementsByTagName("select");
    var radios = document.myAccAddressForm.querySelectorAll("input[type='radio']");

    for (var i = 0; i < inputs.length; i++) {
        inputs[i].className = "form-control";
    }

    for (var x = 0; x < selects.length; x++) {
        selects[x].className = "form-select";
    }

    for (var y = 0; y < radios.length; y++) {
        radios[y].className = "form-check-input myAccAddressInlineRadios";
    }

}

function accordionContentResize() {
    var accordions = document.getElementsByClassName("myAccountAccordionContent");
    for (var x = 0; x < accordions.length; x++) {
        if (accordions[x].style.height > "0px") {
            var forms = accordions[x].getElementsByTagName("form");
            if (x == 0 && window.outerWidth < 576) {
                accordions[x].style.height = document.getElementById("PIdisplay").scrollHeight + forms[0].scrollHeight + "px";
            } else if (x == 1 && window.outerWidth < 768) {
                accordions[x].style.height = 170 + forms[0].scrollHeight + "px";
            } else {
                accordions[x].style.height = forms[0].scrollHeight + "px";
            }
        }
    }
}

function myAccCallAddress(addressId, editStatus) {
    var myAccNewAddBtn = document.getElementById("myAccNewAddressBtn");
    var form = document.myAccAddressForm;
    var submitAddBtn = document.getElementById("myAccAddSubmitBtn");
    var deleteAddBtn = document.getElementById("myAccAddressDeleteBtn");
    var resetFormBtn = document.getElementById("myAccAddResetFormBtn");
    var address = document.querySelector("a[id='" + addressId + "']");

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            if (request.responseText == "Address deleted.") {
                var toast = document.getElementById("liveToast");
                document.getElementById("myAccToastBody").innerHTML = request.responseText;
                var liveToast = new bootstrap.Toast(toast);
                liveToast.show();

                form.reset();
                address.remove();
                if (address.innerHTML == "Home") {
                    window.location.reload();
                }
            } else {
                myAccAddressSubmissionFormReset();
                var t = JSON.parse(request.responseText);
                form.myAccAddFullName.value = t["full_name"];
                form.myAccAddline1.value = t["line1"];
                form.myAccAddline2.value = t["line2"];
                form.myAccCity.value = t["city"];
                document.getElementById("myAccProvince").value = t["provinceId"];
                myAccProvinceDropdownChange();
                setTimeout(() => {
                    form.myAccAddDistrict.value = t["districtId"];
                }, 40);
                form.myAccAddZipcode.value = t["zipcode"];
                if (t["address_type"] == "Home" || t["address_type"] == "Office") {
                    form.myAccAddressInlineRadioOptions.value = t["address_type"];
                } else {
                    document.getElementById("myAccAddressinlineRadio3Text").value = t["address_type"];
                    form.myAccAddressInlineRadioOptions[2].checked = true;
                }
                form.myAccAddressID.value = deleteAddBtn.value = addressId;

                if (myAccNewAddBtn.classList.contains("d-none")) {
                    myAccNewAddBtn.classList.remove("d-none");
                    deleteAddBtn.classList.remove("d-none");
                    submitAddBtn.innerHTML = "Save Changes";
                    myAccNewAddBtn.type = "reset";
                    resetFormBtn.type = "button";
                    if (resetFormBtn.hasAttribute("onclick")) {
                        resetFormBtn.removeAttribute("onclick")
                        resetFormBtn.setAttribute("onclick", "myAccCallAddress(" + addressId + ",1)");
                    } else {
                        resetFormBtn.setAttribute("onclick", "myAccCallAddress(" + addressId + ",1)");
                    }
                }
            }
            accordionContentResize();
        }
    }
    request.open("GET", "myAccAddressCall.php?addId=" + addressId + "&editStatus=" + editStatus, true);
    if (editStatus == 2) {
        if (confirm("Are you sure you want to delete " + address.innerHTML + " address?") == true) {
            request.send();
        }
    } else {
        request.send();
    }
}

function newAddressForm() {
    var form = document.myAccAddressForm;
    var districtDropdown = document.getElementById("myAccDistrict");
    var myAccNewAddBtn = document.getElementById("myAccNewAddressBtn");
    var submitAddBtn = document.getElementById("myAccAddSubmitBtn");
    var deleteAddBtn = document.getElementById("myAccAddressDeleteBtn");
    var resetFormBtn = document.getElementById("myAccAddResetFormBtn");

    while (districtDropdown.children.length > 1) {
        districtDropdown.removeChild(districtDropdown.lastElementChild);
    }
    if (!myAccNewAddBtn.classList.contains("d-none")) {
        myAccNewAddBtn.classList.add("d-none");
        deleteAddBtn.classList.add("d-none");
        submitAddBtn.innerHTML = "Add address";
        form.myAccAddressID.value = "new";
        myAccNewAddBtn.type = "button";
        resetFormBtn.type = "reset"
        resetFormBtn.removeAttribute("onclick")
    }
    accordionContentResize();
}

function checkoutAddressValidity() {
    var form = document.checkoutForm;
    if (form.numOfAddresses.value >= 1) {
        return true;
    } else {
        alert("Add delivery address and billing address.");
        return false;
    }
}

function changeCheckoutAddress(adId) {
    var form = document.checkoutForm;
    var r = new XMLHttpRequest();
    r.onreadystatechange = () => {
        if (r.readyState == 4 && r.status == 200) {
            var t = JSON.parse(r.responseText);
            if (document.getElementById('addressModalTitle').innerHTML == 'Delivery Address') {
                document.getElementById("addType1").innerHTML = t["address_type"];
                document.getElementById("address1").innerHTML = t["full_name"] + "<br />" + t["line_1"] + " " + t["line_2"] + " " + t["city"] + "<br />" +
                    t["district_name"] + " " + t["province_name"] + " " + t["zipcode"] + ".";
                form.deliveryAddId.value = t["address_id"];
            } else if (document.getElementById('addressModalTitle').innerHTML == 'Billing Address') {
                document.getElementById("addType2").innerHTML = t["address_type"];
                document.getElementById("address2").innerHTML = t["full_name"] + "<br />" + t["line_1"] + " " + t["line_2"] + " " + t["city"] + "<br />" +
                    t["district_name"] + " " + t["province_name"] + " " + t["zipcode"] + ".";
                form.billingAddId.value = t["address_id"];
            }
        }
    }
    r.open("GET", "changeCheckoutAddress.php?adId=" + adId, true);
    r.send()
    var modal = document.getElementById("modalClose");
    modal.click();
}

function profilePicUpload() {
    var profileImgUploader = document.getElementById("profileImgUploader");
    var profileImgDiv = document.getElementById("profileImg");
    profileImgUploader.click();
    profileImgUploader.addEventListener("input", function (event) {
        event.stopImmediatePropagation();
        var profileImg = profileImgUploader.files[0];
        var r = new XMLHttpRequest();
        var f = new FormData();
        f.append("pfp", profileImg);
        r.onreadystatechange = () => {
            if (r.readyState == 4 && r.status == 200) {
                if (r.responseText == "success") {
                    profileImgDiv.style.backgroundImage = "url('" + URL.createObjectURL(profileImg) + "')";
                } else {
                    alert(r.responseText);
                }
            }
        }
        r.open("POST", "profilePicUpload.php", true);
        r.send(f)
    });
}

function printInvoice() {
    var restorePage = document.body.innerHTML;
    var invoice = document.getElementById("invoice");
    var invoiceContent = document.getElementById("mainInvoiceContent");
    invoice.innerHTML = invoiceContent.innerHTML;
    invoice.classList.remove("invoicePadding");
    window.print();
    document.body.innerHTML = restorePage;
}

function pagination(x) {
    window.location = window.location.href + "&page=" + x;
}

function invoiceTablePrint() {
    var restoreBody = document.body.innerHTML;
    document.getElementById("lastTableHeading").remove()
    var TableContent = document.getElementById("TableContent");
    var tableRows = TableContent.getElementsByTagName("tr");
    for (let index = 0; index < tableRows.length; index++) {
        tableRows[index].lastElementChild.remove();
    }
    var invoiceTable = document.getElementById("invoiceTable").innerHTML
    document.body.innerHTML = invoiceTable;
    window.print();
    document.body.innerHTML = restoreBody;
}

function invoicePrint(orderId) {
    window.location = "invoicePrint.php?orderId=" + orderId.slice(1)
}