<?php
include 'layouts/session.php';
require_once "layouts/config.php";

// Define variables and initialize with empty values
$useremail = $username = $usersurname =  $password = $confirm_password = "";
$useremail_err = $username_err = $usersurname_err = $password_err = $confirm_password_err = $csfr_err = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check CSRF token
    if (!isset($_POST['csrf_token']) || !validate_csrf_token($_POST['csrf_token'])) {
        $csfr_err = "Geçersiz CSRF token! İşlem iptal edildi.";
    }

    // Validate useremail
    if (empty(trim($_POST["useremail"]))) {
        $useremail_err = "Bir e-posta adresi giriniz.";
    } elseif (!filter_var($_POST["useremail"], FILTER_VALIDATE_EMAIL)) {
        $useremail_err = "Geçerli bir e-posta adresi giriniz.";
    } else {
        $useremail = sanitize_input($_POST["useremail"]);
        $sql = "SELECT id FROM users WHERE useremail = :useremail";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':useremail', $useremail, PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $useremail_err = "Bu e-posta adresi zaten kullanımda.";
        }
    }

    // Validate username
    $username = empty(trim($_POST["username"])) ? $username_err = "Bir ad giriniz." : sanitize_input($_POST["username"]);
    // Validate usersurname
    $usersurname = empty(trim($_POST["usersurname"])) ? $usersurname_err = "Bir soyad giriniz." : sanitize_input($_POST["usersurname"]);
    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Şifre giriniz.";
    } elseif (!preg_match("/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/", $_POST["password"])) {
        $password_err = "Şifre en az 8 karakter, bir büyük harf, bir küçük harf, bir rakam ve bir özel karakter içermelidir.";
    } else {
        $password = sanitize_input($_POST["password"]);
    }
    // Validate confirm password
    $confirm_password = empty(trim($_POST["confirm_password"])) ? $confirm_password_err = "Şifreyi tekrar giriniz." : sanitize_input($_POST["confirm_password"]);
    if ($password !== $confirm_password) {
        $confirm_password_err = "Şifreler eşleşmiyor.";
    }

    // Check input errors before inserting into database
    if (empty($useremail_err) && empty($username_err) && empty($usersurname_err) && empty($password_err) && empty($confirm_password_err) && empty($csfr_err)) {
        $sql = "INSERT INTO users (useremail, username, usersurname, password, token) VALUES (:useremail, :username, :usersurname, :password, :token)";
        $stmt = $pdo->prepare($sql);
        $param_password = password_hash($password, PASSWORD_ARGON2ID);
        $param_token = bin2hex(random_bytes(50));
        $stmt->bindParam(':useremail', $useremail, PDO::PARAM_STR);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':usersurname', $usersurname, PDO::PARAM_STR);
        $stmt->bindParam(':password', $param_password, PDO::PARAM_STR);
        $stmt->bindParam(':token', $param_token, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
            $success = "Üye başarıyla oluşturuldu.";
        } else {
            $error = "Bir şeyler yanlış gitti. Lütfen daha sonra tekrar deneyin.";
        }
    }
}
?>

<?php include 'layouts/head-main.php'; ?>

<head>
    <title>Panel Üyesi Ekle | MENEKŞE LASTİK YÖNETİM PANELİ</title>
    <?php include 'layouts/head.php'; ?>
    <?php include 'layouts/head-style.php'; ?>
    <link rel="stylesheet" type="text/css" href="assets/libs/toastr/build/toastr.min.css">
    <link href="assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
</head>

<?php include 'layouts/body.php'; ?>

<div id="layout-wrapper">

    <?php include 'layouts/menu.php'; ?>


    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Panel Üyesi Ekle</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Üyeler</a></li>
                                    <li class="breadcrumb-item active">Panel Üyesi Ekle</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Üye Ekle</h4>
                                <p class="card-title-desc">Buradan oluşturduğunuz üyeler sadece yönetim paneline erişim sağlayabilir.</p>

                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

                                    <div class="mb-3 <?php echo (!empty($useremail_err)) ? 'has-error' : ''; ?>">
                                        <label for="useremail" class="form-label">E-Posta</label>
                                        <input type="email" class="form-control" id="useremail" name="useremail" placeholder="E-posta adresi giriniz" value="<?php echo $useremail; ?>">
                                        <span class="text-danger"><?php echo $useremail_err; ?></span>
                                    </div>

                                    <div class="mb-3 <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                                        <label for="username" class="form-label">Ad</label>
                                        <input type="text" class="form-control" id="username" name="username" placeholder="Ad giriniz" value="<?php echo $username; ?>">
                                        <span class="text-danger"><?php echo $username_err; ?></span>
                                    </div>
                                    <div class="mb-3 <?php echo (!empty($usersurname_err)) ? 'has-error' : ''; ?>">
                                        <label for="usersurname" class="form-label">Soyad</label>
                                        <input type="text" class="form-control" id="usersurname" name="usersurname" placeholder="Soyad giriniz" value="<?php echo $usersurname; ?>">
                                        <span class="text-danger"><?php echo $usersurname_err; ?></span>
                                    </div>

                                    <div class="mb-3 <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                                        <label for="userpassword" class="form-label">Şifre</label>
                                        <input type="password" class="form-control" id="userpassword" name="password" placeholder="Şifre" value="<?php echo $password; ?>">
                                        <span class="text-danger"><?php echo $password_err; ?></span>
                                    </div>

                                    <div class="mb-3 <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                                        <label for="confirm_password" class="form-label">Tekrar Şifre</label>
                                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Tekrar Şifre" value="<?php echo $confirm_password; ?>">
                                        <span class="text-danger"><?php echo $confirm_password_err; ?></span>
                                    </div>

                                    <div class="mt-4 d-grid d-flex flex-wrap gap-2">
                                        <button class="btn btn-primary waves-effect waves-light" name="kaydet" type="submit">Kaydet</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>


        <?php include 'layouts/footer.php'; ?>
    </div>


</div>



<!-- JAVASCRIPT -->
<?php include 'layouts/vendor-scripts.php'; ?>

<script src="assets/libs/parsleyjs/parsley.min.js"></script>

<script src="assets/js/pages/form-validation.init.js"></script>
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
    <?php }
    if (!empty($csfr_err)) { ?>
        showError('<?php echo htmlspecialchars($csfr_err); ?>');
    <?php }



    if (!empty($success)) { ?>
        showSuccess('<?php echo htmlspecialchars($success); ?>');
        //disable kaydet button
        document.querySelector('button[name="kaydet"]').disabled = true;
        setTimeout(function() {
            window.location.href = "panel-user.php";
        }, 3000);

    <?php } ?>
</script>

<!-- Sweet Alerts js -->
<script src="assets/libs/sweetalert2/sweetalert2.min.js"></script>

<!-- Sweet alert init js-->
<script src="assets/js/pages/sweet-alerts.init.js"></script>

<script src="assets/js/app.js"></script>

</body>

</html>