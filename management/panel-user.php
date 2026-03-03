<?php

include 'layouts/session.php';
include 'layouts/head-main.php';
?>

<head>
    <title>Panel Üyeleri | MENEKŞE LASTİK YÖNETİM PANELİ</title>
    <?php include 'layouts/head.php'; ?>
    <link href="assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="assets/libs/toastr/build/toastr.min.css">
    <link href="assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <?php include 'layouts/head-style.php'; ?>
</head>

<?php include 'layouts/body.php'; ?>

<div id="layout-wrapper">
    <?php include 'layouts/menu.php'; ?>
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Panel Üyeleri</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Üyeler</a></li>
                                    <li class="breadcrumb-item active">Panel Üyeleri</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Üye Listesi</h4>

                                <p class="card-title-desc">Buradan sadece yönetim paneline erişimi olan üyeleri görebilirsiniz.</p>
                                <table id="user-list" class="table table-bordered dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Adı - Soyadı</th>
                                            <th>E-Posta</th>
                                            <th>Rol</th>
                                            <th>Kayıt Zamanı</th>
                                            <th>İşlemler</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
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
<script src="assets/libs/toastr/build/toastr.min.js"></script>
<script src="assets/js/pages/toastr.init.js"></script>
<script src="assets/libs/tinymce/tinymce.min.js"></script>

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

    $(document).ready(function() {
        var csrfToken = '<?php echo $_SESSION["csrf_token"]; ?>';
        var table = $('#user-list').DataTable({
            lengthChange: false,
            buttons: ['copy', 'excel', 'pdf', 'colvis'],
            "ajax": {
                "url": "engine/panel-user.php?action=get_users"
            },
            "columns": [{
                    "data": "id"
                },
                {
                    "data": "username",
                    "render": function(data, type, row, meta) {
                        var imageSrc = row.userphoto && row.userphoto !== "" ?
                            row.userphoto :
                            "assets/images/users/no-user.png";

                        var fullName = data + ' ' + row.usersurname;

                        return '<div class="d-flex align-items-center">' +
                            '<img class="rounded-circle avatar-xs me-2" src="' + imageSrc + '" alt="">' +
                            '<span>' + fullName + '</span>' +
                            '</div>';
                    }
                },
                {
                    "data": "useremail"
                },
                {
                    "data": "role_name"

                },
                {
                    "data": "created_at"
                },
                {
                    "data": "id",
                    "render": function(data, type, row, meta) {
                        return '<a href="panel-user-edit.php?id=' + encodeURIComponent(data) + '" class="btn btn-primary btn-sm">Düzenle</a> ' +
                            (<?= $_SESSION['role_id'] ?> == 1 || <?= $_SESSION['role_id'] ?> == 2 ? '<button data-id="' + encodeURIComponent(data) + '" class="btn btn-danger btn-sm delete-user">Sil</button>' : '');
                    }
                }
            ]
        });


        //user add button to datatable
        $('#user-list_wrapper .row .col-md-6:eq(0)').append('<a href="panel-user-add.php" class="btn btn-primary btn-sm">Yeni Kullanıcı Ekle</a>');
        table.buttons().container()
            .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');

        $(".dataTables_length select").addClass('form-select form-select-sm');

        $('#user-list').on('click', '.delete-user', function() {
            var id = $(this).data('id');
            $.ajax({
                url: 'engine/panel-user.php?action=delete_user',
                method: 'POST',
                dataType: "json",
                data: {
                    id: id,
                    csrf_token: csrfToken
                },
                success: function(response) {
                    console.log("Response:", response);
                    if (response.status && response.status.toLowerCase() == 'success') {
                        showSuccess('Kullanıcı başarıyla silindi.');
                        table.ajax.reload();
                    } else {
                        showError(response.message || 'Kullanıcı silinirken bir hata oluştu.');
                    }
                },
                error: function(xhr) {
                    console.log("XHR:", xhr.responseText);
                    showError('Hata oluştu: ' + xhr.responseText);
                }
            });
        });

    });
</script>

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




<script src="assets/js/app.js"></script>

</body>

</html>