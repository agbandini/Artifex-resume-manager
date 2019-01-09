<div class="modal fade" id="_modalLavoro">
    <form name="frmLavoro" id="_frmLavoro" action="" method="post" >
        <input type="hidden" name="cv_id" class="cv_id" value="<?=(!isset($cv['cv_id'])) ? '0' : $cv['cv_id']?>">
        <input type="hidden" name="lavoro_id" id="_lavoro_id" value="0">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close closemod" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Aggiungi Attività Lavorativa</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Data di inizio:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input required readonly="true" type="text" class="form-control pull-right al" id="_data_inizio_lav" name="data_inizio_lav">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Data di fine:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input readonly="true" type="text" class="form-control pull-right al" id="_data_fine_lav" name="data_fine_lav">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="Mansione">Mansione</label>
                                <input required class="form-control al" type="text" name="mansione" id="_mansione" size="50" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="Azienda">Azienda</label>
                                <input required class="form-control al" type="text" name="azienda" id="_azienda" size="50" />
                            </div> 
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="Citta">Citta</label>&nbsp;<i id="iconaCittaAzienda" class="fa fa-search"></i></span>
                                <input required class="form-control al" type="text" id="_citta_azienda" name="citta_azienda" size="50" />
                            </div> 
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="Provincia">Provincia</label>
                                <input required class="form-control al" type="text" name="provincia_azienda" id="_provincia_azienda" size="50" />
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Descrizione Mansione</label>
                                <textarea required class="form-control al" id="_descrizione_mansione" name="descrizione_mansione" rows="3" placeholder="Breve descizione delle attività svolte..."></textarea>
                            </div>
                        </div>
                    </div>                         
                </div>
                <div class="modal-footer">
                    <div class="col-md-6 text-left">
                        <i id="icoAspetta" style="display:none;" class="fa fa-spinner fa-spin"></i>
                        <i id="icoOk" style="display:none;" class="fa fa-check"></i>
                        <p id="testoInvio" style="display:none;"></p>
                    </div>
                    <div class="col-md-6">                    
                        <button type="button" id="_addLavoroClose" class="btn btn-default closemod" data-dismiss="modal">Chiudi</button>
                        <button type="button" id="_addLavoro" class="btn btn-primary">Salva</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<div style="display:none;" id="_rowLavoro">
<li id="L_id_-ID-">
    <i class="fa fa-cogs bg-blue"></i>
    <div class="timeline-item">
        <div class="timeline-header">
            <div class="row">
                <div class="col-md-6">
                    <h4><span class="text-light-blue" id="L_att_-ID-">%%MANSIONE%%</span></h4>
                </div>
                <div class="col-md-6">
                    <h4><span class="text-light-blue text-bold" >Dal: </span><span id="L_dal_-ID-">%%DAL%%</span><span class="text-light-blue text-bold" > Al: </span><span id="L_al_-ID-">%%AL%%</span></h4>
                </div>
            </div>

        </div>
        <div class="timeline-body">
            <div class="row">
                <div class="col-md-4">
                    <span class="text-light-blue"><b>Presso: </b></span> <span id="L_presso_-ID-">%%PRESSO%%</span>
                </div>
                <div class="col-md-4">
                    <span class="text-light-blue"><b>Citta: </b></span> <span id="L_citta_-ID-">%%CITTA%%</span>
                </div>
                <div class="col-md-4">
                    <span class="text-light-blue"><b>Provincia: </b></span> <span id="L_prov_-ID-">%%PROVINCIA%%</span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <p id="L_descr_-ID-">%%DESCRIZIONE%%</p>
                </div>
            </div>
        </div>
        <div class="timeline-footer">
            <div class="btn-group">
                <button type="button" onclick="editLavoro(%%ID%%)" class="btn btn-default btn-sm"><i class="fa fa-edit"></i></button>
                <button type="button" onclick="deleteLavoro(%%ID%%)" id="_deleteLItem" class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i></button>
            </div>
        </div>
    </div>
</li>    
</div>
<div class="modal fade" id="_delConfimLavoro">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Conferma Eliminazione Elemento</h4>
            </div>                
            <div class="modal-body">
                Sei sicuro di voler eliminare questo elemento?
                <input type="hidden" name="cancellaturo" id="_cancellaturo" value="0">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="_itemDeleteL">Elimina</button>
                <button type="button" data-dismiss="modal" class="btn">Annulla</button>
            </div>
        </div>         
    </div> 
