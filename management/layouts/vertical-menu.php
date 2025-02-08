<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">

            <div class="navbar-brand-box">
                <a href="index.php" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="../images/logo/logo-video.png" alt="" height="20">
                    </span>
                    <span class="logo-lg">
                        <img src="../images/logo/logo-video.png" alt="" height="60">
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
                    <img class="rounded-circle header-profile-user" src="assets/images/users/no-user.png" alt="Header Avatar">
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
                    <a href="seo-settings.php" class="waves-effect">
                        <i class="bx bx-cog"></i>
                        <span key="t-seo-settings">Seo Ayarları</span>
                    </a>
                </li>


                <li class="menu-title" key="t-pages">Otel Hizmeti</li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-hotel"></i>
                        <span key="t-customer">Otel Müşterileri</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="customer-add.php" key="t-customer-add">Müşteri Ekle</a></li>
                        <li><a href="customer.php" key="t-customer">Müşteriler</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-hotel"></i>
                        <span key="t-room">Otel Odaları</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="room-add.php" key="t-room-add">Oda Ekle</a></li>
                        <li><a href="room.php" key="t-room">Odalar</a></li>
                    </ul>
                </li>

                <li class="menu-title" key="t-pages">Servis ve Lastik Takip</li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-car"></i>
                        <span key="t-service">Servis</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="service-add.php" key="t-service-add">Servis Ekle</a></li>
                        <li><a href="service.php" key="t-service">Servisler</a></li>
                    </ul>
                </li>







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