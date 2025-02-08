<?php
// Include config file
require_once "layouts/config.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require_once __DIR__ . '/vendor/phpmailer/src/Exception.php';
require_once __DIR__ . '/vendor/phpmailer/src/PHPMailer.php';
require_once __DIR__ . '/vendor/phpmailer/src/SMTP.php';

$useremail_err = $msg = "";

// Check if the form is submitted
if ($_POST) {
    $useremail = mysqli_real_escape_string($link, $_POST['useremail']);

    // Query to check if the email exists
    $sql = "SELECT * FROM users WHERE useremail = '$useremail'";
    $query = mysqli_query($link, $sql);
    $emailcount = mysqli_num_rows($query);

    if ($emailcount) {
        $userdata = mysqli_fetch_array($query);
        $username = $userdata['username'];
        $token = $userdata['token'];

        // Sender credentials
        $gmailid = "bilgi@htksen.org";
        $gmailpassword = "mail@sendika_HTK1224";
        $gmailusername = "HTK-SEN";

        // Reset password email details
        $subject = "Şifre Sıfırlama";
        $body = "
            <h3>Merhaba, $username</h3>
            <p>Şifrenizi sıfırlamak için aşağıdaki bağlantıya tıklayın:</p>
            <p><a href='http://$_SERVER[HTTP_HOST]/management/reset-password.php?token=$token'>Şifreyi Sıfırla</a></p>
            <br><br>
            <p>Bu e-postayı siz talep etmediyseniz lütfen dikkate almayın.</p>
        ";

        try {
            $mail = new PHPMailer(true);
            // Server settings
            $mail->isSMTP();
            $mail->Host = "srvc176.turhost.com";
            $mail->SMTPAuth = true;
            $mail->Username = $gmailid;
            $mail->Password = $gmailpassword;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;
            $mail->CharSet = "UTF-8";

            // Email sender and recipient
            $mail->setFrom($gmailid, $gmailusername);
            $mail->addAddress($useremail, $username);

            // Email content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $body;

            // Send the email
            $mail->send();
            $success = "Şifre sıfırlama bağlantısı e-posta adresinize gönderildi.";
        } catch (Exception $e) {
            $useremail_err = "E-posta gönderiminde hata oluştu: {$mail->ErrorInfo}";
        }
    } else {
        $useremail_err = "Bu e-posta adresine ait bir kullanıcı bulunamadı.";
    }
}
?>
<?php include 'layouts/head-main.php'; ?>

<head>
    <title>Şifremi Unuttum | MENEKŞE LASTİK</title>
    <?php include 'layouts/head.php'; ?>
    <link rel="stylesheet" type="text/css" href="assets/libs/toastr/build/toastr.min.css">
    <link href="assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    <?php include 'layouts/head-style.php'; ?>
</head>

<body>
    <div class="account-pages my-5 pt-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card overflow-hidden">
                        <div class="bg-primary bg-light">
                            <div class="row">
                                <div class="col-7">
                                    <div class="text-primary p-4">
                                        <h5 class="text-primary">MENEKŞE LASTİK YÖNETİM PANELİ</h5>
                                    </div>
                                </div>
                                <div class="col-5 align-self-end">
                                    <div class="auth-logo">
                                        <a href="index.php" class="auth-logo-dark">
                                            <div class="avatar-lg profile-user-wid m-3">
                                                <span class="avatar-title rounded-circle bg-transparent">
                                                    <img src="assets/images/logo.png" alt="" class="rounded-circle" height="180">
                                                </span>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-4">
                            <div class="p-2">

                                <form class="form-horizontal" action="<?php echo htmlentities($_SERVER["PHP_SELF"]); ?>" method="post">

                                    <div class="mb-3 <?php echo (!empty($useremail_err)) ? 'has-error' : ''; ?>">
                                        <label for="useremail" class="form-label">E-posta Adresiniz</label>
                                        <input type="email" class="form-control mb-1" id="useremail" name="useremail" placeholder="E-posta Adresiniz">
                                        <span class="text-danger"><?php echo $useremail_err; ?></span>
                                    </div>

                                    <div class="text-end">
                                        <button class="btn btn-primary w-md waves-effect waves-light" type='submit' name='submit' value='Submit'>Gönder</button>
                                    </div>

                                </form>
                            </div>

                        </div>
                    </div>
                    <div class="mt-5 text-center">

                        <div>
                            <p>© <script>
                                    document.write(new Date().getFullYear())
                                </script> MENEKŞE LASTİK </p>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

    <!-- JAVASCRIPT -->
    <?php include 'layouts/vendor-scripts.php'; ?>
    <!-- toastr plugin -->
    <script src="assets/libs/toastr/build/toastr.min.js"></script>

    <!-- toastr init -->
    <script src="assets/js/pages/toastr.init.js"></script>


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

        <?php if (!empty($success)) { ?>
            showSuccess('<?php echo htmlspecialchars($success); ?>');
            setTimeout(function() {
                window.location.href = "login.php";
            }, 3000);

        <?php } ?>
    </script>

    <!-- App js -->
    <script src="assets/js/app.js"></script>
</body>

</html>