<?php 

include 'layouts/session.php'; 
// Include config file
require_once "layouts/config.php";

// Define variables and initialize with empty values
$blog_title = $seo_title =  $meta_keywords = $blog_photo = $blog_content  = $start_date = $end_date = "";
$blog_title_err = $seo_title_err = $meta_keywords_err = $blog_photo_err = $blog_content_err  = $start_date_err = $end_date_err = $csfr_err = "";
// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check CSRF token
    if (!isset($_POST['csrf_token']) || !validate_csrf_token($_POST['csrf_token'])) {
        $csfr_err = "Geçersiz CSRF token! İşlem iptal edildi.";
    }
    // Validate blog_title
    if (empty(trim($_POST["blog_title"]))) {
        $blog_title_err = "Blog başlığı giriniz.";
    } else {
        $blog_title = trim($_POST["blog_title"]);
    }

    // Validate seo_title
    if (empty(trim($_POST["seo_title"]))) {
        $seo_title_err = "SEO başlığı giriniz.";
    } else {
        $seo_title = trim($_POST["seo_title"]);
    }

    // Validate meta_keywords
    if (empty(trim($_POST["meta_keywords"]))) {
        $meta_keywords_err = "Meta keywords giriniz.";
    } else {
        $meta_keywords = trim($_POST["meta_keywords"]);
    }

    // Validate blog_photo
    if (empty($_FILES["blog_photo"]["tmp_name"])) {
        $blog_photo_err = "Kapak resmi seçiniz.";
    } else {
        $blog_photo = trim($_FILES["blog_photo"]["tmp_name"]);
    }


    // Validate blog_content
    if (empty($_POST["blog_content"])) {
        $blog_content_err = "İçerik giriniz.";
    } else {
        $blog_content = $_POST["blog_content"];
    }

    // Validate start_date
    if (empty(trim($_POST["start_date"]))) {
        $start_date_err = "Başlangıç tarihi giriniz.";
    } else {
        $start_date = trim($_POST["start_date"]);
    }

    // Validate end_date
    if (empty(trim($_POST["end_date"]))) {
        $end_date_err = "Bitiş tarihi giriniz.";
    } else {
        $end_date = trim($_POST["end_date"]);
    }

    



    // Check input errors before inserting in database
    if (empty($blog_title_err) && empty($seo_title_err) && empty($meta_keywords_err) && empty($blog_photo_err) && empty($blog_content_err) && empty($start_date_err) && empty($end_date_err) && empty($csfr_err)) {
     
        //file upload
        $target_dir = "../uploads/";
        //random file name
        $target_file = $target_dir . uniqid("menekse-lastik-kampanya-") . '.' . pathinfo($_FILES["blog_photo"]["name"], PATHINFO_EXTENSION);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["blog_photo"]["tmp_name"]);
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
        if ($_FILES["blog_photo"]["size"] > 15242880) {
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
            if (move_uploaded_file($_FILES["blog_photo"]["tmp_name"], $target_file)) {
                $blog_photo = $target_file;
            } else {
                $error = "Üzgünüz, dosya yüklenirken bir hata oluştu.";
            }
        }

        // Prepare an insert statement
        $sql = "INSERT INTO blogs (`start_date`, `end_date`,`writer`, `title`, `title_link`, `seo_title`, `content`, `photo`, `meta_keywords`, `numberof_read`, `status`) VALUES (?,?,?,?, ?, ?, ?, ?, ?, ?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssssssssii", $param_start_date, $param_end_date, $param_writer, $param_title, $param_title_link, $param_seo_title, $param_content, $param_photo, $param_meta_keywords, $param_numberof_read, $param_status);

            // Set parameters
            $param_start_date = date('Y-m-d', strtotime($start_date));
            $param_end_date = date('Y-m-d', strtotime($end_date));
            $param_writer = ucfirst($_SESSION["username"] . ' ' . $_SESSION["usersurname"]);
            $param_title = $blog_title;
            $param_title_link = permalink($blog_title);
            $param_seo_title = $seo_title;
            $param_content = $blog_content;
            $param_photo = $blog_photo;
            $param_meta_keywords = $meta_keywords;
            $param_numberof_read = 0;
            $param_status = 1;


            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Redirect to login page
                $success = "Kampanya başarıyla eklendi.";
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
    <title>Kampanya Ekle | MENEKŞE LASTİK YÖNETİM PANELİ</title>
    <?php include 'layouts/head.php'; ?>
    <link rel="stylesheet" type="text/css" href="assets/libs/toastr/build/toastr.min.css">
    <link href="assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    <!-- select2 css -->
    <link href="assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />

    <?php include 'layouts/head-style.php'; ?>

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

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Kampanya Ekle</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Kampanyalar</a></li>
                                    <li class="breadcrumb-item active">Kampanya Ekle</li>
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

                                <h4 class="card-title">Kampanya Ekle</h4>
                                <p class="card-title-desc">Yeni bir kampanya eklemek için bu sayfayı kullanınız.</p>

                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-3 <?php echo (!empty($blog_title_err)) ? 'has-error' : ''; ?>">
                                                <label for="blog_title" class="form-label">Başlık</label>
                                                <input type="text" class="form-control" id="blog_title" name="blog_title" placeholder="Blog başlığı giriniz" value="<?php echo $blog_title; ?>">
                                                <span class="text-danger"><?php echo $blog_title_err; ?></span>
                                            </div>

                                            <div class="mb-3 <?php echo (!empty($seo_title_err)) ? 'has-error' : ''; ?>">
                                                <label for="seo_title" class="form-label">SEO Başlık</label>
                                                <input type="text" class="form-control" id="seo_title" name="seo_title" maxlength="255" placeholder="SEO başlığı giriniz" value="<?php echo $seo_title; ?>">
                                                <span class="text-danger"><?php echo $seo_title_err; ?></span>
                                            </div>

                                        </div>



                                        <div class="col-sm-6">
                                            <div class="mb-3 <?php echo (!empty($blog_photo_err)) ? 'has-error' : ''; ?>">
                                                <label for="blog_photo" class="form-label">Kampanya Kapak Resmi (370x260)</label>
                                                <input class="form-control" type="file" id="blog_photo" name="blog_photo" value="<?php echo $blog_photo; ?>">
                                                <span class="text-danger"><?php echo $blog_photo_err; ?></span>
                                            </div>

                                            <div class="mb-3 <?php echo (!empty($meta_keywords_err)) ? 'has-error' : ''; ?>">
                                                <label for="meta_keywords" class="form-label">Meta Etiketleri (Kelimeleri virgül kullanarak ayırınız)</label>
                                                <input type="text" class="form-control" id="meta_keywords" name="meta_keywords" maxlength="225" placeholder="Soyad giriniz" value="<?php echo $meta_keywords; ?>">
                                                <span class="text-danger"><?php echo $meta_keywords_err; ?></span>
                                            </div>


                                        </div>


                                        <div class="col-sm-6 mb-3 <?php echo (!empty($start_date_err)) ? 'has-error' : ''; ?>">
                                            <label for="example-date-input" class="col-md-2 col-form-label">Başlangıç Tarihi</label>
                                            <div class="col-md-12">
                                                <input class="form-control" type="date" value="<?= $start_date ?>" name="start_date" id="example-date-input">
                                                <span class="text-danger"><?php echo $start_date_err; ?></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 mb-3 <?php echo (!empty($end_date_err)) ? 'has-error' : ''; ?>">
                                            <label for="example-date-input" class="col-md-2 col-form-label">Bitiş Tarihi</label>
                                            <div class="col-md-12">
                                                <input class="form-control" type="date" value="<?= $end_date ?>" name="end_date" id="example-date-input">
                                                <span class="text-danger"><?php echo $end_date_err; ?></span>
                                            </div>
                                        </div>


                                        <div class="mb-3 <?php echo (!empty($blog_content_err)) ? 'has-error' : ''; ?>">
                                            <label for="blog_content" class="form-label">İçerik</label>


                                            <textarea id="blog_content" name="blog_content"><?php echo $blog_content; ?></textarea>

                                            <span class="text-danger"><?php echo $blog_content_err; ?></span>
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

    //max length of meta keywords
    $('input[name="meta_keywords"]').maxlength({
        alwaysShow: true,
        threshold: 10,
        warningClass: "badge bg-warning",
        limitReachedClass: "badge bg-danger",
        separator: ' / ',
        preText: 'Kalan karakter: ',
        postText: ''
    });
    //max length of seo title
    $('input[name="seo_title"]').maxlength({
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
            window.location.href = "news.php";
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