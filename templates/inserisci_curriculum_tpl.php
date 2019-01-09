<?php require_once('header_tpl' . config_item('template_extension')); ?>
<style>
    .example-modal .modal {
      position: relative;
      top: auto;
      bottom: auto;
      right: auto;
      left: auto;
      display: block;
      z-index: 1;
    }

    .example-modal .modal {
      background: transparent !important;
    }
</style>
<body class="hold-transition skin-black-light layout-top-nav">
<div class="wrapper">

  <header class="main-header">
    <nav class="navbar navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <a href="../../index2.html" class="navbar-brand"><b>CV</b>app</a>
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
            <i class="fa fa-bars"></i>
          </button>
        </div>

        <!-- /.navbar-collapse -->
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">

        </div>
        <!-- /.navbar-custom-menu -->
      </div>
      <!-- /.container-fluid -->
    </nav>
  </header>
  <!-- Full Width Column -->
  <div class="content-wrapper">
    <div class="container">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Inviaci il tuo Curriculum Vitae
          <small>Compila questo modulo per inviarci la tua candidatura</small>
        </h1>

      </section>
      <section class="content">
            <div class="box box-default">
          <div class="box-header with-border">
            <h3 class="box-title">Informazioni Anagrafiche</h3>
          </div>
          <div class="box-body">
      <div class="nav-tabs-custom">
          <ul class="nav nav-tabs" id="_cvTabs">
              <li id="_cvtab1" class="active"><a href="#tab_1" data-toggle="stab" aria-expanded="true"><h4><span class="label label-danger">1</span> <b>Informazioni personali</b></h4></a></li>
              <li id="_cvtab2" class=""><a href="#tab_2" data-toggle="stab" aria-expanded="false"><h4><span class="label label-danger">2</span> <b>Percorso formativo</b></h4></a></li>
              <li id="_cvtab3" class=""><a href="#tab_3" data-toggle="stab" aria-expanded="false"><h4><span class="label label-danger">3</span> <b>Percorso Professionale</b></h4></a></li>
              <li id="_cvtab4" class=""><a href="#tab_4" data-toggle="stab" aria-expanded="false"><h4><span class="label label-danger">4</span> <b>Competenze personali</b></h4></a></li>
              <li id="_cvtab5" class="" style="display:none;"><a href="#tab_5" data-toggle="stab" aria-expanded="false">Grazie!</a></li>
          </ul>
          <input type="hidden" name="ckcfmail" id="_ckcfmail" value="0">
            <div class="tab-content gmk-panel-height">
              <div class="tab-pane fade in active" id="tab_1">
                <form name="step1" id="_step1" type="post" enctype="multipart/form-data">
                <input type="hidden" name="pageToken" id="_pageToken" value="<?=$token?>">
                <input type="hidden" name="cv_id" id="_cv_id" class="cv_id" value="0">
                  <div class="row">
                      <div class="col-md-4">
                          <div class="form-group">
                              <label>Nome *</label>
                              <input required class="form-control" type="text" name="nome_candidato" id="_nome_candidato" value="" />
                          </div>
                          <div class="form-group">
                              <label>Cognome *</label>
                              <input required class="form-control" type="text" name="cognome_candidato" id="_cognome_candidato" value="" />
                          </div>
                              <div class="form-group">
                                  <label>Data di nascita:</label>
                                  <div class="input-group">
                                      <div class="input-group-addon">
                                          <i class="fa fa-calendar"></i>
                                      </div>
                                      <input required readonly="true" type="text" class="form-control pull-right" id="_data_nascita" name="data_nascita">
                                  </div>
                              </div>
                          <div class="form-group">
                              <label for="luogo_nascita">Luogo di nascita * </label><span>&nbsp;<i id="iconaLuogoNascita" class="fa fa-search"></i></span>
                              <input required class="form-control input-md" type="text" id="_luogo_nascita" name="luogo_nascita" size="50" value="" />
                          </div>                   

                          <div class="form-group">
                              <label>Codice Fiscale *</label>
                              <input required style="text-transform:uppercase" class="form-control cfmail" type="text" id="_codice_fiscale" name="codice_fiscale" maxlength="16" value="" />
                          </div>
                      </div>
                      <div class="col-md-5">
                          <div class="form-group">
                              <label for="nome">Email *</label>
                              <input required class="form-control cfmail" type="text" name="email" id="_email" size="50" value="" />
                          </div>
                          <div class="form-group">
                              <label for="descrizione">Telefono *</label>
                              <input required class="form-control" type="text" name="telefono" id="_telefono" size="11" />
                          </div>
                          <div class="form-group">
                              <label>Indirizzo *</label>
                              <input required class="form-control" type="text" name="indirizzo_residenza" id="_indirizzo_residenza" size="50" value="" />
                          </div>
                          <div class="form-group">
                              <label>Città *</label>&nbsp;<i id="iconaCitta" class="fa fa-search"></i></span>
                              <input required class="form-control input-md" type="text" name="citta" id="_citta" size="50" value="" />
                          </div>
                          <div class="row">
                              <div class="col-md-4">
                                  <div class="form-group">
                                      <label>Cap</label>
                                      <input required class="form-control" type="text" name="cap_residenza" id="_cap_residenza" size="50" value="" />
                                  </div>					
                              </div>
                              <div class="col-md-4">
                                  <div class="form-group">
                                      <label>Provincia / Stato</label>
                                      <input required maxlength="2" class="form-control" type="text" name="provincia_residenza" id="_provincia_residenza" size="50" value="" />
                                  </div>					
                              </div>
                              <div class="col-md-4">
                                  <div class="form-group">
                                      <label>Sesso</label>
                                      <select required class="form-control select2" name="sesso" id="_sesso" Title="Sesso">
                                          <option value="M">Uomo</option>
                                          <option value="F">Donna</option>
                                      </select>
                                  </div>					
                              </div>
                          </div>                        
                      </div>
                      <div class="col-md-3">
                          <div class="form-group">
                              <label>Immagine</label>
                              <input class="form-control required" id="_img_url" type="file" name="img_new" accept="image/*"><br>
                              <input type="hidden" type="text" id="_url_immagine" name="url_immagine" value="<?php echo $url; ?>uploads/images/no_img.png">
                              <input type="hidden" type="text" id="_img_candidato" name="img_candidato" value="0">
                          </div>
                      </div>
                  </div>
              </form>
              </div>
               <!-- /.tab-pane -->
               <div class="tab-pane fade" id="tab_2">
                   <form name="step2" id="_step2" type="post">
                       <input type="hidden" name="cv_id" id="_cv_id" class="cv_id" value="0">  
                   </form> 
                   <div class="row">
                       <div class="col-md-12" style="background-color: #f2f2f2; max-height: 650px; overflow-y: scroll;">
                           <br>
                           <ul class="timeline" id="_tlFormazione">
                               <!-- timeline time label -->
                               <li class="time-label">
                                   <span class="bg-red">
                                       Studi e formazione
                                   </span>
                               </li>
                               <!-- /.timeline-label -->
                           </ul>
                           <br>                  
                       </div>
                   </div>
                   <div class="row">
                       <div class="col-md-6">
                           <h4 id='_alertForm'>Attenzione! E' necessario inserire almeno un elemento.</h4>
                       </div>
                       <div class="col-md-6">
                           <br>
                           <button type="button" class="btn btn-success pull-right addElemento" data-toggle="modal" data-target="#_modalFormazione"><i class="fa fa-plus"></i> Aggiungi</button> 
                       </div>                     
                   </div>
               </div>
              <!-- /.tab-pane -->
              <div class="tab-pane fade" id="tab_3">
                   <form name="step3" id="_step3" type="post">
                       <input type="hidden" name="cv_id" id="_cv_id" class="cv_id" value="0">  
                   </form> 
                   <div class="row">
                       <div class="col-md-12" style="background-color: #f2f2f2; max-height: 650px; overflow-y: scroll;">
                           <br>
                           <ul class="timeline" id="_tlLavoro">
                               <!-- timeline time label -->
                               <li class="time-label">
                                   <span class="bg-blue">
                                       Esperienze Lavorative Pregresse
                                   </span>
                               </li>
                               <!-- /.timeline-label -->
                           </ul>
                           <br>                  
                       </div>
                   </div>
                   <div class="row">
                        <div class="col-md-6">
                           <h4 id='_alertLav'>Attenzione! E' necessario inserire almeno un elemento.</h4>
                       </div>
                       <div class="col-md-6">
                           <br>
                           <button type="button" class="btn btn-success pull-right addElemento" data-toggle="modal" data-target="#_modalLavoro"><i class="fa fa-plus"></i> Aggiungi</button> 
                       </div>                     
                   </div>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane fade" id="tab_4">
                  <form name="step4" id="_step4" type="post">
                      <input type="hidden" name="cv_id" id="_cv_id" class="cv_id" value="0">  
                      <div class="row">
                          <div class="col-md-3">
                              <div class="form-group">
                                  <label>Lingua Madre *</label>
                                  <input required class="form-control" type="text" name="lingua_madre" id="_lingua_madre" value="Italiano" />
                              </div>
                          </div>    
                          <div class="col-md-3">   
                              <div class="form-group">
                                  <label>Altre lingue</label>
                                  <div class="wrapper"></div>
                                  <select class="form-control select2" name="altre_lingue[]" id="_altre_lingue" Title="Altre Lingue" multiple="multiple" style="width:100%">
                                      <?php foreach ($lingue as $li) { ?>
                                          <option value="<?= $li['langIT'] ?>"><?= $li['langIT'] ?></option>
                                      <?php } ?>
                                  </select>
                              </div>
                          </div>      
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label>In quale punto vendita vorresti lavorare? *</label>
                                  <select required class="form-control select2" name="punti_vendita[]" id="_punti_vendita" Title="Punti vendita" multiple="multiple" style="width:100%">
                                        <?php foreach ($puntiVendita as $pv_key => $pv_value){ ?>
                                            <option value="<?=$pv_value?>"><?=$pv_value?></option>
                                        <?php } ?>
                                  </select>
                              </div>					
                          </div>                          
                      </div>       
                      <div class="row">
                          <div class="col-md-3">   
                              <div class="form-group">
                                  <label>Automunito *</label>
                                  <select required class="form-control select2" name="patente" id="_patente" Title="Patenete">
                                      <option value="0">No</option>
                                      <option value="1">Si</option>
                                  </select>
                              </div>
                          </div>  
                          <div class="col-md-3">
                              <div class="form-group">
                                  <label>Utilizzo software email</label>
                                  <select required class="form-control select2" name="comp_sw_email" id="_comp_sw_email" Title="Utilizzo sw email">
                                      <option value="0">No</option>
                                      <option value="1">Si</option>
                                  </select>
                              </div>
                          </div>                           
                          <div class="col-md-3">
                              <div class="form-group">
                                  <label>Utilizzo Social Network</label>
                                  <select required class="form-control select2" name="comp_social_network" id="_comp_social_network" Title="Utilizzo social network">
                                      <option value="0">No</option>
                                      <option value="1">Si</option>
                                  </select>
                              </div>
                          </div>
                          <div class="col-md-3">
                              <div class="form-group">
                                  <label>Competenze software grafici</label>
                                  <select required class="form-control select2" name="comp_sw_grafica" id="_comp_sw_grafica" Title="Utilizzo software grafici">
                                      <option value="0">No</option>
                                      <option value="1">Si</option>
                                  </select>
                              </div>
                          </div>
                      </div>
                      <div class="row">
                          <div class="col-md-3">
                              <div class="form-group">
                                  <label>Competenze commerciali</label>
                                  <select required class="form-control select2" name="comp_commerciali" id="_comp_commerciali" Title="Comptenze commerciali">
                                      <option value="0">No</option>
                                      <option value="1">Si</option>
                                  </select>
                              </div>
                          </div>   
                          <div class="col-md-3">
                              <div class="form-group">
                                  <label>Esperienza settore profumeria *</label>
                                  <select required class="form-control select2" name="esperienza_profumeria" id="_esperienza_profumeria" Title="esperienza profumeria">
                                      <option value="0">No</option>                                      
                                      <option value="1">Si</option>
                                  </select>
                              </div>					
                          </div>
                          <div class="col-md-3">
                              <div class="form-group">
                                  <label>Esperienza settore estetica *</label>
                                  <select required class="form-control select2" name="esperienza_estetica" id="_esperienza_estetica" Title="esperienza estetica">
                                      <option value="0">No</option>
                                      <option value="1">Si</option>
                                  </select>
                              </div>					
                          </div>
                          <div class="col-md-3">
                              <div class="form-group" id="_box_att_est">
                                  <label>Ho una qualifica per esecitare</label>
                                  <select required class="form-control select2" name="attestato_estetista" id="_attestato_estetista" Title="attestato estetista">
                                      <option value="0">No</option>
                                      <option value="1">Si</option>
                                  </select>
                              </div>					
                          </div>
                      </div>
                  </form> 
              </div>
              <div class="tab-pane fade" id="tab_5">
                   <form name="step5" id="_step5" type="post">
                        <input type="hidden" name="cv_id" id="_cv_id" class="cv_id" value="0">
                        <input type="hidden" name="email_send" id="_email_send" value="0">
                        <img id="_img_grazie" class="img-responsive" src="<?php echo $url; ?>uploads/images/grazie.png">
                        <p class="text-center">Grazie per averci inviato la tua candidatura.
                            <br>Riceverai a breve una mail con le credenziali di accesso per la tua area riservata.
                        </p>
                  </form>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          </div>
            <div class="box-footer clearfix no-border">
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-warning" id="_boxAvviso" style="display:none;">
                        <h4><i class="icon fa fa-warning"></i> Attenzione!</h4>
                        <span id="_avviso"></span>
                      </div>                        
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label>I campi contrassegnati con * sono obbligatori.</label>
                       <div class="btn-group pull-right">
                       <button type="button" class="btn btn-default" id="_indietro"><i class="fa fa-arrow-left"></i> Indietro</button>
                       <button type="button" class="btn btn-default" id="_avanti">Avanti <i id="_icoAvanti" class="fa fa-arrow-right"></i></button>                       
                    </div>
                </div>                

                </div>
            </div>
          
          <!-- /.box-body -->
        </div>

          </section>
      <!-- Main content -->

      <!-- /.modal -->       

      
      <!-- /.content -->
    </div>
    <!-- /.container -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="container">
      <div class="pull-right hidden-xs">

    </div>
    <!-- /.container -->
  </footer>
