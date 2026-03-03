<?php
echo !defined("Secure-MENEKSELASTIK-2025@!") ? die("Hatalı sayfa girişi yaptınız. Lütfen site menüsünü kullanınız.") : null;


$get_home_page = $pdo->prepare("SELECT * FROM home_page WHERE id=?");
$get_home_page->execute([1]);
$home_page = $get_home_page->fetch(PDO::FETCH_ASSOC);

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

    .tyre-calc {
        padding: 25px 10px;
    }

    .tyre-calc__intro {
        padding: 10px 15px 20px;
        font-size: 14px;
        text-align: center;
    }



    .tyre-calc__header {
        padding: 10px 15px;
        font-size: 13px;
        font-weight: 600;
    }

    .tyre-calc__header-label {
        font-size: 0;
    }

    .tyre-calc__row {
        padding: 8px 15px;
        font-size: 13px;
    }

    .tyre-calc__row+.tyre-calc__row {
        border-top: none;
    }

    .tyre-calc__label {
        font-weight: 600;
        display: inline-block;
        margin-bottom: 5px;
    }

    /* Kolon içi küçük başlıklar (Genişlik/Yükseklik/Çap) */
    .tyre-calc__field-label {
        display: none;
        /* desktop'ta gizli, tablet+mobilde açacağız */
        font-size: 12px;
        font-weight: 600;
        margin-bottom: 4px;
    }

    /* Selectler */
    .tyre-calc .bootstrap-select>.dropdown-toggle,
    .tyre-calc select.selectpicker {
        border-radius: 0;
    }

    /* Butonlar */
    .tyre-calc__btns {
        text-align: center;
        margin: 18px 0 10px;
    }

    .tyre-calc__btns .btn {
        min-width: 130px;
        margin: 0 5px;
    }

    /* Sonuç kutusu */
    .tyre-calc__results {
        margin-top: 25px;
        padding: 20px 15px;
        font-size: 13px;
    }

    .tyre-calc__results h6 {
        font-weight: 600;
        margin-bottom: 15px;
    }

    .tyre-calc__results-row {
        margin-bottom: 10px;
        align-items: center;
        padding: 8px 15px;
    }

    .tyre-calc__results .form-control {
        height: 30px;
        padding: 4px 8px;
        font-size: 12px;
    }

    .tyre-calc__results-label {
        font-size: 12px;
        margin-top: 5px;
    }

    /* Tablet + mobil */
    @media screen and (max-width: 991.98px) {

        .tyre-calc__header {
            display: none;
            /* üst tek satır başlığı gizle */
        }

        .tyre-calc__field-label {
            display: block;
            /* başlıkları select üstünde göster */
        }

        .tyre-calc__row {
            margin-bottom: 10px;
            border-radius: 4px;
        }

        .tyre-calc__row .col-4,
        .tyre-calc__row .col-6 {
            margin-bottom: 8px;
        }

        .tyre-calc__results-row {
            margin-bottom: 15px;
        }
    }
</style>

</head>


