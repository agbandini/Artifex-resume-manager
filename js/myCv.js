
$('#_salvaCv').on('click', function () {
    $('#_icoSalva').attr('class', 'fa fa-spinner fa-spin');
    if (Number($('#_tlFormazione li').length) <= 1 || Number($('#_tlLavoro li').length) <= 1){
        $('#_alertSave').modal('show');
        $('#_icoSalva').attr('class', 'fa fa-floppy-o');
        return false;
    }
    var formData = new FormData($("#_frmCv").get(0));
        $.ajax({
            url: "actions/updateCv.php",
            type: 'POST',
            data: formData,
            async: false,
            dataType: 'json',
            success: function (data) {
                if (data.status === 0){
                    $('#_erroriBox').fadeIn(function(){
                        $('#_erroriList').empty();
                        for (i in data.details) {
                            $('#_erroriList').append('<li>'+data.details[i].campo+'</li>');
                        } 
                    });
                } else {
                    console.log(data.details);
                    $('#_saveOk').modal('show');
                    $('#_img_candidato').val(data.details.img);
                    $('#_erroriList').empty();
                    $('#_erroriBox').fadeOut();
                }
                $('#_icoSalva').attr('class', 'fa fa-floppy-o');
            },
            cache: false,
            contentType: false,
            processData: false
        });
});