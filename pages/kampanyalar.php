<?php
echo !defined("Secure-MENEKSELASTIK-2025@!") ? die("Hatalı sayfa girişi yaptınız. Lütfen site menüsünü kullanınız.") : null;


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
                            <h1 class="b-title-page bg-primary_a">Kampanyalar</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <main class="l-main-content">
                        <div class="posts-group-2">
                            <?php
                            // Sayfa başına gösterilecek kayıt sayısı
                            $limit = 5;

                            // Aktif sayfa (GET ile geliyor)
                            $page = isset($_GET['page']) && ctype_digit($_GET['page']) ? (int)$_GET['page'] : 1;
                            if ($page < 1) $page = 1;

                            // Toplam blog sayısını al
                            $stmt = $pdo->query("SELECT COUNT(*) FROM blogs WHERE status = 1");
                            $total_blogs = (int)$stmt->fetchColumn();

                            // Toplam sayfa sayısı
                            $total_pages = (int)ceil($total_blogs / $limit);

                            // OFFSET hesabı
                            $offset = ($page - 1) * $limit;

                            // Blogları getir (sadece o sayfadakiler)
                            $blog_sql = "SELECT * FROM blogs WHERE status = 1 ORDER BY id DESC LIMIT :limit OFFSET :offset";
                            $get_blogs = $pdo->prepare($blog_sql);
                            $get_blogs->bindValue(':limit', $limit, PDO::PARAM_INT);
                            $get_blogs->bindValue(':offset', $offset, PDO::PARAM_INT);
                            $get_blogs->execute();

                            while ($blog = $get_blogs->fetch(PDO::FETCH_ASSOC)) {
                                $blog_id = $blog['id'];
                                $blog_title = $blog['title'];
                                $blog_content = $blog['content'];
                                $blog_image = substr($blog['photo'], 3);
                                $blog_date = $blog['date'];
                                $date_turkce = turkceTarihParcala($blog_date);
                                $end_date = $blog['end_date'];
                                $end_date_turkce = gecerlilikMetni($end_date);
                                $blog_link = $blog['title_link'];

                            ?>
                                <section class="b-post b-post-full clearfix">
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
                                            <p><?= kisalt($blog_content, 25) ?></p>
                                        </div>
                                        <div class="entry-footer"><a class="btn btn-default" href="kampanya/<?= $blog_link ?>/<?= $blog_id ?>">Daha Fazla</a>
                                        </div>
                                    </div>
                                </section>

                            <?php } ?>

                        </div>
                        <ul class="pagination">
                            <?php if ($page > 1): ?>
                                <li>
                                    <a href="kampanyalar/1">
                                        <i class="icon fa fa-angle-double-left"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="kampanyalar/<?= $page - 1 ?>">
                                        <i class="icon fa fa-angle-left"></i>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                <li class="<?= ($i == $page) ? 'active' : '' ?>">
                                    <a href="kampanyalar/<?= $i ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>

                            <?php if ($page < $total_pages): ?>
                                <li>
                                    <a href="kampanyalar/<?= $page + 1 ?>">
                                        <i class="icon fa fa-angle-right"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="kampanyalar/<?= $total_pages ?>">
                                        <i class="icon fa fa-angle-double-right"></i>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>

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
                                $sql_kampanya_widget = "SELECT id, title, title_link, photo, date, end_date
            FROM blogs
            WHERE end_date >= :today AND status = 1
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