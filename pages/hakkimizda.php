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

        <div class="block-table block-table_xs">

            <div class="block-table__cell col-md-6 bg-grey">
                <div class="block-table__inner">
                    <section class="b-services">
                        <h2 class="ui-title-block-2">Menekşe Lastik</h2>
                        <div class="ui-subtitle-block">Güvenli Yolculukların Başlangıç Noktası</div>
                        <div class="ui-decor"></div>
                        <div class="b-services__content">
                            <p>Menekşe Lastik olarak, araçlarınızın yol güvenliğini ve performansını artırmak için profesyonel çözümler sunuyoruz. Lastik değişimi ve satışı, rot-balans ayarı, jant düzeltme ve boyama, lastik oteli, akü değişimi ve tamir-onarım gibi geniş hizmet yelpazemizle her zaman yanınızdayız.</p>
                            <p>Müşteri memnuniyetini her şeyin önünde tutan yaklaşımımızla, aracınızın tüm ihtiyaçlarını uzman ekibimizle hızlı, kaliteli ve ekonomik şekilde karşılıyoruz. Kullandığımız teknolojiler ve deneyimimiz sayesinde, aracınızı en iyi şekilde yolculuğa hazırlıyoruz.</p>
                            <p>Güvenilir servis, kaliteli hizmet ve profesyonel yaklaşım arıyorsanız, Menekşe Lastik her zaman yanınızda.</p>

                        </div><a class="btn btn-dark" href="hizmetlerimiz">Hizmetlerimiz</a><a class="btn btn-primary" href="iletisim">Bize Ulaşın</a>
                    </section>
                    <!-- end .b-services-->
                </div>
            </div>

            <div class="block-table__cell col-md-6">
                <div class="block-table__inner">
                    <img class="b-services__img" src="assets/media/general/menekse.png" alt="foto">
                </div>
            </div>
        </div>
        <!-- end .block-table-->




        <div class="section-area" style="padding-bottom: 60px;">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <section class="section-type-1">
                            <h2 class="ui-title-block-2">Sıkça Sorulan Sorular</h2>
                            <div class="ui-subtitle-block">Zamanınızı önemsiyoruz. En sık sorulan soruları bu bölümde topladık. Daha fazla bilgi için bizimle iletişime geçmekten çekinmeyin.</div>
                            <div class="ui-decor"></div>
                            <div class="panel-group accordion accordion-1" id="accordion-1">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"><a class="btn-collapse" data-toggle="collapse" data-parent="#accordion-1" href="#collapse-1"><i class="icon"></i>Lastik değişimi ne kadar sürüyor?</a></h3>
                                    </div>
                                    <div class="panel-collapse collapse in" id="collapse-1">
                                        <div class="panel-body">
                                            <p>Genellikle 20–30 dakika içerisinde lastik değişimi, balans ve rot ayarı yapılır. Ancak yoğun dönemlerde (özellikle kış lastiği geçiş zamanlarında) süre biraz daha uzayabilir.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"><a class="btn-collapse collapsed" data-toggle="collapse" data-parent="#accordion-1" href="#collapse-2"><i class="icon"></i>Hangi markaların lastiklerini satıyorsunuz?</a></h3>
                                    </div>
                                    <div class="panel-collapse collapse" id="collapse-2">
                                        <div class="panel-body">
                                            <p>Bridgestone, Lassa ve Dayton markalarının güncel üretim lastiklerini satıyoruz.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"><a class="btn-collapse collapsed" data-toggle="collapse" data-parent="#accordion-1" href="#collapse-3"><i class="icon"></i>Lastik oteli hizmetiniz var mı?</a></h3>
                                    </div>
                                    <div class="panel-collapse collapse" id="collapse-3">
                                        <div class="panel-body">
                                            <p>Evet. Mevsimlik lastiklerinizi özel koşullarda saklıyor, kullanım ömrünü uzatıyoruz.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"><a class="btn-collapse collapsed" data-toggle="collapse" data-parent="#accordion-1" href="#collapse-4"><i class="icon"></i>Lastiklerime garanti veriyor musunuz?</a></h3>
                                    </div>
                                    <div class="panel-collapse collapse" id="collapse-4">
                                        <div class="panel-body">
                                            <p>Ürünler üretici garantili, ayrıca işçiliğimiz de Menekşe Lastik garantisi altındadır.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"><a class="btn-collapse collapsed" data-toggle="collapse" data-parent="#accordion-1" href="#collapse-5"><i class="icon"></i>Hangi ödeme yöntemlerini kabul ediyorsunuz?</a></h3>
                                    </div>
                                    <div class="panel-collapse collapse" id="collapse-5">
                                        <div class="panel-body">
                                            <p>Nakit, kredi kartı ve banka kartı ile ödeme alıyoruz.</p>
                                        </div>
                                    </div>
                                </div><div class="panel">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"><a class="btn-collapse collapsed" data-toggle="collapse" data-parent="#accordion-1" href="#collapse-6"><i class="icon"></i>Kış lastiği zorunluluğu ne zaman başlıyor?</a></h3>
                                    </div>
                                    <div class="panel-collapse collapse" id="collapse-6">
                                        <div class="panel-body">
                                            <p>Ticari araçlar için her yıl 1 Aralık–1 Nisan arası zorunlu, binek araçlar için güvenlik açısından tavsiye ediyoruz.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end .accordion-->
                        </section>
                    </div>
                 
                </div>
            </div>
        </div>

    </div>