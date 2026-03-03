<?php include 'layouts/session.php'; ?>
<?php
require_once "layouts/config.php"; // $link burada geliyor

// ID kontrol
if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    header("Location: services.php");
    exit;
}
$service_id = (int)$_GET['id'];

// Değişkenler
$service_title = $short_text = $service_photo = $long_text = $service_number = "";
$service_title_err = $short_text_err = $service_photo_err = $long_text_err = $service_number_err = $csfr_err = "";

// ---- 1) Sayfa ilk açılış: DB'den veriyi çek ----
$sql_get = "SELECT id, title, short_text, long_text, icon_path, sort_order FROM services WHERE id = ? LIMIT 1";
if ($stmt_get = mysqli_prepare($link, $sql_get)) {
    mysqli_stmt_bind_param($stmt_get, "i", $service_id);
    mysqli_stmt_execute($stmt_get);
    $result = mysqli_stmt_get_result($stmt_get);
    $row = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt_get);

    if (!$row) {
        header("Location: services.php");
        exit;
    }

    // Formu doldurmak için
    $service_title  = $row['title'];
    $short_text     = $row['short_text'];
    $long_text      = $row['long_text'];
    $service_photo  = $row['icon_path']; // mevcut resim yolu
    $service_number = $row['sort_order'];
} else {
    $error = "Servis bilgisi alınamadı.";
}

// ---- 2) Form gönderildiyse güncelle ----
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // CSRF
    if (!isset($_POST['csrf_token']) || !validate_csrf_token($_POST['csrf_token'])) {
        $csfr_err = "Geçersiz CSRF token! İşlem iptal edildi.";
    }

    // Başlık
    if (empty(trim($_POST["service_title"]))) {
        $service_title_err = "Servis başlığı giriniz.";
    } else {
        $service_title = trim($_POST["service_title"]);
    }

    // Sıra
    if ($_POST["service_number"] === "" || !is_numeric($_POST["service_number"])) {
        $service_number_err = "Hizmet sırası giriniz.";
    } else {
        $service_number = (int)$_POST["service_number"];
    }

    // Kısa açıklama
    if (empty(trim($_POST["short_text"]))) {
        $short_text_err = "Kısa açıklama giriniz.";
    } else {
        $short_text = trim($_POST["short_text"]);
    }

    // İçerik
    if (empty($_POST["long_text"])) {
        $long_text_err = "İçerik giriniz.";
    } else {
        $long_text = $_POST["long_text"];
    }

    // Mevcut resim yolu (hidden’dan gelsin)
    $current_photo = isset($_POST['current_photo']) ? $_POST['current_photo'] : $service_photo;

    // Yeni resim seçildiyse yükle
    $new_photo_uploaded = !empty($_FILES["service_photo"]["tmp_name"]);

    // Hata yoksa devam
    if (empty($service_title_err) && empty($short_text_err) && empty($long_text_err) && empty($service_number_err) && empty($csfr_err)) {

        // Varsayılan: eski foto
        $final_photo_path = $current_photo;

        if ($new_photo_uploaded) {
            $target_dir = "../uploads/services/";
            $target_file = $target_dir . uniqid("menekse-lastik-hizmet-") . '.' . pathinfo($_FILES["service_photo"]["name"], PATHINFO_EXTENSION);

            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // resim mi?
            $check = getimagesize($_FILES["service_photo"]["tmp_name"]);
            if ($check === false) {
                $error = "Dosya bir resim değil.";
                $uploadOk = 0;
            }

            // boyut
            if ($_FILES["service_photo"]["size"] > 15242880) {
                $error = "Üzgünüz, dosya çok büyük.";
                $uploadOk = 0;
            }

            // tip
            if (!in_array($imageFileType, ["jpeg", "jpg", "png"])) {
                $error = "Üzgünüz, sadece JPEG, JPG, PNG dosyaları yüklenebilir.";
                $uploadOk = 0;
            }

            // yükle
            if ($uploadOk == 1) {
                if (move_uploaded_file($_FILES["service_photo"]["tmp_name"], $target_file)) {
                    $final_photo_path = $target_file;
                    // (İsteğe bağlı) Eski dosyayı silmek istersen:
                    if (!empty($current_photo) && file_exists($current_photo)) { @unlink($current_photo); }

                } else {
                    $error = "Üzgünüz, dosya yüklenirken bir hata oluştu.";
                }
            }
        }

        // Eğer upload sırasında error oluştuysa DB update yapma
        if (empty($error)) {
            // UPDATE
            $sql_upd = "UPDATE services 
                        SET title = ?, short_text = ?, long_text = ?, icon_path = ?, sort_order = ?
                        WHERE id = ?";

            if ($stmt_upd = mysqli_prepare($link, $sql_upd)) {

                mysqli_stmt_bind_param(
                    $stmt_upd,
                    "ssssii",
                    $param_service_title,
                    $param_short_text,
                    $param_long_text,
                    $param_service_photo,
                    $param_sort_order,
                    $param_id
                );

                $param_service_title = $service_title;
                $param_short_text    = $short_text;
                $param_long_text     = $long_text;
                $param_service_photo = $final_photo_path;
                $param_sort_order    = $service_number;
                $param_id            = $service_id;

                if (mysqli_stmt_execute($stmt_upd)) {
                    $success = "Servis başarıyla güncellendi.";
                    $service_photo = $final_photo_path; // sayfada güncel görünsün
                } else {
                    $error = "Bir şeyler yanlış gitti. Lütfen daha sonra tekrar deneyiniz.";
                }

                mysqli_stmt_close($stmt_upd);
            } else {
                $error = "Güncelleme sorgusu hazırlanamadı.";
            }
        }
    }
}
?>
<?php include 'layouts/head-main.php'; ?>

