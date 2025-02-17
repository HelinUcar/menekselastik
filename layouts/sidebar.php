  <!-- Start sidebar widget content -->
  <div class="xs-sidebar-group info-group info-sidebar">
    <div class="xs-overlay xs-bg-black"></div>
    <div class="xs-sidebar-widget">
      <div class="sidebar-widget-container">
        <div class="widget-heading">
          <a href="#" class="close-side-widget">X</a>
        </div>
        <div class="sidebar-textwidget">
          <div class="sidebar-info-contents">
            <div class="content-inner">
              <div class="logo">
                <a href="index.html"><img src="assets/images/resources/logo-1.png" alt="" /></a>
              </div>
              <div class="content-box">
                <h4>Bizi Tanıyın</h4>
                <p>
                  Menekşe Lastik, güvenli sürüş deneyimi için en kaliteli lastik ve jant hizmetlerini sunar. Lastik değişimi, jant düzeltme ve tamir hizmetlerimizle aracınıza en iyi bakımı sağlıyoruz.
                </p>
              </div>
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
              <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3056.5876998567774!2d32.7650029!3d39.9953183!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14d34bd29581fea7%3A0x42fda94fb9bbf3e!2zTUVORUvFnkUgTEFTVMSwSyBPVE9NLsSwTsWeLlRVWi5OQUsuIFBFVFJPTCBTQU4uVkUgVMSwQy5MVEQuxZ5UxLAu!5e0!3m2!1str!2str!4v1739178764809!5m2!1str!2str"
                class="google-map__two" style="height: 200px !important;"
                allowfullscreen></iframe>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- End sidebar widget content -->