<?php
// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to index page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: index.php");
    exit;
}
// Include config file
require_once "layouts/config.php";

// Define variables and initialize with empty values
$useremail = $password = "";
$useremail_err = $password_err = $csfr_err = $csfr_err2 = "";

// Check for multiple CSRF failures
if (!isset($_SESSION['csrf_failures'])) {
    $_SESSION['csrf_failures'] = 0;
}

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check CSRF token
    if (!isset($_POST['csrf_token']) || !validate_csrf_token($_POST['csrf_token'])) {
        $_SESSION['csrf_failures']++;
        if ($_SESSION['csrf_failures'] >= 3) {
            $_SESSION['login_disabled_until'] = time() + 300; // Disable login for 5 minutes
        }
        $csfr_err = "Giriş geçici olarak devre dışı bırakıldı. Lütfen daha sonra tekrar deneyin.";
    }

    // Check if login is temporarily disabled
    if (isset($_SESSION['login_disabled_until']) && time() < $_SESSION['login_disabled_until']) {
        $csfr_err2 = "Giriş denemeleri başarısız oldu. Lütfen " . ceil(($_SESSION['login_disabled_until'] - time()) / 60) . " dakika sonra tekrar deneyin.";
    }

    // Check if useremail is empty
    if (empty(trim($_POST["useremail"]))) {
        $useremail_err = "Lütfen E-posta Adresinizi Girin.";
    } else {
        $useremail = sanitize_input($_POST["useremail"]);
    }

    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
        $password_err = "Lütfen Şifrenizi Girin.";
    } else {
        $password = sanitize_input($_POST["password"]);
    }

    // Validate credentials
    if (empty($useremail_err) && empty($password_err) && empty($csfr_err) && empty($csfr_err2)) {
        // Prepare a select statement
        $sql = "SELECT id, useremail, username, usersurname, password, role_id FROM users WHERE useremail = :useremail";

        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":useremail", $useremail, PDO::PARAM_STR);

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Check if useremail exists, if yes then verify password
                if ($stmt->rowCount() == 1) {
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    $id = $row["id"];
                    $username = $row["username"];
                    $usersurname = $row["usersurname"];
                    $hashed_password = $row["password"];
                    $role_id = $row["role_id"];

                    if (password_verify($password, $hashed_password)) {
                        // Reset CSRF failure count on successful login
                        $_SESSION['csrf_failures'] = 0;

                        // Store data in session variables
                        $_SESSION["loggedin"] = true;
                        $_SESSION["id"] = $id;
                        $_SESSION["useremail"] = $useremail;
                        $_SESSION["username"] = $username;
                        $_SESSION["usersurname"] = $usersurname;
                        $_SESSION["role_id"] = $role_id;
                        $_SESSION['csrf_token'] = generate_csrf_token();

                        $success = "Giriş Başarılı. Yönlendiriliyorsunuz...";
                    } else {
                        $error = "E-posta Adresi veya Şifre Hatalı.";
                    }
                } else {
                    $error = "E-posta Adresi veya Şifre Hatalı.";
                }
            } else {
                $error = "Oops! Bir şeyler yanlış gitti. Lütfen daha sonra tekrar deneyin.";
            }
        }
    }
}

?>
<?php include 'layouts/head-main.php'; ?>

<head>
    <title>MENEKŞE LASTİK YÖNETİM PANELİ</title>
    <?php include 'layouts/head.php'; ?>
    <link rel="stylesheet" type="text/css" href="assets/libs/toastr/build/toastr.min.css">
    <link href="assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    <?php include 'layouts/head-style.php'; ?>
</head>

<body>
    <div class="account-pages my-5 pt-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card overflow-hidden">
                        <div class="bg-dark bg-light">
                            <div class="row">
                                <div class="col-7">
                                    <div class="text-white p-4">
                                        <h5 class="text-white">MENEKŞE LASTİK YÖNETİM PANELİ</h5>
                                    </div>
                                </div>
                                <div class="col-5 align-self-end">
                                    <div class="auth-logo">
                                        <a href="index.php" class="auth-logo-dark">
                                            <div class="avatar-lg profile-user-wid m-3">
                                                <span class="avatar-title rounded-circle bg-transparent">
                                                    <img src="assets/images/logo.png" alt="" class="rounded-circle" height="180">
                                                </span>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-4">
                            <div class="p-2">
                                <form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

                                    <div class="mb-3 <?php echo (!empty($useremail_err)) ? 'has-error' : ''; ?>">
                                        <label for="useremail" class="form-label">E-posta Adresiniz</label>
                                        <input type="email" class="form-control" id="useremail" placeholder="E-posta Adresiniz" name="useremail">
                                        <span class="text-danger"><?php echo htmlspecialchars($useremail_err); ?></span>
                                    </div>

                                    <div class="mb-3 <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                                        <label class="form-label">Şifreniz
                                        </label>
                                        <div class="input-group auth-pass-inputgroup">
                                            <input type="password" name="password" class="form-control" placeholder="Şifreniz" aria-label="Password" aria-describedby="password-addon">
                                            <button class="btn btn-light " type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
                                        </div>
                                        <span class="text-danger"><?php echo htmlspecialchars($password_err); ?></span>
                                    </div>


                                    <div class="mt-4 d-grid">
                                        <button class="btn btn-dark waves-effect waves-light" type="submit" value="Login">Giriş Yap</button>
                                    </div>

                                    <div class="mt-4 text-center">
                                        <a href="forgot-password.php" class="text-muted"><i class="mdi mdi-lock me-1"></i> Şifremi Unuttum</a>
                                    </div>




                                </form>
                            </div>

                        </div>
                    </div>


                    <div class="mt-5 text-center">

                        <div>
                            <p>© <script>
                                    document.write(new Date().getFullYear())
                                </script> MENEKŞE LASTİK </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- end account-pages -->


    <!-- JAVASCRIPT -->
    <?php include 'layouts/vendor-scripts.php'; ?>

    <!-- toastr plugin -->
    <script src="assets/libs/toastr/build/toastr.min.js"></script>

    <!-- toastr init -->
    <script src="assets/js/pages/toastr.init.js"></script>


    <script>
        function showError(message) {
            toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": false,
                "progressBar": false,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": 300,
                "hideDuration": 1000,
                "timeOut": 5000,
                "extendedTimeOut": 1000,
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }
            toastr["error"](message);
        }

        function showSuccess(message) {
            toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": false,
                "progressBar": false,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": 300,
                "hideDuration": 1000,
                "timeOut": 5000,
                "extendedTimeOut": 1000,
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }
            toastr["success"](message);
        }


        <?php if (!empty($error)) { ?>
            showError('<?php echo htmlspecialchars($error); ?>');
        <?php } ?>

        <?php if (!empty($csfr_err)) { ?>
            showError('<?php echo htmlspecialchars($csfr_err); ?>');
        <?php } ?>

        <?php if (!empty($csfr_err2)) { ?>
            showError('<?php echo htmlspecialchars($csfr_err2); ?>');
        <?php } ?>

        <?php if (!empty($success)) { ?>
            showSuccess('<?php echo htmlspecialchars($success); ?>');
            setTimeout(function() {
                window.location.href = "index.php";
            }, 3000);

        <?php } ?>
    </script>

    <!-- Sweet Alerts js -->
    <script src="assets/libs/sweetalert2/sweetalert2.min.js"></script>

    <!-- Sweet alert init js-->
    <script src="assets/js/pages/sweet-alerts.init.js"></script>

    <!-- App js -->
    <script src="assets/js/app.js"></script>
</body>

</html>