<head>
    <title>Servis Düzenle | MENEKŞE LASTİK YÖNETİM PANELİ</title>
    <?php include 'layouts/head.php'; ?>
    <link rel="stylesheet" type="text/css" href="assets/libs/toastr/build/toastr.min.css">
    <link href="assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
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
                            <h4 class="mb-sm-0 font-size-18">Hizmet Düzenle</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="services.php">Hizmetler</a></li>
                                    <li class="breadcrumb-item active">Hizmet Düzenle</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">

                                <h4 class="card-title">Hizmet Düzenle</h4>
                                <p class="card-title-desc">Mevcut hizmeti güncellemek için bu sayfayı kullanınız.</p>

                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $service_id; ?>" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                                    <input type="hidden" name="current_photo" value="<?php echo htmlspecialchars($service_photo); ?>">

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-3 <?php echo (!empty($service_title_err)) ? 'has-error' : ''; ?>">
                                                <label for="service_title" class="form-label">Başlık</label>
                                                <input type="text" class="form-control" id="service_title" name="service_title" placeholder="Hizmet başlığı giriniz" value="<?php echo htmlspecialchars($service_title); ?>">
                                                <span class="text-danger"><?php echo $service_title_err; ?></span>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="mb-3 <?php echo (!empty($service_photo_err)) ? 'has-error' : ''; ?>">
                                                <label for="service_photo" class="form-label">Kapak Resmi (370x260)</label>
                                                <input class="form-control" type="file" id="service_photo" name="service_photo">
                                                <small class="text-muted d-block mt-2">Yeni resim seçmezsen mevcut resim korunur.</small>

                                                <?php if (!empty($service_photo)): ?>
                                                    <div class="mt-2">
                                                        <img src="<?php echo htmlspecialchars($service_photo); ?>" alt="Mevcut Resim" style="max-width:160px; border-radius:6px;">
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <div class="mb-3 <?php echo (!empty($service_number_err)) ? 'has-error' : ''; ?>">
                                            <label for="service_number" class="form-label">Hizmet Sırası</label>
                                            <input type="number" class="form-control" id="service_number" name="service_number" min="0" placeholder="Hizmet sırası giriniz" value="<?php echo htmlspecialchars($service_number); ?>">
                                            <span class="text-danger"><?php echo $service_number_err; ?></span>
                                        </div>

                                        <div class="mb-3 <?php echo (!empty($short_text_err)) ? 'has-error' : ''; ?>">
                                            <label for="short_text" class="form-label">Kısa Açıklama</label>
                                            <input type="text" class="form-control" id="short_text" name="short_text" maxlength="255" placeholder="Kısa açıklama giriniz" value="<?php echo htmlspecialchars($short_text); ?>">
                                            <span class="text-danger"><?php echo $short_text_err; ?></span>
                                        </div>

                                        <div class="mb-3 <?php echo (!empty($long_text_err)) ? 'has-error' : ''; ?>">
                                            <label for="long_text" class="form-label">İçerik</label>
                                            <textarea id="blog_content" name="long_text"><?php echo htmlspecialchars($long_text); ?></textarea>
                                            <span class="text-danger"><?php echo $long_text_err; ?></span>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-wrap gap-2">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light" name="kaydet">Güncelle</button>
                                        <a href="services.php" class="btn btn-secondary waves-effect">İptal</a>
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

<?php include 'layouts/vendor-scripts.php'; ?>

<script src="assets/libs/toastr/build/toastr.min.js"></script>
<script src="assets/js/pages/toastr.init.js"></script>

<script src="assets/libs/tinymce/tinymce.min.js"></script>
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

    // maxlength
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
    <?php } ?>
    <?php if (!empty($csfr_err)) { ?>
        showError('<?php echo htmlspecialchars($csfr_err); ?>');
    <?php } ?>
    <?php if (!empty($success)) { ?>
        showSuccess('<?php echo htmlspecialchars($success); ?>');
        document.querySelector('button[name="kaydet"]').disabled = true;
        setTimeout(function() {
            window.location.href = "services.php";
        }, 2000);
    <?php } ?>
</script>

<script src="assets/libs/select2/js/select2.min.js"></script>
<script src="assets/js/pages/ecommerce-select2.init.js"></script>

<script src="assets/libs/sweetalert2/sweetalert2.min.js"></script>
<script src="assets/js/pages/sweet-alerts.init.js"></script>

<script src="assets/js/app.js"></script>
</body>
</html>