</div>
<script>

    $(function () {
        $("#_citta_azienda").autocomplete({
            source: 'actions/getCity.php',
            minLength: 2,

            // prendo l'id passato dall query PHP e la passo come valore della text box con id = #_luogo_nascita
            select: function (event, ui) {
                $("#_provincia_azienda").val(ui.item.Provincia);
                return ui.item.label;
            }
        })
    });

    $(document).ready(function () {
        $("#_data_inizio_lav").datepicker({
            autoclose: 'true',
            language: "it",
            format: "dd-mm-yyyy"
        });
        $("#_data_fine_lav").datepicker({
            autoclose: 'true',
            language: "it",
            format: "dd-mm-yyyy"
        });

        $("#_citta_azienda").keypress(function () {
            if ($("#_citta_azienda").val().length > 1) {
                $("#iconaCittaAzienda").addClass("fa fa-circle-o-notch fa-spin");
            }
        });

        $("#_citta_azienda").blur(function () {
            $("#iconaCittaAzienda").removeClass("fa fa-circle-o-notch fa-spin");
            $("#iconaCittaAzienda").addClass("fa fa-search");
        });
    });

    $('#_addLavoro').on('click', function () {
        if ($("#_frmLavoro").valid()) {
            $("#testoInvio").css("display","block");
            $("#testoInvio").text(" Salvataggio in corso...");
            $("#icoAspetta").css("display","inline-block");
            $("#icoOk").css("display","none");


            $.ajax({
               url:'actions/saveLavoro.php',
               data:$('#_frmLavoro').serialize(),
               type:'POST',
               success:function(data){

                    obj = JSON.parse(data);
                    dal = moment(obj['data_inizio_lav']).format('DD-MM-YYYY');
                    al = moment(obj['data_fine_lav']).format('DD-MM-YYYY');

                    if($('#_lavoro_id').val() === '0'){
                        liPronto = $('#_rowLavoro').html();
                        if (al === 'Invalid date') al='';
                        liPronto = liPronto.replace(/%%ID%%/g,obj['id']);
                        liPronto = liPronto.replace(/-ID-/g,obj['id']);
                        liPronto = liPronto.replace('%%MANSIONE%%',obj['mansione']);
                        liPronto = liPronto.replace('%%DAL%%',dal);
                        liPronto = liPronto.replace('%%AL%%',al);
                        liPronto = liPronto.replace('%%PRESSO%%',obj['azienda']);
                        liPronto = liPronto.replace('%%CITTA%%',obj['citta_azienda']);
                        liPronto = liPronto.replace('%%PROVINCIA%%',obj['provincia_azienda']);
                        liPronto = liPronto.replace('%%DESCRIZIONE%%',obj['descrizione_mansione']);
                        $("#_tlLavoro").append(liPronto);
                    } else {

                        $('#L_att_'+obj['id']).text(obj['mansione']);
                        $('#L_dal_'+obj['id']).text(dal);
                        $('#L_al_'+obj['id']).text(al);
                        $('#L_att_'+obj['id']).text(obj['mansione']);          
                        $('#L_presso_'+obj['id']).text(obj['azienda']);
                        $('#L_citta_'+obj['id']).text(obj['citta_azienda']);
                        $('#L_prov_'+obj['id']).text(obj['provincia_azienda']);
                        $('#L_descr_'+obj['id']).text(obj['descrizione_mansione']);
                    }

                    $("#icoAspetta").css("display","none");
                    $("#icoOk").css("display","block");
                    $("#testoInvio").text("Salvataggio effettuato!");
                    //    setTimeout(function() {
                    pulisciChiudiL();
                    //    }, 1000);
                },
                error:function(data){
                    alert('Errore!');
                }
            });
        }
	
           

    });
    
    $('.closemod').on('click', function () {
        pulisciChiudiL();
    });
    
    function pulisciChiudiL(){
	$('.af').val("");
        $('#_lavoro_id').val("0");
	$("#testoInvio").css("display","none");
	$("#icoAspetta").css("display","none");
	$("#icoOk").css("display","none");
	$('#_modalLavoro').modal('hide');
    }
    
    function editLavoro(elemId){
        var idpass = new Array();
        idpass['id'] = elemId;
        
        $.post('actions/getItem.php', { id: elemId }, function(returnedData){
            var obj = JSON.parse(returnedData);

            dal = moment(obj['data_inizio_lav']).format('DD-MM-YYYY');
            al = moment(obj['data_fine_lav']).format('DD-MM-YYYY');
            if (!moment(al, 'DD-MM-YYYY', true).isValid()) al = '';
            $("#_data_inizio_lav").val(dal);
            $("#_data_fine_lav").val(al);
            $("#_lavoro_id").val(obj['id']);
            $("#_mansione").val(obj['mansione']);
            $("#_azienda").val(obj['azienda']);
            $("#_citta_azienda").val(obj['citta_azienda']);
            $("#_provincia_azienda").val(obj['provincia_azienda']);            
            $("#_descrizione_mansione").val(obj['descrizione_mansione']);
            $('#_modalLavoro').modal('show');
            
        });
    }
    
    function deleteLavoro(elemId){
        $('#_cancellaturo').val(elemId);
        $('#_delConfimLavoro').modal('show');
    }
    
    $('#_itemDeleteL').on('click', function () {
        elemId = $('#_cancellaturo').val();
        $.post('actions/deleteItem.php', { id: elemId }, function(returnedData){
            var obj = JSON.parse(returnedData);
            if(obj['result'] === 1){
                $('#L_id_'+elemId).remove();
                $('#_cancellaturo').val('0');
                $('#_delConfimLavoro').modal('hide');
            }
        });
    });

</script>
