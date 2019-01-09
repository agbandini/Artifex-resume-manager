<div class="modal fade" id="_modalFormazione">
    <form name="frmFormazione" id="_frmFormazione" action="" method="post" >
        <input type="hidden" name="cv_id" class="cv_id" value="<?=(!isset($cv['cv_id'])) ? '0' : $cv['cv_id']?>">
        <input type="hidden" name="formazione_id" id="_formazione_id" value="0">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close closemod" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Aggiungi Attività Formativa</h4>
                </div>
                <div class="modal-body">
                    <!-- 17-11-2017 modifica campi insermento, offuschiamo data inizio e fine il campo titolo a testo libero a favore di selezione solo anno e salact certificazione  
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Data di inizio:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input required readonly="true" type="text" class="form-control pull-right af" id="_data_inizio_form" name="data_inizio_form">
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
                                    <input readonly="true" type="text" class="form-control pull-right af" id="_data_fine_form" name="data_fine_form">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="Titolo conseguito">Titolo conseguito</label>
                                <input required class="form-control af" type="text" name="titolo_conseguito" id="_titolo_conseguito" size="50" />
                            </div> 
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="Conseguito presso">Conseguito presso</label>
                                <input required class="form-control af" type="text" name="conseguito_presso" id="_conseguito_presso" size="50" />
                            </div> 
                        </div>
                    </div>
                    -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Anno svolgimento attività:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input required readonly="true" type="text" class="form-control pull-right af" id="_anno_attivita" name="anno_attivita">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Certificazione conseguita:</label>
                                <select required class="form-control select2 cvfilter" name="certificazione" id="_certificazione" Title="Certificazione">
                                    <option value="">-- Selezionare la certificazione --</option>
                                    <?php foreach ($certificazioni as $pv_key => $pv_value){ ?>
                                    <option value="<?=$pv_value?>"><?=$pv_value?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="Conseguito presso">Conseguita presso</label>
                                <input required class="form-control af" type="text" name="conseguito_presso" id="_conseguito_presso" size="50" />
                            </div> 
                        </div>
                    </div>

                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="Citta">Citta</label>&nbsp;<i id="iconaCittaTitolo" class="fa fa-search"></i></span>
                                <input required class="form-control af" type="text" id="_citta_titolo" name="citta_titolo" size="50" />
                            </div> 
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="Provincia">Provincia</label>
                                <input required class="form-control af" type="text" name="provincia_titolo" id="_provincia_titolo" maxlength="2" size="50" />
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Attività Svolte</label>
                                <textarea required class="form-control af" id="_attivita_svolte" name="attivita_svolte" rows="3" placeholder="Breve descizione delle attività svolte..."></textarea>
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
                        <button type="button" id="_addFormazioneClose" class="btn btn-default closemod" data-dismiss="modal">Chiudi</button>
                        <button type="button" id="_addFormazione" class="btn btn-primary">Salva</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<div style="display:none;" id="_rowFormazione">
<li id="F_id_-ID-">
    <i class="fa fa-book bg-yellow"></i>
    <div class="timeline-item">
        <div class="timeline-header">
            <div class="row">
                <div class="col-md-6">
                    <h4><span class="text-light-blue" id="F_att_-ID-">%%ATTESTATO%%</span></h4>
                </div>
                <div class="col-md-6">
                    <!-- mofifica date -> solo anno
                    <h4><span class="text-light-blue text-bold" >Dal: </span><span id="F_dal_-ID-">%%DAL%%</span><span class="text-light-blue text-bold" > Al: </span><span id="F_al_-ID-">%%AL%%</span></h4>
                    -->
                    <h4><span class="text-light-blue text-bold" >Anno svolgimento attività: </span><span id="F_anno_-ID-">%%ANNO%%</span></h4>
                </div>
            </div>

        </div>
        <div class="timeline-body">
            <div class="row">
                <div class="col-md-4">
                    <span class="text-light-blue"><b>Presso: </b></span> <span id="F_presso_-ID-">%%PRESSO%%</span>
                </div>
                <div class="col-md-4">
                    <span class="text-light-blue"><b>Citta: </b></span> <span id="F_citta_-ID-">%%CITTA%%</span>
                </div>
                <div class="col-md-4">
                    <span class="text-light-blue"><b>Provincia: </b></span> <span id="F_prov_-ID-">%%PROVINCIA%%</span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <p id="F_descr_-ID-">%%DESCRIZIONE%%</p>
                </div>
            </div>
        </div>
        <div class="timeline-footer">
            <div class="btn-group">
                <button type="button" onclick="editFormazione(%%ID%%)" class="btn btn-default btn-sm"><i class="fa fa-edit"></i></button>
                <button type="button" onclick="deleteFormazione(%%ID%%)" id="_deleteFItem" class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i></button>
            </div>
        </div>
    </div>
</li>    
</div>
<div class="modal fade" id="_delConfimFormaz">
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
                <button type="button" class="btn btn-primary" id="_itemDeleteF">Elimina</button>
                <button type="button" data-dismiss="modal" class="btn">Annulla</button>
            </div>
        </div>         
    </div> 
</div>
<script>

    $(function () {
        $("#_citta_titolo").autocomplete({
            source: 'actions/getCity.php',
            minLength: 2,

            // prendo l'id passato dall query PHP e la passo come valore della text box con id = #_luogo_nascita
            select: function (event, ui) {
                $("#_provincia_titolo").val(ui.item.Provincia);
                return ui.item.label;
            }
        })
    });

    $(document).ready(function () {
        /* modifica rimozione date
        $("#_data_inizio_form").datepicker({
            language: "it",
            format: "dd-mm-yyyy"
        });
        $("#_data_fine_form").datepicker({
            language: "it",
            format: "dd-mm-yyyy"
        });
        */
        $("#_anno_attivita").datepicker({
            autoclose: 'true',
            language: "it",
            format: "yyyy",
            viewMode: "years", 
            minViewMode: "years"
        });       
       

        $("#_citta_titolo").keypress(function () {
            if ($("#_citta_titolo").val().length > 1) {
                $("#iconaCittaTitolo").addClass("fa fa-circle-o-notch fa-spin");
            }
        });

        $("#_citta_titolo").blur(function () {
            $("#iconaCittaTitolo").removeClass("fa fa-circle-o-notch fa-spin");
            $("#iconaCittaTitolo").addClass("fa fa-search");
        });
    });

    $('#_addFormazione').on('click', function () {
        if ($("#_frmFormazione").valid()) {
            $("#testoInvio").css("display","block");
            $("#testoInvio").text(" Salvataggio in corso...");
            $("#icoAspetta").css("display","inline-block");
            $("#icoOk").css("display","none");

            $.ajax({
               url:'actions/saveFormazione.php',
               data:$('#_frmFormazione').serialize(),
               type:'POST',
               success:function(data){

                    obj = JSON.parse(data);
                    //dal = moment(obj['data_inizio_form']).format('DD-MM-YYYY');
                    //al = moment(obj['data_fine_form']).format('DD-MM-YYYY');

                    if($('#_formazione_id').val() === '0'){
                        liPronto = $('#_rowFormazione').html();
                        //if (al === 'Invalid date') al='';
                        liPronto = liPronto.replace(/%%ID%%/g,obj['id']);
                        liPronto = liPronto.replace(/-ID-/g,obj['id']);
                        liPronto = liPronto.replace('%%ATTESTATO%%',obj['titolo_conseguito']);
                        //liPronto = liPronto.replace('%%DAL%%',dal);
                        //liPronto = liPronto.replace('%%AL%%',al);
                        liPronto = liPronto.replace('%%ANNO%%',obj['anno_attivita']);
                        liPronto = liPronto.replace('%%PRESSO%%',obj['conseguito_presso']);
                        liPronto = liPronto.replace('%%CITTA%%',obj['citta_titolo']);
                        liPronto = liPronto.replace('%%PROVINCIA%%',obj['provincia_titolo']);
                        liPronto = liPronto.replace('%%DESCRIZIONE%%',obj['attivita_svolte']);
                        $("#_tlFormazione").append(liPronto);
                    } else {

                        $('#F_att_'+obj['id']).text(obj['titolo_conseguito']);
                        //$('#F_dal_'+obj['id']).text(dal);
                        //$('#F_al_'+obj['id']).text(al);
                        $('#F_anno_'+obj['id']).text(obj['anno_attivita']);
                        $('#F_att_'+obj['id']).text(obj['titolo_conseguito']);          
                        $('#F_presso_'+obj['id']).text(obj['conseguito_presso']);
                        $('#F_citta_'+obj['id']).text(obj['citta_titolo']);
                        $('#F_prov_'+obj['id']).text(obj['provincia_titolo']);
                        $('#F_descr_'+obj['id']).text(obj['attivita_svolte']);
                    }

                    $("#icoAspetta").css("display","none");
                    $("#icoOk").css("display","block");
                    $("#testoInvio").text("Salvataggio effettuato!");
                    pulisciChiudiF();
                },
                error:function(data){
                    alert('Errore!');
                }
            });
        }
    });
    
    $('.closemod').on('click', function () {
        pulisciChiudiF();
    });
    
    function pulisciChiudiF(){
   	$('.af').val("");
        $('#_formazione_id').val("0");
	$("#testoInvio").css("display","none");
	$("#icoAspetta").css("display","none");
	$("#icoOk").css("display","none");
	$('#_modalFormazione').modal('hide');
    }
    
    function editFormazione(elemId){
        var idpass = new Array();
        idpass['id'] = elemId;
        
        $.post('actions/getItem.php', { id: elemId }, function(returnedData){
            var obj = JSON.parse(returnedData);

            //dal = moment(obj['data_inizio_form']).format('DD-MM-YYYY');
            //al = moment(obj['data_fine_form']).format('DD-MM-YYYY');
            //if (!moment(al, 'DD-MM-YYYY', true).isValid()) al = '';
            //$("#_data_inizio_form").val(dal);
            //$("#_data_fine_form").val(al);
            $("#_anno_attivita").val(obj['anno']);
            $("#_formazione_id").val(obj['id']);
            //$("#_titolo_conseguito").val(obj['titolo_conseguito']);
            $('#_titolo_conseguito option[value="' + obj['titolo_conseguito'] + '"]').prop('selected', true);
            $("#_conseguito_presso").val(obj['conseguito_presso']);
            $("#_citta_titolo").val(obj['citta_titolo']);
            $("#_provincia_titolo").val(obj['provincia_titolo']);            
            $("#_attivita_svolte").val(obj['attivita_svolte']);
            $('#_modalFormazione').modal('show');
            
        });
    }
    
    function deleteFormazione(elemId){
        $('#_cancellaturo').val(elemId);
        $('#_delConfimFormaz').modal('show');
    }
    
    $('#_itemDeleteF').on('click', function () {
        elemId = $('#_cancellaturo').val();
        $.post('actions/deleteItem.php', { id: elemId }, function(returnedData){
            var obj = JSON.parse(returnedData);
            if(obj['result'] === 1){
                $('#F_id_'+elemId).remove();
                $('#_cancellaturo').val('0');
                $('#_delConfimFormaz').modal('hide');
            }
        });
    });

</script>
