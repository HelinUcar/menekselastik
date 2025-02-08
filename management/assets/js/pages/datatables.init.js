/*
Template Name: Skote - Admin & Dashboard Template
Author: Themesbrand
Website: https://themesbrand.com/
Contact: themesbrand@gmail.com
File: Datatables Js File
*/

$(document).ready(function() {
    $('#datatable').DataTable();

    //Buttons examples
    var table = $('#datatable-buttons').DataTable({
        lengthChange: false,
        buttons: ['copy', 'excel', 'pdf', 'colvis'],
        "ajax": {
            "url": "engine/panel-user.php?action=get_users", // If same source is used
            "dataSrc": ""
        },
        "columns": [{
                "data": "id"
            },
            {
                "data": "username"
            },
            {
                "data": "usersurname"
            },
            {
                "data": "useremail"
            },
            {
                "data": "created_at"
            },
            {
                "data": "id",
                "render": function(data, type, row, meta) {
                    return '<a href="panel-user-edit.php?id=' + data + '" class="btn btn-primary btn-sm">Düzenle</a> <a href="engine/panel-user.php?action=delete_user&id=' + data + '" class="btn btn-danger btn-sm">Sil</a>';
                }
            }
        ]
    });

    table.buttons().container()
        .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');

    $(".dataTables_length select").addClass('form-select form-select-sm');
});