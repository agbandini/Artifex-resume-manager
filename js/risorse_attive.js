$(document).ready(function () {
    $("#_avviso").hide();
    var filterVals = {};
    paginazione(filterVals);
});

$(function () {
    $("#_cognome_candidato").autocomplete({
        source: 'actions/getCvSurname.php',
        minLength: 3,

        // prendo l'id passato dall query PHP e la passo come valore della text box con id = #_luogo_nascita
        select: function (event, ui) {
            //avvaloraFiltri();
            return ui.item.label;
        }
    })
});



function conteggio(filters){
    var res = 0;
    $.ajax({
        url: "actions/getCvCountAttivi.php",
        type: 'POST',
        data: {
            'filters': JSON.stringify(filters)
        },
        async: false,
        dataType: 'json',
        success: function (data) {
            //console.log(data);
            res = data;
        }
    });
    return res;
}

function paginazione(filters){
    x = conteggio(filters);
    $('#_tot_cv').text(x);
    $("#pagination").paging($('#_tot_cv').text(), {
            format: '[< ncnnn >]',
            perpage: 8,
            onSelect: function (page) {
                //console.log(Object.keys(filters).length);
                //console.log(JSON.stringify(filters));
                $.ajax({
                        type: 'POST',
                        url: 'actions/getCvListAttivi.php',
                        data: {
                            'start': this.slice[0], 
                            'end': this.slice[1],
                            'page': page,
                            'filters': JSON.stringify(filters)
                        },
                        success: function(data){
                            var dataincontro;
                            var dataiscrizione;
                            var valutazione;
                            var obj = jQuery.parseJSON(data);
                            //console.log(obj);
                            $("#_listaProfili").empty();
                            if (obj.length){
                                //$('#_tot_cv').text(obj.tot_records)
                                $("#_avviso").hide();
                                $("#pagination").show();
                                var scheda = '';
                                jQuery.each(obj, function(){
                                    
                                    scheda = $('#_schedaCv').html();
                                    dataincontro = moment(this.cv_data_incontro).format('DD/MM/YYYY');
                                    if(dataincontro == null) dataincontro = '-';
                                    dataiscrizione = moment(this.cv_data_inserimento).format('DD/MM/YYYY');
                                    valutazione = this.cv_valutazione;
                                    if(Number(this.cv_valutazione) === 0) valutazione = 'Nessuna valutazione'; 
                                    scheda = scheda.replace(/%%ID%%/g,this.cv_id);
                                    scheda = scheda.replace(/%%NOMINATIVO%%/g,(this.cv_cognome+' '+this.cv_nome));
                                    scheda = scheda.replace('%%IMG%%',this.cv_file_foto);
                                    scheda = scheda.replace('%%STATOCV%%',this.status_descr);
                                    scheda = scheda.replace('%%TELEFONO%%',this.cv_telefono);
                                    scheda = scheda.replace('%%DATAINCONTRO%%',dataincontro);
                                    scheda = scheda.replace('%%DATAISCRIZIONE%%',dataiscrizione);
                                    scheda = scheda.replace('%%VALUTAZIONE%%',valutazione);
                                    scheda = scheda.replace('%%EMAIL%%',this.cv_email);
                                    //scheda = scheda.replace('%%INDIRIZZO%%',this.cv_indirizzo + '<br>' + this.cv_citta + ' - ' + this.cv_provincia);
                                    var pv = jQuery.parseJSON(this.cv_preferenza_sede);
                                    scheda = scheda.replace('%%PUNTOVENDITA%%',pv.join());
                                    //liPronto = liPronto.replace('%%DESCRIZIONE%%',obj['attivita_svolte']);
                                    $("#_listaProfili").append(scheda);
                                });                                
                            } else {
                                $("#_avviso").show();
                                $("#pagination").hide();
                            }
                        }
                    });
            },
            onFormat: function (type) {
                var attivo = '';
                switch (type) {
                    case 'block': // n and c
                        if (this.active && (this.page == this.value)) attivo = 'active';
                        return '<li class="'+attivo+'"><a href="#">' + this.value + '</a></li>';
                    case 'next': // >
                        //if (this.active) attivo = 'active';
                        return '<li class="'+attivo+'"><a href="#">&gt;</a></li>';
                    case 'prev': // <
                        //if (this.active) attivo = 'active';
                        return '<li class="'+attivo+'"><a href="#">&lt;</a></li>';
                    case 'first': // [
                        //if (this.active) attivo = 'active';
                        return '<li class="'+attivo+'"><a href="#">Inizio</a></li>';
                    case 'last': // ]
                        //if (this.active) attivo = 'active';
                        return '<li class="'+attivo+'"><a href="#">Fine</a></li>';
                    }
            }
    });   
}

function avvaloraFiltri(){
    var filterVals = {};
    if ($("#_cognome_candidato").val().length !== 0) {filterVals['cv_cognome'] = $("#_cognome_candidato").val();}
    if ($("#_anno_nascita").val().length !== 0) {filterVals['cv_anno_nascita'] = $("#_anno_nascita").val();}
    if ($("#_sesso").val().length !== 0) {filterVals['cv_sesso'] = $("#_sesso").val();}
    if ($("#_citta").val().length !== 0) {filterVals['cv_citta'] = $("#_citta").val();}
    if ($("#_punto_vendita").val().length !== 0) {filterVals['cv_preferenza_sede'] = $("#_punto_vendita").val();}
    if ($("#_esp_estetica").val().length !== 0) {filterVals['cv_exp_estetica'] = $("#_esp_estetica").val();}
    if ($("#_esp_profumeria").val().length !== 0) {filterVals['cv_exp_profumeria'] = $("#_esp_profumeria").val();}
    if ($("#_stato_candidatura").val().length !== 0) {filterVals['cv_status'] = $("#_stato_candidatura").val();}
    paginazione(filterVals);  
}


$(".cvfilter").on('change', function(event) {
    avvaloraFiltri();
});