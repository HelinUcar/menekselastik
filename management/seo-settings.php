<?php include 'layouts/session.php'; ?>
<?php
// Include config file
require_once "layouts/config.php";

// Define variables and initialize with empty values

$site_title_err = $site_desc_err = $site_keywords_err = $google_key_err = $yandex_key_err = $whatsapp_number = $whatsapp_number_err = $place_id_err =
    $facebook_url_err = $instagram_url_err  = $site_email_err = $site_phone_err = $logo_text_err = $name_prefix_err = $csfr_err = $google_api_key_err = "";
//check if the last information is already in the database 
$sql = "SELECT * FROM seo_settings ORDER BY id DESC LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$seo = $stmt->fetch(PDO::FETCH_ASSOC);
if ($seo) {
    $id = $seo['id'];
    $site_title = $seo['title'];
    $site_desc = $seo['description'];
    $site_keywords = $seo['keywords'];
    $google_key = $seo['google_verify'];
    $yandex_key = $seo['yandex_verify'];
    $google_api_key = $seo['google_api_key'];
    $place_id = $seo['place_id'];
    $whatsapp_number = $seo['whatsapp'];
    $facebook_url = $seo['facebook'];
    $instagram_url = $seo['instagram'];
    $site_email = $seo['email'];
    $site_phone = $seo['phone'];
    $logo_text = $seo['logo_text'];
    $name_prefix = $seo['name_prefix'];
} else {
    $site_title = $site_desc = $site_keywords = $google_key = $yandex_key = $facebook_url = $instagram_url = $site_email = $site_phone = $logo_text = $name_prefix = $whatsapp_number = $google_api_key = $place_id = "";
}


// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['seo_id'];

    // Check CSRF token
    if (!isset($_POST['csrf_token']) || !validate_csrf_token($_POST['csrf_token'])) {
        $csfr_err = "Geçersiz CSRF token! İşlem iptal edildi.";
    }
    if (!empty($id)) {
        // Validate site title
        $input_site_title = sanitize_input($_POST["site_title"]);
        if (empty($input_site_title)) {
            $site_title_err = "Lütfen başlığı giriniz.";
        } else {
            $site_title = $input_site_title;
        }

        // Validate site desc
        $input_site_desc = sanitize_input($_POST["site_desc"]);
        if (empty($input_site_desc)) {
            $site_desc_err = "Lütfen açıklamayı giriniz.";
        } else {
            $site_desc = $input_site_desc;
        }

        // Validate site keywords
        $input_site_keywords = sanitize_input($_POST["site_keywords"]);
        if (empty($input_site_keywords)) {
            $site_keywords_err = "Lütfen anahtar kelimeleri giriniz.";
        } else {
            $site_keywords = $input_site_keywords;
        }

        // Validate google key
        $input_google_key = sanitize_input($_POST["google_key"]);
        if (empty($input_google_key)) {
            $google_key_err = "Lütfen google key giriniz.";
        } else {
            $google_key = $input_google_key;
        }

        // Validate yandex key
        $input_yandex_key = sanitize_input($_POST["yandex_key"]);
        if (empty($input_yandex_key)) {
            $yandex_key_err = "Lütfen yandex key giriniz.";
        } else {
            $yandex_key = $input_yandex_key;
        }


        // Validate google api key
        $input_google_api_key = sanitize_input($_POST["google_api_key"]);
        if (empty($input_google_api_key)) {
            $google_api_key_err = "Lütfen google api key giriniz.";
        } else {
            $google_api_key = $input_google_api_key;
        }

        // Validate place id
        $input_place_id = sanitize_input($_POST["place_id"]);
        if (empty($input_place_id)) {
            $place_id_err = "Lütfen place id giriniz.";
        } else {
            $place_id = $input_place_id;
        }


        // Validate facebook url
        $input_facebook_url = sanitize_input($_POST["facebook_url"]);
        if (empty($input_facebook_url)) {
            $facebook_url_err = "Lütfen facebook url giriniz.";
        } else {
            $facebook_url = $input_facebook_url;
        }

        // Validate instagram url
        $input_instagram_url = sanitize_input($_POST["instagram_url"]);
        if (empty($input_instagram_url)) {
            $instagram_url_err = "Lütfen instagram url giriniz.";
        } else {
            $instagram_url = $input_instagram_url;
        }



        // Validate email
        $input_site_email = sanitize_input($_POST["site_email"]);
        if (empty($input_site_email)) {
            $site_email_err = "Lütfen email giriniz.";
        } else {
            $site_email = $input_site_email;
        }

        // Validate phone
        $input_site_phone = sanitize_input($_POST["site_phone"]);
        if (empty($input_site_phone)) {
            $site_phone_err = "Lütfen telefon giriniz.";
        } else {
            $site_phone = $input_site_phone;
        }

        //Validate whatsapp number
        $input_whatsapp_number = sanitize_input($_POST["whatsapp_number"]);
        if (empty($input_whatsapp_number)) {
            $whatsapp_number_err = "Lütfen whatsapp numarası giriniz.";
        } else {
            $whatsapp_number = $input_whatsapp_number;
        }

        // Validate logo text
        $input_logo_text = sanitize_input($_POST["logo_text"]);
        if (empty($input_logo_text)) {
            $logo_text_err = "Lütfen logo text giriniz.";
        } else {
            $logo_text = $input_logo_text;
        }

        // Validate name prefix
        $input_name_prefix = sanitize_input($_POST["name_prefix"]);
        if (empty($input_name_prefix)) {
            $name_prefix_err = "Lütfen name prefix giriniz.";
        } else {
            $name_prefix = $input_name_prefix;
        }

        // Check input errors before inserting in database
        if (empty($site_title_err) && empty($site_desc_err) && empty($site_keywords_err) && empty($google_key_err) && empty($yandex_key_err)  && empty($facebook_url_err) && empty($instagram_url_err) && empty($site_email_err) && empty($site_phone_err) && empty($whatsapp_number_err) && empty($logo_text_err) && empty($name_prefix_err) && empty($csfr_err) && empty($google_api_key_err) && empty($place_id_err)) {
            $sql = "UPDATE seo_settings SET title=:title, description=:description, keywords=:keywords, google_verify=:google_verify, yandex_verify=:yandex_verify,google_api_key=:google_api_key,place_id=:place_id, facebook=:facebook, instagram=:instagram, email=:email, phone=:phone, whatsapp=:whatsapp, logo_text=:logo_text, name_prefix=:name_prefix WHERE id=:id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':title', $site_title, PDO::PARAM_STR);
            $stmt->bindParam(':description', $site_desc, PDO::PARAM_STR);
            $stmt->bindParam(':keywords', $site_keywords, PDO::PARAM_STR);
            $stmt->bindParam(':google_verify', $google_key, PDO::PARAM_STR);
            $stmt->bindParam(':yandex_verify', $yandex_key, PDO::PARAM_STR);
            $stmt->bindParam(':google_api_key', $google_api_key, PDO::PARAM_STR);
            $stmt->bindParam(':place_id', $place_id, PDO::PARAM_STR);
            $stmt->bindParam(':facebook', $facebook_url, PDO::PARAM_STR);
            $stmt->bindParam(':instagram', $instagram_url, PDO::PARAM_STR);
            $stmt->bindParam(':email', $site_email, PDO::PARAM_STR);
            $stmt->bindParam(':phone', $site_phone, PDO::PARAM_STR);
            $stmt->bindParam(':whatsapp', $whatsapp_number, PDO::PARAM_STR);
            $stmt->bindParam(':logo_text', $logo_text, PDO::PARAM_STR);
            $stmt->bindParam(':name_prefix', $name_prefix, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                $_SESSION['csrf_token'] = generate_csrf_token();
                $success = "Başarıyla güncellendi.";
            } else {
                $error = "Bir şeyler yanlış gitti. Lütfen daha sonra tekrar deneyiniz.";
            }
        }
    } else {


        // Validate site title
        $input_site_title = sanitize_input($_POST["site_title"]);
        if (empty($input_site_title)) {
            $site_title_err = "Lütfen başlığı giriniz.";
        } else {
            $site_title = $input_site_title;
        }

        // Validate site desc
        $input_site_desc = sanitize_input($_POST["site_desc"]);
        if (empty($input_site_desc)) {
            $site_desc_err = "Lütfen açıklamayı giriniz.";
        } else {
            $site_desc = $input_site_desc;
        }

        // Validate site keywords
        $input_site_keywords = sanitize_input($_POST["site_keywords"]);
        if (empty($input_site_keywords)) {
            $site_keywords_err = "Lütfen anahtar kelimeleri giriniz.";
        } else {
            $site_keywords = $input_site_keywords;
        }

        // Validate google key
        $input_google_key = sanitize_input($_POST["google_key"]);
        if (empty($input_google_key)) {
            $google_key_err = "Lütfen google key giriniz.";
        } else {
            $google_key = $input_google_key;
        }

        // Validate yandex key
        $input_yandex_key = sanitize_input($_POST["yandex_key"]);
        if (empty($input_yandex_key)) {
            $yandex_key_err = "Lütfen yandex key giriniz.";
        } else {
            $yandex_key = $input_yandex_key;
        }

        // Validate google api key
        $input_google_api_key = sanitize_input($_POST["google_api_key"]);
        if (empty($input_google_api_key)) {
            $google_api_key_err = "Lütfen google api key giriniz.";
        } else {
            $google_api_key = $input_google_api_key;
        }

        // Validate place id
        $input_place_id = sanitize_input($_POST["place_id"]);
        if (empty($input_place_id)) {
            $place_id_err = "Lütfen place id giriniz.";
        } else {
            $place_id = $input_place_id;
        }


        // Validate facebook url
        $input_facebook_url = sanitize_input($_POST["facebook_url"]);
        if (empty($input_facebook_url)) {
            $facebook_url_err = "Lütfen facebook url giriniz.";
        } else {
            $facebook_url = $input_facebook_url;
        }

        // Validate instagram url
        $input_instagram_url = sanitize_input($_POST["instagram_url"]);
        if (empty($input_instagram_url)) {
            $instagram_url_err = "Lütfen instagram url giriniz.";
        } else {
            $instagram_url = $input_instagram_url;
        }


        // Validate email
        $input_site_email = sanitize_input($_POST["site_email"]);
        if (empty($input_site_email)) {
            $site_email_err = "Lütfen email giriniz.";
        } else {
            $site_email = $input_site_email;
        }

        // Validate phone
        $input_site_phone = sanitize_input($_POST["site_phone"]);
        if (empty($input_site_phone)) {
            $site_phone_err = "Lütfen telefon giriniz.";
        } else {
            $site_phone = $input_site_phone;
        }

        //Validate whatsapp number
        $input_whatsapp_number = sanitize_input($_POST["whatsapp_number"]);
        if (empty($input_whatsapp_number)) {
            $whatsapp_number_err = "Lütfen whatsapp numarası giriniz.";
        } else {
            $whatsapp_number = $input_whatsapp_number;
        }

        // Validate logo text
        $input_logo_text = sanitize_input($_POST["logo_text"]);
        if (empty($input_logo_text)) {
            $logo_text_err = "Lütfen logo text giriniz.";
        } else {
            $logo_text = $input_logo_text;
        }

        // Validate name prefix
        $input_name_prefix = sanitize_input($_POST["name_prefix"]);
        if (empty($input_name_prefix)) {
            $name_prefix_err = "Lütfen name prefix giriniz.";
        } else {
            $name_prefix = $input_name_prefix;
        }

        // Check input errors before inserting in database
        if (empty($site_title_err) && empty($site_desc_err) && empty($site_keywords_err) && empty($google_key_err) && empty($yandex_key_err) && empty($facebook_url_err) && empty($instagram_url_err) && empty($site_email_err) && empty($site_phone_err) && empty($whatsapp_number_err) && empty($logo_text_err) && empty($name_prefix_err) && empty($csfr_err) && empty($google_api_key_err) && empty($place_id_err)) {
            // Prepare an insert statement
            $sql = "INSERT INTO seo_settings ( `title`, `description`, `keywords`, `google_verify`, `yandex_verify`,`google_api_key`,`place_id`, `logo_text`, `email`, `phone`,`whatsapp`, `facebook`, `instagram`, `name_prefix`) VALUES (:title, :description, :keywords, :google_verify, :yandex_verify,:google_api_key,:place_id, :logo_text, :email, :phone, :whatsapp, :facebook, :instagram, :name_prefix)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':title', $site_title, PDO::PARAM_STR);
            $stmt->bindParam(':description', $site_desc, PDO::PARAM_STR);
            $stmt->bindParam(':keywords', $site_keywords, PDO::PARAM_STR);
            $stmt->bindParam(':google_verify', $google_key, PDO::PARAM_STR);
            $stmt->bindParam(':yandex_verify', $yandex_key, PDO::PARAM_STR);
            $stmt->bindParam(':google_api_key', $google_api_key, PDO::PARAM_STR);
            $stmt->bindParam(':place_id', $place_id, PDO::PARAM_STR);
            $stmt->bindParam(':logo_text', $logo_text, PDO::PARAM_STR);
            $stmt->bindParam(':email', $site_email, PDO::PARAM_STR);
            $stmt->bindParam(':phone', $site_phone, PDO::PARAM_STR);
            $stmt->bindParam(':whatsapp', $whatsapp_number, PDO::PARAM_STR);
            $stmt->bindParam(':facebook', $facebook_url, PDO::PARAM_STR);
            $stmt->bindParam(':instagram', $instagram_url, PDO::PARAM_STR);
            $stmt->bindParam(':name_prefix', $name_prefix, PDO::PARAM_STR);

            if ($stmt->execute()) {
                $success = "Başarıyla eklendi.";
            } else {
                $error = "Bir şeyler yanlış gitti. Lütfen daha sonra tekrar deneyiniz.";
            }
        }
    }


    // Close connection
    mysqli_close($link);
}
?>
<?php include 'layouts/head-main.php'; ?>

