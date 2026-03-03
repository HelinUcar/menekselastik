<?php
echo !defined("Secure-MENEKSELASTIK-2025@!") ? die("Hatalı sayfa girişi yaptınız. Lütfen site menüsünü kullanınız.") : null;

// GET ile gelen id
if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    // Geçersiz istek → ana sayfaya yönlendir veya 404 göster
    header("Location: index.php");
    exit;
}

$blog_id = (int)$_GET['id'];

// Kampanya bilgisini çek
$sql = "SELECT * FROM blogs WHERE id = :id LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id' => $blog_id]);
$blog = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$blog) {
    // Kampanya bulunamadı
    echo "Kampanya bulunamadı.";
    exit;
}

// Değişkenler
$blog_title     = $blog['title'];
$blog_content   = $blog['content'];
$blog_image     = substr($blog['photo'], 3);
$blog_date      = $blog['date'];
$date_turkce    = turkceTarihParcala($blog_date);
$end_date       = $blog['end_date'];
$end_date_turkce = gecerlilikMetni($end_date);
$blog_link      = $blog['title_link'];

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
                            <h1 class="b-title-page bg-primary_a"><?= $blog_title ?></h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <main class="l-main-content">
                        <article class="b-post b-post-full clearfix">
                            <div class="entry-media">
                                <a class="js-zoom-images" href="<?= $blog_image ?>">
                                    <img class="img-responsive" src="<?= $blog_image ?>" alt="Foto" />
                                </a>
                            </div>
                            <div class="entry-main">
                                <div class="entry-meta">
                                    <div class="entry-meta__group-left">
                                        <span
                                            class="entry-meta__categorie bg-primary"><?= $end_date_turkce ?></span>
                                    </div>
                                    <div class="entry-meta__group-right"><span class="entry-meta__item"><?= $date_turkce['gun'] . ' ' . $date_turkce['ay'] . ' ' . $date_turkce['yil']  ?></span>

                                    </div>
                                </div>
                                <div class="entry-header">
                                    <h2 class="entry-title"><a href="kampanya/<?= $blog_link ?>/<?= $blog_id ?>"><?= $blog_title ?></a></h2>
                                </div>
                                <div class="entry-content">
                                    <?= $blog_content ?>
                                </div>
                            </div>
                            <div class="entry-footer">

                                <div class="entry-footer__group">
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
                        </article>

                    </main>

                </div>
                <div class="col-md-4">
                    <aside class="l-sidebar-3">



                        <section class="widget section-sidebar">
                            <h3 class="widget-title ui-title-inner">Güncel Kampanyalar</h3>
                            <div class="widget-content">

                                <?php
                                // Bugünün tarihi (end_date ile karşılaştırmak için)
                                $today = date('Y-m-d');

                                // Güncel kampanyaları çek (bitiş tarihi bugün veya sonrası)
                                $sql_kampanya_widget = "
            SELECT id, title, title_link, photo, date, end_date
            FROM blogs
            WHERE end_date >= :today
            ORDER BY date DESC
            LIMIT 5
        ";

                                $stmt_kampanya_widget = $pdo->prepare($sql_kampanya_widget);
                                $stmt_kampanya_widget->execute([':today' => $today]);

                                // Kayıt varsa listele
                                if ($stmt_kampanya_widget->rowCount() > 0):
                                    while ($k = $stmt_kampanya_widget->fetch(PDO::FETCH_ASSOC)):
                                        $k_id    = $k['id'];
                                        $k_title = $k['title'];
                                        $k_link  = $k['title_link'];
                                        $k_img   = substr($k['photo'], 3); // senin ana listede yaptığın gibi
                                        $k_date  = $k['date'];

                                        // Türkçe tarih istersen mevcut fonksiyonu kullan
                                        if (function_exists('turkceTarihParcala')) {
                                            $t = turkceTarihParcala($k_date);
                                            $gosterilen_tarih = $t['gun'] . ' ' . $t['ay'] . ' ' . $t['yil'];
                                        } else {
                                            $gosterilen_tarih = date('d.m.Y', strtotime($k_date));
                                        }

                                        // time etiketi için ISO format
                                        $datetime_attr = date('Y-m-d H:i', strtotime($k_date));
                                ?>
                                        <div class="post-widget clearfix">
                                            <div class="post-widget__media">
                                                <a href="kampanya/<?= $k_link ?>/<?= $k_id ?>">
                                                    <img class="img-responsive" src="<?= $k_img ?>" alt="foto" />
                                                </a>
                                            </div>
                                            <div class="post-widget__inner">
                                                <a class="post-widget__title" href="kampanya/<?= $k_link ?>/<?= $k_id ?>">
                                                    <?= htmlspecialchars($k_title) ?>
                                                </a>
                                                <div class="post-widget__date">
                                                    <time class="post-widget__time" datetime="<?= $datetime_attr ?>">
                                                        <?= $gosterilen_tarih ?>
                                                    </time>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    endwhile;
                                else:
                                    ?>
                                    <p>Şu anda güncel kampanya bulunmamaktadır.</p>
                                <?php endif; ?>

                            </div>
                        </section>





                    </aside>

                </div>
            </div>
        </div>
    </div>