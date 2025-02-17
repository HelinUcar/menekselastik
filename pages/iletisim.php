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
                        <h2>İletişim</h2>

                    </div>
                </div>
            </div>
        </section>
        <!--Page Header End-->



        <!--Contact Four Start-->
        <section class="contact-four">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6">
                        <div class="contact-four__left">
                            <div
                                class="section-title text-left sec-title-animation animation-style2">
                                <div class="section-title__tagline-box">
                                    <span class="section-title__tagline">İletişim</span>
                                </div>
                                <h2 class="section-title__title title-animation">
                                    Fast and Reliable Car Care <br />
                                    Your Car Our Priority
                                </h2>
                            </div>
                            <p class="contact-four__text">
                                Car service is essential for maintaining the performance and
                                longevity of your vehicle. From oil changes and tire rotations
                                to engine diagnostics and brake repairs, car service ensures
                                your safety on the road
                            </p>
                            <ul class="contact-four__contact-list list-unstyled">
                                <li>
                                    <div class="contact-four__contact-title-box">
                                        <div class="icon">
                                            <span class="icon-pin"></span>
                                        </div>
                                        <p>Address</p>
                                    </div>
                                    <h5>66 Broklyant,New India</h5>
                                </li>
                                <li>
                                    <div class="contact-four__contact-title-box">
                                        <div class="icon">
                                            <span class="icon-phone"></span>
                                        </div>
                                        <p>Phone Number</p>
                                    </div>
                                    <h5><a href="tel:0123456789101">012 345 678 9101</a></h5>
                                </li>
                                <li>
                                    <div class="contact-four__contact-title-box">
                                        <div class="icon">
                                            <span class="icon-mail"></span>
                                        </div>
                                        <p>Email</p>
                                    </div>
                                    <h5><a href="mailto:abcd@gmail.com">abcd@gmail.com</a></h5>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="contact-four__right">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3056.5876998567774!2d32.7650029!3d39.9953183!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14d34bd29581fea7%3A0x42fda94fb9bbf3e!2zTUVORUvFnkUgTEFTVMSwSyBPVE9NLsSwTsWeLlRVWi5OQUsuIFBFVFJPTCBTQU4uVkUgVMSwQy5MVEQuxZ5UxLAu!5e0!3m2!1str!2str!4v1739178764809!5m2!1str!2str"
                                class="google-map__two"
                                allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--Contact Four End-->

        <!--Contact Three Start-->
        <section class="contact-three mb-5">
            <div class="container">
                <div class="contact-three__inner">
                    <h3 class="contact-three__title">Appiontment Now</h3>
                    <form
                        class="contact-form-validated contact-three__form"
                        action="assets/inc/sendemail.php"
                        method="post"
                        novalidate="novalidate">
                        <div class="row">
                            <div class="col-xl-6 col-lg-6">
                                <div class="contact-three__input-box">
                                    <input
                                        type="text"
                                        name="name"
                                        placeholder="Your Name"
                                        required="" />
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6">
                                <div class="contact-three__input-box">
                                    <input
                                        type="email"
                                        name="email"
                                        placeholder="Your Email"
                                        required="" />
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6">
                                <div class="contact-three__input-box">
                                    <input
                                        type="text"
                                        name="Phone"
                                        placeholder="Phone"
                                        required="" />
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6">
                                <div class="contact-three__input-box">
                                    <div class="select-box">
                                        <select class="selectmenu wide">
                                            <option selected="selected">Choose a Option</option>
                                            <option>Type Of Service 01</option>
                                            <option>Type Of Service 02</option>
                                            <option>Type Of Service 03</option>
                                            <option>Type Of Service 04</option>
                                            <option>Type Of Service 05</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <div class="contact-three__input-box text-message-box">
                                    <textarea
                                        name="message"
                                        placeholder="Message here.."></textarea>
                                </div>
                                <div class="contact-three__btn-box">
                                    <button type="submit" class="thm-btn contact-three__btn">
                                        Appiontment Now
                                        <span class="icon-arrow-up-right"></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="result"></div>
                </div>
            </div>
        </section>
        <!--Contact Three End-->


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