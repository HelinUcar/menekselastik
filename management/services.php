<?php 

include 'layouts/session.php';  include 'layouts/head-main.php'; ?>

<head>
    <title>Hizmet Listesi | MENEKŞE LASTİK YÖNETİM PANELİ</title>
    <?php include 'layouts/head.php'; ?>
    <!-- DataTables -->
    <link href="assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="assets/libs/toastr/build/toastr.min.css">
    <!-- Responsive datatable examples -->
    <link href="assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
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
                            <h4 class="mb-sm-0 font-size-18">Hizmet Listesi</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Hizmetler</a></li>
                                    <li class="breadcrumb-item active">Hizmet Listesi</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Hizmet Listesi</h4>
                                <p class="card-title-desc">Buradan hiz görebilir ve düzenleyebilirsiniz.</p>
                                <table id="new-list" class="table table-bordered dt-responsive nowrap w-100">

                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Başlık</th>
                                            <th>Tarih</th>
                                            <th>Görsel</th>
                                            <th>Durum</th>
                                            <th>İşlemler</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                    </tbody>
                                </table>



                            </div>
                        </div>
                    </div> <!-- end col -->

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

<script>
    $(document).ready(function() {
        $('#datatable').DataTable();

        //Buttons examples
        var table = $('#new-list').DataTable({
            lengthChange: false,
            buttons: ['copy', 'excel', 'pdf', 'colvis'],

            "ajax": {
                "url": "engine/services.php?action=get_services", // If same source is used
                "dataSrc": ""
            },
            "columns": [{
                    "data": "id"
                },
                {
                    "data": "title"
                },
               
                {
                    "data": "created_at"
                },
                {
                    "data": "icon_path",
                    "render": function(data, type, row, meta) {
                        return '<img src="' + data + '" class="img-fluid" style="max-width: 100px;">';
                    }
                },
                {
                    "data": "status",
                    "render": function(data, type, row, meta) {
                        let checked = (data == 1) ? 'checked' : '';
                        return '<div class="form-check form-switch form-switch-md mb-3" dir="ltr">\
                    <input class="form-check-input status-toggle" type="checkbox" data-id="' + row.id + '" data-status="' + data + '" ' + checked + '>\
                </div>';
                    }
                },
                {
                    "data": "id",
                    "render": function(data, type, row, meta) {
                        return '<a href="services-edit.php?id=' + data + '" class="btn btn-primary btn-sm">Düzenle</a> <button data-id="' + data + '" class="btn btn-danger btn-sm delete-blog">Sil</button>';
                    }
                }
            ]
        });

        //blog add button to datatable
        $('#new-list_wrapper .row .col-md-6:eq(0)').append('<a href="services-add.php" class="btn btn-primary btn-sm">Yeni Hizmet Ekle</a>');

        //export buttons to datatable


        table.buttons().container()
            .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');

        $(".dataTables_length select").addClass('form-select form-select-sm');
    });
</script>

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

    //delete blog with ajax
    $(document).on('click', '.delete-blog', function() {
        var id = $(this).data('id');
        $.ajax({
            url: 'engine/services.php?action=delete_blog',
            type: 'POST',
            data: {
                id: id
            },
            success: function(response) {
                if (response.status == 'success') {
                    showSuccess('Hizmet başarıyla silindi.');
                    $('#new-list').DataTable().ajax.reload();
                } else {
                    showError('Hizmet silinirken bir hata oluştu.');
                }
            }
        });
    });

    //change status with ajax
    $(document).on('change', '.status-toggle', function() {
        // Checkbox'tan id ve mevcut durumu alıyoruz
        var id = $(this).data('id');
        var status = $(this).is(':checked') ? 1 : 0;
        $.ajax({
            url: 'engine/services.php?action=change_status',
            type: 'POST',
            data: {
                id: id,
                status: status
            },
            success: function(response) {
                if (response.status == 'success') {
                    showSuccess('Durum başarıyla değiştirildi.');
                } else {
                    showError('Durum değiştirilirken bir hata oluştu.');
                }
            }
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