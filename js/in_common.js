var img = $("#_url_immagine").val();
var nomeimg = $("#_nome_immagine").val();

$("#_img_url").fileinput({
    showUpload: false,
    showCaption: false,
    showRemove: false,
    dropZoneEnabled: false,
    browseClass: "btn btn-default",
    fileType: "any",
    previewFileIcon: "<i class='fa fa-star'></i>",
    overwriteInitial: true,
    initialPreviewAsData: true,
    initialPreviewShowDelete: false,
    initialPreview: [
        img
    ],
    initialPreviewConfig: [
        {caption: nomeimg,
            width: '196px'
        }]
});

$('#_img_url').on('change', function(event) {
    $('#_img_candidato').val('0');
});

$(function () {
    $("#_luogo_nascita").autocomplete({
        source: 'actions/getCity.php',
        minLength: 2,

        // prendo l'id passato dall query PHP e la passo come valore della text box con id = #_luogo_nascita
        select: function (event, ui) {
            return ui.item.label;
        }
    })
});

$(function (){
    $("#_citta").autocomplete({
        source: 'actions/getCity.php',
        minLength: 2,

        // prendo l'id passato dall query PHP e la passo come valore della text box con id = #_luogo_nascita
        select: function (event, ui) {
            $("#_cap_residenza").val(ui.item.CAP);
            $("#_provincia_residenza").val(ui.item.Provincia);
            return ui.item.label;
        }
    })
});

$('#_esperienza_estetica').on('change', function() {
    //$(element).is(":visible");
    if (Number($('#_esperienza_estetica').val()) === 0){
        
        $('#_box_att_est').fadeOut("slow");
        $('#_attestato_estetista').val(0);
    } else {
        $('#_box_att_est').fadeIn("slow");
    }
});

$(document).ready(function () {
    $("#_data_nascita").datepicker({
        autoclose: 'true',
        language: "it",
        format: "yyyy-mm-dd",
        startView: 2
    });

    $("#_luogo_nascita").keypress(function () {
        if ($("#_luogo_nascita").val().length > 1) {
            $("#iconaLuogoNascita").addClass("fa fa-circle-o-notch fa-spin");
        }
    });

    $("#_luogo_nascita").blur(function () {
        $("#iconaLuogoNascita").removeClass("fa fa-circle-o-notch fa-spin");
        $("#iconaLuogoNascita").addClass("fa fa-search");
    });
    
    $("#_altre_lingue").select2();
    $("#_punti_vendita").select2();
    
    $("#_step1").validate();
    
    $("#_indietro").prop('disabled',true);
});