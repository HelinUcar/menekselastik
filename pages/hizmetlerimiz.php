<?php
echo !defined("Secure-MENEKSELASTIK-2025@!") ? die("Hatalı sayfa girişi yaptınız. Lütfen site menüsünü kullanınız.") : null;
?>
<title><?= $seo_settings_arr['title'] ?></title>
<meta name="description" content="<?= $seo_settings_arr['description'] ?>" />
<meta property="og:title" content="<?= $seo_settings_arr['title'] ?>" />
<meta property="og:description" content="<?= $seo_settings_arr['description'] ?>" />
<style>
    .b-about__img {
        width: 100%;
        max-width: 100%;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    .b-about__img img {
        display: block;
        width: 100%;
        height: auto;
        object-fit: cover;
    }

    .section-advantages-1.working-hours {
        margin-top: -520px;
        background-color: #f4f4f473;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);

    }

    .section-advantages-1.working-hours .b-advantages-1__info {
        font-size: 15px;
        color: black;
    }

    .section-advantages-1.working-hours .b-advantages-1__info a {
        color: black;
        text-decoration: none;
    }

    @media screen and (max-width: 767px) {
        .section-advantages-1.working-hours .b-advantages-1 {
            padding: 40px 5% 25px;
        }
    }
</style>
</head>

<body>
    <?php include("layouts/mobile-menu.php"); ?>
    <div class="l-theme animated-css" data-header="sticky" data-header-top="200" data-canvas="container">
        <?php include("layouts/header.php"); ?>
        <div class="main-slider main-slider-1">
            <div class="slider-pro" id="main-slider" data-slider-width="100%" data-slider-height="700px" data-slider-arrows="true" data-slider-buttons="false">
                <div class="sp-slides">
                    <div class="sp-slide">
                        <img class="sp-image" src="assets/media/banner/lastik.png" alt="slider" />
                    </div>
                    <div class="sp-slide">
                        <img class="sp-image" src="assets/media/banner/lastik-oteli.png" alt="slider" />
                    </div>
                    <div class="sp-slide">
                        <img class="sp-image" src="assets/media/banner/balans.png" alt="slider" />
                    </div>
                    <div class="sp-slide">
                        <img class="sp-image" src="assets/media/banner/sensor.png" alt="slider" />
                    </div>
                    <div class="sp-slide">
                        <img class="sp-image" src="assets/media/banner/aku.png" alt="slider" />
                    </div>
                    <div class="sp-slide">
                        <img class="sp-image" src="assets/media/banner/jant.png" alt="slider" />
                    </div>
                    <div class="sp-slide">
                        <img class="sp-image" src="assets/media/banner/klima.png" alt="slider" />
                    </div>

                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-12 mb-5">
                    <div class="section-advantages-1 working-hours">
                        <section class="b-advantages-1">
                            <h3 class="b-advantages-1__title">Çalışma Saatleri</h3>
                            <div class="b-advantages-1__info">
                                Pazartesi-Cumartesi 08:30-19:00
                                <br>
                                Pazar günleri kapalı!
                            </div>
                        </section>

                        <section class="b-advantages-1">
                            <h3 class="b-advantages-1__title">Adres</h3>
                            <div class="b-advantages-1__info">SEMT, İvedik OSB, 1354. Cadde No:171, 06378 İvedik Osb/Yenimahalle/Ankara</div>
                        </section>

                        <section class="b-advantages-1">
                            <h3 class="b-advantages-1__title">Bizi Arayabilirsiniz</h3>
                            <div class="b-advantages-1__info"><a href="tel:<?= $seo_settings_arr['phone'] ?>"><?= $seo_settings_arr['phone'] ?> </a> <br>
                                <a href="tel:<?= $seo_settings_arr['whatsapp'] ?>"><?= $seo_settings_arr['whatsapp'] ?></a></a>
                            </div>
                        </section>
                    </div>


                </div>

            </div>

        </div>
        <section class="section-default">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="text-center">
                            <h2 class="ui-title-block">Hizmetlerimiz</h2>
                            <div class="ui-subtitle-block">Aracınız için lastik ve bakım hizmetlerini tek çatı altında sunuyoruz.</div>
                            <div class="ui-decor"></div>
                        </div>
                    </div>
                </div>
                <div class="wrap-inl-bl">
                    <div class="row">
                        <?php
                        $get_services = $pdo->prepare("SELECT * FROM services WHERE status = 1 ORDER BY id ASC LIMIT 6");
                        $get_services->execute();
                        $services = $get_services->fetchAll(PDO::FETCH_ASSOC);
                        //çiftleri active yap

                        foreach ($services as $service):
                        ?>
                            <div class="col-md-6">
                                <section class="b-advantages-4">
                                    <img class="b-advantages-4__icon flaticon-screwdriver-and-wrench" src="<?= substr($service['icon_path'], 3) ?>" alt="<?= $service['title'] ?>">
                                    <h3 class="b-advantages-4__title"><?= $service['title'] ?></h3>
                                    <div class="b-advantages-4__info"><?= $service['long_text'] ?></div><span class="ui-decor-2"></span>
                                </section>
                                <!-- end .b-advantages-->
                            </div>
                        <?php

                        endforeach;
                        ?>


                    </div>
                </div>
            </div>
        </section>

    </div>