</div>
<!-- jQuery 3 -->
<script src="<?php echo $url; ?>templates/plugins/jquery/dist/jquery.min.js"></script>
<script src="<?php echo $url; ?>templates/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo $url; ?>templates/bootstrap/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="<?php echo $url; ?>templates/plugins/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo $url; ?>templates/dist/js/adminlte.min.js"></script>
<script src="<?php echo $url; ?>templates/plugins/select2/js/select2.min.js"></script>
<script src="<?php echo $url; ?>templates/plugins/fileinput/js/fileinput.min.js"></script>

<script src="<?php echo $url; ?>templates/plugins/moment/moment-with-locales.js"></script>
<!-- date -->
<script src="<?php echo $url; ?>templates/plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="<?php echo $url; ?>templates/plugins/datepicker/locales/bootstrap-datepicker.it.js"></script>

<script src="<?php echo $url; ?>templates/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="<?php echo $url; ?>templates/plugins/jquery-validation/additional-methods.js"></script>
<script src="<?php echo $url; ?>templates/plugins/jquery-validation/localization/messages_it.js"></script>

<script src="<?php echo $url; ?>js/in_common.js"></script>
<script src="<?php echo $url; ?>js/inserisci_curriculum.js"></script>
<?php require_once('modFormazione_tpl' . config_item('template_extension')); ?>
<?php require_once('modLavoro_tpl' . config_item('template_extension')); ?>
<?php require_once('footer_tpl' . config_item('template_extension')); ?>