<?php

include 'layouts/session.php';
require_once "layouts/config.php";

// ---- Yardımcılar ----
function ensure_dir($dir) {
    if (!is_dir($dir)) @mkdir($dir, 0775, true);
}
function upload_image($tmp, $name, $dir, &$err) {
    ensure_dir($dir);

    $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
    if (!in_array($ext, ["jpeg", "jpg", "png"], true)) {
        $err = "Üzgünüz, sadece JPG/JPEG/PNG yüklenebilir.";
        return "";
    }

    $check = @getimagesize($tmp);
    if ($check === false) {
        $err = "Dosya bir resim değil.";
        return "";
    }

    if (filesize($tmp) > 15242880) {
        $err = "Üzgünüz, dosya çok büyük.";
        return "";
    }

    $target = $dir . uniqid("rim-", true) . "." . $ext;
    if (!move_uploaded_file($tmp, $target)) {
        $err = "Dosya yüklenirken hata oluştu.";
        return "";
    }

    return $target;
}

// ---- Vars ----
$rim_id = (int)($_GET['id'] ?? $_POST['rim_id'] ?? 0);
if ($rim_id <= 0) {
    die("Geçersiz ID");
}

// Form vars
$brand = $model = $mini_description = $description = "";
$main_photo = ""; // path
$model_link = "";

$brand_err = $model_err = $mini_err = $desc_err = $main_photo_err = $gallery_err = $csrf_err = "";
$spec_errors = [];
$success = $error = "";

// Listeler
$diameters = range(12, 24, 1);
$widths = [];
for ($w = 6.0; $w <= 12.0; $w += 0.5) $widths[] = number_format($w, 1, '.', '');

// ---- DB: mevcut rim getir ----
$getRim = $pdo->prepare("SELECT * FROM rims WHERE id=? LIMIT 1");
$getRim->execute([$rim_id]);
$rim = $getRim->fetch(PDO::FETCH_ASSOC);
if (!$rim) {
    die("Jant bulunamadı");
}

// Mevcut galeri
$getImgs = $pdo->prepare("SELECT id, image_path, sort_order FROM rim_images WHERE rim_id=? ORDER BY sort_order ASC, id ASC");
$getImgs->execute([$rim_id]);
$rim_images = $getImgs->fetchAll(PDO::FETCH_ASSOC);

// Mevcut specs
$getSpecs = $pdo->prepare("SELECT * FROM rim_specs WHERE rim_id=? ORDER BY id ASC");
$getSpecs->execute([$rim_id]);
$rim_specs = $getSpecs->fetchAll(PDO::FETCH_ASSOC);

// Formda göstereceğimiz repeater data
$specs_post = $_POST['spec-group'] ?? (
    !empty($rim_specs) ? array_map(function($r){
        return [
            'diameter' => $r['diameter'],
            'width' => number_format((float)$r['width'], 1, '.', ''),
            'bolt_pattern' => $r['bolt_pattern'],
            'offset_et' => $r['offset_et'],
            'center_bore' => $r['center_bore'],
            'color' => $r['color'],
            'finish' => $r['finish'],
            'material' => $r['material'],
        ];
    }, $rim_specs) : [
        ['diameter' => '', 'width' => '', 'bolt_pattern' => '', 'offset_et' => '', 'center_bore' => '', 'color' => '', 'finish' => '', 'material' => '']
    ]
);

// İlk açılışta form değerleri DB’den gelsin (POST yoksa)
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    $brand = $rim['brand'] ?? "";
    $model = $rim['model'] ?? "";
    $mini_description = $rim['mini_description'] ?? "";
    $description = $rim['description'] ?? "";
    $main_photo = $rim['photo'] ?? "";
    $model_link = $rim['model_link'] ?? "";
}

