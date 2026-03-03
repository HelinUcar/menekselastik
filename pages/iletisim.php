<?php
echo !defined("Secure-MENEKSELASTIK-2025@!") ? die("Hatalı sayfa girişi yaptınız. Lütfen site menüsünü kullanınız.") : null;
?>
<title><?= $seo_settings_arr['title'] ?></title>
<meta name="description" content="<?= $seo_settings_arr['description'] ?>" />
<meta property="og:title" content="<?= $seo_settings_arr['title'] ?>" />
<meta property="og:description" content="<?= $seo_settings_arr['description'] ?>" />

<style>
    .map-responsive {
        position: relative;
        width: 100%;
        padding-top: 75%;
        /* kareye yakın (4:3). Tam kare istersen 100% yap */
        overflow: hidden;
    }

    .map-responsive iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100% !important;
        height: 100% !important;
        border: 0;
    }
</style>

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
                            <h1 class="b-title-page bg-primary_a">İletişim</h1>
                        </div>
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
                        <div class="map-responsive">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3056.5876998567774!2d32.7650029!3d39.9953183!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14d34bd29581fea7%3A0x42fda94fb9bbf3e!2zTUVORUvFnkUgTEFTVMSwSyBPVE9NLsSwTsWeLlRVWi5OQUsuIFBFVFJPTCBTQU4uVkUgVMSwQy5MVEQuxZ5UxLAu!5e0!3m2!1str!2str!4v1768540274898!5m2!1str!2str" width="600" height="600" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>



                </div>


            </div>

        </div>







    </div>