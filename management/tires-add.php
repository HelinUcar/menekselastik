<?php
include 'layouts/session.php';
require_once "layouts/config.php";

// Define variables and initialize with empty values
$tireimage = $tiremodel = $tirewidth = $tireheight = $tirediameter = $role_id = $loadindex = $speedrating = "";
$tiremodel_err = $tirewidth_err = $tireheight_err = $tirediameter_err = $loadindex_err = $csfr_err = $role_err = $error = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check CSRF token
    if (!isset($_POST['csrf_token']) || !validate_csrf_token($_POST['csrf_token'])) {
        $csfr_err = "Geçersiz CSRF token! İşlem iptal edildi.";
    }



    $user_image_path = null;
    if (isset($_FILES['tireimage']) && $_FILES['tireimage']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['tireimage']['tmp_name'];
        $fileName = $_FILES['tireimage']['name'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        $allowedfileExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($fileExtension, $allowedfileExtensions)) {
            $newFileName = uniqid('user_', true) . '.' . $fileExtension;
            $uploadFileDir = 'uploads/users/';
            $dest_path = $uploadFileDir . $newFileName;

            if (!is_dir($uploadFileDir)) {
                mkdir($uploadFileDir, 0755, true);
            }

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $user_image_path = $dest_path;
            } else {
                $error = 'Profil resmi yüklenemedi.';
            }
        } else {
            $error = 'Yalnızca JPG, JPEG, PNG, GIF dosyalarına izin verilir.';
        }
    }


    // Check input errors before inserting into database
    if (empty($useremail_err) && empty($username_err) && empty($usersurname_err) && empty($password_err) && empty($confirm_password_err) && empty($csfr_err)) {
        $sql = "INSERT INTO users (useremail, username, usersurname, password, token, role_id, userphoto)
        VALUES (:useremail, :username, :usersurname, :password, :token, :role_id, :userphoto)";

        $stmt = $pdo->prepare($sql);
        $param_password = password_hash($password, PASSWORD_ARGON2ID);
        $param_token = bin2hex(random_bytes(50));
        $stmt->bindParam(':useremail', $useremail, PDO::PARAM_STR);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':role_id', $role_id, PDO::PARAM_INT);
        $stmt->bindParam(':userphoto', $user_image_path, PDO::PARAM_STR);
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
    <title>Lastik Ekle | MENEKŞE LASTİK YÖNETİM PANELİ</title>
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
                            <h4 class="mb-sm-0 font-size-18">Lastik Ekle</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Lastikler</a></li>
                                    <li class="breadcrumb-item active">Lastik Ekle</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Lastik Ekle</h4>
                                <p class="card-title-desc">Buradan oluşturduğunuz lastikleri kampanyalı lastiklerinizde ve otel hizmetinde kullanabilirsiniz.</p>

                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">


                                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

                                    <div class="mb-3 <?php echo (!empty($tireimage_err)) ? 'has-error' : ''; ?>">
                                        <label for="tireimage" class="form-label">Lastik Görseli</label>
                                        <input type="file" class="form-control" id="tireimage" name="tireimage">
                                    </div>

                                    <div class="mb-3 <?php echo (!empty($tiremodel_err)) ? 'has-error' : ''; ?>">
                                        <label for="tiremodel" class="form-label">Lastik Modeli</label>
                                        <input type="text" class="form-control" id="tiremodel" name="tiremodel" placeholder="Lastik modeli giriniz" value="<?php echo $tiremodel; ?>">
                                        <span class="text-danger"><?php echo $tiremodel_err; ?></span>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4 mb-3 <?php echo (!empty($tirewidth_err)) ? 'has-error' : ''; ?>">
                                            <label for="tirewidth" class="form-label">Lastik Genişliği</label>
                                            <input type="number" class="form-control" id="tirewidth" name="tirewidth" min="0" placeholder="Lastik genişliği giriniz" value="<?php echo $tirewidth; ?>">
                                            <span class="text-danger"><?php echo $tirewidth_err; ?></span>
                                        </div>
                                        <div class="col-md-4 mb-3 <?php echo (!empty($tireheight_err)) ? 'has-error' : ''; ?>">
                                            <label for="tireheight" class="form-label">Lastik Yüksekliği</label>
                                            <input type="number" class="form-control" id="tireheight" name="tireheight" min="0" placeholder="Lastik yüksekliği giriniz" value="<?php echo $tireheight; ?>">
                                            <span class="text-danger"><?php echo $tireheight_err; ?></span>
                                        </div>

                                        <div class="col-md-4 mb-3 <?php echo (!empty($tirediameter_err)) ? 'has-error' : ''; ?>">
                                            <label for="tirediameter" class="form-label">Lastik Çapı</label>
                                            <input type="number" class="form-control" id="tirediameter" name="tirediameter" min="0" placeholder="Lastik çapını giriniz" value="<?php echo $tirediameter; ?>">
                                            <span class="text-danger"><?php echo $tirediameter_err; ?></span>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3 <?php echo (!empty($loadindex_err)) ? 'has-error' : ''; ?>">
                                            <label for="loadindex" class="form-label">Yük Endeksi</label>
                                            <input type="text" class="form-control" id="loadindex" name="loadindex" placeholder="Yük endeksini giriniz" value="<?php echo $loadindex; ?>">
                                            <span class="text-danger"><?php echo $loadindex_err; ?></span>
                                        </div>
                                        <div class="col-md-6 mb-3 <?php echo (!empty($speedrating_err)) ? 'has-error' : ''; ?>">
                                            <label for="speedrating" class="form-label">Hız Endeksi</label>
                                            <input type="text" class="form-control" id="speedrating" name="speedrating" placeholder="Hız endeksini giriniz" value="<?php echo $speedrating; ?>">
                                            <span class="text-danger"><?php echo $loadindex_err; ?></span>
                                        </div>
                                    </div>


                                    <div class="mb-3 <?php echo (!empty($role_err)) ? 'has-error' : ''; ?>">
                                        <label for="role" class="form-label">Sezon</label>
                                        <select class="form-select" id="role" name="role_id">
                                            <option value="">Seçiniz</option>
                                            <option value="Yaz">Yaz</option>
                                            <option value="Kış">Kış</option>
                                            <option value="Dört Mevsim">Dört Mevsim</option>

                                        </select>
                                        <span class="text-danger"><?php echo $role_err; ?></span>
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