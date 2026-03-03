<?php 

include 'layouts/session.php'; 
// Include config file
require_once "layouts/config.php";

// Define variables and initialize with empty values
 $about_title_err = $about_content_err = "";

//check if the last information is already in the database 
$sql = "SELECT * FROM home_page ORDER BY id DESC LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$home = $stmt->fetch(PDO::FETCH_ASSOC);
if ($home) {
    $id = $home['id'];

    $about_title = $home['about_title'];
    $about_content = $home['about_content'];
} else {
    $about_title = $about_content = "";
}


// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check CSRF token
    if (!isset($_POST['csrf_token']) || !validate_csrf_token($_POST['csrf_token'])) {
        $csfr_err = "Geçersiz CSRF token! İşlem iptal edildi.";
    }

    if (!empty($id)) {
      

        // Validate about title
        $input_about_title = trim($_POST["about_title"]);
        if (empty($input_about_title)) {
            $about_title_err = "Hakkımızda başlığı gereklidir.";
        } else {
            $about_title = $input_about_title;
        }

        // Validate about content
        $input_about_content = trim($_POST["about_content"]);
        if (empty($input_about_content)) {
            $about_content_err = "Hakkımızda açıklaması gereklidir.";
        } else {
            $about_content = $input_about_content;
        }

        if (empty($csfr_err)) {
            // Prepare an update statement
            $sql = "UPDATE home_page SET about_title = :about_title, about_content = :about_content WHERE id = :id";

            if ($stmt = $pdo->prepare($sql)) {
                // Bind variables to the prepared statement as parameters
                $stmt->bindParam(":about_title", $about_title);
                $stmt->bindParam(":about_content", $about_content);
                $stmt->bindParam(":id", $id);

                // Attempt to execute the prepared statement
                if ($stmt->execute()) {
                    $_SESSION['csrf_token'] = generate_csrf_token();
                    $success = "Anasayfa bilgileri başarıyla güncellendi.";
                } else {
                    $error = "Bir hata oluştu. Lütfen daha sonra tekrar deneyin.";
                }
            }
        }
    } else {
       

        // Validate about title
        $input_about_title = trim($_POST["about_title"]);
        if (empty($input_about_title)) {
            $about_title_err = "Hakkımızda başlığı gereklidir.";
        } else {
            $about_title = $input_about_title;
        }

        // Validate about content
        $input_about_content = trim($_POST["about_content"]);
        if (empty($input_about_content)) {
            $about_content_err = "Hakkımızda açıklaması gereklidir.";
        } else {
            $about_content = $input_about_content;
        }

        if (empty($csfr_err)) {
            // Prepare an insert statement
            $sql = "INSERT INTO home_page ( about_title, about_content) VALUES ( :about_title, :about_content)";
            if ($stmt = $pdo->prepare($sql)) {
                // Bind variables to the prepared statement as parameters
                $stmt->bindParam(":about_title", $about_title, PDO::PARAM_STR);
                $stmt->bindParam(":about_content", $about_content, PDO::PARAM_STR);

                // Attempt to execute the prepared statement
                if ($stmt->execute()) {
                    $_SESSION['csrf_token'] = generate_csrf_token();
                    $success = "Başarıyla eklendi.";
                } else {
                    $error = "Bir şeyler yanlış gitti. Lütfen daha sonra tekrar deneyiniz.";
                }
            }
        }
    }



    // Close connection
    mysqli_close($link);
}
?>
<?php include 'layouts/head-main.php'; ?>

<head>
    <title>Anasayfa Ayarları | MENEKŞE LASTİK YÖNETİM PANELİ</title>
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
                            <h4 class="mb-sm-0 font-size-18">Anasayfa Ayarları</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item active">Anasayfa Ayarları</li>

                                </ol>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">

                                <h4 class="card-title">Anasayfa Ayarları</h4>
                                <p class="card-title-desc">Anasayfa ayarlarını düzenlemek için bu sayfayı kullanınız.</p>

                                <form class="repeater" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">


                                    <div class="row">


                                        <input type="hidden" name="seo_id" value="<?php echo $id; ?>" />
                                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>" />
                                  
                                        <div class="mb-3 <?php echo (!empty($about_title_err)) ? 'has-error' : ''; ?>">
                                            <label for="about_title" class="form-label">Başlık</label>
                                            <input type="text" class="form-control" id="about_title" name="about_title" maxlength="255" placeholder="Başlığı giriniz" value="<?php echo $about_title; ?>">
                                            <span class="text-danger"><?php echo $about_title_err; ?></span>
                                        </div>

                                        <div class="row">


                                            <div class="mb-3 <?php echo (!empty($about_content_err)) ? 'has-error' : ''; ?>">
                                                <label for="about_content" class="form-label">Hakkımızda İçerik</label>


                                                <textarea id="about_content" name="about_content"><?= $about_content ?></textarea>

                                                <span class="text-danger"><?php echo $about_content_err; ?></span>
                                            </div>


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

<script src="assets/libs/jquery.repeater/jquery.repeater.min.js"></script>

<script src="assets/js/pages/form-repeater.int.js"></script>

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



    //max length of site title
    $('input[name="about_title"]').maxlength({
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
        setTimeout(() => {
            window.location.href = "home-page.php";
        }, 3000);

    <?php }

    ?>
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