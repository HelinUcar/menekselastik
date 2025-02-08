<?php include 'layouts/session.php'; ?>

<?php
// Include config file
require_once "layouts/config.php";

$user_id = $_SESSION["id"];
//get user
$get_user = "SELECT * FROM users WHERE id = $user_id";
$result_user = mysqli_query($link, $get_user);
$user = mysqli_fetch_assoc($result_user);


// Define variables and initialize with empty values
$useremail = $username = $usersurname =  $password = $confirm_password = $profilephoto = "";
$useremail_err = $username_err = $usersurname_err = $password_err = $confirm_password_err = $profilephoto_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if user_id is empty
    $user_id = trim($_POST["user_id"]);

    // Validate useremail
    if (empty(trim($_POST["useremail"]))) {
        $useremail_err = "Bir e-posta adresi giriniz.";
    } elseif (!filter_var($_POST["useremail"], FILTER_VALIDATE_EMAIL)) {
        $useremail_err = "Geçerli bir e-posta adresi giriniz.";
    } else {
        $useremail = trim($_POST["useremail"]);
    }

    // Validate username
    if (empty(trim($_POST["username"]))) {
        $username_err = "Bir ad giriniz.";
    } else {
        $username = trim($_POST["username"]);
    }

    // Validate usersurname
    if (empty(trim($_POST["usersurname"]))) {
        $usersurname_err = "Bir soyad giriniz.";
    } else {
        $usersurname = trim($_POST["usersurname"]);
    }

    // Validate profilephoto
    if (empty(trim($_FILES["blog_photo"]["tmp_name"]))) {
        $profilephoto_err = "";
    } else {
        $profilephoto = trim($_FILES["profilephoto"]["tmp_name"]);
    }

    // Validate password
    if (!empty(trim($_POST["password"]))) {
        if (strlen(trim($_POST["password"])) < 6) {
            $password_err = "Şifre en az 6 karakter olmalıdır.";
        } else {
            $password = trim($_POST["password"]);
        }
    }

    // Validate confirm password
    if (!empty(trim($_POST["confirm_password"]))) {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Şifreler eşleşmiyor.";
        }
    }

    // Check input errors before inserting in database
    if (empty($useremail_err) && empty($username_err) && empty($usersurname_err) && empty($password_err) && empty($confirm_password_err) && empty($profilephoto_err)) {
        if (!empty(trim($_FILES["profilephoto"]["tmp_name"]))) {

            //file upload
            $target_dir = "../uploads/";
            //random file name
            $target_file = $target_dir . uniqid("profile-") . '.' . pathinfo($_FILES["profilephoto"]["name"], PATHINFO_EXTENSION);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Check if image file is a actual image or fake image
            $check = getimagesize($_FILES["profilephoto"]["tmp_name"]);
            if ($check !== false) {
                $uploadOk = 1;
            } else {
                $error = "Dosya bir resim değil.";
                $uploadOk = 0;
            }

            // Check if file already exists
            if (file_exists($target_file)) {
                $error = "Üzgünüz, dosya zaten var.";
                $uploadOk = 0;
            }

            // Check file size
            if ($_FILES["profilephoto"]["size"] > 15242880) {
                $error = "Üzgünüz, dosya çok büyük.";
                $uploadOk = 0;
            }

            // Allow certain file formats
            if ($imageFileType != "jpeg" && $imageFileType != "jpg" && $imageFileType != "png") {
                $error = "Üzgünüz, sadece JPEG dosyaları yüklenebilir.";
                $uploadOk = 0;
            }

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                $error = "Üzgünüz, dosyanız yüklenemedi.";
                // if everything is ok, try to upload file
            } else {
                //delete old photo
                if (!empty($blog['photo'])) {
                    unlink($blog['photo']);
                }
                if (move_uploaded_file($_FILES["profilephoto"]["tmp_name"], $target_file)) {
                    $profilephoto = $target_file;
                } else {
                    $error = "Üzgünüz, dosya yüklenirken bir hata oluştu.";
                }
            }
        } else {
            $profilephoto = "";
        }


        if (!empty(trim($_POST["password"]))) {
            // Prepare an insert statement
            $sql = "UPDATE users SET userphoto = ?, useremail = ?, username = ?, usersurname = ?, password = ? WHERE id = $user_id";

            if ($stmt = mysqli_prepare($link, $sql)) {
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "ssss", $param_userphoto, $param_useremail, $param_username, $param_usersurname, $param_password);

                // Set parameters
                $param_userphoto = $profilephoto;
                $param_useremail = $useremail;
                $param_username = $username;
                $param_usersurname = $usersurname;
                $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

                // Attempt to execute the prepared statement
                if (mysqli_stmt_execute($stmt)) {
                    // Redirect to login page
                    $success = "Üye başarıyla güncellendi.";
                } else {
                    $error = "Bir şeyler yanlış gitti. Lütfen daha sonra tekrar deneyin.";
                }

                // Close statement
                mysqli_stmt_close($stmt);
            }
        } else {
            // Prepare an insert statement
            $sql = "UPDATE users SET userphoto = ?, useremail = ?, username = ?, usersurname = ? WHERE id = $user_id";

            if ($stmt = mysqli_prepare($link, $sql)) {
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "sss", $param_userphoto, $param_useremail, $param_username, $param_usersurname);

                // Set parameters
                $param_userphoto = $profilephoto;
                $param_useremail = $useremail;
                $param_username = $username;
                $param_usersurname = $usersurname;

                // Attempt to execute the prepared statement
                if (mysqli_stmt_execute($stmt)) {
                    // Redirect to login page
                    $success = "Üye başarıyla güncellendi.";
                } else {
                    $error = "Bir şeyler yanlış gitti. Lütfen daha sonra tekrar deneyin.";
                }

                // Close statement
                mysqli_stmt_close($stmt);
            }
        }
    }

    // Close connection
    mysqli_close($link);
}
?>
<?php include 'layouts/head-main.php'; ?>

