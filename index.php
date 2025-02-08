<?php
header("content-type:text/html;charset=utf8");
define("Secure-MENEKSELASTIK-2025@!", true);
define("SITE", "pages/");
define("COMPONENTS", "components/");
require("components/config.php");
include("components/webp.php");

ob_start();
session_start();
?>
<?php
// Tarayıcı önbelleğini devre dışı bırakmak için bu başlıkları ekleyin
header("Cache-Control: no-cache, no-store, must-revalidate");

header("Access-Control-Allow-Origin: *");
header("Pragma: no-cache");
header("Expires: 0");
?>
<!DOCTYPE html>
<html lang="tr">


<head>
    <meta charset="UTF-8">
    <!-- For IE -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- For Resposive Device -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- For Window Tab Color -->
    <!-- Chrome, Firefox OS and Opera -->
    <meta name="theme-color" content="#061948">
    <!-- Windows Phone -->
    <meta name="msapplication-navbutton-color" content="#061948">
    <!-- iOS Safari -->
    <meta name="apple-mobile-web-app-status-bar-style" content="#061948">
    <!-- Favicon -->
    <link rel="icon" sizes="192x192" href="images/logo/logo.png" type="image/png">
    <link rel="shortcut icon" href="images/logo/shorticon.png" type="image/png">
    <link rel="apple-touch-icon" href="images/logo/appleicon.png" type="image/png">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <meta name="keywords" content="<?= $seo_settings_arr['keywords'] ?>">
    <meta name="google-site-verification" content="<?= $seo_settings_arr['google_verify'] ?>">
    <meta name="yandex-verification" content="<?= $seo_settings_arr['yandex_verify'] ?>">

    <!-- Main style sheet -->
    <!-- fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet" />

    <link
        href="https://fonts.googleapis.com/css2?family=Archivo:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet" />

    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/animate.min.css" />
    <link rel="stylesheet" href="assets/css/custom-animate.css" />
    <link rel="stylesheet" href="assets/css/swiper.min.css" />
    <link rel="stylesheet" href="assets/css/font-awesome-all.css" />
    <link rel="stylesheet" href="assets/css/jarallax.css" />
    <link rel="stylesheet" href="assets/css/jquery.magnific-popup.css" />
    <link rel="stylesheet" href="assets/css/flaticon.css" />
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css" />
    <link rel="stylesheet" href="assets/css/odometer.min.css" />
    <link rel="stylesheet" href="assets/css/owl.theme.default.min.css" />
    <link rel="stylesheet" href="assets/css/nice-select.css" />
    <link rel="stylesheet" href="assets/css/jquery-ui.css" />
    <link rel="stylesheet" href="assets/css/aos.css" />

    <link rel="stylesheet" href="assets/css/module-css/slider.css" />
    <link rel="stylesheet" href="assets/css/module-css/footer.css" />
    <link rel="stylesheet" href="assets/css/module-css/counter.css" />
    <link rel="stylesheet" href="assets/css/module-css/services.css" />
    <link rel="stylesheet" href="assets/css/module-css/about.css" />
    <link rel="stylesheet" href="assets/css/module-css/brand.css" />
    <link rel="stylesheet" href="assets/css/module-css/gallery.css" />
    <link rel="stylesheet" href="assets/css/module-css/faq.css" />
    <link rel="stylesheet" href="assets/css/module-css/testimonial.css" />
    <link rel="stylesheet" href="assets/css/module-css/team.css" />
    <link rel="stylesheet" href="assets/css/module-css/contact.css" />
    <link rel="stylesheet" href="assets/css/module-css/pricing.css" />
    <link rel="stylesheet" href="assets/css/module-css/blog.css" />
    <link rel="stylesheet" href="assets/css/module-css/sliding-text.css" />
    <link rel="stylesheet" href="assets/css/module-css/cta.css" />
    <link rel="stylesheet" href="assets/css/module-css/feature.css" />
    <link rel="stylesheet" href="assets/css/module-css/banner.css" />
    <link rel="stylesheet" href="assets/css/module-css/page-header.css" />

    <!-- template styles -->
    <link rel="stylesheet" href="assets/css/style.css" />
    <link rel="stylesheet" href="assets/css/responsive.css" />
    <script src="cookie/cookieconsent.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.6.172/pdf.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.6.172/pdf.worker.min.js"></script>
    <script>
        window.addEventListener('load', function() {
            window.cookieconsent.initialise({
                revokeBtn: "<div class='cc-revoke'></div>",
                type: "opt-in",
                position: "bottom",
                palette: {
                    popup: {
                        background: "#1d4d89;",
                        text: "#fff"
                    },
                    button: {
                        background: "#ff8c00",
                        text: "#fff"
                    }
                },
                content: {
                    message: "Çerez tercihlerinizi değiştirmek ve Çerezler hakkında detaylı bilgi almak için Çerez Politikasını inceleyebilirsiniz.",
                    link: "Çerez Politikası",
                    href: "cerez-politikasi"
                }
            })
        });
    </script>
    <?php
    if ($_GET && !empty($_GET["p"])) {
        $p = htmlspecialchars(trim($_GET["p"] . ".php"));
        if (file_exists(SITE . $p)) {

            include_once(SITE . $p);
        } else {
            include("pages/404.php");
        }
    } else {

    ?>
        <?php
        echo !defined("Secure-MENEKSELASTIK-2025@!") ? die("Hatalı sayfa girişi yaptınız. Lütfen site menüsünü kullanınız.") : null;
        ?>
        <title><?= $seo_settings_arr['title'] ?></title>
        <meta name="description" content="<?= $seo_settings_arr['description'] ?>" />
        <meta property="og:title" content="<?= $seo_settings_arr['title'] ?>" />
        <meta property="og:description" content="<?= $seo_settings_arr['description'] ?>" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>


</head>

<body class="custom-cursor body-bg-color">
    <div class="custom-cursor__cursor"></div>
    <div class="custom-cursor__cursor-two"></div>

    <?php include("layouts/sidebar.php"); ?>

    <div class="page-wrapper">

        <?php include("layouts/header.php"); ?>

        <div class="stricky-header stricked-menu main-menu main-menu-four">
            <div class="sticky-header__content"></div>
            <!-- /.sticky-header__content -->
        </div>
        <!-- /.stricky-header -->

        <!-- Banner One Start -->
        <section class="banner-one">
            <div class="container">
                <div class="banner-one__inner">
                    <div
                        class="banner-one__title-box sec-title-animation animation-style1">
                        <h2 class="banner-one__title title-animation">
                            Dayanıklı
                            <span>Lastikler,</span><br /> Güvenli <span>Sürüş!</span>
                        </h2>
                        <div class="banner-one__video-box">
                            <div class="banner-one__video-link">
                                <a
                                    href="https://www.youtube.com/watch?v=Get7rqXYrbQ"
                                    class="video-popup">
                                    <div class="banner-one__video-icon">
                                        <span class="icon-video"></span>
                                        <i class="ripple"></i>
                                    </div>
                                </a>
                            </div>
                            <h5 class="banner-one__video-title">İzle</h5>
                        </div>
                    </div>
                    <div class="banner-one__designer-and-developer">
                        <p class="banner-one__designer-and-developer-text">
                            Slogan
                        </p>
                        <ul class="list-unstyled banner-one__designer-and-developer-list">
                            <li>
                                <div class="banner-one__designer-and-developer-img">
                                    <img
                                        src="assets/images/resources/banner-one-designer-and-developer-img-1-1.jpg"
                                        alt="" />
                                </div>
                            </li>
                            <li>
                                <div class="banner-one__designer-and-developer-img">
                                    <img
                                        src="assets/images/resources/banner-one-designer-and-developer-img-1-2.jpg"
                                        alt="" />
                                </div>
                            </li>
                            <li>
                                <div class="banner-one__designer-and-developer-img">
                                    <img
                                        src="assets/images/resources/banner-one-designer-and-developer-img-1-3.jpg"
                                        alt="" />
                                </div>
                            </li>
                            <li>
                                <div class="banner-one__designer-and-developer-img">
                                    <img
                                        src="assets/images/resources/banner-one-designer-and-developer-img-1-4.jpg"
                                        alt="" />
                                </div>
                            </li>
                        </ul>
                    </div>

                    <p class="banner-one__text">
                        Slogan
                    </p>
                    <div class="banner-one__img-box">
                        <div class="banner-one__img">
                            <img
                                src="assets/images/resources/banner-photo.png"
                                alt="" />
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--Banner One End -->

        <!--Sliding Text Two Start-->
        <section class="sliding-text sliding-text-two">
            <div class="sliding-text__inner">
                <ul class="sliding-text__list marquee_mode-1 list-unstyled">
                    <li>
                        <div class="icon">
                            <span class="icon-brake-disc"></span>
                        </div>
                    </li>
                    <li>
                        <p>Dayanıklı Lastikler</p>
                    </li>
                    <li>
                        <div class="icon">
                            <span class="icon-broken-car"></span>
                        </div>
                    </li>
                    <li>
                        <p>Hasara Son, Yola Devam</p>
                    </li>
                    <li>
                        <div class="icon">
                            <span class="icon-wheel-2"></span>
                        </div>
                    </li>
                    <li>
                        <p>Estetik ve Performans</p>
                    </li>
                    <li>
                        <div class="icon">
                            <span class="icon-chassis"></span>
                        </div>
                    </li>
                    <li>
                        <p>Güçlü Yol Tutuş</p>
                    </li>
                </ul>
            </div>
        </section>
        <!--Sliding Text Two End-->

        <!--Services Four Start -->
        <section class="services-four">
            <div class="container">
                <div
                    class="section-title-two text-center sec-title-animation animation-style1">
                    <div class="section-title-two__tagline-box justify-content-center">
                        <div class="section-title-two__tagline-shape-1"></div>
                        <span class="section-title-two__tagline">Hizmetlerimiz</span>
                        <div class="section-title-two__tagline-shape-1"></div>
                    </div>
                    <h2 class="section-title-two__title title-animation">
                        Your Trusted Car Provider <br />
                        Keeping Your Vehicle
                    </h2>
                </div>
                <div class="services-four__top">
                    <div class="row">
                        <!--Services Three Single Start -->
                        <div
                            class="col-xl-4 col-lg-6 col-md-6 wow fadeInLeft"
                            data-wow-delay="100ms">
                            <div class="services-four__single">
                                <div class="services-four__icon">
                                    <span class="icon-pressure"></span>
                                </div>
                                <h3 class="services-four__title">
                                    <a href="easy-drive-maintenance.html">Lastik Değişimi & Satışı</a>
                                </h3>
                                <p class="services-four__text">
                                Doğru lastik seçimi ve profesyonel montaj ile güvenli sürüş sunuyoruz. Balans ve rot ayarı ile aracınızın performansını en üst seviyeye çıkarıyoruz.
                                </p>
                            </div>
                        </div>
                        <!--Services Three Single End -->
                        <!--Services Three Single Start -->
                        <div
                            class="col-xl-4 col-lg-6 col-md-6 wow fadeInUp"
                            data-wow-delay="200ms">
                            <div class="services-four__single">
                                <div class="services-four__icon">
                                    <!--svg icon -->
                                    <span class="icon-wheels"></span>
                                </div>
                                <h3 class="services-four__title">
                                    <a href="auto-pro-mechanic-shop.html">Lastik Oteli</a>
                                </h3>
                                <p class="services-four__text">
                                Lastiklerinizi güvenle saklıyoruz! Özel depolama koşulları ile mevsimlik lastiklerinizin yıpranmasını önlüyor, kullanım ömrünü uzatıyoruz.
                                </p>
                            </div>
                        </div>
                        <!--Services Three Single End -->
                        <!--Services Three Single Start -->
                        <div
                            class="col-xl-4 col-lg-6 col-md-6 wow fadeInRight"
                            data-wow-delay="300ms">
                            <div class="services-four__single">
                                <div class="services-four__icon">
                                    <span class="icon-wheel-2"></span>
                                </div>
                                <h3 class="services-four__title">
                                    <a href="elite-auto-services.html">Jant Düzeltme & Boyama</a>
                                </h3>
                                <p class="services-four__text">
                                Hasarlı jantlarınızı onarıyor, şık ve dayanıklı boyama seçenekleri sunuyoruz. Aracınıza estetik bir görünüm kazandırıyoruz.
                                </p>
                            </div>
                        </div>
                        <!--Services Three Single End -->
                    </div>
                </div>
                <div class="services-four__bottom">
                    <div class="row">
                        <!--Services Three Single Start -->
                        <div
                            class="col-xl-4 col-lg-6 col-md-6 wow fadeInLeft"
                            data-wow-delay="400ms">
                            <div class="services-four__single">
                                <div class="services-four__icon">
                                    <span class="icon-brake-disc"></span>
                                </div>
                                <h3 class="services-four__title">
                                    <a href="smooth-ride-vehicle-care.html">Lastik Tamiri & Onarım</a>
                                </h3>
                                <p class="services-four__text">
                                Patlak veya hasarlı lastikleriniz için hızlı ve güvenilir onarım hizmeti sunuyoruz. Güvenli sürüş için uzman ekibimizle hizmet veriyoruz.
                                </p>
                            </div>
                        </div>
                        <!--Services Three Single End -->
                        <!--Services Three Single Start -->
                        <div
                            class="col-xl-4 col-lg-6 col-md-6 wow fadeInRight"
                            data-wow-delay="500ms">
                            <div class="services-four__single">
                                <div class="services-four__icon">
                                    <span class="icon-broken-car"></span>
                                </div>
                                <h3 class="services-four__title">
                                    <a href="careful-car-service-station.html">Akü Değişimi</a>
                                </h3>
                                <p class="services-four__text">
                                Güçlü bir akü, sorunsuz bir sürüş demektir! Akü kontrolü, bakımı ve değişimi ile aracınızı her zaman yola hazır hale getiriyoruz.
                                </p>
                            </div>
                        </div>
                        <!--Services Three Single End -->
                    </div>
                </div>
            </div>
        </section>
        <!--Services Four End -->

        <!--About Four Start -->
        <section class="about-four">
            <div class="container">
                <div class="row">
                    <div
                        class="col-xl-6 wow slideInLeft"
                        data-wow-delay="100ms"
                        data-wow-duration="2500ms">
                        <div class="about-four__left">
                            <div class="about-four__img">
                                <img
                                    src="assets/images/resources/about-four-img-1.jpg"
                                    alt="" />
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="about-four__right">
                            <div
                                class="section-title-two text-left sec-title-animation animation-style1">
                                <div class="section-title-two__tagline-box">
                                    <span class="section-title-two__tagline">Hakkımızda</span>
                                    <div class="section-title-two__tagline-shape-1"></div>
                                </div>
                                <h2 class="section-title-two__title title-animation">
                                    Car Service Businesses Offer A Range Of Services To Keep
                                    Running Smoothly
                                </h2>
                            </div>
                            <p class="about-four__text">
                                Car service is essential for maintaining the performance and
                                longevity of your vehicle. From oil changes Car service is
                                essential for maintaining
                            </p>
                            <div
                                class="about-four__points-box wow slideInRight"
                                data-wow-delay="100ms"
                                data-wow-duration="2500ms">
                                <ul class="list-unstyled about-four__points">
                                    <li>
                                        <div class="about-four__points-count"></div>
                                        <div class="about-four__points-content">
                                            <h4><a href="about.html">Beyond Boundaries</a></h4>
                                            <p>
                                                Car service is essential maintaining <br />
                                                the and longevity vehicle
                                            </p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="about-four__points-count"></div>
                                        <div class="about-four__points-content">
                                            <h4>
                                                <a href="about.html">Vroom Service Solutions</a>
                                            </h4>
                                            <p>
                                                Car service is essential maintaining <br />
                                                the and longevity vehicle
                                            </p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--About Four End -->

        <!--CTA One Start -->
        <section class="cta-one">
            <div
                class="cta-one__bg jarallax"
                data-jarallax
                data-speed="0.05"
                data-imgPosition="50% 0%"
                style="
            background-image: url(assets/images/backgrounds/cta-one-bg.jpg);
          "></div>
            <div class="container">
                <div class="cta-one__inner">
                    <h3 class="cta-one__title">
                        Get Premium Auto Car Service <br />
                        Feel Free To <a href="contact.html">Contact Us</a>
                    </h3>
                    <div class="cta-one__btn-and-video-link">
                        <div class="cta-one__btn">
                            <a href="contact.html" class="thm-btn">Contact Us<span class="icon-arrow-up-right"></span></a>
                        </div>
                        <div class="cta-one__video-link">
                            <a
                                href="https://www.youtube.com/watch?v=Get7rqXYrbQ"
                                class="video-popup">
                                <div class="cta-one__video-icon">
                                    <span class="icon-video"></span>
                                    <i class="ripple"></i>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--CTA One End -->

        <!--Feature One Start -->
        <section class="feature-one">
            <div class="container">
                <div
                    class="section-title-two text-center sec-title-animation animation-style1">
                    <div class="section-title-two__tagline-box justify-content-center">
                        <div class="section-title-two__tagline-shape-1"></div>
                        <span class="section-title-two__tagline">Our Feature</span>
                        <div class="section-title-two__tagline-shape-1"></div>
                    </div>
                    <h2 class="section-title-two__title title-animation">
                        Keep Your Engine Smiling <br />
                        Drive Safe Smart
                    </h2>
                </div>
                <ul class="list-unstyled feature-one__list">
                    <li class="wow fadeInLeft" data-wow-delay="100ms">
                        <div class="feature-one__title-box">
                            <h2 class="feature-one__title">
                                <a href="easy-drive-maintenance.html">Speedy Auto <br />
                                    Service</a>
                            </h2>
                        </div>
                        <div class="feature-one__content-box">
                            <p class="feature-one__text">
                                Car service is essential for maintaining the performance and
                                longevity of your <br />
                                vehicle. From oil changes Car service is essential for
                                maintaining
                            </p>
                            <div class="feature-one__arrow">
                                <a href="easy-drive-maintenance.html"><span class="icon-arrow-up-right"></span></a>
                            </div>
                        </div>
                    </li>
                    <li class="wow fadeInRight" data-wow-delay="200ms">
                        <div class="feature-one__title-box">
                            <h2 class="feature-one__title">
                                <a href="careful-car-service-station.html">Expert Care for <br />
                                    Your Vehicle</a>
                            </h2>
                        </div>
                        <div class="feature-one__content-box">
                            <p class="feature-one__text">
                                Car service is essential for maintaining the performance and
                                longevity of your <br />
                                vehicle. From oil changes Car service is essential for
                                maintaining
                            </p>
                            <div class="feature-one__arrow">
                                <a href="careful-car-service-station.html"><span class="icon-arrow-up-right"></span></a>
                            </div>
                        </div>
                    </li>
                    <li class="wow fadeInLeft" data-wow-delay="300ms">
                        <div class="feature-one__title-box">
                            <h2 class="feature-one__title">
                                <a href="elite-auto-services.html">Trust Us with A <br />
                                    Your Wheels</a>
                            </h2>
                        </div>
                        <div class="feature-one__content-box">
                            <p class="feature-one__text">
                                Car service is essential for maintaining the performance and
                                longevity of your <br />
                                vehicle. From oil changes Car service is essential for
                                maintaining
                            </p>
                            <div class="feature-one__arrow">
                                <a href="elite-auto-services.html"><span class="icon-arrow-up-right"></span></a>
                            </div>
                        </div>
                    </li>
                    <li class="wow fadeInRight" data-wow-delay="400ms">
                        <div class="feature-one__title-box">
                            <h2 class="feature-one__title">
                                <a href="auto-pro-mechanic-shop.html">Reliable Service <br />
                                    Every Time</a>
                            </h2>
                        </div>
                        <div class="feature-one__content-box">
                            <p class="feature-one__text">
                                Car service is essential for maintaining the performance and
                                longevity of your <br />
                                vehicle. From oil changes Car service is essential for
                                maintaining
                            </p>
                            <div class="feature-one__arrow">
                                <a href="auto-pro-mechanic-shop.html"><span class="icon-arrow-up-right"></span></a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </section>
        <!--Feature One End -->

        <!--Gallery Four Start -->
        <section class="gallery-four">
            <div class="container">
                <div class="gallery-four__top">
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="gallery-four__left">
                                <div
                                    class="section-title-two text-left sec-title-animation animation-style2">
                                    <div class="section-title-two__tagline-box">
                                        <span class="section-title-two__tagline">Latest Gallery</span>
                                        <div class="section-title-two__tagline-shape-1"></div>
                                    </div>
                                    <h2 class="section-title-two__title title-animation">
                                        Quality Service, Every Time <br />
                                        Drive Safe Stay Secure
                                    </h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="gallery-four__right">
                                <p class="gallery-four__text">
                                    Car service is essential for maintaining the performance and
                                    longevity of your vehicle. From oil changes
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="gallery-four__bottom">
                    <div class="row">
                        <div class="col-xl-6 col-lg-6">
                            <div class="gallery-four__single">
                                <div
                                    class="gallery-four__img-box wow fadeInLeft"
                                    data-wow-delay="100ms">
                                    <div class="gallery-four__img">
                                        <img src="assets/images/gallery/gallery-4-1.jpg" alt="" />
                                    </div>
                                    <div class="gallery-four__content">
                                        <div class="gallery-four__title-box">
                                            <h3>
                                                <a href="project-details.html">Drive Stress-Free</a>
                                            </h3>
                                            <p>2022</p>
                                        </div>
                                        <div class="gallery-four__arrow">
                                            <a
                                                href="assets/images/gallery/gallery-4-1.jpg"
                                                class="img-popup"><span class="icon-arrow-right-three"></span></a>
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="gallery-four__img-box wow fadeInLeft"
                                    data-wow-delay="200ms">
                                    <div class="gallery-four__img">
                                        <img src="assets/images/gallery/gallery-4-2.jpg" alt="" />
                                    </div>
                                    <div class="gallery-four__content">
                                        <div class="gallery-four__title-box">
                                            <h3>
                                                <a href="project-details.html">Car Revive Experts</a>
                                            </h3>
                                            <p>2022</p>
                                        </div>
                                        <div class="gallery-four__arrow">
                                            <a
                                                href="assets/images/gallery/gallery-4-2.jpg"
                                                class="img-popup"><span class="icon-arrow-right-three"></span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6">
                            <div class="gallery-four__single">
                                <div
                                    class="gallery-four__img-box wow fadeInRight"
                                    data-wow-delay="300ms">
                                    <div class="gallery-four__img">
                                        <img src="assets/images/gallery/gallery-4-3.jpg" alt="" />
                                    </div>
                                    <div class="gallery-four__content">
                                        <div class="gallery-four__title-box">
                                            <h3>
                                                <a href="project-details.html">Spark Car Care</a>
                                            </h3>
                                            <p>2022</p>
                                        </div>
                                        <div class="gallery-four__arrow">
                                            <a
                                                href="assets/images/gallery/gallery-4-3.jpg"
                                                class="img-popup"><span class="icon-arrow-right-three"></span></a>
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="gallery-four__img-box wow fadeInRight"
                                    data-wow-delay="400ms">
                                    <div class="gallery-four__img">
                                        <img src="assets/images/gallery/gallery-4-4.jpg" alt="" />
                                    </div>
                                    <div class="gallery-four__content">
                                        <div class="gallery-four__title-box">
                                            <h3>
                                                <a href="project-details.html">Trusted Car Service</a>
                                            </h3>
                                            <p>2022</p>
                                        </div>
                                        <div class="gallery-four__arrow">
                                            <a
                                                href="assets/images/gallery/gallery-4-4.jpg"
                                                class="img-popup"><span class="icon-arrow-right-three"></span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--Gallery Four End -->

        <!--Team Four Start -->
        <section class="team-four">
            <div class="team-four__wrap">
                <div class="container">
                    <div
                        class="section-title-two text-center sec-title-animation animation-style1">
                        <div
                            class="section-title-two__tagline-box justify-content-center">
                            <div class="section-title-two__tagline-shape-1"></div>
                            <span class="section-title-two__tagline">Our Team</span>
                            <div class="section-title-two__tagline-shape-1"></div>
                        </div>
                        <h2 class="section-title-two__title title-animation">
                            They Our Best Team <br />
                            Member Ever
                        </h2>
                    </div>
                    <div class="row">
                        <!--Team Four Single Start -->
                        <div
                            class="col-xl-4 col-lg-4 col-md-6 wow fadeInLeft"
                            data-wow-delay="100ms">
                            <div class="team-four__single">
                                <div class="team-four__img">
                                    <img src="assets/images/team/team-4-1.jpg" alt="" />
                                    <div class="team-four__plus-and-social">
                                        <div class="team-four__plus">
                                            <span class="icon-arrow-up-right"></span>
                                        </div>
                                        <div class="team-four__social">
                                            <a href="#"><span class="icon-pintarest"></span></a>
                                            <a href="#"><span class="icon-linkedin-in-two"></span></a>
                                            <a href="#"><span class="icon-Vector"></span></a>
                                            <a href="#"><span class="icon-facebook-f"></span></a>
                                        </div>
                                    </div>
                                    <div class="team-four__sub-title">
                                        <p>Car Revive Experts</p>
                                    </div>
                                </div>
                                <div class="team-four__content">
                                    <h3 class="team-four__name">
                                        <a href="team-details.html">Darlene Robertson</a>
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <!--Team Four Single End -->
                        <!--Team Four Single Start -->
                        <div
                            class="col-xl-4 col-lg-4 col-md-6 wow fadeInUp"
                            data-wow-delay="200ms">
                            <div class="team-four__single">
                                <div class="team-four__img">
                                    <img src="assets/images/team/team-4-2.jpg" alt="" />
                                    <div class="team-four__plus-and-social">
                                        <div class="team-four__plus">
                                            <span class="icon-arrow-up-right"></span>
                                        </div>
                                        <div class="team-four__social">
                                            <a href="#"><span class="icon-pintarest"></span></a>
                                            <a href="#"><span class="icon-linkedin-in-two"></span></a>
                                            <a href="#"><span class="icon-Vector"></span></a>
                                            <a href="#"><span class="icon-facebook-f"></span></a>
                                        </div>
                                    </div>
                                    <div class="team-four__sub-title">
                                        <p>Wheels Experts</p>
                                    </div>
                                </div>
                                <div class="team-four__content">
                                    <h3 class="team-four__name">
                                        <a href="team-details.html">Dianne Russell</a>
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <!--Team Four Single End -->
                        <!--Team Four Single Start -->
                        <div
                            class="col-xl-4 col-lg-4 col-md-6 wow fadeInRight"
                            data-wow-delay="300ms">
                            <div class="team-four__single">
                                <div class="team-four__img">
                                    <img src="assets/images/team/team-4-3.jpg" alt="" />
                                    <div class="team-four__plus-and-social">
                                        <div class="team-four__plus">
                                            <span class="icon-arrow-up-right"></span>
                                        </div>
                                        <div class="team-four__social">
                                            <a href="#"><span class="icon-pintarest"></span></a>
                                            <a href="#"><span class="icon-linkedin-in-two"></span></a>
                                            <a href="#"><span class="icon-Vector"></span></a>
                                            <a href="#"><span class="icon-facebook-f"></span></a>
                                        </div>
                                    </div>
                                    <div class="team-four__sub-title">
                                        <p>Ride Services</p>
                                    </div>
                                </div>
                                <div class="team-four__content">
                                    <h3 class="team-four__name">
                                        <a href="team-details.html">Leslie Alexander</a>
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <!--Team Four Single End -->
                    </div>
                </div>
            </div>
        </section>
        <!--Team Four End -->

        <!--Testimonial Four Start -->
        <section class="testimonial-four">
            <div class="container">
                <div class="testimonial-four__inner">
                    <div class="testimonial-four__big-img">
                        <img
                            src="assets/images/testimonial/testimonial-four-big-img.png"
                            alt="" />
                    </div>
                    <div class="testimonial-four__top">
                        <div class="row">
                            <div class="col-xl-6">
                                <div
                                    class="testimonial-four__carousel owl-theme owl-carousel">
                                    <div class="item">
                                        <div class="testimonial-four__single">
                                            <div class="testimonial-four__quote-and-rating">
                                                <div class="testimonial-four__quote">
                                                    <span class="fas fa-quote-right"></span>
                                                </div>
                                                <div class="testimonial-four__rating">
                                                    <span class="icon-star"></span>
                                                    <span class="icon-star"></span>
                                                    <span class="icon-star"></span>
                                                    <span class="icon-star"></span>
                                                    <span class="icon-star"></span>
                                                </div>
                                            </div>
                                            <p class="testimonial-four__text">
                                                Car service the maintaining and a the performance
                                                longevity of the vehicle a From oil is a and a
                                                rotations Car service Car service the maintaining and
                                                a the performance longevity of the vehicle
                                            </p>
                                            <div class="testimonial-four__client-info">
                                                <div class="testimonial-four__client-img">
                                                    <img
                                                        src="assets/images/testimonial/testimonial-4-1.jpg"
                                                        alt="" />
                                                </div>
                                                <h3 class="testimonial-four__client-name">
                                                    <a href="testimonials.html">Arlene McCoy</a>
                                                </h3>
                                                <p class="testimonial-four__client-sub-title">
                                                    Nursing Assistant
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="testimonial-four__single">
                                            <div class="testimonial-four__quote-and-rating">
                                                <div class="testimonial-four__quote">
                                                    <span class="fas fa-quote-right"></span>
                                                </div>
                                                <div class="testimonial-four__rating">
                                                    <span class="icon-star"></span>
                                                    <span class="icon-star"></span>
                                                    <span class="icon-star"></span>
                                                    <span class="icon-star"></span>
                                                    <span class="icon-star"></span>
                                                </div>
                                            </div>
                                            <p class="testimonial-four__text">
                                                Car service the maintaining and a the performance
                                                longevity of the vehicle a From oil is a and a
                                                rotations Car service Car service the maintaining and
                                                a the performance longevity of the vehicle
                                            </p>
                                            <div class="testimonial-four__client-info">
                                                <div class="testimonial-four__client-img">
                                                    <img
                                                        src="assets/images/testimonial/testimonial-4-2.jpg"
                                                        alt="" />
                                                </div>
                                                <h3 class="testimonial-four__client-name">
                                                    <a href="testimonials.html">Arlene Toynoby</a>
                                                </h3>
                                                <p class="testimonial-four__client-sub-title">
                                                    Nursing Assistant
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="testimonial-four__single">
                                            <div class="testimonial-four__quote-and-rating">
                                                <div class="testimonial-four__quote">
                                                    <span class="fas fa-quote-right"></span>
                                                </div>
                                                <div class="testimonial-four__rating">
                                                    <span class="icon-star"></span>
                                                    <span class="icon-star"></span>
                                                    <span class="icon-star"></span>
                                                    <span class="icon-star"></span>
                                                    <span class="icon-star"></span>
                                                </div>
                                            </div>
                                            <p class="testimonial-four__text">
                                                Car service the maintaining and a the performance
                                                longevity of the vehicle a From oil is a and a
                                                rotations Car service Car service the maintaining and
                                                a the performance longevity of the vehicle
                                            </p>
                                            <div class="testimonial-four__client-info">
                                                <div class="testimonial-four__client-img">
                                                    <img
                                                        src="assets/images/testimonial/testimonial-4-3.jpg"
                                                        alt="" />
                                                </div>
                                                <h3 class="testimonial-four__client-name">
                                                    <a href="testimonials.html">Obed McCoy</a>
                                                </h3>
                                                <p class="testimonial-four__client-sub-title">
                                                    Nursing Assistant
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-four__bottom">
                        <div class="row">
                            <div class="col-xl-3 col-lg-4 col-md-5">
                                <div class="testimonial-four__bottom-img">
                                    <img
                                        src="assets/images/testimonial/testimonial-four-bottom-img-1.jpg"
                                        alt="" />
                                </div>
                            </div>
                            <div class="col-xl-5 col-lg-8 col-md-7">
                                <div class="testimonial-four__car-repair-box">
                                    <h3 class="testimonial-four__car-repair-title">
                                        Car Repair
                                    </h3>
                                    <form
                                        class="contact-form-validated testimonial-four__form"
                                        action="assets/inc/sendemail.php"
                                        method="post"
                                        novalidate="novalidate">
                                        <div class="row">
                                            <div class="col-xl-6 col-lg-6 col-md-6">
                                                <div class="testimonial-four__input-box">
                                                    <div class="select-box">
                                                        <select class="wide">
                                                            <option data-display="Make">Make</option>
                                                            <option value="1">Make 01</option>
                                                            <option value="2">Make 02</option>
                                                            <option value="3">Make 03</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6">
                                                <div class="testimonial-four__input-box">
                                                    <input
                                                        type="text"
                                                        name="Model"
                                                        placeholder="Model"
                                                        required="" />
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6">
                                                <div class="testimonial-four__input-box">
                                                    <input
                                                        type="text"
                                                        placeholder="Year"
                                                        name="date"
                                                        id="datepicker" />
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6">
                                                <div class="testimonial-four__input-box">
                                                    <input
                                                        type="text"
                                                        name="Repair"
                                                        placeholder="Repair Needed"
                                                        required="" />
                                                </div>
                                            </div>
                                            <div class="col-xl-12">
                                                <div class="testimonial-four__btn-box">
                                                    <button
                                                        type="submit"
                                                        class="thm-btn testimonial-four__btn">
                                                        Get Estimate<span
                                                            class="icon-arrow-up-right"></span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="result"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--Testimonial Four End -->

        <!--Blog Four Start-->
        <section class="blog-four">
            <div class="container">
                <div class="blog-four__top">
                    <div
                        class="section-title-two text-left sec-title-animation animation-style1">
                        <div class="section-title-two__tagline-box">
                            <span class="section-title-two__tagline">Latest Blog And News</span>
                            <div class="section-title-two__tagline-shape-1"></div>
                        </div>
                        <h2 class="section-title-two__title title-animation">
                            Our Best Recent Blog And News
                        </h2>
                    </div>
                    <div class="blog-four__btn-box">
                        <a href="blog.html" class="thm-btn">View More<span class="icon-arrow-up-right"></span></a>
                    </div>
                </div>
                <div class="row">
                    <!--Blog Four Single Start-->
                    <div
                        class="col-xl-4 col-lg-4 wow fadeInLeft"
                        data-wow-delay="100ms">
                        <div class="blog-four__single">
                            <div class="blog-four__img-box">
                                <div class="blog-four__img">
                                    <img src="assets/images/blog/blog-4-1.jpg" alt="" />
                                </div>
                            </div>
                            <div class="blog-four__content">
                                <ul class="blog-four__meta list-unstyled">
                                    <li>
                                        <div class="icon">
                                            <span class="icon-user"></span>
                                        </div>
                                        <p>By admin</p>
                                    </li>
                                    <li>
                                        <div class="icon">
                                            <span class="icon-calendar-2"></span>
                                        </div>
                                        <p>20, june 2024</p>
                                    </li>
                                </ul>
                                <h3 class="blog-four__title">
                                    <a href="blog-details.html">Quality Maintenance, Quality DriveTrust Us
                                    </a>
                                </h3>
                                <div class="blog-four__btn-box-2">
                                    <a href="blog-details.html" class="thm-btn">Read More<span class="icon-arrow-up-right"></span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Blog Four Single End-->
                    <!--Blog Four Single Start-->
                    <div class="col-xl-4 col-lg-4 wow fadeInUp" data-wow-delay="200ms">
                        <div class="blog-four__single">
                            <div class="blog-four__img-box">
                                <div class="blog-four__img">
                                    <img src="assets/images/blog/blog-4-2.jpg" alt="" />
                                </div>
                            </div>
                            <div class="blog-four__content">
                                <ul class="blog-four__meta list-unstyled">
                                    <li>
                                        <div class="icon">
                                            <span class="icon-user"></span>
                                        </div>
                                        <p>By admin</p>
                                    </li>
                                    <li>
                                        <div class="icon">
                                            <span class="icon-calendar-2"></span>
                                        </div>
                                        <p>15 Aug 2024</p>
                                    </li>
                                </ul>
                                <h3 class="blog-four__title">
                                    <a href="blog-details.html">Drive Safe, Drive Performance Guaranteed Reliable
                                    </a>
                                </h3>
                                <div class="blog-four__btn-box-2">
                                    <a href="blog-details.html" class="thm-btn">Read More<span class="icon-arrow-up-right"></span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Blog Four Single End-->
                    <!--Blog Four Single Start-->
                    <div
                        class="col-xl-4 col-lg-4 wow fadeInRight"
                        data-wow-delay="300ms">
                        <div class="blog-four__single">
                            <div class="blog-four__img-box">
                                <div class="blog-four__img">
                                    <img src="assets/images/blog/blog-4-3.jpg" alt="" />
                                </div>
                            </div>
                            <div class="blog-four__content">
                                <ul class="blog-four__meta list-unstyled">
                                    <li>
                                        <div class="icon">
                                            <span class="icon-user"></span>
                                        </div>
                                        <p>By admin</p>
                                    </li>
                                    <li>
                                        <div class="icon">
                                            <span class="icon-calendar-2"></span>
                                        </div>
                                        <p>25 Feb 2024</p>
                                    </li>
                                </ul>
                                <h3 class="blog-four__title">
                                    <a href="blog-details.html">Expert Care for Your Drive for Your Stress-Free</a>
                                </h3>
                                <div class="blog-four__btn-box-2">
                                    <a href="blog-details.html" class="thm-btn">Read More<span class="icon-arrow-up-right"></span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Blog Four Single End-->
                </div>
            </div>
        </section>
        <!--Blog Four End -->


    </div>
    <!-- /.page-wrapper -->

    <?php include('layouts/mobile.php'); ?>

    <div class="search-popup">
        <div class="search-popup__overlay search-toggler"></div>
        <!-- /.search-popup__overlay -->
        <div class="search-popup__content">
            <form action="#">
                <label for="search" class="sr-only">search here</label><!-- /.sr-only -->
                <input type="text" id="search" placeholder="Search Here..." />
                <button type="submit" aria-label="search submit" class="thm-btn">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
        <!-- /.search-popup__content -->
    </div>
    <!-- /.search-popup -->


<?php
    }
