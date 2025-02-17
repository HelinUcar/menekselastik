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

<body class="custom-cursor">
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

        <!--Page Header Start-->
        <section class="page-header">
            <div class="page-header__wrap">
                <div
                    class="page-header__shape-1"
                    style="
              background-image: url(assets/images/shapes/page-header-shape-1.png);
            "></div>
                <div class="container">
                    <div class="page-header__inner">
                        <div class="page-header__shape-2"></div>
                        <div class="page-header__shape-3"></div>
                        <div class="page-header__shape-4"></div>
                        <div class="page-header__img-1">
                            <img
                                src="assets/images/resources/page-header-img-1.png"
                                alt="" />
                            <div class="page-header__shape-5">
                                <img
                                    src="assets/images/shapes/page-header-shape-5.png"
                                    alt="" />
                            </div>
                        </div>
                        <h2>Hakkımızda</h2>
                        <div class="thm-breadcrumb__box">
                            <ul class="thm-breadcrumb list-unstyled">
                                <li>Kurumsal</li>
                                <li><span class="icon-angle-right"></span></li>
                                <li>Hizmetlerimiz</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--Page Header End-->

        <!--Counter One Start -->
        <section class="counter-one counter-three">
            <div class="container">
                <div class="counter-one__inner">
                    <ul class="list-unstyled counter-one__list">
                        <li class="wow fadeInLeft" data-wow-delay="100ms">
                            <div class="counter-one__single">
                                <div class="counter-one__count-box">
                                    <h3 class="odometer" data-count="600">00</h3>
                                    <span>+</span>
                                </div>
                                <p class="counter-one__text">Team member</p>
                            </div>
                        </li>
                        <li class="wow fadeInLeft" data-wow-delay="200ms">
                            <div class="counter-one__single">
                                <div class="counter-one__count-box">
                                    <h3 class="odometer" data-count="2">00</h3>
                                    <span>k+</span>
                                </div>
                                <p class="counter-one__text">Service Complete</p>
                            </div>
                        </li>
                        <li class="wow fadeInRight" data-wow-delay="300ms">
                            <div class="counter-one__single">
                                <div class="counter-one__count-box">
                                    <h3 class="odometer" data-count="53">00</h3>
                                    <span>+</span>
                                </div>
                                <p class="counter-one__text">Winning award</p>
                            </div>
                        </li>
                        <li class="wow fadeInRight" data-wow-delay="400ms">
                            <div class="counter-one__single">
                                <div class="counter-one__count-box">
                                    <h3 class="odometer" data-count="3">00</h3>
                                    <span>k+</span>
                                </div>
                                <p class="counter-one__text">Client Review</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </section>
        <!--Counter One End -->

        <!--About Five Start -->
        <section class="about-five">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6">
                        <div class="about-five__left">
                            <div
                                class="section-title text-left sec-title-animation animation-style2">
                                <div class="section-title__tagline-box">
                                    <span class="section-title__tagline">AboUt Us</span>
                                </div>
                                <h2 class="section-title__title title-animation">
                                    Fast and Reliable Car Care Your Car Our Priority
                                </h2>
                            </div>
                            <p class="about-five__text-1">
                                Car service is essential for maintaining the performance and
                                <br />
                                longevity of your vehicle. From oil changes
                            </p>
                            <ul class="list-unstyled about-five__points">
                                <li>
                                    <div class="icon">
                                        <span class="icon-double-arrow-right"></span>
                                    </div>
                                    <div class="text">
                                        <p>Fast and Reliable Car Care Your Car Our Priority</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="icon">
                                        <span class="icon-double-arrow-right"></span>
                                    </div>
                                    <div class="text">
                                        <p>Free with Our Services Care for Your Car</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="icon">
                                        <span class="icon-double-arrow-right"></span>
                                    </div>
                                    <div class="text">
                                        <p>Top-notch Care for Your Vehicle Your Vehicle</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="icon">
                                        <span class="icon-double-arrow-right"></span>
                                    </div>
                                    <div class="text">
                                        <p>Expert Service for Your Vehicle Drive Stress</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="icon">
                                        <span class="icon-double-arrow-right"></span>
                                    </div>
                                    <div class="text">
                                        <p>Your Trusted Car Service Provider Keeping</p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="about-five__right">
                            <div class="about-five__img-box">
                                <div class="about-five__img">
                                    <img
                                        src="assets/images/resources/about-five-img-1.jpg"
                                        alt="" />
                                </div>
                                <div class="about-five__shope-box">
                                    <div
                                        class="about-five__shope-box-bg-shape"
                                        style="
                        background-image: url(assets/images/shapes/about-five-shope-box-bg-shape.png);
                      "></div>
                                    <div class="about-five__shope-icon">
                                        <span class="icon-auto-machanic-shop"></span>
                                    </div>
                                    <h3 class="about-five__shope-title">Auto Mechanic Shop</h3>
                                    <p class="about-five__shope-text">
                                        Car service is essential for maintaining the performance
                                        and longevity Car service is essential maintaining
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--About Five End -->

        <!--Brand One Start -->
        <section class="brand-one">
            <div class="container">
                <div class="brand-one__inner">
                    <div class="brand-one__carousel owl-theme owl-carousel">
                        <!--Brand One Single Start-->
                        <div class="item">
                            <div class="brand-one__single">
                                <div class="brand-one__img">
                                    <img src="assets/images/brand/brand-1-1.png" alt="" />
                                </div>
                            </div>
                        </div>
                        <!--Brand One Single End-->
                        <!--Brand One Single Start-->
                        <div class="item">
                            <div class="brand-one__single">
                                <div class="brand-one__img">
                                    <img src="assets/images/brand/brand-1-2.png" alt="" />
                                </div>
                            </div>
                        </div>
                        <!--Brand One Single End-->
                        <!--Brand One Single Start-->
                        <div class="item">
                            <div class="brand-one__single">
                                <div class="brand-one__img">
                                    <img src="assets/images/brand/brand-1-3.png" alt="" />
                                </div>
                            </div>
                        </div>
                        <!--Brand One Single End-->
                        <!--Brand One Single Start-->
                        <div class="item">
                            <div class="brand-one__single">
                                <div class="brand-one__img">
                                    <img src="assets/images/brand/brand-1-4.png" alt="" />
                                </div>
                            </div>
                        </div>
                        <!--Brand One Single End-->
                        <!--Brand One Single Start-->
                        <div class="item">
                            <div class="brand-one__single">
                                <div class="brand-one__img">
                                    <img src="assets/images/brand/brand-1-5.png" alt="" />
                                </div>
                            </div>
                        </div>
                        <!--Brand One Single End-->
                    </div>
                </div>
            </div>
        </section>
        <!--Brand One End -->

        <!--Services Two Start -->
        <section class="services-two services-five">
            <div class="container">
                <div
                    class="section-title text-center sec-title-animation animation-style1">
                    <div class="section-title__tagline-box">
                        <span class="section-title__tagline">Latest service</span>
                    </div>
                    <h2 class="section-title__title title-animation">
                        The Car Doctor Service Easy Drive<br />
                        Maintenance Center
                    </h2>
                </div>
                <div class="row">
                    <!--Services Two Single Start-->
                    <div class="col-xl-4 col-lg-4 wow fadeInUp" data-wow-delay="100ms">
                        <div class="services-two__single">
                            <div class="services-two__icon">
                                <span class="icon-gearshift"></span>
                            </div>
                            <h3 class="services-two__title">
                                <a href="auto-pro-mechanic-shop.html">ProBuild Solutions</a>
                            </h3>
                            <p class="services-two__text">
                                Car service is essential for maintaining a the performance and
                                longevity service is essential for maintaining
                            </p>
                        </div>
                        <div class="services-two__single">
                            <div class="services-two__icon">
                                <span class="icon-wheels"></span>
                            </div>
                            <h3 class="services-two__title">
                                <a href="careful-car-service-station.html">Beyond Boundaries</a>
                            </h3>
                            <p class="services-two__text">
                                Car service is essential for maintaining a the performance and
                                longevity service is essential for maintaining
                            </p>
                        </div>
                    </div>
                    <!--Services Two Single End-->
                    <!--Services Two Single Start-->
                    <div class="col-xl-4 col-lg-4 wow fadeInUp" data-wow-delay="200ms">
                        <div class="services-two__img">
                            <img src="assets/images/team/team-two-img-1.png" alt="" />
                        </div>
                    </div>
                    <!--Services Two Single End-->
                    <!--Services Two Single Start-->
                    <div class="col-xl-4 col-lg-4 wow fadeInUp" data-wow-delay="300ms">
                        <div class="services-two__single">
                            <div class="services-two__icon">
                                <span class="icon-piston"></span>
                            </div>
                            <h3 class="services-two__title">
                                <a href="smooth-ride-vehicle-care.html">Prime Construction</a>
                            </h3>
                            <p class="services-two__text">
                                Car service is essential for maintaining a the performance and
                                longevity service is essential for maintaining
                            </p>
                        </div>
                        <div class="services-two__single">
                            <div class="services-two__icon">
                                <span class="icon-pressure"></span>
                            </div>
                            <h3 class="services-two__title">
                                <a href="elite-auto-services.html">Elite Builders</a>
                            </h3>
                            <p class="services-two__text">
                                Car service is essential for maintaining a the performance and
                                longevity service is essential for maintaining
                            </p>
                        </div>
                    </div>
                    <!--Services Two Single End-->
                </div>
            </div>
        </section>
        <!--Services Two End -->

        <!--Testimonial Two Start -->
        <section class="testimonial-two">
            <div class="testimonial-two__inner">
                <div class="testimonial-two__shape-1"></div>
                <div class="testimonial-two__shape-2">
                    <img
                        src="assets/images/shapes/testimonial-two-shape-2.png"
                        alt="" />
                </div>
                <div class="testimonial-two__shape-3">
                    <img
                        src="assets/images/shapes/testimonial-two-shape-3.png"
                        alt="" />
                </div>
                <div class="testimonial-two__shape-4">
                    <img
                        src="assets/images/shapes/testimonial-two-shape-4.png"
                        alt="" />
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-xl-6 col-lg-6">
                            <div class="testimonial-two__left">
                                <h3 class="testimonial-two__title">Clients Testimonial</h3>
                                <div class="testimonial-two__carousel owl-theme owl-carousel">
                                    <!--Testimonial Two Single Start -->
                                    <div class="item">
                                        <div class="testimonial-two__single">
                                            <div class="testimonial-two__quote">
                                                <i class="fal fa-quote-right"></i>
                                            </div>
                                            <div class="testimonial-two__name-box">
                                                <h4 class="testimonial-two__name">
                                                    <a href="testimonials.html">Kathryn Murphy</a>
                                                </h4>
                                                <p class="testimonial-two__sub-title">Web Designer</p>
                                            </div>
                                            <p class="testimonial-two__text">
                                                Car service is essential maintaining the performance
                                                and longevity your vehicle. From oil changes and tire
                                                rotations to engine diagnostics and brake repairs, car
                                                service
                                            </p>
                                        </div>
                                    </div>
                                    <!--Testimonial Two Single End -->
                                    <!--Testimonial Two Single Start -->
                                    <div class="item">
                                        <div class="testimonial-two__single">
                                            <div class="testimonial-two__quote">
                                                <i class="fal fa-quote-right"></i>
                                            </div>
                                            <div class="testimonial-two__name-box">
                                                <h4 class="testimonial-two__name">
                                                    <a href="testimonials.html">Kathryn Murphy</a>
                                                </h4>
                                                <p class="testimonial-two__sub-title">Web Designer</p>
                                            </div>
                                            <p class="testimonial-two__text">
                                                Car service is essential maintaining the performance
                                                and longevity your vehicle. From oil changes and tire
                                                rotations to engine diagnostics and brake repairs, car
                                                service
                                            </p>
                                        </div>
                                    </div>
                                    <!--Testimonial Two Single End -->
                                    <!--Testimonial Two Single Start -->
                                    <div class="item">
                                        <div class="testimonial-two__single">
                                            <div class="testimonial-two__quote">
                                                <i class="fal fa-quote-right"></i>
                                            </div>
                                            <div class="testimonial-two__name-box">
                                                <h4 class="testimonial-two__name">
                                                    <a href="testimonials.html">Kathryn Murphy</a>
                                                </h4>
                                                <p class="testimonial-two__sub-title">Web Designer</p>
                                            </div>
                                            <p class="testimonial-two__text">
                                                Car service is essential maintaining the performance
                                                and longevity your vehicle. From oil changes and tire
                                                rotations to engine diagnostics and brake repairs, car
                                                service
                                            </p>
                                        </div>
                                    </div>
                                    <!--Testimonial Two Single End -->
                                    <!--Testimonial Two Single Start -->
                                    <div class="item">
                                        <div class="testimonial-two__single">
                                            <div class="testimonial-two__quote">
                                                <i class="fal fa-quote-right"></i>
                                            </div>
                                            <div class="testimonial-two__name-box">
                                                <h4 class="testimonial-two__name">
                                                    <a href="testimonials.html">Kathryn Murphy</a>
                                                </h4>
                                                <p class="testimonial-two__sub-title">Web Designer</p>
                                            </div>
                                            <p class="testimonial-two__text">
                                                Car service is essential maintaining the performance
                                                and longevity your vehicle. From oil changes and tire
                                                rotations to engine diagnostics and brake repairs, car
                                                service
                                            </p>
                                        </div>
                                    </div>
                                    <!--Testimonial Two Single End -->
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6">
                            <div class="testimonial-two__right">
                                <div
                                    class="testimonial-two__img wow fadeInUp"
                                    data-wow-delay="100ms">
                                    <img
                                        src="assets/images/testimonial/testimonial-two-img-1.png"
                                        alt="" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--Testimonial Two End -->

        <!--Pricing Three Start -->
        <section class="pricing-three">
            <div class="container">
                <div
                    class="section-title text-center sec-title-animation animation-style1">
                    <div class="section-title__tagline-box">
                        <span class="section-title__tagline">Pricing Plan</span>
                    </div>
                    <h2 class="section-title__title title-animation">
                        Our Pricing Plan
                    </h2>
                </div>
                <div class="pricing-three__main-tab-box tabs-box">
                    <ul class="tab-buttons list-unstyled">
                        <li data-tab="#monthly" class="tab-btn active-btn">
                            <span>Monthly</span>
                        </li>
                        <li data-tab="#yearly" class="tab-btn"><span>Yearly</span></li>
                    </ul>
                    <div class="tabs-content">
                        <!--tab-->
                        <div class="tab active-tab" id="monthly">
                            <div class="pricing-three__inner">
                                <div class="row">
                                    <!--Pricing Three Single Start -->
                                    <div class="col-xl-4 col-lg-4">
                                        <div class="pricing-three__single">
                                            <div
                                                class="pricing-three__single-bg-shape"
                                                style="
                            background-image: url(assets/images/shapes/pricing-three-single-bg-shape.png);
                          "></div>
                                            <div class="pricing-three__title-box">
                                                <h2 class="pricing-three__title">Esay</h2>
                                                <p class="pricing-three__text">
                                                    Car service is essential for maintaining performance
                                                    and longevity of vehicle. From oil changes
                                                </p>
                                            </div>
                                            <div class="pricing-three__price-and-icon-box">
                                                <div class="pricing-three__price-box">
                                                    <h3 class="pricing-three__price">
                                                        $10 <span>/month</span>
                                                    </h3>
                                                </div>
                                            </div>
                                            <ul class="list-unstyled pricing-three__points">
                                                <li>
                                                    <div class="icon">
                                                        <span class="icon-double-arrow-right"></span>
                                                    </div>
                                                    <div class="text">
                                                        <p>Mistakes To Avoid</p>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="icon">
                                                        <span class="icon-double-arrow-right"></span>
                                                    </div>
                                                    <div class="text">
                                                        <p>Winning for Your Startup</p>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="icon">
                                                        <span class="icon-double-arrow-right"></span>
                                                    </div>
                                                    <div class="text">
                                                        <p>Mistakes To Avoid</p>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="icon">
                                                        <span class="icon-double-arrow-right"></span>
                                                    </div>
                                                    <div class="text">
                                                        <p>Your Event, Your Memories</p>
                                                    </div>
                                                </li>
                                            </ul>
                                            <div class="pricing-three__btn-box">
                                                <a href="pricing.html" class="thm-btn">Get Started Now<span
                                                        class="icon-arrow-up-right"></span></a>
                                            </div>
                                        </div>
                                    </div>
                                    <!--Pricing Three Single Start -->
                                    <!--Pricing Three Single Start -->
                                    <div class="col-xl-4 col-lg-4">
                                        <div class="pricing-three__single">
                                            <div
                                                class="pricing-three__single-bg-shape"
                                                style="
                            background-image: url(assets/images/shapes/pricing-three-single-bg-shape.png);
                          "></div>
                                            <div class="pricing-three__title-box">
                                                <h2 class="pricing-three__title">Free</h2>
                                                <p class="pricing-three__text">
                                                    Car service is essential for maintaining performance
                                                    and longevity of vehicle. From oil changes
                                                </p>
                                            </div>
                                            <div class="pricing-three__price-and-icon-box">
                                                <div class="pricing-three__price-box">
                                                    <h3 class="pricing-three__price">
                                                        $0 <span>/month</span>
                                                    </h3>
                                                </div>
                                            </div>
                                            <ul class="list-unstyled pricing-three__points">
                                                <li>
                                                    <div class="icon">
                                                        <span class="icon-double-arrow-right"></span>
                                                    </div>
                                                    <div class="text">
                                                        <p>Mistakes To Avoid</p>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="icon">
                                                        <span class="icon-double-arrow-right"></span>
                                                    </div>
                                                    <div class="text">
                                                        <p>Winning for Your Startup</p>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="icon">
                                                        <span class="icon-double-arrow-right"></span>
                                                    </div>
                                                    <div class="text">
                                                        <p>Mistakes To Avoid</p>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="icon">
                                                        <span class="icon-double-arrow-right"></span>
                                                    </div>
                                                    <div class="text">
                                                        <p>Your Event, Your Memories</p>
                                                    </div>
                                                </li>
                                            </ul>
                                            <div class="pricing-three__btn-box">
                                                <a href="pricing.html" class="thm-btn">Get Started Now<span
                                                        class="icon-arrow-up-right"></span></a>
                                            </div>
                                        </div>
                                    </div>
                                    <!--Pricing Three Single Start -->
                                    <!--Pricing Three Single Start -->
                                    <div class="col-xl-4 col-lg-4">
                                        <div class="pricing-three__single">
                                            <div
                                                class="pricing-three__single-bg-shape"
                                                style="
                            background-image: url(assets/images/shapes/pricing-three-single-bg-shape.png);
                          "></div>
                                            <div class="pricing-three__title-box">
                                                <h2 class="pricing-three__title">Free</h2>
                                                <p class="pricing-three__text">
                                                    Car service is essential for maintaining performance
                                                    and longevity of vehicle. From oil changes
                                                </p>
                                            </div>
                                            <div class="pricing-three__price-and-icon-box">
                                                <div class="pricing-three__price-box">
                                                    <h3 class="pricing-three__price">
                                                        $30 <span>/month</span>
                                                    </h3>
                                                </div>
                                            </div>
                                            <ul class="list-unstyled pricing-three__points">
                                                <li>
                                                    <div class="icon">
                                                        <span class="icon-double-arrow-right"></span>
                                                    </div>
                                                    <div class="text">
                                                        <p>Mistakes To Avoid</p>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="icon">
                                                        <span class="icon-double-arrow-right"></span>
                                                    </div>
                                                    <div class="text">
                                                        <p>Winning for Your Startup</p>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="icon">
                                                        <span class="icon-double-arrow-right"></span>
                                                    </div>
                                                    <div class="text">
                                                        <p>Mistakes To Avoid</p>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="icon">
                                                        <span class="icon-double-arrow-right"></span>
                                                    </div>
                                                    <div class="text">
                                                        <p>Your Event, Your Memories</p>
                                                    </div>
                                                </li>
                                            </ul>
                                            <div class="pricing-three__btn-box">
                                                <a href="pricing.html" class="thm-btn">Get Started Now<span
                                                        class="icon-arrow-up-right"></span></a>
                                            </div>
                                        </div>
                                    </div>
                                    <!--Pricing Three Single Start -->
                                </div>
                            </div>
                        </div>
                        <!--tab-->
                        <div class="tab" id="yearly">
                            <div class="pricing-three__inner">
                                <div class="row">
                                    <!--Pricing Three Single Start -->
                                    <div class="col-xl-4 col-lg-4">
                                        <div class="pricing-three__single">
                                            <div
                                                class="pricing-three__single-bg-shape"
                                                style="
                            background-image: url(assets/images/shapes/pricing-three-single-bg-shape.png);
                          "></div>
                                            <div class="pricing-three__title-box">
                                                <h2 class="pricing-three__title">Esay</h2>
                                                <p class="pricing-three__text">
                                                    Car service is essential for maintaining performance
                                                    and longevity of vehicle. From oil changes
                                                </p>
                                            </div>
                                            <div class="pricing-three__price-and-icon-box">
                                                <div class="pricing-three__price-box">
                                                    <h3 class="pricing-three__price">
                                                        $10 <span>/month</span>
                                                    </h3>
                                                </div>
                                            </div>
                                            <ul class="list-unstyled pricing-three__points">
                                                <li>
                                                    <div class="icon">
                                                        <span class="icon-double-arrow-right"></span>
                                                    </div>
                                                    <div class="text">
                                                        <p>Mistakes To Avoid</p>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="icon">
                                                        <span class="icon-double-arrow-right"></span>
                                                    </div>
                                                    <div class="text">
                                                        <p>Winning for Your Startup</p>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="icon">
                                                        <span class="icon-double-arrow-right"></span>
                                                    </div>
                                                    <div class="text">
                                                        <p>Mistakes To Avoid</p>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="icon">
                                                        <span class="icon-double-arrow-right"></span>
                                                    </div>
                                                    <div class="text">
                                                        <p>Your Event, Your Memories</p>
                                                    </div>
                                                </li>
                                            </ul>
                                            <div class="pricing-three__btn-box">
                                                <a href="pricing.html" class="thm-btn">Get Started Now<span
                                                        class="icon-arrow-up-right"></span></a>
                                            </div>
                                        </div>
                                    </div>
                                    <!--Pricing Three Single Start -->
                                    <!--Pricing Three Single Start -->
                                    <div class="col-xl-4 col-lg-4">
                                        <div class="pricing-three__single">
                                            <div
                                                class="pricing-three__single-bg-shape"
                                                style="
                            background-image: url(assets/images/shapes/pricing-three-single-bg-shape.png);
                          "></div>
                                            <div class="pricing-three__title-box">
                                                <h2 class="pricing-three__title">Free</h2>
                                                <p class="pricing-three__text">
                                                    Car service is essential for maintaining performance
                                                    and longevity of vehicle. From oil changes
                                                </p>
                                            </div>
                                            <div class="pricing-three__price-and-icon-box">
                                                <div class="pricing-three__price-box">
                                                    <h3 class="pricing-three__price">
                                                        $0 <span>/month</span>
                                                    </h3>
                                                </div>
                                            </div>
                                            <ul class="list-unstyled pricing-three__points">
                                                <li>
                                                    <div class="icon">
                                                        <span class="icon-double-arrow-right"></span>
                                                    </div>
                                                    <div class="text">
                                                        <p>Mistakes To Avoid</p>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="icon">
                                                        <span class="icon-double-arrow-right"></span>
                                                    </div>
                                                    <div class="text">
                                                        <p>Winning for Your Startup</p>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="icon">
                                                        <span class="icon-double-arrow-right"></span>
                                                    </div>
                                                    <div class="text">
                                                        <p>Mistakes To Avoid</p>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="icon">
                                                        <span class="icon-double-arrow-right"></span>
                                                    </div>
                                                    <div class="text">
                                                        <p>Your Event, Your Memories</p>
                                                    </div>
                                                </li>
                                            </ul>
                                            <div class="pricing-three__btn-box">
                                                <a href="pricing.html" class="thm-btn">Get Started Now<span
                                                        class="icon-arrow-up-right"></span></a>
                                            </div>
                                        </div>
                                    </div>
                                    <!--Pricing Three Single Start -->
                                    <!--Pricing Three Single Start -->
                                    <div class="col-xl-4 col-lg-4">
                                        <div class="pricing-three__single">
                                            <div
                                                class="pricing-three__single-bg-shape"
                                                style="
                            background-image: url(assets/images/shapes/pricing-three-single-bg-shape.png);
                          "></div>
                                            <div class="pricing-three__title-box">
                                                <h2 class="pricing-three__title">Free</h2>
                                                <p class="pricing-three__text">
                                                    Car service is essential for maintaining performance
                                                    and longevity of vehicle. From oil changes
                                                </p>
                                            </div>
                                            <div class="pricing-three__price-and-icon-box">
                                                <div class="pricing-three__price-box">
                                                    <h3 class="pricing-three__price">
                                                        $30 <span>/month</span>
                                                    </h3>
                                                </div>
                                            </div>
                                            <ul class="list-unstyled pricing-three__points">
                                                <li>
                                                    <div class="icon">
                                                        <span class="icon-double-arrow-right"></span>
                                                    </div>
                                                    <div class="text">
                                                        <p>Mistakes To Avoid</p>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="icon">
                                                        <span class="icon-double-arrow-right"></span>
                                                    </div>
                                                    <div class="text">
                                                        <p>Winning for Your Startup</p>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="icon">
                                                        <span class="icon-double-arrow-right"></span>
                                                    </div>
                                                    <div class="text">
                                                        <p>Mistakes To Avoid</p>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="icon">
                                                        <span class="icon-double-arrow-right"></span>
                                                    </div>
                                                    <div class="text">
                                                        <p>Your Event, Your Memories</p>
                                                    </div>
                                                </li>
                                            </ul>
                                            <div class="pricing-three__btn-box">
                                                <a href="pricing.html" class="thm-btn">Get Started Now<span
                                                        class="icon-arrow-up-right"></span></a>
                                            </div>
                                        </div>
                                    </div>
                                    <!--Pricing Three Single Start -->
                                </div>
                            </div>
                        </div>
                        <!--tab-->
                    </div>
                </div>
            </div>
        </section>
        <!--Pricing Three End -->


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


</body>