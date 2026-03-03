<?php include 'layouts/session.php'; ?>
<?php
// Include config file
require_once "layouts/config.php";

// Define variables and initialize with empty values
$service_title = $short_text  = $service_photo = $long_text = $service_number = "";
$service_title_err = $short_text_err  = $service_photo_err = $long_text_err = $service_number_err = $csfr_err = "";
// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check CSRF token
    if (!isset($_POST['csrf_token']) || !validate_csrf_token($_POST['csrf_token'])) {
        $csfr_err = "Geçersiz CSRF token! İşlem iptal edildi.";
    }
    // Validate service_title
    if (empty(trim($_POST["service_title"]))) {
        $service_title_err = "Servis başlığı giriniz.";
    } else {
        $service_title = trim($_POST["service_title"]);
    }

    // Validate service_number
    if (empty(trim($_POST["service_number"]))) {
        $service_number_err = "Hizmet sırası giriniz.";
    } else {
        $service_number = trim($_POST["service_number"]);
    }

    // Validate short_text
    if (empty(trim($_POST["short_text"]))) {
        $short_text_err = "Kısa açıklama giriniz.";
    } else {
        $short_text = trim($_POST["short_text"]);
    }

  
    // Validate service_photo
    if (empty($_FILES["service_photo"]["tmp_name"])) {
        $service_photo_err = "Kapak resmi seçiniz.";
    } else {
        $service_photo = trim($_FILES["service_photo"]["tmp_name"]);
    }


    // Validate long_text
    if (empty($_POST["long_text"])) {
        $long_text_err = "İçerik giriniz.";
    } else {
        $long_text = $_POST["long_text"];
    }






    // Check input errors before inserting in database
    if (empty($service_title_err) && empty($short_text_err) && empty($service_photo_err) && empty($long_text_err) && empty($service_number_err) && empty($csfr_err)) {

        //file upload
        $target_dir = "../uploads/services/";
        //random file name
        $target_file = $target_dir . uniqid("menekse-lastik-hizmet-") . '.' . pathinfo($_FILES["service_photo"]["name"], PATHINFO_EXTENSION);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["service_photo"]["tmp_name"]);
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
        if ($_FILES["service_photo"]["size"] > 15242880) {
            $error = "Üzgünüz, dosya çok büyük.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if ($imageFileType != "jpeg" && $imageFileType != "jpg" && $imageFileType != "png") {
            $error = "Üzgünüz, sadece JPEG, JPG, PNG dosyaları yüklenebilir.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            $error = "Üzgünüz, dosyanız yüklenemedi.";
            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["service_photo"]["tmp_name"], $target_file)) {
                $service_photo = $target_file;
            } else {
                $error = "Üzgünüz, dosya yüklenirken bir hata oluştu.";
            }
        }

        // Prepare an insert statement
        $sql = "INSERT INTO services (`title`, `short_text`, `long_text`, `icon_path`, `status`, `sort_order`) VALUES (?, ?, ?, ?, ?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssii", $param_service_title, $param_short_text, $param_long_text, $param_service_photo, $param_status, $param_sort_order);
            // Set parameters
            $param_service_title = $service_title;
            $param_short_text = $short_text;
            $param_long_text = $long_text;
            $param_service_photo = $service_photo;
            $param_status = 1;
            $param_sort_order = $service_number;



            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Redirect to login page
                $success = "Servis başarıyla eklendi.";
            } else {
                $error = "Bir şeyler yanlış gitti. Lütfen daha sonra tekrar deneyiniz.";
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
    <title>Servis Ekle | MENEKŞE LASTİK YÖNETİM PANELİ</title>
    <?php include 'layouts/head.php'; ?>
    <link rel="stylesheet" type="text/css" href="assets/libs/toastr/build/toastr.min.css">
    <link href="assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    <!-- select2 css -->
    <link href="assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />

    <?php include 'layouts/head-style.php'; ?>

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
                            <h4 class="mb-sm-0 font-size-18">Hizmet Ekle</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Hizmetler</a></li>
                                    <li class="breadcrumb-item active">Hizmet Ekle</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">

                                <h4 class="card-title">Hizmet Ekle</h4>
                                <p class="card-title-desc">Yeni bir hizmet eklemek için bu sayfayı kullanınız.</p>

                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-3 <?php echo (!empty($service_title_err)) ? 'has-error' : ''; ?>">
                                                <label for="service_title" class="form-label">Başlık</label>
                                                <input type="text" class="form-control" id="service_title" name="service_title" placeholder="Hizmet başlığı giriniz" value="<?php echo $service_title; ?>">
                                                <span class="text-danger"><?php echo $service_title_err; ?></span>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="mb-3 <?php echo (!empty($service_photo_err)) ? 'has-error' : ''; ?>">
                                                <label for="service_photo" class="form-label">Kampanya Kapak Resmi (370x260)</label>
                                                <input class="form-control" type="file" id="service_photo" name="service_photo" value="<?php echo $service_photo; ?>">
                                                <span class="text-danger"><?php echo $service_photo_err; ?></span>
                                            </div>
                                        </div>
                                        <div class="mb-3 <?php echo (!empty($service_number_err)) ? 'has-error' : ''; ?>">
                                            <label for="service_number" class="form-label">Hizmet Sırası</label>
                                            <input type="number" class="form-control" id="service_number" name="service_number" min="0" placeholder="Hizmet sırası giriniz" value="<?php echo $service_number; ?>">
                                            <span class="text-danger"><?php echo $service_number_err; ?></span>
                                        </div>

                                        <div class="mb-3 <?php echo (!empty($short_text_err)) ? 'has-error' : ''; ?>">
                                            <label for="short_text" class="form-label">Kısa Açıklama</label>
                                            <input type="text" class="form-control" id="short_text" name="short_text" maxlength="255" placeholder="Kısa açıklama giriniz" value="<?php echo $short_text; ?>">
                                            <span class="text-danger"><?php echo $short_text_err; ?></span>
                                        </div>


                                        <div class="mb-3 <?php echo (!empty($long_text_err)) ? 'has-error' : ''; ?>">
                                            <label for="long_text" class="form-label">İçerik</label>

                                            <textarea id="blog_content" name="long_text"><?php echo $long_text; ?></textarea>

                                            <span class="text-danger"><?php echo $long_text_err; ?></span>
                                        </div>


                                    </div>

                                    <div class="d-flex flex-wrap gap-2">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light" name="kaydet">Kaydet</button>

                                    </div>
                                </form>

                            </div>
                        </div>


                    </div>
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


<!-- toastr plugin -->
<script src="assets/libs/toastr/build/toastr.min.js"></script>

<!-- toastr init -->
<script src="assets/js/pages/toastr.init.js"></script>

<!--tinymce js-->
<script src="assets/libs/tinymce/tinymce.min.js"></script>

<!-- init js -->
<script src="assets/js/pages/form-editor.init.js"></script>
<script src="assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js"></script>

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


    //max length of short text
    $('input[name="short_text"]').maxlength({
        alwaysShow: true,
        threshold: 10,
        warningClass: "badge bg-warning",
        limitReachedClass: "badge bg-danger",
        separator: ' / ',
        preText: 'Kalan karakter: ',
        postText: ''
    });
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
            window.location.href = "services.php";
        }, 3000);

    <?php } ?>
</script>



<!-- select 2 plugin -->
<script src="assets/libs/select2/js/select2.min.js"></script>



<!-- init js -->
<script src="assets/js/pages/ecommerce-select2.init.js"></script>

<!-- Sweet Alerts js -->
<script src="assets/libs/sweetalert2/sweetalert2.min.js"></script>

<!-- Sweet alert init js-->
<script src="assets/js/pages/sweet-alerts.init.js"></script>

<script src="assets/js/app.js"></script>

</body>

</html>