<head>
    <title>Profil | MENEKŞE LASTİK YÖNETİM PANELİ</title>
    <?php include 'layouts/head.php'; ?>
    <?php include 'layouts/head-style.php'; ?>
    <link rel="stylesheet" type="text/css" href="assets/libs/toastr/build/toastr.min.css">
    <link href="assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
</head>

<?php include 'layouts/body.php'; ?>

<!-- Begin page -->
<div id="layout-wrapper">

    <?php include 'layouts/menu.php'; ?>

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Profil</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item active">Profil</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title"><?php echo ucfirst($user["username"] . ' ' . $user["usersurname"]); ?></h4>
                                <p class="card-title-desc">Buradan profilinizdeki bilgilerinizi düzenleyebilir ve şifre işlemlerinizi yapabilirsiniz.</p>

                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                                    <input type="hidden" name="user_id" value="<?php echo $user["id"]; ?>">

                                    <?php if (!empty($user['userphoto'])) { ?>
                                        <div class="row mb-3">
                                            <div class="col-sm-6">
                                                <img src="<?php echo $user['userphoto']; ?>" height="200" alt="Profil Fotoğrafı">
                                            </div>
                                        </div>
                                    <?php } ?>

                                    <div class="mb-3 <?php echo (!empty($profilephoto_err)) ? 'has-error' : ''; ?>">
                                        <label for="profilephoto" class="form-label">Profil Fotoğrafı</label>
                                        <input type="file" class="form-control" id="profilephoto" name="profilephoto" value="<?php echo $user["useremail"]; ?>">
                                        <span class="text-danger"><?php echo $profilephoto_err; ?></span>
                                    </div>

                                    <div class="mb-3 <?php echo (!empty($useremail_err)) ? 'has-error' : ''; ?>">
                                        <label for="useremail" class="form-label">E-Posta</label>
                                        <input type="email" class="form-control" id="useremail" name="useremail" placeholder="E-posta adresi giriniz" value="<?php echo $user["useremail"]; ?>">
                                        <span class="text-danger"><?php echo $useremail_err; ?></span>
                                    </div>

                                    <div class="mb-3 <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                                        <label for="username" class="form-label">Ad</label>
                                        <input type="text" class="form-control" id="username" name="username" placeholder="Ad giriniz" value="<?php echo $user["username"]; ?>">
                                        <span class="text-danger"><?php echo $username_err; ?></span>
                                    </div>
                                    <div class="mb-3 <?php echo (!empty($usersurname_err)) ? 'has-error' : ''; ?>">
                                        <label for="usersurname" class="form-label">Soyad</label>
                                        <input type="text" class="form-control" id="usersurname" name="usersurname" placeholder="Soyad giriniz" value="<?php echo $user["usersurname"]; ?>">
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
                                        <button class="btn btn-primary waves-effect waves-light" type="submit" name="guncelle">Güncelle</button>
                                    </div>



                                </form>

                            </div>
                        </div>
                    </div> <!-- end col -->

                </div>

            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->

        <?php include 'layouts/footer.php'; ?>
    </div>
    <!-- end main content-->

</div>
<!-- END layout-wrapper -->



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
    <?php } ?>

    <?php if (!empty($success)) { ?>
        showSuccess('<?php echo htmlspecialchars($success); ?>');

        setTimeout(function() {
            window.location.href = "profile.php";
        }, 1500);

    <?php } ?>
</script>

<!-- Sweet Alerts js -->
<script src="assets/libs/sweetalert2/sweetalert2.min.js"></script>

<!-- Sweet alert init js-->
<script src="assets/js/pages/sweet-alerts.init.js"></script>

<script src="assets/js/app.js"></script>

</body>

</html>