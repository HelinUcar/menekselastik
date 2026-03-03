<?php

// Include config file
require_once "layouts/config.php";


// Define variables and initialize with empty values
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = $msg = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate new password
    if (empty(trim($_POST["new_password"]))) {
        $new_password_err = "Lütfen yeni şifreyi girin.";
    } elseif (strlen(trim($_POST["new_password"])) < 6) {
        $new_password_err = "Şifre en az 6 karakterden oluşmalıdır.";
    } else {
        $new_password = trim($_POST["new_password"]);
    }

    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Lütfen onaylama şifresini girin.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($new_password_err) && ($new_password != $confirm_password)) {
            $confirm_password_err = "Şifre eşleşmedi.";
        }
    }





    $tokenvalue = $_POST["token-value"];

    // Check input errors before updating the database
    if (empty($new_password_err) && empty($confirm_password_err)) {
        // Prepare an update statement
        $sql = "UPDATE users SET password = ? WHERE token = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_password, $param_token);

            // Set parameters
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_token = $tokenvalue;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                $success = "Şifre başarıyla güncellendi. Lütfen giriş yapın.";
                session_destroy();
            } else {
                $error = "Hata! Bir şeyler ters gitti. Lütfen daha sonra tekrar deneyin.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($link);
}
?>
<?php include 'layouts/head-main.php'; ?>

<head>
    <title>Şifre Yenileme | MENEKŞE LASTİK YÖNETİM PANELİ</title>
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
                        <div class="bg-primary bg-light">
                            <div class="row">
                                <div class="col-7">
                                    <div class="text-primary p-4">
                                        <h5 class="text-primary">MENEKŞE LASTİK YÖNETİM PANELİ</h5>
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

                                    <div class="mb-3 <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                                        <label for="new_password">Yeni Şifre</label>
                                        <input type="password" class="form-control" id="new_password" name="new_password" placeholder="Yeni Şifre" value="<?php echo $new_password; ?>">
                                        <span class="text-danger"><?php echo $new_password_err; ?></span>
                                    </div>

                                    <div class="mb-3 <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                                        <label for="userpassword">Şifre Tekrarı</label>
                                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Şifre Tekrarı" value="<?php echo $confirm_password; ?>">
                                        <span class="text-danger"><?php echo $confirm_password_err; ?></span>
                                    </div>

                                    <input type="hidden" name="token-value" value="<?php echo $_GET['token']; ?>" />
                                    <div class="text-end">
                                        <button class="btn btn-primary w-md waves-effect waves-light" type='submit' name='submit' value='Submit'>Sıfırla</button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                    <div class="mt-5 text-center">

                        <div>
                            <p>© <script>
                                    document.write(new Date().getFullYear())
                                </script> MENEKŞE LASTİK YÖNETİM PANELİ </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

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

        <?php if (!empty($success)) { ?>
            showSuccess('<?php echo htmlspecialchars($success); ?>');
            setTimeout(function() {
                window.location.href = "login.php";
            }, 3000);

        <?php } ?>
    </script>


    <!-- App js -->
    <script src="assets/js/app.js"></script>
</body>

</html>