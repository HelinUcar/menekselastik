<?php

include 'layouts/session.php';
require_once "layouts/config.php";


if (isset($_GET['id'])) {
    $tire_id = (int)($_GET['id'] ?? 0);
    // --- GET: mevcut veriyi çek ---
    $stmt = $pdo->prepare("SELECT * FROM tires WHERE id=? LIMIT 1");
    $stmt->execute([$tire_id]);
    $tire = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$tire) {
        die("Kayıt bulunamadı");
    }

    $tiremodel = $tire['model'];
    $season = $tire['season'];
    $runflat = (int)$tire['run_flat'];
    $manufacturers_id = (int)$tire['manufacturer_id'];
    $tire_content = $tire['description'];
    $tire_mini_content = $tire['mini_description'];
    $current_photo = $tire['photo'];
    // seçili araç tipleri
    $vtStmt = $pdo->prepare("SELECT vehicle_type_id FROM tire_vehicle_type WHERE tire_id=?");
    $vtStmt->execute([$tire_id]);
    $vehicle_types = array_map('intval', $vtStmt->fetchAll(PDO::FETCH_COLUMN));

    // mevcut ebatlar
    $szStmt = $pdo->prepare("SELECT * FROM tire_sizes WHERE tire_id=? ORDER BY id ASC");
    $szStmt->execute([$tire_id]);
    $sizes_post = $szStmt->fetchAll(PDO::FETCH_ASSOC);
    if (!$sizes_post) {
        $sizes_post = [['id' => '', 'width' => '', 'aspect_ratio' => '', 'rim_diameter' => '', 'load_index' => '', 'speed_rating' => '']];
    }
}


$success = $error = "";
$tiremodel_err = $tireimage_err = $season_err = $manufacturers_err = $vehicle_types_err = $tire_content_err = $tire_mini_content_err = $csfr_err = "";
$size_errors = [];

// select listeleri (istersen selectbox için)
$widths    = range(145, 335, 10);
$heights   = range(30, 85, 5);
$diameters = range(12, 20, 1);


