<?php
echo !defined("Secure-MENEKSELASTIK-2025@!") ? die("Hatalı sayfa girişi yaptınız. Lütfen site menüsünü kullanınız.") : null;


// GET ile gelen id
if (!isset($_GET['model_link'])) {
    // Geçersiz istek → ana sayfaya yönlendir veya 404 göster
    header("Location: index.php");
    exit;
}

$model_link = trim($_GET['model_link']);
// Jant bilgisini çek
$sql = "SELECT * FROM rims WHERE model_link = :model_link";
$stmt = $pdo->prepare($sql);
$stmt->execute([':model_link' => $model_link]);
$rims = $stmt->fetch(PDO::FETCH_ASSOC);

$rims_photo = substr($rims['photo'], 3);

//jant görsellerini getir 
$sql_gallery = "SELECT * FROM rim_images WHERE rim_id = :rim_id order by sort_order ASC";
$stmt_gallery = $pdo->prepare($sql_gallery);
$stmt_gallery->execute([':rim_id' => $rims['id']]);
$rims_gallery = $stmt_gallery->fetchAll(PDO::FETCH_ASSOC);

//aynı ölçek jantlardan getir 6 tane
$sqlINC = "SELECT DISTINCT
    r2.id,
    r2.photo,
    r2.brand,
    r2.model,
    r2.model_link
FROM rim_specs rs1
INNER JOIN rim_specs rs2
    ON rs2.diameter = rs1.diameter
   AND rs2.bolt_pattern = rs1.bolt_pattern
INNER JOIN rims r2 ON r2.id = rs2.rim_id
WHERE rs1.rim_id = :rim_id
AND r2.id <> :rim_id
ORDER BY r2.id DESC
LIMIT 6;

";
$stmt = $pdo->prepare($sqlINC);
$stmt->execute([':rim_id' => $rims['id']]);
$relatedRims = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
                            <h1 class="b-title-page bg-primary_a"><?= $rims['model'] ?></h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <main class="l-main-content">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <section class="b-car-details">
                            <div class="b-car-details__header">
                                <h2 class="b-car-details__title"><?= $rims['brand'] ?></h2>
                                <div class="b-car-details__subtitle"><?= $rims['model'] ?></div>
                                <div class="b-car-details__links">
                                    <i class="icon fa fa-share-alt text-primary"></i>
                                    <?php
                                    $url = 'https://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
                                    ?>
                                    Paylaş :

                                    <a href="https://twitter.com/intent/tweet?url=<?php echo $url ?>"><i class="icon fa fa-twitter"></i></a>
                                    <a href="http://www.facebook.com/share.php?u=<?php echo $url ?>"><i class="icon fa fa-facebook"></i></a>
                                    <a href="https://wa.me/?text=<?php echo $url ?>"><i class="icon fa fa-whatsapp"></i></a>
                                </div>

                            </div>
                            <div class="slider-car-details slider-pro" id="slider-car-details">
                                <div class="sp-slides">
                                    <div class="sp-slide">
                                        <img class="sp-image" src="<?= $rims_photo ?>" alt="img" />
                                    </div>
                                    <?php foreach ($rims_gallery as $gallery) :
                                        $gallery_photo = substr($gallery['image_path'], 3);
                                    ?>
                                        <div class="sp-slide">
                                            <img class="sp-image" src="<?= $gallery_photo ?>" alt="img" />
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <div class="sp-thumbnails">
                                    <div class="sp-thumbnail">
                                        <img class="img-responsive" src="<?= $rims_photo ?>" alt="img" />
                                    </div>
                                    <?php foreach ($rims_gallery as $gallery) :
                                        $gallery_photo = substr($gallery['image_path'], 3);
                                    ?>
                                        <div class="sp-thumbnail">
                                            <img class="img-responsive" src="<?= $gallery_photo ?>" alt="img" />
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <!-- end .b-thumb-slider-->
                            <div class="b-car-details__section">
                                <h3 class="b-car-details__section-title ui-title-inner"><?= $rims['model'] ?></h3>
                                <?= $rims['mini_description'] ?>
                            </div>
                            <ul class="b-car-details__nav nav nav-tabs bg-primary">
                                <li class="active"><a href="#specifications" data-toggle="tab">Özellikler</a>
                                </li>
                                <li><a href="#details" data-toggle="tab">Teknik Detaylar</a>
                                </li>

                            </ul>
                            <div class="b-car-details__tabs tab-content">
                                <div class="tab-pane active fade in" id="specifications">
                                    <?= $rims['description'] ?>
                                </div>
                                <div class="tab-pane fade" id="details">
                                    <table id="rim-spec-list" class="table table_primary">
                                        <thead>
                                            <tr>
                                                <th>Malzeme</th>
                                                <th>Yüzey/Renk</th>
                                                <th>Jant Çapı</th>
                                                <th>Bijon Aralığı</th>
                                                <th>Jant Genişliği</th>
                                                <th>Ofset Aralığı (ET)</th>
                                                <th>Göbek Çapı</th>

                                            </tr>
                                        </thead>


                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>



                            </div>
                        </section>
                    </div>

                </div>
            </div>
            <section class="section-default_top">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <h2 class="ui-title-block">Benzer Jantlar</h2>
                            <div class="ui-decor"></div>
                            <div class="related-carousel owl-carousel owl-theme owl-theme_w-btn enable-owl-carousel" data-min768="2" data-min992="3" data-min1200="3" data-margin="30" data-pagination="false" data-navigation="true" data-auto-play="4000" data-stop-on-hover="true">

                                <?php if ($relatedRims): foreach ($relatedRims as $relatedRim):
                                        $related_photo = substr($relatedRim['photo'], 3);
                                       
                                ?>
                                        <div class="b-goods-feat"><a href="jant/<?= $relatedRim['model_link'] ?>">
                                                <div class="b-goods-feat__img">
                                                    <img class="img-responsive" src="<?= $related_photo ?>" alt="foto" /><span class="b-goods-feat__label"></span>
                                                </div>
                                               
                                                <h3 class="b-goods-feat__name"><?= $relatedRim['model'] ?>
                                                   </h3>
                                            </a>

                                        </div>
                                <?php endforeach;
                                endif; ?>

                            </div>

                        </div>
                    </div>
                </div>
            </section>

        </main>

        <script>
            $(document).ready(function() {

                var table = $('#rim-spec-list').DataTable({
                    responsive: true,
                    autoWidth: false,
                    paging: false, // ✅ pagination kapalı
                    info: false, // (istersen kapalı)

                    lengthChange: false,
                    language: {
                        search: "Ara:",
                        zeroRecords: "Kayıt bulunamadı",
                        infoEmpty: "Gösterilecek kayıt yok",
                    },
                    "ajax": {
                        "url": "engine/rim-specs.php?action=get_rim_specs&rim_id=<?= $rims['id'] ?>",
                    },
                    columns: [{
                            data: "material"
                        },
                        {
                            //renk ve yüzey birleştir
                            data: null,
                            render: function(data, type, row) {
                                return row.finish + ' / ' + row.color;
                            }
                        },
                        {
                            data: "diameter"
                        },
                        {
                            data: "bolt_pattern"
                        },
                        {
                            data: "width"
                        },
                        {
                            data: "offset_et"
                        },
                        {
                            data: "center_bore"
                        }
                    ]
                });
            });
        </script>