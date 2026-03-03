<?php

include 'layouts/session.php';
include 'layouts/head-main.php';
include 'layouts/config.php';
$stmt = $pdo->query("SELECT COUNT(*) FROM users WHERE role_id = 3");
$total_employees = (int)$stmt->fetchColumn();

$stmt = $pdo->query("SELECT COUNT(*) FROM tires");
$total_tires = (int)$stmt->fetchColumn();

$stmt = $pdo->query("SELECT COUNT(*) FROM rims");
$total_rims = (int)$stmt->fetchColumn();

$stmt = $pdo->query("SELECT COUNT(*) FROM blogs");
$total_blogs = (int)$stmt->fetchColumn();

?>

<head>
    <title>Anasayfa | MENEKŞE LASTİK YÖNETİM PANELİ</title>
    <?php include 'layouts/head.php'; ?>
    <?php include 'layouts/head-style.php'; ?>
</head>

<?php include 'layouts/body.php'; ?>

<!-- Begin page -->
<div id="layout-wrapper">

    <?php include 'layouts/menu.php';

    ?>

    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Anasayfa</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Anasayfa</a></li>
                                    <li class="breadcrumb-item active">Anasayfa</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-4">
                        <div class="card overflow-hidden">
                            <div class="bg-primary bg-soft">
                                <div class="row">
                                    <div class="col-7">
                                        <div class="text-primary p-3">
                                            <h5 class="text-primary">Hoş Geldin!</h5>
                                            <p>Menekşe Lastik Yönetim Paneli</p>
                                        </div>
                                    </div>
                                    <div class="col-5 align-self-end">
                                        <img src="assets/images/profile-img.png" alt="" class="img-fluid">
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="avatar-md profile-user-wid mb-4">
                                            <img src="<?= $_SESSION['userphoto'] ?>" alt=""
                                                class="img-thumbnail rounded-circle">
                                        </div>
                                        <h5 class="font-size-15 text-truncate"><?php echo ucfirst($_SESSION["username"] . ' ' . $_SESSION["usersurname"]); ?></h5>
                                        <p class="text-muted mb-0 text-truncate">
                                            <?php
                                            echo getUserRole($_SESSION["role_id"]);
                                            ?>
                                        </p>
                                    </div>

                                    <div class="col-sm-8">
                                        <div class="pt-4">

                                            <div class="row">
                                                <div class="col-6">
                                                    <h5 class="font-size-15"><?php echo $total_employees; ?></h5>
                                                    <p class="text-muted mb-2">Çalışan</p>
                                                </div>
                                                <div class="col-6">
                                                    <h5 class="font-size-15">0</h5>
                                                    <p class="text-muted mb-2">İlanlar</p>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-8">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card mini-stats-wid">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-muted fw-medium">Toplam Kampanya</p>
                                                <h4 class="mb-0"><?php echo $total_blogs; ?></h4>
                                            </div>

                                            <div class="mini-stat-icon avatar-sm rounded-circle bg-primary align-self-center">
                                                <span class="avatar-title">
                                                    <i class="bx bx-copy-alt font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card mini-stats-wid">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-muted fw-medium">Toplam Lastik</p>
                                                <h4 class="mb-0"><?php echo $total_tires; ?></h4>
                                            </div>

                                            <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                                                <span class="avatar-title rounded-circle bg-primary">
                                                    <i class="bx bx-archive-in font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card mini-stats-wid">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-muted fw-medium">Toplam Jant</p>
                                                <h4 class="mb-0"><?php echo $total_rims; ?></h4>
                                            </div>

                                            <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                                                <span class="avatar-title rounded-circle bg-primary">
                                                    <i class="bx bx-purchase-tag-alt font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>




            </div>

        </div>


        <?php include 'layouts/footer.php'; ?>
    </div>


</div>




<?php include 'layouts/vendor-scripts.php'; ?>

<script src="assets/libs/apexcharts/apexcharts.min.js"></script>
<script src="assets/js/pages/dashboard.init.js"></script>

<!-- App js -->
<script src="assets/js/app.js"></script>

</body>

</html>