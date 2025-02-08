<div class="mobile-nav__wrapper">
    <div class="mobile-nav__overlay mobile-nav__toggler"></div>
    <!-- /.mobile-nav__overlay -->
    <div class="mobile-nav__content">
        <span class="mobile-nav__close mobile-nav__toggler"><i class="fa fa-times"></i></span>

        <div class="logo-box">
            <a href="index.html" aria-label="logo image"><img src="assets/images/resources/logo-1.png" width="135" alt="" /></a>
        </div>
        <!-- /.logo-box -->
        <div class="mobile-nav__container"></div>
        <!-- /.mobile-nav__container -->

        <ul class="mobile-nav__contact list-unstyled">
            <li>
                <i class="fa fa-envelope"></i>
                <a href="mailto:<?= $seo_settings_arr['email'] ?>"><?= $seo_settings_arr['email'] ?></a>
            </li>
            <li>
                <?php
                // Veritabanından çekilen numara
                $phone = $seo_settings_arr['whatsapp'];

                // Telefon numarasındaki gereksiz karakterleri temizle
                $clean_phone = preg_replace("/[^0-9]/", "", $phone);

                // WhatsApp için uygun hale getirme (başına + ekleme)
                $whatsapp_link = "https://wa.me/" . $clean_phone; ?>
                <i class="fab fa-whatsapp"></i>
                <a href="<?= $whatsapp_link ?>" target="_blank"><?= $seo_settings_arr['whatsapp'] ?></a>
            </li>
            <li>
                <i class="fas fa-phone"></i>
                <a href="tel:<?= $seo_settings_arr['phone'] ?>"><?= $seo_settings_arr['phone'] ?></a>
            </li>
            <li>
                <i class="fas fa-phone"></i>
                <a href="tel:<?= $seo_settings_arr['whatsapp'] ?>"><?= $seo_settings_arr['whatsapp'] ?></a>
            </li>



        </ul>
        <!-- /.mobile-nav__contact -->
        <div class="mobile-nav__top">
            <div class="mobile-nav__social">
                <a href="<?= $seo_settings_arr['facebook'] ?>" target="_blank" class="fab fa-facebook-square"></a>
                <a href="<?= $seo_settings_arr['instagram'] ?>" target="_blank" class="fab fa-instagram"></a>
            </div>
            <!-- /.mobile-nav__social -->
        </div>
        <!-- /.mobile-nav__top -->
    </div>
    <!-- /.mobile-nav__content -->
</div>
<!-- /.mobile-nav__wrapper -->