// ---- POST işlemi ----
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // CSRF
    if (!isset($_POST['csrf_token']) || !validate_csrf_token($_POST['csrf_token'])) {
        $csrf_err = "Geçersiz CSRF token! İşlem iptal edildi.";
    }

    // Marka / Model
    $brand = trim($_POST["brand"] ?? "");
    if ($brand === "") $brand_err = "Jant markası boş bırakılamaz.";

    $model = trim($_POST["model"] ?? "");
    if ($model === "") $model_err = "Jant modeli boş bırakılamaz.";

    // Model link üret
    if (empty($brand_err) && empty($model_err)) {
        $model_link = permalink($brand . "-" . $model);
        if ($model_link === "") $error = "Model link üretilemedi.";
    }

    // model_link uniq kontrol (kendini hariç tut)
    if (empty($error) && $model_link !== "") {
        $chk = $pdo->prepare("SELECT COUNT(*) FROM rims WHERE model_link=? AND id<>?");
        $chk->execute([$model_link, $rim_id]);
        if ((int)$chk->fetchColumn() > 0) {
            $model_err = "Bu jant zaten kayıtlı (link çakışması). Model adını farklılaştırın.";
        }
    }

    // Mini açıklama
    $mini_description = trim($_POST["mini_description"] ?? "");
    if ($mini_description === "") $mini_err = "Mini açıklama boş bırakılamaz.";
    if ($mini_description !== "" && mb_strlen($mini_description) > 255) $mini_err = "Mini açıklama en fazla 255 karakter olabilir.";

    // Açıklama
    $description = trim($_POST["description"] ?? "");
    if ($description === "") $desc_err = "Açıklama boş bırakılamaz.";

    // Ana görsel (opsiyonel)
    $new_main_photo = "";
    if (!empty($_FILES["main_photo"]["tmp_name"])) {
        $new_main_photo = upload_image($_FILES["main_photo"]["tmp_name"], $_FILES["main_photo"]["name"], "../uploads/rims/", $main_photo_err);
    }

    // Galeri path’leri (hidden inputlar)
    $gallery_paths = [];
    if (isset($_POST['gallery_paths']) && is_array($_POST['gallery_paths'])) {
        foreach ($_POST['gallery_paths'] as $path) {
            $trimmed = trim($path);
            if ($trimmed !== "") $gallery_paths[] = $trimmed;
        }
    }

    // Specs doğrulama
    $specs = $_POST['spec-group'] ?? [];
    if (!is_array($specs) || count($specs) === 0) {
        $error = "En az 1 varyasyon girmelisiniz.";
    } else {
        foreach ($specs as $i => $row) {
            $d = trim($row['diameter'] ?? '');
            $w = trim($row['width'] ?? '');
            $bp = trim($row['bolt_pattern'] ?? '');
            $et = trim($row['offset_et'] ?? '');
            $cb = trim($row['center_bore'] ?? '');
            $c  = trim($row['color'] ?? '');
            $f  = trim($row['finish'] ?? '');
            $m  = trim($row['material'] ?? '');

            if ($d === "" || !is_numeric($d)) $spec_errors[$i]['diameter'] = "Çap sayısal olmalı.";
            if ($w === "" || !is_numeric($w)) $spec_errors[$i]['width'] = "Genişlik sayısal olmalı.";
            if ($bp === "") $spec_errors[$i]['bolt_pattern'] = "Bijon deseni zorunlu.";
            if ($et === "" || !is_numeric($et)) $spec_errors[$i]['offset_et'] = "ET sayısal olmalı.";
            if ($cb === "" || !is_numeric($cb)) $spec_errors[$i]['center_bore'] = "Göbek çapı sayısal olmalı.";
            if ($c === "") $spec_errors[$i]['color'] = "Renk zorunlu.";
            if ($f === "") $spec_errors[$i]['finish'] = "Yüzey zorunlu.";
            if ($m === "") $spec_errors[$i]['material'] = "Malzeme zorunlu.";

            if ($d !== "" && !in_array((int)$d, $diameters, true)) $spec_errors[$i]['diameter'] = "Geçersiz çap.";
            if ($w !== "" && !in_array(number_format((float)$w, 1, '.', ''), $widths, true)) $spec_errors[$i]['width'] = "Geçersiz genişlik.";
        }
    }
    $has_spec_error = !empty($spec_errors);

    // DB update
    if (
        empty($brand_err) && empty($model_err) && empty($mini_err) && empty($desc_err) &&
        empty($main_photo_err) && empty($gallery_err) && empty($csrf_err) && empty($error) && !$has_spec_error
    ) {
        try {
            $pdo->beginTransaction();

            // 1) rims update
            if ($new_main_photo !== "") {
                // eski foto opsiyonel silinebilir (istersen)
                // @unlink($rim['photo']);
                $upd = $pdo->prepare("UPDATE rims SET photo=?, brand=?, model=?, model_link=?, mini_description=?, description=? WHERE id=?");
                $upd->execute([$new_main_photo, $brand, $model, $model_link, $mini_description, $description, $rim_id]);
                $main_photo = $new_main_photo;
            } else {
                $upd = $pdo->prepare("UPDATE rims SET brand=?, model=?, model_link=?, mini_description=?, description=? WHERE id=?");
                $upd->execute([$brand, $model, $model_link, $mini_description, $description, $rim_id]);
            }

            // 2) rim_specs: temizle -> yeniden ekle
            $pdo->prepare("DELETE FROM rim_specs WHERE rim_id=?")->execute([$rim_id]);

            $insSpec = $pdo->prepare("
                INSERT INTO rim_specs (rim_id, diameter, width, bolt_pattern, offset_et, center_bore, color, finish, material)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            foreach ($specs as $row) {
                $insSpec->execute([
                    $rim_id,
                    (int)$row['diameter'],
                    (float)$row['width'],
                    trim($row['bolt_pattern']),
                    (int)$row['offset_et'],
                    (float)$row['center_bore'],
                    trim($row['color']),
                    trim($row['finish']),
                    trim($row['material']),
                ]);
            }

            // 3) rim_images: temizle -> yeniden ekle
            // Not: Silinen eski görselleri dosyadan silmek istersen burada kontrol gerekir.
            $pdo->prepare("DELETE FROM rim_images WHERE rim_id=?")->execute([$rim_id]);

            if (!empty($gallery_paths)) {
                $insImg = $pdo->prepare("INSERT INTO rim_images (rim_id, image_path, sort_order) VALUES (?, ?, ?)");
                foreach ($gallery_paths as $idx => $path) {
                    $insImg->execute([$rim_id, $path, $idx]);
                }
            }

            $pdo->commit();
            $success = "Jant başarıyla güncellendi. (" . count($specs) . " varyasyon, " . count($gallery_paths) . " galeri görseli)";

            // güncel veriyi tekrar çek (sayfa yenilenmeden doğru görüntülensin)
            $getRim->execute([$rim_id]);
            $rim = $getRim->fetch(PDO::FETCH_ASSOC);

            $getImgs->execute([$rim_id]);
            $rim_images = $getImgs->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            $pdo->rollBack();

            if (str_contains($e->getMessage(), 'uniq_model_link')) {
                $error = "Model link zaten kullanılıyor. Model adını farklılaştırın.";
            } elseif (str_contains($e->getMessage(), 'uniq_rim_spec')) {
                $error = "Aynı jant varyasyonu tekrar eklenemez. (Tekrarlı satır var)";
            } else {
                $error = "DB Hatası: " . $e->getMessage();
            }
        } catch (Exception $e) {
            $pdo->rollBack();
            $error = $e->getMessage();
        }
    }

    // fail olursa form dolu kalsın
    $specs_post = $_POST['spec-group'] ?? $specs_post;
}

