<?php
header("content-type:text/html;charset=utf8");
define("Secure-MENEKSELASTIK-2025@!", true);
define("SITE", "pages/");
define("COMPONENTS", "components/");
require("components/config.php");

ob_start();
session_start();


// URL'den aktif sayfayı belirle
$currentPage = 'anasayfa';

if (!empty($_GET['p'])) {
    // sadece ilk segmenti al (lastik/blizzak → lastik)
    $segments = explode('/', $_GET['p']);
    $currentPage = $segments[0];
}




// Tarayıcı önbelleğini devre dışı bırakmak için bu başlıkları ekleyin
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Access-Control-Allow-Origin: *");
header("Pragma: no-cache");
header("Expires: 0");
?>
<!DOCTYPE html>
<html lang="tr">

<base href="http://localhost/menekselastik2/">

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
    <link rel="stylesheet" href="assets/css/master.css" />


    <link href="assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />

    <link href="assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />






    <?php
    if ($_GET && !empty($_GET["p"])) {
        $p = htmlspecialchars(trim($_GET["p"] . ".php"));
        if (file_exists(SITE . $p)) {

            include_once(SITE . $p);
        } else {
            include("pages/404.php");
        }
    } else {

        include("pages/anasayfa.php");
    }
    ?>


    <?php include 'layouts/footer.php'; ?>


    <!-- ++++++++++++-->
    <!-- MAIN SCRIPTS-->
    <!-- ++++++++++++-->
    <script src="assets/libs/jquery-1.12.4.min.js"></script>
    <script src="assets/libs/jquery-migrate-1.2.1.js"></script>
    <!-- Bootstrap-->
    <script src="assets/libs/bootstrap/bootstrap.min.js"></script>
    <!-- User customization-->
    <script src="assets/js/custom.js"></script>
    <!-- Headers scripts-->
    <script src="assets/plugins/headers/slidebar.js"></script>
    <script src="assets/plugins/headers/header.js"></script>
    <!-- Color scheme-->
    <script src="assets/plugins/switcher/js/dmss.js"></script>
    <!-- Select customization & Color scheme-->
    <script src="assets/plugins/bootstrap-select/js/bootstrap-select.min.js"></script>
    <!-- Slider-->
    <script src="assets/plugins/owl-carousel/owl.carousel.min.js"></script>
    <!-- Pop-up window-->
    <script src="assets/plugins/magnific-popup/jquery.magnific-popup.min.js"></script>
    <!-- Mail scripts-->
    <script src="assets/plugins/jqBootstrapValidation.js"></script>
    
    <!-- Filter and sorting images-->
    <script src="assets/plugins/isotope/isotope.pkgd.min.js"></script>
    <script src="assets/plugins/isotope/imagesLoaded.js"></script>
    <!-- Progress numbers-->
    <script src="assets/plugins/rendro-easy-pie-chart/jquery.easypiechart.min.js"></script>
    <script src="assets/plugins/rendro-easy-pie-chart/waypoints.min.js"></script>
    <!-- NoUiSlider-->
    <script src="assets/plugins/noUiSlider/nouislider.min.js"></script>
    <script src="assets/plugins/noUiSlider/wNumb.js"></script>
    <!-- Animations-->
    <script src="assets/plugins/scrollreveal/scrollreveal.min.js"></script>
    <!-- Main slider-->
    <script src="assets/plugins/slider-pro/jquery.sliderPro.min.js"></script>
    <!-- Datepicker-->
    <script src="assets/plugins/datepicker/jquery.datetimepicker.js"></script>


    <!-- Required datatable js -->
    <script src="assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <!-- Buttons examples -->
    <script src="assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
    <script src="assets/libs/jszip/jszip.min.js"></script>
    <script src="assets/libs/pdfmake/build/pdfmake.min.js"></script>
    <script src="assets/libs/pdfmake/build/vfs_fonts.js"></script>
    <script src="assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="assets/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>

    <!-- Responsive examples -->
    <script src="assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

    <!-- Datatable init js -->
    <script src="assets/js/pages/datatables.init.js"></script>


    </body>

</html>