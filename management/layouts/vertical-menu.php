<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">

            <div class="navbar-brand-box">
                <a href="index.php" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="assets/images/favicon.png" alt="" height="30">
                    </span>
                    <span class="logo-lg">
                        <img src="assets/images/logo-1.png" alt="" height="35">
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect" id="vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>

        </div>

        <div class="d-flex">


            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="<?= $_SESSION['userphoto'] ?>" alt="Header Avatar">
                    <span class="d-none d-xl-inline-block ms-1" key="t-henry"><?php echo ucfirst($_SESSION["username"] . ' ' . $_SESSION["usersurname"]); ?></span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item" href="profile.php"><i class="bx bx-user font-size-16 align-middle me-1"></i> <span key="t-profile">Profil</span></a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="logout.php"><i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> <span key="t-logout">Çıkış Yap</span></a>
                </div>
            </div>



        </div>
    </div>
</header>


<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <div id="sidebar-menu">

            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" key="t-menu">Menü</li>

                <li>
                    <a href="index.php" class="waves-effect">
                        <i class="bx bx-home-circle"></i>
                        <span key="t-dashboard">Anasayfa</span>
                    </a>
                </li>



                <li class="menu-title" key="t-apps">İçerikler</li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bxs-user-detail"></i>
                        <span key="t-user">Site Yöneticileri</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="panel-user-add.php" key="t-panel-user-add">Panel Üyesi Ekle</a></li>
                        <li><a href="panel-user.php" key="t-panel-user">Panel Üyeleri</a></li>
                    </ul>
                </li>



                <li>
                    <a href="home-page.php" class="waves-effect">
                        <i class="bx bx-home-circle"></i>
                        <span key="t-home-page">Anasayfa Ayarları</span>
                    </a>
                </li>

                <li>
                    <a href="seo-settings.php" class="waves-effect">
                        <i class="bx bx-cog"></i>
                        <span key="t-seo-settings">Seo Ayarları</span>
                    </a>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-news"></i>
                        <span key="t-services">Hizmetler</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="services-add.php" key="t-services-add">Hizmet Ekle</a></li>
                        <li><a href="services.php" key="t-services">Hizmet Listesi</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-news"></i>
                        <span key="t-news">Kampanyalar</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="news-add.php" key="t-news-add">Kampanya Ekle</a></li>
                        <li><a href="news.php" key="t-news">Kampanya Listesi</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-aperture"></i>
                        <span key="t-tires">Lastikler</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="tires-add.php" key="t-tires-add">Lastik Ekle</a></li>
                        <li><a href="tires.php" key="t-tires">Lastik Listesi</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-aperture"></i>
                        <span key="t-rims">Jantlar</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="rims-add.php" key="t-rims-add">Jant Ekle</a></li>
                        <li><a href="rims.php" key="t-rims">Jant Listesi</a></li>
                    </ul>
                </li>

                <!-- <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="mdi mdi-car-battery"></i>
                        <span key="t-batteries">Aküler</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="batteries-add.php" key="t-batteries-add">Akü Ekle</a></li>
                        <li><a href="batteries.php" key="t-batteries">Akü Listesi</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-broadcast"></i>
                        <span key="t-sensors">Sensörler</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="sensors-add.php" key="t-sensors-add">Sensör Ekle</a></li>
                        <li><a href="sensors.php" key="t-sensors">Sensör Listesi</a></li>
                    </ul>
                </li> -->
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="mdi mdi-newspaper-variant-multiple"></i>
                        <span key="t-ads">İlanlar(eklenecek)</span>
                    </a>
                    <!-- <ul class="sub-menu" aria-expanded="false">
                        <li><a href="ads-add.php" key="t-ads-add">İlan Ekle (eklenecek)</a></li>
                        <li><a href="ads.php" key="t-ads">İlan Listesi</a></li>
                    </ul> -->
                </li>


                <li class="menu-title" key="t-pages">Otel Hizmeti</li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-hotel"></i>
                        <span key="t-customer">Otel Müşterileri (eklenecek)</span>
                    </a>
                    <!-- <ul class="sub-menu" aria-expanded="false">
                        <li><a href="customer-add.php" key="t-customer-add">Müşteri Ekle</a></li>
                        <li><a href="customers.php" key="t-customer">Müşteri Listesi</a></li>
                    </ul> -->
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-hotel"></i>
                        <span key="t-room">Otel Odaları (eklenecek)</span>
                    </a>
                    <!-- <ul class="sub-menu" aria-expanded="false">
                        <li><a href="room-add.php" key="t-room-add">Oda Ekle</a></li>
                        <li><a href="rooms.php" key="t-room">Oda Listesi</a></li>
                    </ul> -->
                </li>

                <!-- <li class="menu-title" key="t-pages">Servis ve Lastik Takip</li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-car"></i>
                        <span key="t-service">Servis</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="process-add.php" key="t-service-add">Servis Ekle</a></li>
                        <li><a href="processes.php" key="t-service">Servis Listesi</a></li>
                    </ul>
                </li> -->


                <li class="menu-title" key="t-pages"></li>
                <li>
                    <a href="logout.php" class="waves-effect">
                        <i class="bx bx-log-out-circle"></i>
                        <span key="t-log-out">Çıkış Yap</span>
                    </a>

                </li>

            </ul>
        </div>
    </div>
</div>