?>


<?php include 'layouts/footer.php'; ?>
<a href="#" data-target="html" class="scroll-to-target scroll-to-top">
    <span class="scroll-to-top__wrapper"><span class="scroll-to-top__inner"></span></span>
    <span class="scroll-to-top__text"> Go Back Top</span>
</a>



<script src="assets/js/jquery-3.6.0.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/jarallax.min.js"></script>
<script src="assets/js/jquery.ajaxchimp.min.js"></script>
<script src="assets/js/jquery.appear.min.js"></script>
<script src="assets/js/swiper.min.js"></script>
<script src="assets/js/jquery.circle-progress.min.js"></script>
<script src="assets/js/jquery.magnific-popup.min.js"></script>
<script src="assets/js/isotope.js"></script>
<script src="assets/js/jquery.validate.min.js"></script>
<script src="assets/js/wNumb.min.js"></script>
<script src="assets/js/wow.js"></script>
<script src="assets/js/owl.carousel.min.js"></script>
<script src="assets/js/jquery-ui.js"></script>
<script src="assets/js/odometer.min.js"></script>
<script src="assets/js/jquery.nice-select.min.js"></script>
<script src="assets/js/jquery-sidebar-content.js"></script>
<script src="assets/js/marquee.min.js"></script>
<script src="assets/js/gsap/gsap.js"></script>
<script src="assets/js/gsap/ScrollTrigger.js"></script>
<script src="assets/js/gsap/SplitText.js"></script>
<script src="assets/js/aos.js"></script>

<!-- template js -->
<script src="assets/js/script.js"></script>

</body>

</html>