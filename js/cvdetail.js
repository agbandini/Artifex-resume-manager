$(document).ready(function () {
    $("#_data_incontro").datepicker({
        autoclose: 'true',
        language: "it",
        format: "dd-mm-yyyy"
    });
});


$('#_btSalvaAdm').on('click', function () {
    $('#_icoSalva').attr('class', 'fa fa-spinner fa-spin');
    var formData = new FormData($("#_frmCvData").get(0));
    $.ajax({
        url: "actions/updateCvAdm.php",
        type: 'POST',
        data: formData,
        async: false,
        dataType: 'json',
        success: function (data) {
            $('#_saveOk').modal('show');
            $('#_icoSalva').attr('class', 'fa fa-floppy-o');
        },
        cache: false,
        contentType: false,
        processData: false
    });
});