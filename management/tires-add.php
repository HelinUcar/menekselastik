<?php

include 'layouts/session.php';
require_once "layouts/config.php";

$tiremodel = $tire_mini_content = $tireimage = $season = $tire_content = "";
$manufacturers_id = 0;
$runflat = 0;
$vehicle_types = [];


$widths = range(145, 335, 10);   // istersen 5 yapabiliriz
$heights = range(30, 85, 5);
$diameters = range(12, 20, 1);


$tiremodel_err = $tire_mini_content_err = $season_err = $tireimage_err = $manufacturers_err = $vehicle_types_err = $tire_content_err = $csfr_err = "";
$size_errors = []; // her satır için hata
$success = $error = "";

// Repeater post verisi (form açılışında en az 1 satır gösterelim)
$sizes_post = $_POST['group-a'] ?? [
    ['tirewidth' => '', 'tireheight' => '', 'tirediameter' => '', 'loadindex' => '', 'speedrating' => '']
];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // CSRF
    if (!isset($_POST['csrf_token']) || !validate_csrf_token($_POST['csrf_token'])) {
        $csfr_err = "Geçersiz CSRF token! İşlem iptal edildi.";
    }

    // DESEN alanları
    $tiremodel = trim($_POST["tiremodel"] ?? "");
    if ($tiremodel === "") $tiremodel_err = "Lastik modeli boş bırakılamaz.";

    $model_link = permalink($tiremodel);
    if ($model_link === "") {
        $error = "Model link üretilemedi.";
    }

    

    $season = trim($_POST["season"] ?? "");
    if ($season === "") $season_err = "Sezon seçilmelidir.";

    $manufacturers_id = (int)($_POST["manufacturer_id"] ?? 0);
    if ($manufacturers_id <= 0) $manufacturers_err = "Lastik üreticisi seçilmelidir.";

    // Aynı marka + aynı desen adı kontrolü
    if (empty($tiremodel_err) && empty($manufacturers_err)) {

        $check = $pdo->prepare("
        SELECT id 
        FROM tires 
        WHERE manufacturer_id = ? AND model = ?
        LIMIT 1
    ");
        $check->execute([$manufacturers_id, $tiremodel]);
        $exists_id = (int)$check->fetchColumn();

        if ($exists_id > 0) {
            $tiremodel_err = "Bu markaya ait bu desen zaten kayıtlı. Mevcut desene ebat ekleyin.";
        }
    }


    $runflat = isset($_POST['runflat']) ? 1 : 0;

    $tire_mini_content = trim($_POST["tire_mini_content"] ?? "");
    if ($tire_mini_content === "") $tire_mini_content_err = "Mini açıklama boş bırakılamaz.";

    $tire_content = trim($_POST["tire_content"] ?? "");
    if ($tire_content === "") $tire_content_err = "Lastik açıklaması boş bırakılamaz.";

    // Vehicle types
    if (!isset($_POST["vehicle_types"]) || !is_array($_POST["vehicle_types"]) || count($_POST["vehicle_types"]) === 0) {
        $vehicle_types_err = "Araç tipi seçilmelidir.";
    } else {
        $vehicle_types = array_map('intval', $_POST["vehicle_types"]);
    }

    // Resim upload
    if (!empty($_FILES["tireimage"]["tmp_name"])) {
        $target_dir = "../uploads/tires/";
        if (!is_dir($target_dir)) @mkdir($target_dir, 0775, true);

        $ext = strtolower(pathinfo($_FILES["tireimage"]["name"], PATHINFO_EXTENSION));
        $target_file = $target_dir . uniqid("tire-", true) . "." . $ext;

        $check = getimagesize($_FILES["tireimage"]["tmp_name"]);
        if ($check === false) {
            $tireimage_err = "Dosya bir resim değil.";
        } elseif ($_FILES["tireimage"]["size"] > 15242880) {
            $tireimage_err = "Üzgünüz, dosya çok büyük.";
        } elseif (!in_array($ext, ["jpeg", "jpg", "png"])) {
            $tireimage_err = "Üzgünüz, sadece JPG/JPEG/PNG yüklenebilir.";
        } elseif (!move_uploaded_file($_FILES["tireimage"]["tmp_name"], $target_file)) {
            $tireimage_err = "Üzgünüz, dosya yüklenirken bir hata oluştu.";
        } else {
            $tireimage = $target_file;
        }
    } else {
        $tireimage_err = "Lastik görseli seçilmelidir.";
    }

    // REPEATER: EBAT doğrulama
    $sizes = $_POST['group-a'] ?? [];
    if (!is_array($sizes) || count($sizes) === 0) {
        $error = "En az 1 ebat girmelisiniz.";
    } else {
        foreach ($sizes as $i => $row) {
            $w = trim($row['tirewidth'] ?? '');
            $h = trim($row['tireheight'] ?? '');
            $d = trim($row['tirediameter'] ?? '');
            $li = trim($row['loadindex'] ?? '');
            $sr = trim($row['speedrating'] ?? '');

            if ($w === "" || !is_numeric($w)) $size_errors[$i]['tirewidth'] = "Genişlik sayısal olmalı.";
            if ($h === "" || !is_numeric($h)) $size_errors[$i]['tireheight'] = "Yükseklik sayısal olmalı.";
            if ($d === "" || !is_numeric($d)) $size_errors[$i]['tirediameter'] = "Çap sayısal olmalı.";
            if ($li === "") $size_errors[$i]['loadindex'] = "Yük endeksi zorunlu.";
            if ($sr === "") $size_errors[$i]['speedrating'] = "Hız endeksi zorunlu.";

            $allowed_widths = $widths;        // yukarıdaki listeler
            $allowed_heights = $heights;
            $allowed_diameters = $diameters;

            if ($w === "" || !in_array((int)$w, $allowed_widths, true))  $size_errors[$i]['tirewidth'] = "Geçersiz genişlik.";
            if ($h === "" || !in_array((int)$h, $allowed_heights, true)) $size_errors[$i]['tireheight'] = "Geçersiz yükseklik.";
            if ($d === "" || !in_array((int)$d, $allowed_diameters, true)) $size_errors[$i]['tirediameter'] = "Geçersiz çap.";


            // İstersen min/max kısıt da koyabiliriz (145-335 vs.)
        }
    }

    $has_size_error = !empty($size_errors);

    // TÜM hata kontrolleri temizse DB’ye yaz
    if (
        empty($tiremodel_err) && empty($tire_mini_content_err) && empty($season_err) && empty($manufacturers_err) && empty($tireimage_err) &&
        empty($vehicle_types_err) && empty($tire_content_err) && empty($tire_mini_content_err) && empty($csfr_err) && empty($error) && !$has_size_error
    ) {
        try {
            $pdo->beginTransaction();

            // 1) DESEN ekle -> tires
            // (tires tablon artık DESEN tablosu: photo, model, model_link, season, run_flat, manufacturer_id, description)
            $insTire = $pdo->prepare("
                INSERT INTO tires (photo, model, model_link, season, run_flat, manufacturer_id, description, mini_description)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $insTire->execute([$tireimage, $tiremodel, $model_link, $season, $runflat, $manufacturers_id, $tire_content, $tire_mini_content]);
            $tire_id = (int)$pdo->lastInsertId();

            // 2) Araç tipleri -> tire_vehicle_type
            $insVT = $pdo->prepare("INSERT INTO tire_vehicle_type (tire_id, vehicle_type_id) VALUES (?, ?)");
            foreach ($vehicle_types as $vt) {
                $insVT->execute([$tire_id, $vt]);
            }

            // 3) Ebatları -> tire_sizes (çoklu)
            $insSize = $pdo->prepare("
                INSERT INTO tire_sizes (tire_id, width, aspect_ratio, rim_diameter, load_index, speed_rating)
                VALUES (?, ?, ?, ?, ?, ?)
            ");

            foreach ($sizes as $row) {
                $insSize->execute([
                    $tire_id,
                    (int)$row['tirewidth'],
                    (int)$row['tireheight'],
                    (int)$row['tirediameter'],
                    trim($row['loadindex']),
                    trim($row['speedrating']),
                ]);
            }

            $pdo->commit();
            $success = "Desen başarıyla eklendi ve " . count($sizes) . " adet ebat kaydedildi.";
        } catch (PDOException $e) {
            $pdo->rollBack();

            // UNIQUE yakalama (uniq_tire_size adını sen koyduysan)
            if (str_contains($e->getMessage(), 'uniq_tire_size')) {
                $error = "Aynı ebat aynı desene tekrar eklenemez. (Bazı satırlar tekrarlı)";
            } else {
                $error = "DB Hatası: " . $e->getMessage();
            }
        } catch (Exception $e) {
            $pdo->rollBack();
            $error = $e->getMessage();
        }
    }

    // Validation fail olursa formu doldu bırakmak için:
    $sizes_post = $_POST['group-a'] ?? $sizes_post;
}
?>


<?php include 'layouts/head-main.php'; ?>

<head>
    <title>Lastik Ekle | MENEKŞE LASTİK YÖNETİM PANELİ</title>
    <?php include 'layouts/head.php'; ?>
    <?php include 'layouts/head-style.php'; ?>
    <link rel="stylesheet" type="text/css" href="assets/libs/toastr/build/toastr.min.css">
    <link href="assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
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

                                <form class="repeater" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">


                                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

                                    <div class="mb-3 <?php echo (!empty($tireimage_err)) ? 'has-error' : ''; ?>">
                                        <label for="tireimage" class="form-label">Lastik Görseli</label>
                                        <input type="file" class="form-control" id="tireimage" name="tireimage">
                                        <span class="text-danger"><?php echo $tireimage_err; ?></span>
                                    </div>

                                    <div class="mb-3 <?php echo (!empty($manufacturers_err)) ? 'has-error' : ''; ?>">
                                        <label for="manufacturer_id" class="form-label">Lastik Üreticisi</label>
                                        <select class="form-select" id="manufacturers" name="manufacturer_id">

                                            <option value="">Seçiniz</option>
                                            <?php
                                            // Fetch manufacturers from the database
                                            $sql = "SELECT * FROM manufacturers";
                                            $result = $pdo->prepare($sql);
                                            $result->execute();
                                            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                                $manufacturerId = $row['id'];
                                                $manufacturer_name = $row['name'];
                                                echo "<option value='$manufacturerId' " . (($manufacturerId == $manufacturers_id) ? 'selected' : '') . ">$manufacturer_name</option>";
                                            }
                                            ?>

                                        </select>
                                        <span class="text-danger"><?php echo $manufacturers_err; ?></span>
                                    </div>


                                    <div class="mb-3 <?php echo (!empty($tiremodel_err)) ? 'has-error' : ''; ?>">
                                        <label for="tiremodel" class="form-label">Lastik Modeli</label>
                                        <input type="text" class="form-control" id="tiremodel" name="tiremodel" placeholder="Lastik modeli giriniz" value="<?php echo $tiremodel; ?>">
                                        <span class="text-danger"><?php echo $tiremodel_err; ?></span>
                                    </div>






                                    <div class="mb-3 <?php echo (!empty($vehicle_types_err)) ? 'has-error' : ''; ?>">
                                        <label class="form-label">Araç Tipleri</label>

                                        <select class="select2 form-control select2-multiple" name="vehicle_types[]" id="vehicle_types" multiple="multiple"
                                            data-placeholder="Seçiniz">
                                            <?php
                                            // Fetch vehicle types from the database
                                            $sql = "SELECT * FROM vehicle_types";
                                            $result = $pdo->query($sql);
                                            $result->execute();
                                            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                                $vehicleTypeId = $row['id'];
                                                $vehicleTypeName = $row['name'];
                                                echo "<option value='$vehicleTypeId' " . (in_array($vehicleTypeId, $vehicle_types ?? []) ? 'selected' : '') . ">$vehicleTypeName</option>";
                                            }
                                            ?>
                                        </select>

                                        <span class="text-danger"><?php echo $vehicle_types_err; ?></span>

                                    </div>

                                    <div class="mb-3 <?php echo (!empty($season_err)) ? 'has-error' : ''; ?>">
                                        <label for="season" class="form-label">Sezon</label>
                                        <select class="form-select" id="season" name="season">

                                            <option value="">Seçiniz</option>
                                            <option value="Yaz" <?php echo ($season == 'Yaz') ? 'selected' : ''; ?>>Yaz</option>
                                            <option value="Kış" <?php echo ($season == 'Kış') ? 'selected' : ''; ?>>Kış</option>
                                            <option value="Dört Mevsim" <?php echo ($season == 'Dört Mevsim') ? 'selected' : ''; ?>>Dört Mevsim</option>

                                        </select>
                                        <span class="text-danger"><?php echo $season_err; ?></span>
                                    </div>

                                    <div class="form-check form-check-primary mb-3">
                                        <input class="form-check-input" type="checkbox" id="formCheckcolor1" name="runflat" <?php echo ($runflat == 1) ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="formCheckcolor1">
                                            Run Flat (Patlasa da gidebilen)
                                        </label>
                                    </div>
                                    <div class="mt-3">
                                        <label class="form-label">Lastik Ölçüleri</label>
                                        <div data-repeater-list="group-a">


                                            <?php foreach ($sizes_post as $i => $row) { ?>
                                                <div data-repeater-item class="row">
                                                    <div class="mb-3 col-lg-2">
                                                        <label class="form-label">Genişlik</label>
                                                        <select class="form-select" name="tirewidth">
                                                            <option value="">Seç</option>
                                                            <?php foreach ($widths as $w) { ?>
                                                                <option value="<?php echo $w; ?>"
                                                                    <?php echo ((($row['tirewidth'] ?? '') == $w) ? 'selected' : ''); ?>>
                                                                    <?php echo $w; ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                        <?php if (!empty($size_errors[$i]['tirewidth'])) { ?>
                                                            <span class="text-danger"><?php echo htmlspecialchars($size_errors[$i]['tirewidth']); ?></span>
                                                        <?php } ?>

                                                    </div>

                                                    <div class="mb-3 col-lg-2">
                                                        <label class="form-label">Yükseklik</label>
                                                        <select class="form-select" name="tireheight">
                                                            <option value="">Seç</option>
                                                            <?php foreach ($heights as $h) { ?>
                                                                <option value="<?php echo $h; ?>"
                                                                    <?php echo ((($row['tireheight'] ?? '') == $h) ? 'selected' : ''); ?>>
                                                                    <?php echo $h; ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                        <?php if (!empty($size_errors[$i]['tireheight'])) { ?>
                                                            <span class="text-danger"><?php echo htmlspecialchars($size_errors[$i]['tireheight']); ?></span>
                                                        <?php } ?>

                                                    </div>

                                                    <div class="mb-3 col-lg-2">
                                                        <label class="form-label">Çap</label>
                                                        <select class="form-select" name="tirediameter">
                                                            <option value="">Seç</option>
                                                            <?php foreach ($diameters as $d) { ?>
                                                                <option value="<?php echo $d; ?>"
                                                                    <?php echo ((($row['tirediameter'] ?? '') == $d) ? 'selected' : ''); ?>>
                                                                    <?php echo $d; ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                        <?php if (!empty($size_errors[$i]['tirediameter'])) { ?>
                                                            <span class="text-danger"><?php echo htmlspecialchars($size_errors[$i]['tirediameter']); ?></span>
                                                        <?php } ?>

                                                    </div>

                                                    <div class="mb-3 col-lg-2">
                                                        <label class="form-label">Yük Endeksi</label>
                                                        <input type="text" class="form-control" name="loadindex" value="<?php echo htmlspecialchars($row['loadindex'] ?? ''); ?>">
                                                        <?php if (!empty($size_errors[$i]['loadindex'])) { ?>
                                                            <span class="text-danger"><?php echo htmlspecialchars($size_errors[$i]['loadindex']); ?></span>
                                                        <?php } ?>
                                                    </div>

                                                    <div class="mb-3 col-lg-2">
                                                        <label class="form-label">Hız Endeksi</label>
                                                        <input type="text" class="form-control" name="speedrating" value="<?php echo htmlspecialchars($row['speedrating'] ?? ''); ?>">
                                                        <?php if (!empty($size_errors[$i]['speedrating'])) { ?>
                                                            <span class="text-danger"><?php echo htmlspecialchars($size_errors[$i]['speedrating']); ?></span>
                                                        <?php } ?>
                                                    </div>

                                                    <div class="col-lg-2 align-self-center">
                                                        <div class="d-grid">
                                                            <input data-repeater-delete type="button" class="btn btn-primary" value="Sil" />
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>

                                        </div>
                                        <input data-repeater-create type="button" class="btn btn-success mt-3 mt-lg-0" value="Ebat Ekle" />

                                    </div>

                                    <div class="mb-3 mt-3">


                                        <div class="mb-3 <?php echo (!empty($tire_mini_content_err)) ? 'has-error' : ''; ?>">
                                            <label for="tire_mini_content" class="form-label">Mini Açıklamas</label>


                                            <textarea id="tire_mini_content" name="tire_mini_content"><?= $tire_mini_content ?></textarea>

                                            <span class="text-danger"><?php echo $tire_mini_content_err; ?></span>
                                        </div>


                                    </div>

                                    <div class="mb-3 mt-3 <?php echo (!empty($tire_content_err)) ? 'has-error' : ''; ?>">
                                        <label for="tire_content" class="form-label">Açıklama</label>


                                        <textarea id="tire_content" name="tire_content"><?php echo $tire_content; ?></textarea>

                                        <span class="text-danger"><?php echo $tire_content_err; ?></span>
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
<!--tinymce js-->
<script src="assets/libs/tinymce/tinymce.min.js"></script>
<!-- toastr init -->
<script src="assets/js/pages/form-editor.init.js"></script>

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
            window.location.href = "tires.php";
        }, 3000);

    <?php } ?>
</script>

<!-- Sweet Alerts js -->
<script src="assets/libs/sweetalert2/sweetalert2.min.js"></script>
<script src="assets/libs/jquery.repeater/jquery.repeater.min.js"></script>

<script src="assets/js/pages/form-repeater.int.js"></script>
<!-- Sweet alert init js-->
<script src="assets/js/pages/sweet-alerts.init.js"></script>

<script src="assets/libs/select2/js/select2.min.js"></script>

<script src="assets/js/pages/form-advanced.init.js"></script>
<script>
    function formatState(state) {
        if (!state.id) {
            return state.text;
        }
        var baseUrl = "./assets/images/flags/select2";
        var $state = $(
            '<span><img src="' + baseUrl + '/' + state.element.value.toLowerCase() + '.png" class="img-flag" /> ' + state.text + '</span>'
        );
        return $state;
    };

    $(".select2-templating").select2({
        templateResult: formatState
    });
</script>

<script src="assets/js/app.js"></script>

</body>

</html>