<head>
    <title>Seo Ayarları | MENEKŞE LASTİK YÖNETİM PANELİ</title>
    <?php include 'layouts/head.php'; ?>
    <link rel="stylesheet" type="text/css" href="assets/libs/toastr/build/toastr.min.css">
    <link href="assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    <!-- select2 css -->
    <link href="assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />

    <?php include 'layouts/head-style.php'; ?>

</head>

<?php include 'layouts/body.php'; ?>

<!-- Begin page -->
<div id="layout-wrapper">

    <?php include 'layouts/menu.php'; ?>

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Seo Ayarları</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item active">Seo Ayarları</li>

                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">

                                <h4 class="card-title">Seo Ayarları</h4>
                                <p class="card-title-desc">Seo ayarlarını düzenlemek için bu sayfayı kullanınız.</p>

                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">


                                    <div class="row">


                                        <input type="hidden" name="seo_id" value="<?php echo $id; ?>" />
                                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>" />
                                        <div class="mb-3 <?php echo (!empty($site_title_err)) ? 'has-error' : ''; ?>">
                                            <label for="site_title" class="form-label">Başlık</label>
                                            <input type="text" class="form-control" id="site_title" name="site_title" maxlength="255" placeholder="Başlığı giriniz" value="<?php echo $site_title; ?>">
                                            <span class="text-danger"><?php echo $site_title_err; ?></span>
                                        </div>

                                        <div class="mb-3 <?php echo (!empty($site_desc_err)) ? 'has-error' : ''; ?>">
                                            <label for="site_desc" class="form-label">Açıklama</label>
                                            <input type="text" class="form-control" id="site_desc" name="site_desc" maxlength="255" placeholder="Açıklama giriniz" value="<?php echo $site_desc; ?>">
                                            <span class="text-danger"><?php echo $site_desc_err; ?></span>
                                        </div>

                                        <div class="mb-3 <?php echo (!empty($site_keywords_err)) ? 'has-error' : ''; ?>">
                                            <label for="site_keywords" class="form-label">Anahtar Kelimeler</label>
                                            <input type="text" class="form-control" id="site_keywords" name="site_keywords" maxlength="255" placeholder="Anahtar kelimeleri giriniz" value="<?php echo $site_keywords; ?>">
                                            <span class="text-danger"><?php echo $site_keywords_err; ?></span>
                                        </div>

                                        <div class="mb-3 <?php echo (!empty($google_key_err)) ? 'has-error' : ''; ?>">
                                            <label for="google_key" class="form-label">Google Site Verification Key</label>
                                            <input type="text" class="form-control" id="google_key" name="google_key" placeholder="Google site verification key giriniz" value="<?php echo $google_key; ?>">
                                            <span class="text-danger"><?php echo $google_key_err; ?></span>
                                        </div>

                                        <div class="mb-3 <?php echo (!empty($yandex_key_err)) ? 'has-error' : ''; ?>">
                                            <label for="yandex_key" class="form-label">Yandex Site Verification Key</label>
                                            <input type="text" class="form-control" id="yandex_key" name="yandex_key" placeholder="Yandex site verification key giriniz" value="<?php echo $yandex_key; ?>">
                                            <span class="text-danger"><?php echo $yandex_key_err; ?></span>
                                        </div>

                                        <div class="mb-3 <?php echo (!empty($google_api_key_err)) ? 'has-error' : ''; ?>">
                                            <label for="google_api_key" class="form-label">Google API KEY</label>
                                            <input type="text" class="form-control" id="google_api_key" name="google_api_key" placeholder="Google API KEY" value="<?php echo $google_api_key; ?>">
                                            <span class="text-danger"><?php echo $google_api_key_err; ?></span>
                                        </div>

                                        <div class="mb-3 <?php echo (!empty($place_id_err)) ? 'has-error' : ''; ?>">
                                            <label for="place_id" class="form-label">Place ID</label>
                                            <input type="text" class="form-control" id="place_id" name="place_id" placeholder="Place ID" value="<?php echo $place_id; ?>">
                                            <span class="text-danger"><?php echo $place_id_err; ?></span>
                                        </div>



                                        <div class="mb-3 <?php echo (!empty($facebook_url_err)) ? 'has-error' : ''; ?>">
                                            <label for="facebook_url" class="form-label">Facebook URL</label>
                                            <input type="text" class="form-control" id="facebook_url" name="facebook_url" placeholder="Facebook URL" value="<?php echo $facebook_url; ?>">
                                            <span class="text-danger"><?php echo $facebook_url_err; ?></span>
                                        </div>

                                        <div class="mb-3 <?php echo (!empty($instagram_url_err)) ? 'has-error' : ''; ?>">
                                            <label for="instagram_url" class="form-label">Instagram URL</label>
                                            <input type="text" class="form-control" id="instagram_url" name="instagram_url" placeholder="Instagram URL" value="<?php echo $instagram_url; ?>">
                                            <span class="text-danger"><?php echo $instagram_url_err; ?></span>
                                        </div>



                                        <div class="mb-3 <?php echo (!empty($site_email_err)) ? 'has-error' : ''; ?>">
                                            <label for="site_email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="site_email" name="site_email" placeholder="Facebook URL" value="<?php echo $site_email; ?>">
                                            <span class="text-danger"><?php echo $site_email_err; ?></span>
                                        </div>

                                        <div class="mb-3 <?php echo (!empty($site_phone_err)) ? 'has-error' : ''; ?>">
                                            <label for="site_phone" class="form-label">Telefon</label>
                                            <input type="text" class="form-control" id="site_phone" name="site_phone" placeholder="Telefon" value="<?php echo $site_phone; ?>">
                                            <span class="text-danger"><?php echo $site_phone_err; ?></span>
                                        </div>

                                        <div class="mb-3 <?php echo (!empty($whatsapp_number_err)) ? 'has-error' : ''; ?>">
                                            <label for="whatsapp_number" class="form-label">Whatsapp Numarası</label>
                                            <input type="text" class="form-control" id="whatsapp_number" name="whatsapp_number" placeholder="Whatsapp numarası" value="<?php echo $whatsapp_number; ?>">
                                            <span class="text-danger"><?php echo $whatsapp_number_err; ?></span>
                                        </div>

                                        <div class="mb-3 <?php echo (!empty($logo_text_err)) ? 'has-error' : ''; ?>">
                                            <label for="logo_text" class="form-label">Logo Text</label>
                                            <input type="text" class="form-control" id="logo_text" name="logo_text" maxlength="255" placeholder="Logo text giriniz" value="<?php echo $logo_text; ?>">
                                            <span class="text-danger"><?php echo $logo_text_err; ?></span>
                                        </div>

                                        <div class="mb-3 <?php echo (!empty($name_prefix_err)) ? 'has-error' : ''; ?>">
                                            <label for="name_prefix" class="form-label">Name Prefix (the name must end with the "_" sign. Do not use space or uppercase text.)</label>
                                            <input type="text" class="form-control" id="name_prefix" name="name_prefix" maxlength="255" placeholder="Name prefix giriniz" value="<?php echo $name_prefix; ?>">
                                            <span class="text-danger"><?php echo $name_prefix_err; ?></span>
                                        </div>

                                    </div>



                                    <div class="d-flex flex-wrap gap-2">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light" name="kaydet">Kaydet</button>

                                    </div>
                                </form>

                            </div>
                        </div>


                    </div>
                </div>


            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->

        <?php include 'layouts/footer.php'; ?>
    </div>
    <!-- end main content-->

