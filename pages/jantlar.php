<?php
echo !defined("Secure-MENEKSELASTIK-2025@!") ? die("Hatalı sayfa girişi yaptınız. Lütfen site menüsünü kullanınız.") : null;

// Pagination
$limit = 10;

// Eğer senin routing jantlar/2 ise genelde sayfa numarasını $_GET['page'] yerine
// index.php router’ında alıyorsun. Şimdilik güvenli şekilde GET’ten okuyalım:
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $limit;

// ====== FİLTRELER (GET) ======
$q = trim($_GET['q'] ?? '');
$brand = trim($_GET['brand'] ?? '');
$diameter = isset($_GET['diameter']) && is_numeric($_GET['diameter']) ? (int)$_GET['diameter'] : 0;
$bolt = trim($_GET['bolt'] ?? '');
$width = isset($_GET['width']) && is_numeric($_GET['width']) ? (float)$_GET['width'] : 0;
$et = isset($_GET['et']) && is_numeric($_GET['et']) ? (int)$_GET['et'] : 0;
$color = trim($_GET['color'] ?? '');
$finish = trim($_GET['finish'] ?? '');

// Option listeleri (dropdownları doldurmak için)
$brandOptions = $pdo->query("SELECT DISTINCT brand FROM rims WHERE brand IS NOT NULL AND brand<>'' ORDER BY brand")->fetchAll(PDO::FETCH_COLUMN);
// Çap (inç) - en çok kullanılan aralık
$diameterOptions = range(12, 24, 1); // 12" - 24"
$boltOptions = $pdo->query("SELECT DISTINCT bolt_pattern FROM rim_specs WHERE bolt_pattern<>'' ORDER BY bolt_pattern")->fetchAll(PDO::FETCH_COLUMN);
// Jant genişliği (inç) - en sık kullanılan değerler
$widthOptions = [
    "6.0",
    "6.5",
    "7.0",
    "7.5",
    "8.0",
    "8.5",
    "9.0",
    "9.5",
    "10.0",
    "10.5",
    "11.0",
    "11.5",
    "12.0"
];
$etOptions = $pdo->query("SELECT DISTINCT offset_et FROM rim_specs ORDER BY offset_et")->fetchAll(PDO::FETCH_COLUMN);
$colorOptions = $pdo->query("SELECT DISTINCT color FROM rim_specs WHERE color<>'' ORDER BY color")->fetchAll(PDO::FETCH_COLUMN);
$finishOptions = $pdo->query("SELECT DISTINCT finish FROM rim_specs WHERE finish<>'' ORDER BY finish")->fetchAll(PDO::FETCH_COLUMN);

// WHERE kur
$where = [];
$params = [];

if ($q !== '') {
    $where[] = "(r.brand LIKE :q OR r.model LIKE :q)";
    $params[':q'] = "%{$q}%";
}
if ($brand !== '') {
    $where[] = "r.brand = :brand";
    $params[':brand'] = $brand;
}
if ($diameter > 0) {
    $where[] = "rs.diameter = :diameter";
    $params[':diameter'] = $diameter;
}
if ($bolt !== '') {
    $where[] = "rs.bolt_pattern = :bolt";
    $params[':bolt'] = $bolt;
}
if ($width > 0) {
    $where[] = "rs.width = :width";
    $params[':width'] = $width;
}
if ($et > 0) {
    $where[] = "rs.offset_et = :et";
    $params[':et'] = $et;
}
if ($color !== '') {
    $where[] = "rs.color = :color";
    $params[':color'] = $color;
}
if ($finish !== '') {
    $where[] = "rs.finish = :finish";
    $params[':finish'] = $finish;
}

$whereSql = $where ? ("WHERE " . implode(" AND ", $where)) : "";
$from = "FROM rims r
         LEFT JOIN rim_specs rs ON rs.rim_id = r.id";

// COUNT
$countSql = "SELECT COUNT(DISTINCT r.id) $from $whereSql";
$countStmt = $pdo->prepare($countSql);
foreach ($params as $k => $v) $countStmt->bindValue($k, $v);
$countStmt->execute();
$totalCount = (int)$countStmt->fetchColumn();

$totalPages = (int)ceil($totalCount / $limit);
if ($totalPages < 1) $totalPages = 1;
if ($page > $totalPages) $page = $totalPages;
$offset = ($page - 1) * $limit;

// LIST
$listSql = "SELECT DISTINCT r.* $from $whereSql
            ORDER BY r.id DESC
            LIMIT :limit OFFSET :offset";
$stmt = $pdo->prepare($listSql);
foreach ($params as $k => $v) $stmt->bindValue($k, $v);
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$jantlar = $stmt->fetchAll(PDO::FETCH_ASSOC);

// gösterilen aralık
$start = ($totalCount > 0) ? ($offset + 1) : 0;
$end = ($totalCount > 0) ? min($offset + $limit, $totalCount) : 0;

