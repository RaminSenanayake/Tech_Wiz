<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tech Wiz | Admin Login</title>

    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="bootstrap.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" />
    <link rel="icon" href="resources/gadgets1.svg" />
</head>

<body class="bg-body-tertiary">

    <div class="container-fluid d-flex vh-100 justify-content-center">
        <div class="row align-content-center" id="signInBox">
            <div class="col-12">
                <div class="row text-center fw-bold lh-1">
                    <div class="col-12 adminLogo mb-2"></div>
                    <div style="line-height: 30px;">
                        <h1 class="display-5">Welcome to</h1>
                        <div class="col-10 offset-1 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4 mb-3">
                            <a href="home.php" class="comp_title text-decoration-none">Tech Wiz</a>
                        </div>
                    </div>
                    <h3 class="mb-3">Admin Sign In</h1>
                </div>
            </div>

            <div class="col-10 offset-1 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                <form name="adminLoginForm" class="row row-gap-3" method="post" onsubmit="adminLogin();return false">
                    <div class="col-12">
                        <div class="form-floating">
                            <input name="adminEmail" class="form-control" type="email" id="signInEmail" placeholder="" required />
                            <label for="signInEmail">Email Address</label>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="input-group">
                            <div class="form-floating">
                                <input name="adminPassword" class="form-control" type="password" id="signInPassword" placeholder="" required />
                                <label for="signInPassword">Password</label>
                            </div>
                            <span class="input-group-text" type="button" id="viewSignInPasswordButton" onclick="viewSignInPassword();"><i class="bi bi-eye"></i></span>
                        </div>
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-outline-primary col-12" id="signInButton">Sign In</button>
                    </div>

                </form>
            </div>
        </div>

        <div class="text-center border-top position-absolute bottom-0 col-12 py-2">
            <p class=" my-auto text-body-secondary">&copy; Tech Wiz</p>
        </div>
    </div>
    <script src="bootstrap.js"></script>
    <script src="adminScript.js"></script>
</body>

</html>