<body>

    <?php include("layouts/mobile-menu.php"); ?>
    <div class="l-theme animated-css" data-header="sticky" data-header-top="200" data-canvas="container">

        <?php include("layouts/header.php"); ?>
        <!-- end .header-->
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
        <!-- end .main-slider-->


        <section class="b-about section-default">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7">
                        <div class="b-about__inner">
                            <h2 class="ui-title-block">Menekşe Lastik Hakkında</h2>
                            <div class="ui-subtitle-block">Yol güvenliğiniz bizim işimiz.</div>
                            <div class="ui-decor"></div>
                            <div class="b-about-main">
                                <div class="b-about-main__title"> <?= $home_page['about_title'] ?></div>
                                <div class="b-about-main__subtitle"></div>
                                <?= $home_page['about_content'] ?>
                                <div class="b-about-main__btns"><a class="btn btn-dark" href="hizmetlerimiz">Hizmetlerimiz</a><a class="btn btn-primary" href="hakkimizda">Daha Fazla</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="b-about__img">
                            <img src="assets/media/general/menekse.png"
                                alt="Menekşe Lastik Bayisi"
                                class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>

        </section>

        <div class="container">
            <div class="row" style="margin-bottom: 70px;">
                <div class="col-xs-12">
                    <div class="text-center">
                        <h2 class="ui-title-block">Hizmetlerimiz</h2>
                        <div class="ui-subtitle-block">Aracınız İçin Profesyonel Çözümler</div>
                        <div class="ui-decor"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mb-5">
                    <div class="section-advantages-1">
                        <?php
                        $get_services = $pdo->prepare("SELECT * FROM services WHERE status = 1 ORDER BY id ASC LIMIT 6");
                        $get_services->execute();
                        $services = $get_services->fetchAll(PDO::FETCH_ASSOC);
                        //çiftleri active yap
                        $count = 1;
                        foreach ($services as $service):
                            $count++;
                            $active_class = ($count % 2 == 0) ? 'active' : '';
                        ?>
                            <section class="b-advantages-1 <?= $active_class ?>">
                                <img class="b-advantages-1__icon" src="<?= substr($service['icon_path'], 3) ?>" alt="<?= $service['title'] ?>" />
                                <h3 class="b-advantages-1__title"><?= $service['title'] ?></h3>
                                <div class="b-advantages-1__info"><?= $service['short_text'] ?></div><span class="ui-decor-2"></span>
                            </section>
                        <?php endforeach;
                        ?>

                    </div>


                </div>

            </div>

        </div>

        <section class="section-filter">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="text-center">
                            <h2 class="ui-title-block">Lastik Ebatını Hesapla</h2>
                            <div class="ui-subtitle-block">Lütfen orjinal oto lastik ölçünüzü ve karşılaştırmak istediğiniz lastik ölçüsünü aşağıdan seçiniz</div>
                            <div class="ui-decor"></div>
                        </div>
                    </div>
                </div>
            </div>
            <form class="b-filter">
                <div class="b-filter__inner bg-grey">
                    <div class="container tyre-calc">


                        <!-- TABLO BAŞLIĞI (sadece desktop) -->
                        <div class="row tyre-calc__header align-items-center">
                            <div class="col-md-3 col-12 tyre-calc__header-label">
                                &nbsp;
                            </div>
                            <div class="col-md-3 col-4 text-center">
                                <span>Genişlik</span>
                            </div>
                            <div class="col-md-3 col-4 text-center">
                                <span>Yükseklik</span>
                            </div>
                            <div class="col-md-3 col-4 text-center">
                                <span>Çap</span>
                            </div>
                        </div>

                        <!-- ORİJİNAL LASTİK -->
                        <div class="row tyre-calc__row align-items-center">
                            <div class="col-md-3 col-12">
                                <span class="tyre-calc__label">Orijinal Lastik</span>
                            </div>

                            <div class="col-md-3 col-4">
                                <span class="tyre-calc__field-label">Genişlik</span>
                                <select id="origWidth" class="selectpicker" data-width="100%">
                                    <option value="145">145</option>
                                    <option value="155">155</option>
                                    <option value="165">165</option>
                                    <option value="175">175</option>
                                    <option value="185">185</option>
                                    <option value="195" selected>195</option>
                                    <option value="205">205</option>
                                    <option value="215">215</option>
                                    <option value="225">225</option>
                                    <option value="235">235</option>
                                    <option value="245">245</option>
                                    <option value="255">255</option>
                                    <option value="265">265</option>
                                    <option value="275">275</option>
                                    <option value="285">285</option>
                                    <option value="295">295</option>
                                    <option value="305">305</option>
                                    <option value="315">315</option>
                                    <option value="325">325</option>
                                    <option value="335">335</option>
                                </select>
                            </div>

                            <div class="col-md-3 col-4">
                                <span class="tyre-calc__field-label">Yükseklik</span>
                                <select id="origHeight" class="selectpicker" data-width="100%">
                                    <option value="30">30</option>
                                    <option value="35">35</option>
                                    <option value="40">40</option>
                                    <option value="45">45</option>
                                    <option value="50">50</option>
                                    <option value="55">55</option>
                                    <option value="60">60</option>
                                    <option value="65" selected>65</option>
                                    <option value="70">70</option>
                                    <option value="75">75</option>
                                    <option value="80">80</option>
                                    <option value="85">85</option>
                                </select>
                            </div>

                            <div class="col-md-3 col-4">
                                <span class="tyre-calc__field-label">Çap</span>
                                <select id="origRim" class="selectpicker" data-width="100%">
                                    <option value="12">12</option>
                                    <option value="13">13</option>
                                    <option value="14">14</option>
                                    <option value="15" selected>15</option>
                                    <option value="16">16</option>
                                    <option value="17">17</option>
                                    <option value="18">18</option>
                                    <option value="19">19</option>
                                    <option value="20">20</option>
                                </select>
                            </div>
                        </div>

                        <!-- KARŞILAŞTIRMA LASTİĞİ -->
                        <div class="row tyre-calc__row align-items-center">
                            <div class="col-md-3 col-12">
                                <span class="tyre-calc__label">Karşılaştırmak İstediğiniz Lastik Ölçüsü</span>
                            </div>

                            <div class="col-md-3 col-4">
                                <span class="tyre-calc__field-label">Genişlik</span>
                                <select id="newWidth" class="selectpicker" data-width="100%">
                                    <option value="145">145</option>
                                    <option value="155">155</option>
                                    <option value="165">165</option>
                                    <option value="175">175</option>
                                    <option value="185">185</option>
                                    <option value="195">195</option>
                                    <option value="205" selected>205</option>
                                    <option value="215">215</option>
                                    <option value="225">225</option>
                                    <option value="235">235</option>
                                    <option value="245">245</option>
                                    <option value="255">255</option>
                                    <option value="265">265</option>
                                    <option value="275">275</option>
                                    <option value="285">285</option>
                                    <option value="295">295</option>
                                    <option value="305">305</option>
                                    <option value="315">315</option>
                                    <option value="325">325</option>
                                    <option value="335">335</option>
                                </select>
                            </div>

                            <div class="col-md-3 col-4">
                                <span class="tyre-calc__field-label">Yükseklik</span>
                                <select id="newHeight" class="selectpicker" data-width="100%">
                                    <option value="30">30</option>
                                    <option value="35">35</option>
                                    <option value="40">40</option>
                                    <option value="45">45</option>
                                    <option value="50">50</option>
                                    <option value="55" selected>55</option>
                                    <option value="60">60</option>
                                    <option value="65">65</option>
                                    <option value="70">70</option>
                                    <option value="75">75</option>
                                    <option value="80">80</option>
                                    <option value="85">85</option>
                                </select>
                            </div>

                            <div class="col-md-3 col-4">
                                <span class="tyre-calc__field-label">Çap</span>
                                <select id="newRim" class="selectpicker" data-width="100%">
                                    <option value="12">12</option>
                                    <option value="13">13</option>
                                    <option value="14">14</option>
                                    <option value="15">15</option>
                                    <option value="16" selected>16</option>
                                    <option value="17">17</option>
                                    <option value="18">18</option>
                                    <option value="19">19</option>
                                    <option value="20">20</option>
                                </select>
                            </div>
                        </div>

                        <!-- BUTONLAR -->
                        <div class="row">
                            <div class="col-12 tyre-calc__btns">
                                <button id="tyreCalcBtn" type="button" class="btn btn-lg btn-primary">Hesapla</button>
                                <button id="tyreCalcReset" type="button" class="btn btn-lg btn-dark">Sıfırla</button>
                            </div>
                        </div>

                        <!-- SONUÇLAR -->
                        <div class="row">
                            <div class="col-12">
                                <div class="tyre-calc__results">
                                    <h6>Hesaplanan Değerler</h6>

                                    <div class="row tyre-calc__results-row">
                                        <div class="col-md-4 col-12">
                                            Orijinal Lastik Çapı (mm)
                                        </div>
                                        <div class="col-md-4 col-6">
                                            <input id="origDiaMm" class="form-control" type="text" readonly>
                                        </div>
                                        <div class="col-md-2 col-6 tyre-calc__results-label">
                                            Inch Hesabı
                                        </div>
                                        <div class="col-md-2 col-6">
                                            <input id="origDiaInch" class="form-control" type="text" readonly>
                                        </div>
                                    </div>

                                    <div class="row tyre-calc__results-row">
                                        <div class="col-md-4 col-12">
                                            İstenen Lastik Çapı (mm)
                                        </div>
                                        <div class="col-md-4 col-6">
                                            <input id="newDiaMm" class="form-control" type="text" readonly>
                                        </div>
                                        <div class="col-md-2 col-6 tyre-calc__results-label">
                                            Inch Hesabı
                                        </div>
                                        <div class="col-md-2 col-6">
                                            <input id="newDiaInch" class="form-control" type="text" readonly>
                                        </div>
                                    </div>

                                    <div class="row tyre-calc__results-row">
                                        <div class="col-md-4 col-12">
                                            Aradaki Fark (mm)
                                        </div>
                                        <div class="col-md-4 col-6">
                                            <input id="diffMm" class="form-control" type="text" readonly>
                                        </div>
                                        <div class="col-md-2 col-6 tyre-calc__results-label">
                                            Inch Hesabı
                                        </div>
                                        <div class="col-md-2 col-6">
                                            <input id="diffInch" class="form-control" type="text" readonly>
                                        </div>
                                    </div>

                                    <div class="row tyre-calc__results-row">
                                        <div class="col-md-4 col-12">
                                            Değişim Yüzdesi:
                                        </div>
                                        <div class="col-md-2 col-6">
                                            <input id="diffPct" class="form-control" type="text" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </form>

            <script>
                // mm cinsinden lastik çapı hesapla
                function tyreDiameter(width, aspect, rimInch) {
                    var sidewall = width * (aspect / 100); // mm
                    var rim = rimInch * 25.4; // inch → mm
                    return 2 * sidewall + rim; // toplam çap (mm)
                }

                document.addEventListener('DOMContentLoaded', function() {
                    var btn = document.getElementById('tyreCalcBtn');
                    var resetBtn = document.getElementById('tyreCalcReset');

                    if (!btn || !resetBtn) return;

                    btn.addEventListener('click', function() {
                        var ow = parseFloat(document.getElementById('origWidth').value);
                        var oh = parseFloat(document.getElementById('origHeight').value);
                        var orim = parseFloat(document.getElementById('origRim').value);

                        var nw = parseFloat(document.getElementById('newWidth').value);
                        var nh = parseFloat(document.getElementById('newHeight').value);
                        var nrim = parseFloat(document.getElementById('newRim').value);

                        if (isNaN(ow) || isNaN(oh) || isNaN(orim) || isNaN(nw) || isNaN(nh) || isNaN(nrim)) {
                            alert('Lütfen tüm ölçüleri seçiniz.');
                            return;
                        }

                        var dOrig = tyreDiameter(ow, oh, orim);
                        var dNew = tyreDiameter(nw, nh, nrim);

                        var diffMm = dNew - dOrig;
                        var diffInch = diffMm / 25.4;
                        var diffPct = (diffMm / dOrig) * 100;

                        // Orijinal
                        document.getElementById('origDiaMm').value = dOrig.toFixed(1);
                        document.getElementById('origDiaInch').value = (dOrig / 25.4).toFixed(2);

                        // Yeni
                        document.getElementById('newDiaMm').value = dNew.toFixed(1);
                        document.getElementById('newDiaInch').value = (dNew / 25.4).toFixed(2);

                        // Fark
                        document.getElementById('diffMm').value = diffMm.toFixed(1);
                        document.getElementById('diffInch').value = diffInch.toFixed(2);
                        document.getElementById('diffPct').value = diffPct.toFixed(2) + ' %';
                    });

                    resetBtn.addEventListener('click', function() {
                        // Selectleri ilk seçeneğe al
                        ['origWidth', 'origHeight', 'origRim', 'newWidth', 'newHeight', 'newRim'].forEach(function(id) {
                            var el = document.getElementById(id);
                            if (el) {
                                el.selectedIndex = 0;
                            }
                        });

                        // bootstrap-select kullanıyorsan, görünümü yenile
                        if (typeof $ !== 'undefined' && $.fn.selectpicker) {
                            $('.selectpicker').selectpicker('refresh');
                        }

                        // Sonuçları temizle
                        ['origDiaMm', 'origDiaInch', 'newDiaMm', 'newDiaInch', 'diffMm', 'diffInch', 'diffPct'].forEach(function(id) {
                            var el = document.getElementById(id);
                            if (el) el.value = '';
                        });
                    });
                });
            </script>
        </section>





        <!-- 
        <section class="section-default" style="margin-top:100px;">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="text-center">
                            <h2 class="ui-title-block">Lastik İlanları</h2>
                            <div class="ui-subtitle-block">Lastik fırsatlarını Menekşe Lastik ile yakalayın</div>
                            <div class="ui-decor"></div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            $lastikIlanlari = [];
            $tire_sql = "SELECT * FROM tires ORDER BY id DESC LIMIT 10";
            $get_tires = $pdo->query($tire_sql);
            if ($get_tires->rowCount() > 0) {
                $lastikIlanlari = $get_tires->fetchAll(PDO::FETCH_ASSOC);
            }
            if (!empty($lastikIlanlari)): ?>
                <div class="featured-carousel owl-carousel owl-theme owl-theme_w-btn enable-owl-carousel"
                    data-min768="2"
                    data-min992="3"
                    data-min1200="5"
                    data-margin="30"
                    data-pagination="false"
                    data-navigation="true"
                    data-auto-play="4000"
                    data-stop-on-hover="true">

                    <?php foreach ($lastikIlanlari as $ilan): ?>
                        <?php
                        // Lastik bilgilerini al
                        $tire_photo = substr($ilan['photo'], 3); // Fotoğraf yolunu düzenle

                        ?>
                        <div class="b-goods-feat">
                            <div class="b-goods-feat__img">
                                <img class="img-responsive" src="<?= $tire_photo ?>" alt="foto" /><span class="b-goods-feat__label">$45,000<span class="b-goods-feat__label_msrp">MSRP $27,000</span></span>
                            </div>
                            <ul class="b-goods-feat__desc list-unstyled">
                                <li class="b-goods-feat__desc-item">35,000 mi</li>
                                <li class="b-goods-feat__desc-item">Model: 2017</li>
                                <li class="b-goods-feat__desc-item">Auto</li>
                                <li class="b-goods-feat__desc-item">320 hp</li>
                            </ul>
                            <h3 class="b-goods-feat__name"><a href="car-details.html">Lexus GX 490i Hybird</a></h3>
                            <div class="b-goods-feat__info">Duis aute irure reprehender voluptate velit ese acium fugiat nulla pariatur excepteur ipsum.</div>
                        </div>
                    <?php endforeach; ?>

                </div>
            <?php endif; ?>
       
        </section> -->



        <div class="info-group block-table block-table_md">
            <div class="info-group__section col-md-6">
                <section class="b-info b-info_mod-a area-bg area-bg_op_80 area-bg_prim parallax" style="background-image: url(assets/media/backgrounds/wheel-bg.webp)">
                    <div class="area-bg__inner">
                        <h2 class="b-info__title">Lastik <strong class="b-info__title_lg">Satın Almak mı İstiyorsunuz?</strong> </h2>
                        <div class="b-info__desc">Menekşe Lastik’te Bridgestone, Lassa ve Dayton markalarında geniş stok, uygun fiyat ve profesyonel montaj ile güvenli sürüş sizi bekliyor.</div><a class="btn btn-white" href="lastikler">Lastiklerimizi İncele</a>
                    </div>
                </section>
            </div>
            <div class="info-group__section col-md-6">
                <section class="b-info b-info_mod-b area-bg area-bg_op_80 area-bg_dark-2 parallax" style="background-image: url(assets/media/backgrounds/wheel-bg.webp)">
                    <div class="area-bg__inner">
                        <h2 class="b-info__title">Lastiğinizi <strong class="b-info__title_lg">Satmak mı İstiyorsunuz?</strong></h2>
                        <div class="b-info__desc">Kullanmadığınız veya sezon sonu lastiklerinizi bize getirin; değerinde alım yapalım. Hem bütçenize katkı sağlayın hem de geri dönüşüme destek olun.</div><a class="btn btn-white" href="iletisim">Bize Ulaşın</a>
                    </div>
                </section>
            </div>
        </div>

        <?php
        // 1) Filtre için tüm çapları çek
        $diameters = $pdo->query("
    SELECT DISTINCT diameter
    FROM rim_specs
    ORDER BY diameter ASC
")->fetchAll(PDO::FETCH_COLUMN);

        // 2) Jantları + sahip oldukları çaplar
        $rims = $pdo->query("
    SELECT r.id, r.photo, r.brand, r.model, r.model_link,
           GROUP_CONCAT(DISTINCT rs.diameter ORDER BY rs.diameter SEPARATOR ',') AS diameters
    FROM rims r
    LEFT JOIN rim_specs rs ON rs.rim_id = r.id
    GROUP BY r.id
    ORDER BY r.id DESC
")->fetchAll(PDO::FETCH_ASSOC);
        ?>

        <section class="section-isotope">
            <div class="section-isotope__header">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="text-center">
                                <h2 class="ui-title-block">Jant Galerisi</h2>
                                <div class="ui-subtitle-block"></div>
                                <div class="ui-decor"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="b-isotope">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">

                            <ul class="b-isotope-filter list-inline">
                                <li class="current"><a href="#" data-filter="*">Tümü</a></li>
                                <?php foreach ($diameters as $d): ?>
                                    <li><a href="#" data-filter=".d<?= (int)$d ?>"><?= (int)$d ?> Jant</a></li>
                                <?php endforeach; ?>
                            </ul>

                        </div>
                    </div>
                </div>

                <ul class="b-isotope-grid grid list-unstyled">
                    <li class="grid-sizer"></li>

                    <?php foreach ($rims as $rim): ?>
                        <?php
                        $photo = $rim['photo'] ?? '';
                        $photo_show = $photo ? substr($photo, 3) : '';
                        $title = trim(($rim['brand'] ?? '') . ' - ' . ($rim['model'] ?? ''));
                        $detailUrl = "jant/" . ($rim['model_link'] ?? $rim['id']);

                        // çap classları
                        $cls = '';
                        if (!empty($rim['diameters'])) {
                            foreach (explode(',', $rim['diameters']) as $d) {
                                $d = (int)trim($d);
                                if ($d > 0) $cls .= " d{$d}";
                            }
                        } else {
                            $cls = " d0"; // specs yoksa
                        }
                        ?>

                        <li class="b-isotope-grid__item grid-item<?= htmlspecialchars($cls) ?>">
                            <a class="b-isotope-grid__inner js-zoom-images" href="<?= htmlspecialchars($photo_show) ?>">
                                <img src="<?= htmlspecialchars($photo_show) ?>" alt="<?= htmlspecialchars($title) ?>" />
                                <span class="b-isotope-grid__wrap-info helper">
                                    <span class="b-isotope-grid__info">
                                        <i class="icon fa fa-search"></i>
                                        <span class="b-isotope-grid__title"><?= htmlspecialchars($title) ?></span>
                                    </span>
                                </span>
                            </a>

                            <!-- detay linki (istersen görünür yaparız) -->
                            <a href="<?= htmlspecialchars($detailUrl) ?>" class="sr-only"><?= htmlspecialchars($title) ?></a>
                        </li>
                    <?php endforeach; ?>

                </ul>
            </div>
        </section>

        <script>
            // filtre linkleri sayfayı yenilemesin
            $('.b-isotope-filter a').on('click', function(e) {
                e.preventDefault();
            });
        </script>

        <div class="section-default">
            <div class="container">
                <div class="row">
                    <div class="col-md-7">
                        <section class="section-list-brands" style="margin-bottom: 70px;">
                            <h2 class="ui-title-block">Popüler Lastik Ebatları</h2>
                            <div class="ui-decor"></div>
                            <ul class="b-list-brands list-unstyled">
                                <li class="b-list-brands__item"><a class="b-list-brands__link" href="lastikler?width=175&height=65&diameter=14">175/65 R14</a>
                                </li>
                                <li class="b-list-brands__item"><a class="b-list-brands__link" href="lastikler?width=185&height=65&diameter=15">185/65 R15</a>
                                </li>
                                <li class="b-list-brands__item"><a class="b-list-brands__link" href="lastikler?width=195&height=65&diameter=15">195/65 R15</a>
                                </li>
                                <li class="b-list-brands__item"><a class="b-list-brands__link" href="lastikler?width=205&height=55&diameter=16">205/55 R16</a>
                                </li>
                                <li class="b-list-brands__item"><a class="b-list-brands__link" href="lastikler?width=205&height=60&diameter=16">205/60 R16</a>
                                </li>
                                <li class="b-list-brands__item"><a class="b-list-brands__link" href="lastikler?width=205&height=75&diameter=16">205/75 R16</a>
                                </li>
                                <li class="b-list-brands__item"><a class="b-list-brands__link" href="lastikler?width=215&height=55&diameter=16">215/55 R16</a>
                                </li>
                                <li class="b-list-brands__item"><a class="b-list-brands__link" href="lastikler?width=215&height=60&diameter=16">215/60 R16</a>
                                </li>
                                <li class="b-list-brands__item"><a class="b-list-brands__link" href="lastikler?width=215&height=75&diameter=16">215/75 R16</a>
                                </li>
                                <li class="b-list-brands__item"><a class="b-list-brands__link" href="lastikler?width=225&height=45&diameter=17">225/45 R17</a>
                                </li>
                                <li class="b-list-brands__item"><a class="b-list-brands__link" href="lastikler?width=225&height=50&diameter=17">225/50 R17</a>
                                </li>
                                <li class="b-list-brands__item"><a class="b-list-brands__link" href="lastikler?width=265&height=65&diameter=17">265/65 R17</a>
                                </li>
                                <li class="b-list-brands__item"><a class="b-list-brands__link" href="lastikler?width=225&height=40&diameter=18">225/40 R18</a>
                                </li>
                                <li class="b-list-brands__item"><a class="b-list-brands__link" href="lastikler?width=235&height=45&diameter=18">235/45 R18</a>
                                </li>
                                <li class="b-list-brands__item"><a class="b-list-brands__link" href="lastikler?width=255&height=55&diameter=18">255/55 R18</a>
                                </li>
                                <li class="b-list-brands__item"><a class="b-list-brands__link" href="lastikler?width=235&height=55&diameter=19">235/55 R19</a>
                                </li>
                            </ul>
                            <a class="btn btn-primary" href="lastikler">Bütün Lastikleri Gör</a>
                        </section>
                    </div>
                    <div class="col-md-4 col-md-offset-1">
                        <div class="b-bnr">
                            <div class="b-bnr__label">Neden</div>
                            <div class="b-bnr__title">Menekşe Lastik?</div>
                            <div class="b-bnr__info">Müşterilerimize sunduğumuz güvenilir hizmet anlayışımızın farkını yaşayın.</div>
                            <ul class="b-bnr__list list list-mark-3">
                                <li>Uzman kadro ve yılların tecrübesi</li>
                                <li>Aynı gün hızlı servis & randevu kolaylığı</li>
                                <li>Bridgestone, Lassa, Dayton markalarında geniş stok</li>
                                <li>Şeffaf fiyat politikası, sürpriz masrafsız</li>
                                <li>İşçilik garantisi ve müşteri memnuniyeti</li>
                            </ul>
                        </div>
                        <!-- end .b-banner-->
                    </div>
                </div>
            </div>
        </div>
        <!-- end .b-list-brands-->
        <section class="section-news area-bg area-bg_light area-bg_op_90 parallax" style="background-image: url(assets/media/backgrounds/wheel-bg.webp)">
            <div class="area-bg__inner">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="text-center">
                                <h2 class="ui-title-block">Kampanyalar</h2>
                                <div class="ui-subtitle-block">Tempor incididunt labore dolore magna clium fugiat alique</div>
                                <div class="ui-decor"></div>
                            </div>
                            <div class="carousel-news owl-carousel owl-theme owl-theme_w-btn enable-owl-carousel" data-min768="2" data-min992="3" data-min1200="3" data-margin="30" data-pagination="false" data-navigation="true" data-auto-play="4000" data-stop-on-hover="true">

                                <?php
                                //get the campaigns from the database
                                $campaigns = $pdo->query("SELECT * FROM blogs ORDER BY id DESC LIMIT 6");

                                foreach ($campaigns as $campaign) {
                                    $campaign_id = $campaign['id'];
                                    $campaign_title = $campaign['title'];
                                    $campaign_image = $campaign['photo'];
                                    $path = substr($campaign_image, 3);
                                    $campaign_date = $campaign['date'];
                                    $campaign_writer = $campaign['writer'];
                                    $date_turkce = turkceTarihParcala($campaign_date);
                                    $end_date = $campaign['end_date'];
                                    $end_date_turkce = gecerlilikMetni($end_date);
                                    $campaign_link = $campaign['title_link']; ?>
                                    <section class="b-post b-post-1 clearfix">
                                        <div class="entry-media">
                                            <img class="img-responsive" src="<?php echo $path; ?>" alt="Foto" />
                                        </div>
                                        <div class="entry-main">
                                            <div class="entry-header">
                                                <div class="entry-meta">
                                                    <div class="entry-meta__face">

                                                    </div><a class="entry-meta__categorie" href="kampanya/<?= $campaign_link ?>/<?= $campaign_id ?>"><strong><?= $end_date_turkce ?></strong></a>
                                                </div>
                                                <h2 class="entry-title"><a href="kampanya/<?= $campaign_link ?>/<?= $campaign_id ?>"><?php echo $campaign_title; ?></a></h2>
                                            </div>
                                            <div class="entry-footer">
                                                <div class="entry-footer__inner">
                                                    <div class="b-post-social">Paylaş:
                                                        <ul class="b-post-social__list list-inline">
                                                            <li><a href="twitter.com"><i class="icon fa fa-twitter"></i></a>
                                                            </li>
                                                            <li><a href="facebook.com"><i class="icon fa fa-facebook"></i></a>
                                                            </li>
                                                            <li><a href="plus.google.com"><i class="icon fa fa-google-plus"></i></a>
                                                            </li>
                                                            <li><a href="pinterest.com"><i class="icon fa fa-pinterest-p"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </section>

                                <?php
                                }
                                ?>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>