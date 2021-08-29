// Call the dataTables jQuery plugin
$(document).ready(function () {
    $('#dataTableForm').DataTable();
});

$(document).ready(function () {
    var table = $('#dataTable').DataTable({
        buttons: ['copy', 'csv', 'print', 'excel', 'pdf', 'colvis'],
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]
    });

    table.buttons().container()
        .appendTo('#dataTable_wrapper .col-md-6:eq(0)');
});