// --- POST: güncelle ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (!isset($_POST['csrf_token']) || !validate_csrf_token($_POST['csrf_token'])) {
        $csfr_err = "Geçersiz CSRF token! İşlem iptal edildi.";
    }
    $tire_id = (int)($_POST['tire_id'] ?? 0);
    if ($tire_id <= 0) {
        die("Geçersiz lastik ID.");
    }

    // --- GET: mevcut veriyi çek ---
    $stmt = $pdo->prepare("SELECT * FROM tires WHERE id=? LIMIT 1");
    $stmt->execute([$tire_id]);
    $tire = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$tire) {
        die("Kayıt bulunamadı");
    }

    $tiremodel = $tire['model'];
    $season = $tire['season'];
    $runflat = (int)$tire['run_flat'];
    $manufacturers_id = (int)$tire['manufacturer_id'];
    $tire_content = $tire['description'];
    $tire_mini_content = $tire['mini_description'];
    $current_photo = $tire['photo'];
    // seçili araç tipleri
    $vtStmt = $pdo->prepare("SELECT vehicle_type_id FROM tire_vehicle_type WHERE tire_id=?");
    $vtStmt->execute([$tire_id]);
    $vehicle_types = array_map('intval', $vtStmt->fetchAll(PDO::FETCH_COLUMN));

    // mevcut ebatlar
    $szStmt = $pdo->prepare("SELECT * FROM tire_sizes WHERE tire_id=? ORDER BY id ASC");
    $szStmt->execute([$tire_id]);
    $sizes_post = $szStmt->fetchAll(PDO::FETCH_ASSOC);
    if (!$sizes_post) {
        $sizes_post = [['id' => '', 'width' => '', 'aspect_ratio' => '', 'rim_diameter' => '', 'load_index' => '', 'speed_rating' => '']];
    }

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

    $runflat = isset($_POST['runflat']) ? 1 : 0;

    $tire_mini_content = trim($_POST["tire_mini_content"] ?? "");
    if ($tire_mini_content === "") $tire_mini_content_err = "Mini açıklama boş bırakılamaz.";

    $tire_content = trim($_POST["tire_content"] ?? "");
    if ($tire_content === "") $tire_content_err = "Lastik açıklaması boş bırakılamaz.";

    if (!isset($_POST["vehicle_types"]) || !is_array($_POST["vehicle_types"]) || count($_POST["vehicle_types"]) === 0) {
        $vehicle_types_err = "Araç tipi seçilmelidir.";
    } else {
        $vehicle_types = array_map('intval', $_POST["vehicle_types"]);
    }

    // aynı marka + aynı model kontrolü (kendi kaydını hariç tut!)
    if (empty($tiremodel_err) && empty($manufacturers_err)) {
        $chk = $pdo->prepare("SELECT id FROM tires WHERE manufacturer_id=? AND model=? AND id<>? LIMIT 1");
        $chk->execute([$manufacturers_id, $tiremodel, $tire_id]);
        if ((int)$chk->fetchColumn() > 0) {
            $tiremodel_err = "Bu markaya ait bu desen zaten kayıtlı.";
        }
    }

    // Foto: edit’te opsiyonel (yüklenmezse eskisi kalsın)
    $new_photo = $current_photo;
    if (!empty($_FILES["tireimage"]["tmp_name"])) {
        $target_dir = "../uploads/tires/";
        if (!is_dir($target_dir)) @mkdir($target_dir, 0775, true);

        $ext = strtolower(pathinfo($_FILES["tireimage"]["name"], PATHINFO_EXTENSION));
        $target_file = $target_dir . uniqid("tire-", true) . "." . $ext;

        $check = getimagesize($_FILES["tireimage"]["tmp_name"]);
        if ($check === false) {
            $error = "Dosya bir resim değil.";
        } elseif ($_FILES["tireimage"]["size"] > 15242880) {
            $error = "Üzgünüz, dosya çok büyük.";
        } elseif (!in_array($ext, ["jpeg", "jpg", "png"])) {
            $error = "Üzgünüz, sadece JPG/JPEG/PNG yüklenebilir.";
        } elseif (!move_uploaded_file($_FILES["tireimage"]["tmp_name"], $target_file)) {
            $error = "Dosya yüklenirken hata oluştu.";
        } else {
            $new_photo = $target_file;
        }
    }

    // Repeater ebatlar
    $posted = $_POST['group-a'] ?? [];
    if (!is_array($posted) || count($posted) === 0) {
        $error = "En az 1 ebat girmelisiniz.";
    }

    // form tekrar dolsun diye
    $sizes_post = $posted;

    // satır doğrulama + normalize
    $normalized_sizes = [];
    foreach ($posted as $i => $row) {
        $sid = (int)($row['size_id'] ?? 0);
        $w  = (int)($row['tirewidth'] ?? 0);
        $h  = (int)($row['tireheight'] ?? 0);
        $d  = (int)($row['tirediameter'] ?? 0);
        $li = trim($row['loadindex'] ?? "");
        $sr = trim($row['speedrating'] ?? "");

        if ($w <= 0) $size_errors[$i]['tirewidth'] = "Genişlik zorunlu.";
        if ($h <= 0) $size_errors[$i]['tireheight'] = "Yükseklik zorunlu.";
        if ($d <= 0) $size_errors[$i]['tirediameter'] = "Çap zorunlu.";
        if ($li === "") $size_errors[$i]['loadindex'] = "Yük endeksi zorunlu.";
        if ($sr === "") $size_errors[$i]['speedrating'] = "Hız endeksi zorunlu.";

        $normalized_sizes[] = [
            'size_id' => $sid,
            'width' => $w,
            'aspect_ratio' => $h,
            'rim_diameter' => $d,
            'load_index' => $li,
            'speed_rating' => $sr,
        ];
    }

    $has_size_error = !empty($size_errors);

    if (
        empty($tiremodel_err) && empty($tire_mini_content_err) && empty($season_err) && empty($manufacturers_err) &&
        empty($vehicle_types_err) && empty($tire_content_err) && empty($csfr_err) &&
        empty($error) && !$has_size_error
    ) {
        try {
            $pdo->beginTransaction();

            // 1) tires güncelle
            $up = $pdo->prepare("
        UPDATE tires
        SET photo=?, model=?, model_link=?, season=?, run_flat=?, manufacturer_id=?, description=?, mini_description=?
        WHERE id=?
      ");
            $up->execute([$new_photo, $tiremodel, $model_link, $season, $runflat, $manufacturers_id, $tire_content, $tire_mini_content, $tire_id]);

            // 2) araç tipleri (sil-yaz)
            $pdo->prepare("DELETE FROM tire_vehicle_type WHERE tire_id=?")->execute([$tire_id]);
            $insVT = $pdo->prepare("INSERT INTO tire_vehicle_type (tire_id, vehicle_type_id) VALUES (?, ?)");
            foreach ($vehicle_types as $vt) {
                $insVT->execute([$tire_id, $vt]);
            }

            // 3) ebatlar: update/insert
            $existingIdsStmt = $pdo->prepare("SELECT id FROM tire_sizes WHERE tire_id=?");
            $existingIdsStmt->execute([$tire_id]);
            $existing_ids = array_map('intval', $existingIdsStmt->fetchAll(PDO::FETCH_COLUMN));

            $posted_ids = [];
            $updSize = $pdo->prepare("
        UPDATE tire_sizes
        SET width=?, aspect_ratio=?, rim_diameter=?, load_index=?, speed_rating=?
        WHERE id=? AND tire_id=?
      ");
            $insSize = $pdo->prepare("
        INSERT INTO tire_sizes (tire_id, width, aspect_ratio, rim_diameter, load_index, speed_rating)
        VALUES (?, ?, ?, ?, ?, ?)
      ");

            foreach ($normalized_sizes as $s) {
                if ($s['size_id'] > 0) {
                    $posted_ids[] = $s['size_id'];
                    $updSize->execute([
                        $s['width'],
                        $s['aspect_ratio'],
                        $s['rim_diameter'],
                        $s['load_index'],
                        $s['speed_rating'],
                        $s['size_id'],
                        $tire_id
                    ]);
                } else {
                    $insSize->execute([$tire_id, $s['width'], $s['aspect_ratio'], $s['rim_diameter'], $s['load_index'], $s['speed_rating']]);
                }
            }

            // 4) silinen ebatları DB’den kaldır
            $to_delete = array_diff($existing_ids, $posted_ids);
            if (!empty($to_delete)) {
                $in = implode(',', array_fill(0, count($to_delete), '?'));
                $del = $pdo->prepare("DELETE FROM tire_sizes WHERE tire_id=? AND id IN ($in)");
                $del->execute(array_merge([$tire_id], array_values($to_delete)));
            }

            $pdo->commit();
            $success = "Güncelleme başarılı.";

            // güncel foto
            $current_photo = $new_photo;
        } catch (PDOException $e) {
            $pdo->rollBack();
            // ebat uniq yakalama
            if (str_contains($e->getMessage(), 'uniq_tire_size')) {
                $error = "Aynı ebat aynı desende tekrar edemez (tekrarlı satır var).";
            } else if (($e->errorInfo[1] ?? null) == 1062) {
                $error = "Aynı marka + aynı desen adı zaten mevcut.";
            } else {
                $error = "DB Hatası: " . $e->getMessage();
            }
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
                            <h4 class="mb-sm-0 font-size-18">Lastik Düzenle</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Lastikler</a></li>
                                    <li class="breadcrumb-item active">Lastik Düzenle</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title"><?= $tire['model'] ?></h4>
                                <p class="card-title-desc">Oluşturduğunuz lastikleri buradan düzenleyebilirsiniz</p>

                                <form class="repeater" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                                    <label for="tire_content" class="form-label">Lastik Görseli</label>
                                    <div class="row mb-3">
                                        <div class="col-sm-6">
                                            <img src="<?php echo $tire['photo']; ?>" height="200" alt="Lastik Görseli">
                                        </div>
                                    </div>

                                    <input type="hidden" name="tire_id" value="<?php echo $tire_id ?>">
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
                                                echo "<option value='$manufacturerId' " . (($manufacturerId == $tire['manufacturer_id']) ? 'selected' : '') . ">$manufacturer_name</option>";
                                            }
                                            ?>

                                        </select>
                                        <span class="text-danger"><?php echo $manufacturers_err; ?></span>
                                    </div>


                                    <div class="mb-3 <?php echo (!empty($tiremodel_err)) ? 'has-error' : ''; ?>">
                                        <label for="tiremodel" class="form-label">Lastik Modeli</label>
                                        <input type="text" class="form-control" id="tiremodel" name="tiremodel" placeholder="Lastik modeli giriniz" value="<?php echo $tire['model']; ?>">
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
                                                echo "<option value='$vehicleTypeId' " . (in_array((int)$vehicleTypeId, $vehicle_types ?? [], true) ? 'selected' : '') . ">$vehicleTypeName</option>";
                                            }
                                            ?>
                                        </select>

                                        <span class="text-danger"><?php echo $vehicle_types_err; ?></span>

                                    </div>

                                    <div class="mb-3 <?php echo (!empty($season_err)) ? 'has-error' : ''; ?>">
                                        <label for="season" class="form-label">Sezon</label>
                                        <select class="form-select" id="season" name="season">

                                            <option value="">Seçiniz</option>
                                            <option value="Yaz" <?php echo ($tire['season'] == 'Yaz') ? 'selected' : ''; ?>>Yaz</option>
                                            <option value="Kış" <?php echo ($tire['season'] == 'Kış') ? 'selected' : ''; ?>>Kış</option>
                                            <option value="Dört Mevsim" <?php echo ($tire['season'] == 'Dört Mevsim') ? 'selected' : ''; ?>>Dört Mevsim</option>

                                        </select>
                                        <span class="text-danger"><?php echo $season_err; ?></span>
                                    </div>

                                    <div class="form-check form-check-primary mb-3">
                                        <input class="form-check-input" type="checkbox" id="formCheckcolor1" name="runflat" <?php echo ($tire['run_flat'] == 1) ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="formCheckcolor1">
                                            Run Flat (Patlasa da gidebilen)
                                        </label>
                                    </div>


                                    <div class="mt-3">
                                        <label class="form-label">Lastik Ölçüleri</label>

                                        <div data-repeater-list="group-a">

                                            <?php
                                            // Eğer hiç ebat yoksa 1 satır göster
                                            if (empty($sizes_post) || !is_array($sizes_post)) {
                                                $sizes_post = [['id' => '', 'width' => '', 'aspect_ratio' => '', 'rim_diameter' => '', 'load_index' => '', 'speed_rating' => '']];
                                            }

                                            foreach ($sizes_post as $i => $row) {

                                                // DB'den gelen / POST'tan gelen alanları normalize et
                                                $sid = $row['id'] ?? ($row['size_id'] ?? 0);

                                                $w  = $row['width'] ?? ($row['tirewidth'] ?? '');
                                                $h  = $row['aspect_ratio'] ?? ($row['tireheight'] ?? '');
                                                $d  = $row['rim_diameter'] ?? ($row['tirediameter'] ?? '');
                                                $li = $row['load_index'] ?? ($row['loadindex'] ?? '');
                                                $sr = $row['speed_rating'] ?? ($row['speedrating'] ?? '');
                                            ?>
                                                <div data-repeater-item class="row align-items-end">

                                                    <!-- Edit için gerekli: mevcut satırın id’si -->
                                                    <input type="hidden" name="size_id" value="<?php echo htmlspecialchars($sid); ?>">

                                                    <div class="mb-3 col-lg-2">
                                                        <label class="form-label">Genişlik</label>
                                                        <select class="form-select" name="tirewidth" required>
                                                            <option value="">Seç</option>
                                                            <?php foreach ($widths as $opt) { ?>
                                                                <option value="<?php echo $opt; ?>" <?php echo ((string)$w === (string)$opt) ? 'selected' : ''; ?>>
                                                                    <?php echo $opt; ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                        <?php if (!empty($size_errors[$i]['tirewidth'])) { ?>
                                                            <span class="text-danger"><?php echo htmlspecialchars($size_errors[$i]['tirewidth']); ?></span>
                                                        <?php } ?>
                                                    </div>

                                                    <div class="mb-3 col-lg-2">
                                                        <label class="form-label">Yükseklik</label>
                                                        <select class="form-select" name="tireheight" required>
                                                            <option value="">Seç</option>
                                                            <?php foreach ($heights as $opt) { ?>
                                                                <option value="<?php echo $opt; ?>" <?php echo ((string)$h === (string)$opt) ? 'selected' : ''; ?>>
                                                                    <?php echo $opt; ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                        <?php if (!empty($size_errors[$i]['tireheight'])) { ?>
                                                            <span class="text-danger"><?php echo htmlspecialchars($size_errors[$i]['tireheight']); ?></span>
                                                        <?php } ?>
                                                    </div>

                                                    <div class="mb-3 col-lg-2">
                                                        <label class="form-label">Çap</label>
                                                        <select class="form-select" name="tirediameter" required>
                                                            <option value="">Seç</option>
                                                            <?php foreach ($diameters as $opt) { ?>
                                                                <option value="<?php echo $opt; ?>" <?php echo ((string)$d === (string)$opt) ? 'selected' : ''; ?>>
                                                                    <?php echo $opt; ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                        <?php if (!empty($size_errors[$i]['tirediameter'])) { ?>
                                                            <span class="text-danger"><?php echo htmlspecialchars($size_errors[$i]['tirediameter']); ?></span>
                                                        <?php } ?>
                                                    </div>

                                                    <div class="mb-3 col-lg-2">
                                                        <label class="form-label">Yük</label>
                                                        <input type="text" class="form-control" name="loadindex" value="<?php echo htmlspecialchars($li); ?>" required>
                                                        <?php if (!empty($size_errors[$i]['loadindex'])) { ?>
                                                            <span class="text-danger"><?php echo htmlspecialchars($size_errors[$i]['loadindex']); ?></span>
                                                        <?php } ?>
                                                    </div>

                                                    <div class="mb-3 col-lg-2">
                                                        <label class="form-label">Hız</label>
                                                        <input type="text" class="form-control" name="speedrating" value="<?php echo htmlspecialchars($sr); ?>" required>
                                                        <?php if (!empty($size_errors[$i]['speedrating'])) { ?>
                                                            <span class="text-danger"><?php echo htmlspecialchars($size_errors[$i]['speedrating']); ?></span>
                                                        <?php } ?>
                                                    </div>

                                                    <div class="mb-3 col-lg-2">
                                                        <div class="d-grid">
                                                            <input data-repeater-delete type="button" class="btn btn-primary" value="Sil" />
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>

                                        </div>

                                        <input data-repeater-create type="button" class="btn btn-success mt-2" value="Ebat Ekle" />
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


                                        <textarea id="tire_content" name="tire_content"><?= $tire_content ?></textarea>

                                        <span class="text-danger"><?php echo $tire_content_err; ?></span>
                                    </div>









                                    <div class="mt-4 d-grid d-flex flex-wrap gap-2">
                                        <button class="btn btn-primary waves-effect waves-light" name="kaydet" type="submit">Güncelle</button>
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

<!-- Sweet alert init js-->
<script src="assets/js/pages/sweet-alerts.init.js"></script>
<!--tinymce js-->
<script src="assets/libs/tinymce/tinymce.min.js"></script>
<script src="assets/libs/select2/js/select2.min.js"></script>
<script src="assets/js/pages/form-editor.init.js"></script>
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