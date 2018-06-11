$(document).ready(function () {

    var oTable;

    $('.datepicker').datepicker();

    $('.report-go').click(function (e){
        e.preventDefault();
        var formVals = $(this).closest('form').serializeArray();
        $.post('../private/reports_generate.php', formVals, function (data){
            oTable.fnDestroy();
            $('#repTable').html(data);
            oTable = $('#repTable').dataTable();
        });
    });

    $('#repTable').load('../private/reports_generate.php', function() {
        oTable = $('#repTable').dataTable();
    });








});