?>

<?php include 'layouts/head-main.php'; ?>
<head>
    <title>Jant Düzenle | MENEKŞE LASTİK YÖNETİM PANELİ</title>
    <?php include 'layouts/head.php'; ?>
    <?php include 'layouts/head-style.php'; ?>
    <link rel="stylesheet" type="text/css" href="assets/libs/toastr/build/toastr.min.css">
    <link href="assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/dropzone/min/dropzone.min.css" rel="stylesheet" type="text/css" />
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
                            <h4 class="mb-sm-0 font-size-18">Jant Düzenle</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Jantlar</a></li>
                                    <li class="breadcrumb-item active">Jant Düzenle</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title"><?php echo htmlspecialchars(($rim['brand'] ?? '') . " " . ($rim['model'] ?? '')); ?></h4>
                                <p class="card-title-desc">Buradan jantı düzenleyebilir ve varyasyonlarını güncelleyebilirsiniz.</p>

                                <form id="rimForm" class="repeater" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?id=<?php echo $rim_id; ?>" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                                    <input type="hidden" name="rim_id" value="<?php echo $rim_id; ?>">

                                    <!-- Mevcut Ana Görsel -->
                                    <div class="mb-3">
                                        <label class="form-label">Mevcut Ana Görsel</label>
                                        <div>
                                            <?php if (!empty($rim['photo'])) { ?>
                                                <img src="<?php echo htmlspecialchars($rim['photo']); ?>" height="160" alt="Ana Görsel">
                                            <?php } else { ?>
                                                <div class="text-muted">Ana görsel yok</div>
                                            <?php } ?>
                                        </div>
                                    </div>

                                    <!-- Yeni Ana Görsel (opsiyonel) -->
                                    <div class="mb-3 <?php echo (!empty($main_photo_err)) ? 'has-error' : ''; ?>">
                                        <label class="form-label">Yeni Ana Görsel (seçmezseniz değişmez)</label>
                                        <input type="file" class="form-control" name="main_photo">
                                        <span class="text-danger"><?php echo $main_photo_err; ?></span>
                                    </div>

                                    <!-- Galeri -->
                                    <div class="mb-3">
                                        <label class="form-label">Galeri Görselleri</label>
                                        <div id="rimGalleryDropzone" class="dropzone">
                                            <div class="fallback">
                                                <input name="file" type="file" multiple="multiple">
                                            </div>
                                            <div class="dz-message needsclick">
                                                <div class="mb-3">
                                                    <i class="display-4 text-muted bx bxs-cloud-upload"></i>
                                                </div>
                                                <h4>Dosyaları buraya sürükleyin veya tıklayın.</h4>
                                            </div>
                                        </div>

                                        <!-- Hidden inputs (mevcut + yeni) -->
                                        <div id="galleryHiddenInputs">
                                            <?php
                                            // Edit sayfasında mevcut görselleri hidden olarak da yazıyoruz ki “kaydet”te tekrar gitsin
                                            foreach ($rim_images as $img) {
                                                $p = $img['image_path'];
                                                echo '<input type="hidden" name="gallery_paths[]" value="'.htmlspecialchars($p).'">';
                                            }
                                            ?>
                                        </div>

                                        <small class="text-muted">JPG/JPEG/PNG, max 15MB.</small>
                                        <span class="text-danger"><?php echo $gallery_err ?? ''; ?></span>
                                    </div>

                                    <div class="mb-3 <?php echo (!empty($brand_err)) ? 'has-error' : ''; ?>">
                                        <label class="form-label">Jant Markası</label>
                                        <input type="text" class="form-control" name="brand" value="<?php echo htmlspecialchars($brand ?: ($rim['brand'] ?? '')); ?>">
                                        <span class="text-danger"><?php echo $brand_err; ?></span>
                                    </div>

                                    <div class="mb-3 <?php echo (!empty($model_err)) ? 'has-error' : ''; ?>">
                                        <label class="form-label">Jant Modeli</label>
                                        <input type="text" class="form-control" name="model" value="<?php echo htmlspecialchars($model ?: ($rim['model'] ?? '')); ?>">
                                        <span class="text-danger"><?php echo $model_err; ?></span>
                                    </div>

                                    <div class="mb-3 <?php echo (!empty($mini_err)) ? 'has-error' : ''; ?>">
                                        <label class="form-label">Mini Açıklama</label>
                                        <textarea id="tire_mini_content" name="mini_description"><?php echo htmlspecialchars($mini_description ?: ($rim['mini_description'] ?? '')); ?></textarea>
                                        <span class="text-danger"><?php echo $mini_err; ?></span>
                                    </div>

                                    <div class="mt-3">
                                        <label class="form-label">Jant Varyasyonları</label>
                                        <div data-repeater-list="spec-group">
                                            <?php foreach ($specs_post as $i => $row) { ?>
                                                <div data-repeater-item class="row">
                                                    <div class="mb-3 col-lg-2">
                                                        <label class="form-label">Çap</label>
                                                        <select class="form-select" name="diameter">
                                                            <option value="">Seç</option>
                                                            <?php foreach ($diameters as $d) { ?>
                                                                <option value="<?php echo $d; ?>" <?php echo ((($row['diameter'] ?? '') == $d) ? 'selected' : ''); ?>>
                                                                    <?php echo $d; ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                        <?php if (!empty($spec_errors[$i]['diameter'])) { ?>
                                                            <span class="text-danger"><?php echo htmlspecialchars($spec_errors[$i]['diameter']); ?></span>
                                                        <?php } ?>
                                                    </div>

                                                    <div class="mb-3 col-lg-2">
                                                        <label class="form-label">Genişlik</label>
                                                        <select class="form-select" name="width">
                                                            <option value="">Seç</option>
                                                            <?php foreach ($widths as $w) { ?>
                                                                <option value="<?php echo $w; ?>" <?php echo ((($row['width'] ?? '') == $w) ? 'selected' : ''); ?>>
                                                                    <?php echo $w; ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                        <?php if (!empty($spec_errors[$i]['width'])) { ?>
                                                            <span class="text-danger"><?php echo htmlspecialchars($spec_errors[$i]['width']); ?></span>
                                                        <?php } ?>
                                                    </div>

                                                    <div class="mb-3 col-lg-2">
                                                        <label class="form-label">Bijon</label>
                                                        <input type="text" class="form-control" name="bolt_pattern" value="<?php echo htmlspecialchars($row['bolt_pattern'] ?? ''); ?>">
                                                        <?php if (!empty($spec_errors[$i]['bolt_pattern'])) { ?>
                                                            <span class="text-danger"><?php echo htmlspecialchars($spec_errors[$i]['bolt_pattern']); ?></span>
                                                        <?php } ?>
                                                    </div>

                                                    <div class="mb-3 col-lg-2">
                                                        <label class="form-label">ET</label>
                                                        <input type="number" class="form-control" name="offset_et" value="<?php echo htmlspecialchars($row['offset_et'] ?? ''); ?>">
                                                        <?php if (!empty($spec_errors[$i]['offset_et'])) { ?>
                                                            <span class="text-danger"><?php echo htmlspecialchars($spec_errors[$i]['offset_et']); ?></span>
                                                        <?php } ?>
                                                    </div>

                                                    <div class="mb-3 col-lg-2">
                                                        <label class="form-label">Göbek</label>
                                                        <input type="number" step="0.1" class="form-control" name="center_bore" value="<?php echo htmlspecialchars($row['center_bore'] ?? ''); ?>">
                                                        <?php if (!empty($spec_errors[$i]['center_bore'])) { ?>
                                                            <span class="text-danger"><?php echo htmlspecialchars($spec_errors[$i]['center_bore']); ?></span>
                                                        <?php } ?>
                                                    </div>

                                                    <div class="mb-3 col-lg-2">
                                                        <label class="form-label">Malzeme</label>
                                                        <input type="text" class="form-control" name="material" value="<?php echo htmlspecialchars($row['material'] ?? ''); ?>">
                                                        <?php if (!empty($spec_errors[$i]['material'])) { ?>
                                                            <span class="text-danger"><?php echo htmlspecialchars($spec_errors[$i]['material']); ?></span>
                                                        <?php } ?>
                                                    </div>

                                                    <div class="mb-3 col-lg-3">
                                                        <label class="form-label">Renk</label>
                                                        <input type="text" class="form-control" name="color" value="<?php echo htmlspecialchars($row['color'] ?? ''); ?>">
                                                        <?php if (!empty($spec_errors[$i]['color'])) { ?>
                                                            <span class="text-danger"><?php echo htmlspecialchars($spec_errors[$i]['color']); ?></span>
                                                        <?php } ?>
                                                    </div>

                                                    <div class="mb-3 col-lg-3">
                                                        <label class="form-label">Yüzey</label>
                                                        <input type="text" class="form-control" name="finish" value="<?php echo htmlspecialchars($row['finish'] ?? ''); ?>">
                                                        <?php if (!empty($spec_errors[$i]['finish'])) { ?>
                                                            <span class="text-danger"><?php echo htmlspecialchars($spec_errors[$i]['finish']); ?></span>
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
                                        <input data-repeater-create type="button" class="btn btn-success mt-3 mt-lg-0" value="Varyasyon Ekle" />
                                    </div>

                                    <div class="mb-3 mt-3 <?php echo (!empty($desc_err)) ? 'has-error' : ''; ?>">
                                        <label class="form-label">Açıklama</label>
                                        <textarea id="tire_content" name="description"><?php echo htmlspecialchars($description ?: ($rim['description'] ?? '')); ?></textarea>
                                        <span class="text-danger"><?php echo $desc_err; ?></span>
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

<!-- Dropzone -->
<script src="assets/libs/dropzone/min/dropzone.min.js"></script>

<script>
Dropzone.autoDiscover = false;

const dz = new Dropzone("#rimGalleryDropzone", {
    url: "ajax/upload-rim-gallery.php",
    paramName: "file",
    maxFilesize: 15,
    acceptedFiles: ".jpg,.jpeg,.png",
    uploadMultiple: false,
    parallelUploads: 4,
    addRemoveLinks: true,
    dictRemoveFile: "Sil",
    dictDefaultMessage: "Dosyaları buraya sürükleyin veya tıklayın.",
});

// ✅ Mevcut galeri görsellerini Dropzone’a “mock” olarak ekle
(function preloadExistingGallery(){
    const existing = <?php echo json_encode(array_map(function($img){
        return [
            'name' => basename($img['image_path']),
            'size' => 12345,
            'path' => $img['image_path'],
        ];
    }, $rim_images), JSON_UNESCAPED_UNICODE); ?>;

    existing.forEach(item => {
        const mock = { name: item.name, size: item.size };
        dz.emit("addedfile", mock);
        dz.emit("thumbnail", mock, item.path);
        dz.emit("complete", mock);
        mock._uploadedPath = item.path;
        mock._isExisting = true;
        dz.files.push(mock);
    });
})();

dz.on("success", function(file, res) {
    if (typeof res === "string") {
        try { res = JSON.parse(res); } catch(e) { res = null; }
    }
    if (!res || res.status !== "ok" || !res.path) {
        dz.removeFile(file);
        alert("Yükleme başarısız.");
        return;
    }

    const form = document.getElementById("rimForm");
    let wrap = document.getElementById("galleryHiddenInputs");
    if (!wrap) {
        wrap = document.createElement("div");
        wrap.id = "galleryHiddenInputs";
        form.appendChild(wrap);
    }

    // duplicate önle
    const exists = wrap.querySelector(`input[name="gallery_paths[]"][value="${CSS.escape(res.path)}"]`);
    if (!exists) {
        const input = document.createElement("input");
        input.type = "hidden";
        input.name = "gallery_paths[]";
        input.value = res.path;
        wrap.appendChild(input);
    }

    file._uploadedPath = res.path;
});

dz.on("removedfile", function(file) {
    const p = file._uploadedPath;
    if (!p) return;

    // hidden input kaldır
    const wrap = document.getElementById("galleryHiddenInputs");
    if (wrap) {
        wrap.querySelectorAll('input[name="gallery_paths[]"]').forEach(el => {
            if (el.value === p) el.remove();
        });
    }

    // ✅ Eğer bu resim DB’den gelen “existing” ise backend’den de sil (dosya + rim_images kaydı)
    if (file._isExisting) {
        fetch("ajax/delete-rim-gallery.php", {
            method: "POST",
            headers: {"Content-Type":"application/x-www-form-urlencoded; charset=UTF-8"},
            body: "rim_id=<?php echo (int)$rim_id; ?>&path=" + encodeURIComponent(p)
        }).catch(()=>{});
    } else {
        // tmp dosyayı da silmek istiyorsan burada tmp delete endpoint’in varsa çağırabilirsin
        // fetch("ajax/delete-rim-tmp-file.php", { ... })
    }
});
</script>

<script>
let rimFormSaved = false;
<?php if (!empty($success)) { ?>
rimFormSaved = true;
<?php } ?>

window.addEventListener("pagehide", function() {
    if (rimFormSaved) return;
    if (navigator.sendBeacon) {
        navigator.sendBeacon("ajax/cleanup-rim-tmp.php");
    } else {
        fetch("ajax/cleanup-rim-tmp.php", { method:"POST", keepalive:true }).catch(()=>{});
    }
});
</script>

<!-- Vendor -->
<?php include 'layouts/vendor-scripts.php'; ?>

<script src="assets/libs/parsleyjs/parsley.min.js"></script>
<script src="assets/js/pages/form-validation.init.js"></script>
<script src="assets/libs/toastr/build/toastr.min.js"></script>
<script src="assets/libs/tinymce/tinymce.min.js"></script>
<script src="assets/js/pages/form-editor.init.js"></script>
<script src="assets/js/pages/toastr.init.js"></script>

<script>
function showError(message) {
    toastr.options = { "positionClass": "toast-top-right", "timeOut": 5000 };
    toastr["error"](message);
}
function showSuccess(message) {
    toastr.options = { "positionClass": "toast-top-right", "timeOut": 5000 };
    toastr["success"](message);
}

<?php if (!empty($error)) { ?>
showError('<?php echo htmlspecialchars($error); ?>');
<?php } ?>
<?php if (!empty($csrf_err)) { ?>
showError('<?php echo htmlspecialchars($csrf_err); ?>');
<?php } ?>

<?php if (!empty($success)) { ?>
showSuccess('<?php echo htmlspecialchars($success); ?>');
document.querySelector('button[name="kaydet"]').disabled = true;
setTimeout(function(){ window.location.href = "rims.php"; }, 1500);
<?php } ?>
</script>

<script src="assets/libs/sweetalert2/sweetalert2.min.js"></script>
<script src="assets/libs/jquery.repeater/jquery.repeater.min.js"></script>
<script src="assets/js/pages/form-repeater.int.js"></script>
<script src="assets/js/pages/sweet-alerts.init.js"></script>

<script src="assets/libs/select2/js/select2.min.js"></script>
<script src="assets/js/pages/form-advanced.init.js"></script>

<script src="assets/js/app.js"></script>
</body>
</html>