</div>
<!-- END layout-wrapper -->



<!-- JAVASCRIPT -->
<?php include 'layouts/vendor-scripts.php'; ?>


<!-- toastr plugin -->
<script src="assets/libs/toastr/build/toastr.min.js"></script>

<!-- toastr init -->
<script src="assets/js/pages/toastr.init.js"></script>

<!--tinymce js-->
<script src="assets/libs/tinymce/tinymce.min.js"></script>

<!-- init js -->
<script src="assets/js/pages/form-editor.init.js"></script>
<script src="assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js"></script>

<script>
    function showError(message) {
        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": 300,
            "hideDuration": 1000,
            "timeOut": 5000,
            "extendedTimeOut": 1000,
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
        toastr["error"](message);
    }

    function showSuccess(message) {
        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": 300,
            "hideDuration": 1000,
            "timeOut": 5000,
            "extendedTimeOut": 1000,
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
        toastr["success"](message);
    }

    //max length of seo title
    $('input[name="site_desc"]').maxlength({
        alwaysShow: true,
        threshold: 10,
        warningClass: "badge bg-warning",
        limitReachedClass: "badge bg-danger",
        separator: ' / ',
        preText: 'Kalan karakter: ',
        postText: ''
    });

    //max length of site title
    $('input[name="site_title"]').maxlength({
        alwaysShow: true,
        threshold: 10,
        warningClass: "badge bg-warning",
        limitReachedClass: "badge bg-danger",
        separator: ' / ',
        preText: 'Kalan karakter: ',
        postText: ''
    });

    //max length of site keywords
    $('input[name="site_keywords"]').maxlength({
        alwaysShow: true,
        threshold: 10,
        warningClass: "badge bg-warning",
        limitReachedClass: "badge bg-danger",
        separator: ' / ',
        preText: 'Kalan karakter: ',
        postText: ''
    });




    <?php if (!empty($error)) { ?>
        showError('<?php echo htmlspecialchars($error); ?>');
    <?php }

    if (!empty($csfr_err)) { ?>
        showError('<?php echo htmlspecialchars($csfr_err); ?>');
    <?php }

    if (!empty($success)) { ?>
        showSuccess('<?php echo htmlspecialchars($success); ?>');
        setTimeout(() => {
            window.location.href = "seo-settings.php";
        }, 3000);

    <?php }

    ?>
</script>


<!-- select 2 plugin -->
<script src="assets/libs/select2/js/select2.min.js"></script>



<!-- init js -->
<script src="assets/js/pages/ecommerce-select2.init.js"></script>

<!-- Sweet Alerts js -->
<script src="assets/libs/sweetalert2/sweetalert2.min.js"></script>

<!-- Sweet alert init js-->
<script src="assets/js/pages/sweet-alerts.init.js"></script>

<script src="assets/js/app.js"></script>

</body>

</html>