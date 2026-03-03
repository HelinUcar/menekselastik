<header class="header header-boxed-width navbar-fixed-top header-background-white header-color-black header-topbar-dark header-logo-black header-topbarbox-1-left header-topbarbox-2-right header-navibox-1-left header-navibox-2-right header-navibox-3-right header-navibox-4-right">
    <div class="container container-boxed-width">
        <nav class="navbar" id="nav">
            <div class="container">
                <div class="header-navibox-1">
                    <!-- Mobile Trigger Start-->
                    <button class="menu-mobile-button visible-xs-block js-toggle-mobile-slidebar toggle-menu-button">
                        <i class="toggle-menu-button-icon"><span></span><span></span><span></span><span></span><span></span><span></span></i>
                    </button>
                    <!-- Mobile Trigger End-->
                    <a class="navbar-brand scroll" href="/">
                        <img class="normal-logo img-responsive" src="assets/media/general/logo.png" alt="logo" />
                        <img class="scroll-logo hidden-xs img-responsive" src="assets/media/general/logo-dark.png" alt="logo" />
                    </a>
                </div>

                <div class="header-navibox-2">
                    <ul class="yamm main-menu nav navbar-nav">
                        <li class="<?= ($currentPage === 'anasayfa' || $currentPage === 'index') ? 'active' : '' ?>">
                            <a href="anasayfa">Anasayfa</a>
                        </li>

                        <li class="dropdown <?= in_array($currentPage, ['hakkimizda', 'hizmetlerimiz'], true) ? 'active' : '' ?>">
                            <a class="dropdown-toggle" href="hakkimizda" data-toggle="dropdown">
                                Kurumsal<b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li class="<?= ($currentPage === 'hakkimizda') ? 'active' : '' ?>">
                                    <a href="hakkimizda" tabindex="-1">Hakkımızda</a>
                                </li>
                                <li class="<?= ($currentPage === 'hizmetlerimiz') ? 'active' : '' ?>">
                                    <a href="hizmetlerimiz" tabindex="-1">Hizmetlerimiz</a>
                                </li>
                            </ul>
                        </li>

                        <li class="<?= in_array($currentPage, ['lastikler', 'lastik'], true) ? 'active' : '' ?>">
                            <a href="lastikler">Lastikler</a>
                        </li>

                        <li class="<?= ($currentPage === 'jantlar') ? 'active' : '' ?>">
                            <a href="jantlar">Jantlar</a>
                        </li>

                        <!-- <li class="<?= ($currentPage === 'ilanlar') ? 'active' : '' ?>">
                            <a href="ilanlar">İlanlar</a>
                        </li> -->

                        <li class="<?= ($currentPage === 'kampanyalar') ? 'active' : '' ?>">
                            <a href="kampanyalar">Kampanyalar</a>
                        </li>

                        <li class="<?= ($currentPage === 'iletisim') ? 'active' : '' ?>">
                            <a href="iletisim">İletişim</a>
                        </li>
                    </ul>

                    <a class="btn btn-primary" href="tel:<?= $seo_settings_arr['phone'] ?>">
                        <?= $seo_settings_arr['phone'] ?>
                    </a>
                </div>
            </div>
        </nav>
    </div>
</header>