// pagination URL builder (filtreleri korur)
// Eğer routing’in jantlar/2 değil de jantlar?page=2 ise base’i ona göre değiştirirsin.
function jant_page_url($n)
{
    $qs = $_GET;
    $qs['page'] = (int)$n;
    return "jantlar?" . http_build_query($qs);
}
?>

<title><?= $seo_settings_arr['title'] ?></title>
<meta name="description" content="<?= $seo_settings_arr['description'] ?>" />
<meta property="og:title" content="<?= $seo_settings_arr['title'] ?>" />
<meta property="og:description" content="<?= $seo_settings_arr['description'] ?>" />
</head>

<body>
    <?php include("layouts/mobile-menu.php"); ?>

    <div class="l-theme animated-css" data-header="sticky" data-header-top="200" data-canvas="container">
        <?php include("layouts/header.php"); ?>

        <div class="section-title-page area-bg area-bg_dark area-bg_op_70">
            <div class="area-bg__inner">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <h1 class="b-title-page bg-primary_a">Jantlar</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">

                <div class="col-md-9">
                    <main class="l-main-content">

                        <div class="filter-goods">
                            <div class="filter-goods__info">
                                Gösterilen sonuçlar:
                                <strong><?= $start ?> - <?= $end ?></strong>
                                / Toplam
                                <strong><?= $totalCount ?></strong>
                            </div>
                            <div class="filter-goods__select">
                                <div class="btns-switch">
                                    <i class="btns-switch__item js-view-th icon fa fa-th-large"></i>
                                    <i class="btns-switch__item js-view-list active icon fa fa-th-list"></i>
                                </div>
                            </div>
                        </div>

                        <?php if (!empty($jantlar)): ?>
                            <div class="goods-group-2 list-goods">

                                <?php foreach ($jantlar as $jant): ?>
                                    <?php
                                    $jant_photo = substr($jant['photo'], 3);

                                    // mini_description format düzeltme
                                    $jant_desc_raw = $jant['mini_description'] ?? '';
                                    $jant_desc = html_entity_decode($jant_desc_raw, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                                    $jant_desc = strip_tags($jant_desc);
                                    $jant_desc = trim(preg_replace('/\s+/', ' ', $jant_desc));

                                    $limitDesc = 60;
                                    $short = mb_substr($jant_desc, 0, $limitDesc, 'UTF-8');
                                    $rest  = mb_substr($jant_desc, $limitDesc, null, 'UTF-8');
                                    $infoId = "info-" . (int)$jant['id'];
                                    

                                    // örnek: jantın bazı özelliklerini listelemek istersen
                                    $specStmt = $pdo->prepare("SELECT diameter, color FROM rim_specs WHERE rim_id=? GROUP BY diameter, color");
                                    $specStmt->execute([(int)$jant['id']]);
                                    $specs = $specStmt->fetchAll(PDO::FETCH_ASSOC);
                                    ?>

                                    <section class="b-goods-1">
                                        <div class="row">
                                            <div class="b-goods-1__img">
                                                <a class="js-zoom-images" href="<?= $jant_photo ?>">
                                                    <img class="img-responsive" src="<?= $jant_photo ?>" alt="foto" />
                                                </a>
                                            </div>
                                            <div class="b-goods-1__inner">
                                                <div class="b-goods-1__header">
                                                    <h2 class="b-goods-1__name">
                                                        <a href="jant/<?= $jant['model_link'] ?>"><?= $jant['model'] ?></a>
                                                    </h2>
                                                </div>

                                                <div class="b-goods-1__info">
                                                    <?php echo htmlspecialchars($short, ENT_QUOTES, 'UTF-8'); ?>

                                                    <?php if (mb_strlen($jant_desc, 'UTF-8') > $limitDesc): ?>
                                                        <span class="b-goods-1__info-more collapse" id="<?php echo $infoId; ?>">
                                                            <?php echo htmlspecialchars($rest, ENT_QUOTES, 'UTF-8'); ?>
                                                        </span>
                                                        <span class="b-goods-1__info-link"
                                                            data-toggle="collapse"
                                                            data-target="#<?php echo $infoId; ?>"></span>
                                                    <?php endif; ?>
                                                </div>

                                                <span class="b-goods-1__price_th text-primary visible-th"><?= $jant['brand'] ?></span>

                                                <?php if (!empty($specs)): ?>
                                                    <div class="b-goods-1__section hidden-th">
                                                        <h3 class="b-goods-1__title" data-toggle="collapse" data-target="#spec-<?= (int)$jant['id'] ?>">
                                                            Mevcut Çap / Renk
                                                        </h3>
                                                        <div class="collapse in" id="spec-<?= (int)$jant['id'] ?>">
                                                            <ul class="b-goods-1__list list list-mark-5 list_mark-prim">
                                                                <?php foreach ($specs as $s): ?>
                                                                    <li class="b-goods-1__list-item">
                                                                        <?= htmlspecialchars($s['diameter']) ?>" / <?= htmlspecialchars($s['color']) ?>
                                                                    </li>
                                                                <?php endforeach; ?>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>


                                            </div>
                                        </div>
                                    </section>

                                <?php endforeach; ?>

                            </div>
                        <?php else: ?>
                            <div class="alert alert-warning">Sonuç bulunamadı.</div>
                        <?php endif; ?>


                        <?php if ($totalPages > 1): ?>
                            <ul class="pagination text-center">

                                <li class="<?= ($page <= 1) ? 'disabled' : '' ?>">
                                    <a href="<?= ($page > 1) ? jant_page_url(1) : '#' ?>">
                                        <i class="icon fa fa-angle-double-left"></i>
                                    </a>
                                </li>

                                <?php
                                $range = 2;
                                $startPage = max(1, $page - $range);
                                $endPage   = min($totalPages, $page + $range);
                                for ($i = $startPage; $i <= $endPage; $i++):
                                ?>
                                    <li class="<?= ($i == $page) ? 'active' : '' ?>">
                                        <a href="<?= jant_page_url($i) ?>"><?= $i ?></a>
                                    </li>
                                <?php endfor; ?>

                                <li class="<?= ($page >= $totalPages) ? 'disabled' : '' ?>">
                                    <a href="<?= ($page < $totalPages) ? jant_page_url($totalPages) : '#' ?>">
                                        <i class="icon fa fa-angle-double-right"></i>
                                    </a>
                                </li>

                            </ul>
                        <?php endif; ?>

                    </main>
                </div>

                <div class="col-md-3">
                    <aside class="l-sidebar">

                        <!-- Tasarım aynı: b-filter-2 -->
                        <form class="b-filter-2 bg-grey" method="get" action="jantlar">
                            <h3 class="b-filter-2__title">Gelişmiş Arama</h3>

                            <div class="b-filter-2__inner">

                                <div class="b-filter-2__group">
                                    <div class="b-filter-2__group-title">Arama</div>
                                    <input class="form-control" type="text" name="q"
                                        value="<?= htmlspecialchars($q) ?>" placeholder="Marka / Model">
                                </div>

                                <div class="b-filter-2__group">
                                    <div class="b-filter-2__group-title">Marka</div>
                                    <select class="selectpicker" name="brand" data-width="100%">
                                        <option value="">Hepsi</option>
                                        <?php foreach ($brandOptions as $b): ?>
                                            <option value="<?= htmlspecialchars($b) ?>" <?= ($brand === $b) ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($b) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="b-filter-2__group">
                                    <div class="b-filter-2__group-title">Çap</div>
                                    <select class="selectpicker" name="diameter" data-width="100%">
                                        <option value="">Hepsi</option>
                                        <?php foreach ($diameterOptions as $d): ?>
                                            <option value="<?= (int)$d ?>" <?= ($diameter == (int)$d) ? 'selected' : '' ?>>
                                                <?= (int)$d ?>"
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="b-filter-2__group">
                                    <div class="b-filter-2__group-title">Bijon</div>
                                    <select class="selectpicker" name="bolt" data-width="100%">
                                        <option value="">Hepsi</option>
                                        <?php foreach ($boltOptions as $bp): ?>
                                            <option value="<?= htmlspecialchars($bp) ?>" <?= ($bolt === $bp) ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($bp) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="b-filter-2__group">
                                    <div class="b-filter-2__group-title">Genişlik</div>
                                    <select class="selectpicker" name="width" data-width="100%">
                                        <option value="">Hepsi</option>
                                        <?php foreach ($widthOptions as $w): ?>
                                            <option value="<?= htmlspecialchars($w) ?>" <?= ((string)$width === (string)$w) ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($w) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="b-filter-2__group">
                                    <div class="b-filter-2__group-title">ET</div>
                                    <select class="selectpicker" name="et" data-width="100%">
                                        <option value="">Hepsi</option>
                                        <?php foreach ($etOptions as $e): ?>
                                            <option value="<?= (int)$e ?>" <?= ($et == (int)$e) ? 'selected' : '' ?>>
                                                <?= (int)$e ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="b-filter-2__group">
                                    <div class="b-filter-2__group-title">Renk</div>
                                    <select class="selectpicker" name="color" data-width="100%">
                                        <option value="">Hepsi</option>
                                        <?php foreach ($colorOptions as $c): ?>
                                            <option value="<?= htmlspecialchars($c) ?>" <?= ($color === $c) ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($c) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="b-filter-2__group">
                                    <div class="b-filter-2__group-title">Yüzey</div>
                                    <select class="selectpicker" name="finish" data-width="100%">
                                        <option value="">Hepsi</option>
                                        <?php foreach ($finishOptions as $f): ?>
                                            <option value="<?= htmlspecialchars($f) ?>" <?= ($finish === $f) ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($f) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="b-filter-2__group">
                                    <button type="submit" class="btn btn-primary btn-block">Ara</button>
                                    <a href="jantlar" class="btn btn-default btn-block" style="margin-top:10px;">Temizle</a>
                                </div>

                            </div>
                        </form>

                    </aside>
                </div>

            </div>
        </div>