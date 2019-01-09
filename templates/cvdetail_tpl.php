<?php require_once('header_tpl' . config_item('template_extension')); ?>
<!-- REQUIRED JS SCRIPTS -->
<body class="hold-transition skin-green-light sidebar-mini">
    <div class="wrapper">

        <!-- Main Header -->
        <header class="main-header">

            <!-- Logo -->
            <a href="index.php" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini"><b>G</b>cv</span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg"><?php echo config_item('site_title'); ?></span>
            </a>

            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>
                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">

                        <!-- User Account Menu -->
                        <li class="dropdown user user-menu">
                            <!-- Menu Toggle Button -->
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <!-- The user image in the navbar-->
                                <img src="<?php echo config_item('site_url'); ?>templates/dist/img/amministratore.png" class="user-image" alt="User Image">
                                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                                <span class="hidden-xs"><?php if ($session->get('user_email')) echo $session->get('user_email'); ?></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- The user image in the menu -->
                                <li class="user-header">
                                    <img src="<?php echo config_item('site_url'); ?>templates/dist/img/amministratore.png" class="img-circle" alt="User Image">
                                    <p>
                                        <?php if ($session->get('first_name')) echo $session->get('first_name') . " " . $session->get('last_name'); ?>
                                        <small>L'unico e il vero amministratore</small>
                                    </p>
                                </li>

                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">

                                    </div>
                                    <div class="pull-right">
                                        <a href="index.php?logout" class="btn btn-default btn-flat">Esci</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">

            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">

                <!-- Sidebar user panel (optional) -->
                <div class="user-panel">
                    <div class="pull-left image">
                        <img src="<?php echo config_item('site_url'); ?>templates/dist/img/amministratore.png" class="img-circle" alt="User Image">
                    </div>
                    <div class="pull-left info">
                        <p><?php if ($session->get('user_email')) echo $session->get('user_email'); ?></p>
                        <!-- Status -->
                        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                    </div>
                </div>
                <?php require_once('menu_tpl' . config_item('template_extension')); ?>
            </section>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Gestione Curriculum
                    <small>Cv app</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Gestione cv</li>
                </ol>
            </section>
            <!-- Main content -->
            <section class="content">
      <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
                <form name="frmCvData" id="_frmCvData">
                    <input type="hidden" name="cv_id" id="_cv_id" class="cv_id" value="<?= $userCv['cv_id'] ?>">
              <img class="profile-user-img1 img-responsive img-rounded" src="<?=$url?>uploads/images/<?=$userCv['cv_file_foto']?>">
              <h3 class="profile-username text-center"><?=$userCv['cv_nome']?> <?=$userCv['cv_cognome']?></h3>
              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Data invio cv</b> <a class="pull-right"><?=date("d/m/Y", strtotime($userCv['cv_data_inserimento']))?></a>
                </li>
                <li class="list-group-item">
                    <div class="form-group">
                        <label>Stato della candidatura</label>
                        <select required class="form-control select2 cvfilter" name="stato_candidatura" id="_stato_candidatura" Title="Stato candidatura">
                            <?php foreach ($statiCv as $stat_key => $stat_value) { 
                                $found = false;
                                if ($stat_key == $userCv['cv_status']) {
                                    $found = true;
                                } ?>
                                <option <?=($found == true) ? 'selected' : '' ?> value="<?= $stat_key ?>"><?= $stat_value ?></option>
                            <?php } ?>
                        </select>
                    </div> 
                </li>
                <li class="list-group-item">
                    <div class="form-group">
                        <label>Incontro in data:</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control pull-right" id="_data_incontro" name="data_incontro" value="<?=(!is_null($userCv['cv_data_incontro']) ? date("d-m-Y", strtotime($userCv['cv_data_incontro'])) : '')?>">
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="form-group">
                        <label>Valutazione</label>
                        <select required class="form-control select2 cvfilter" name="valutazione" id="_valutazione" Title="Valutazione">
                            <?php for ($i = 0; $i <= 10; $i++) { 
                                $found = false;
                                if ($i == $userCv['cv_valutazione']) {
                                    $found = true;
                                } ?>
                                <option <?=($found == true) ? 'selected' : '' ?> value="<?= $i ?>"><?= ($i == 0) ? 'Nessuna valutazione' : $i ?></option>
                            <?php } ?>
                        </select>
                    </div> 
                </li>
                <li class="list-group-item">
                    <div class="form-group">
                        <textarea class="form-control" rows="2" name="osservazioni" id="_osservazioni" placeholder="Osservazioni..."><?=$userCv['cv_considerazioni']?></textarea>
                    </div> 
                </li>                
              </ul>
              <button type="button" class="btn btn-success btn-block" id="_btSalvaAdm"><b>Salva Status CV <i id="_icoSalva" class="fa fa-floppy-o"></i></b></button>
              <a href="cvdetailspdf.php?cv_id=<?=$userCv['cv_id']?>" target="_blank" class="btn btn-danger btn-block"><b>Genera PDF <i id="_icoPdf" class="fa fa-file-pdf-o"></i></b></a>
              </form>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#informazioni" data-toggle="tab">Informazioni</a></li>
              <li><a href="#formazione" data-toggle="tab">Formazione</a></li>
              <li><a href="#lavoro" data-toggle="tab">Lavoro</a></li>
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="informazioni">
                  <div class="row">
                      <div class="col-md-12">
                           <dl>
                            <dt>Punti Vendita di interesse</dt>
                            <dd><?php foreach ($cvPuntiVendita as $pv){
                               echo '<span class="label label-primary">'.$curriculum::Utf8_ansi($pv).'</span> '; 
                            } ?></dd>
                          </dl>                           
                      </div>
                  </div>                  
                  <div class="row">
                      <div class="col-md-3">
                          <dl>
                            <dt>Indirizzo completo</dt>
                            <dd><?=$userCv['cv_indirizzo']?></dd>
                            <dd><?=$userCv['cv_cap']?> - <?=$userCv['cv_citta']?> (<?=$userCv['cv_provincia']?>)</dd>
                          </dl>
                      </div>
                      <div class="col-md-3">
                           <dl>
                            <dt>Codice Fiscale</dt>
                            <dd><?=$userCv['cv_codice_fiscale']?></dd>
                          </dl>                         
                      </div>
                      <div class="col-md-3">
                           <dl>
                            <dt>Email</dt>
                            <dd><?=$userCv['cv_email']?></dd>
                          </dl>                         
                      </div>
                      <div class="col-md-3">
                           <dl>
                            <dt>Telefono</dt>
                            <dd><?=$userCv['cv_telefono']?></dd>
                          </dl>                          
                      </div>
                  </div>
                  <hr/>
                  <div class="row">
                    <div class="col-md-3">
                          <dl>
                            <dt>Data di nascita</dt>
                            <dd><?=date("d/m/Y", strtotime($userCv['cv_data_nascita']))?></dd>
                          </dl>
                      </div>
                      <div class="col-md-3">
                           <dl>
                            <dt>Luogo di nascita</dt>
                            <dd><?=$userCv['cv_luogo_nascita']?></dd>
                          </dl>                          
                      </div>
                      <div class="col-md-3">
                           <dl>
                            <dt>Sesso</dt>
                            <dd><?=$userCv['cv_sesso']?></dd>
                          </dl>                          
                      </div>
                      <div class="col-md-3">
                           <dl>
                            <dt>Automunito</dt>
                            <dd><?=($userCv['cv_patente'] == 0 ? 'No': 'Si')?></dd>
                          </dl>                         
                      </div>
                  </div>
                  <hr>
                  <div class="row">
                      <div class="col-md-3">
                          <dl>
                            <dt>Lingua madre</dt>
                            <dd><?=$userCv['cv_lingua_madre']?></dd>
                          </dl>
                      </div>
                      <div class="col-md-3">
                           <dl>
                            <dt>Altre lingue</dt>
                            <dd><?php foreach ($cvLingue as $lin){
                               echo '<span class="label label-primary">'.$lin.'</span> '; 
                            } ?></dd>
                          </dl>                         
                      </div>                      
                        <div class="col-md-3">
                           <dl>
                            <dt>Utilizzo Software Email</dt>
                            <dd><?=($userCv['cv_mail_client'] == 0 ? 'No': 'Si')?></dd>
                          </dl>                          
                      </div>
                        <div class="col-md-3">
                           <dl>
                            <dt>Utilizzo Social Network</dt>
                            <dd><?=($userCv['cv_social_network'] == 0 ? 'No': 'Si')?></dd>
                          </dl>                          
                      </div>
                  </div>
                  <hr>
                  <div class="row">
                      <div class="col-md-3">
                           <dl>
                            <dt>Utilizzo Software grafica</dt>
                            <dd><?=($userCv['cv_sw_grafica'] == 0 ? 'No': 'Si')?></dd>
                          </dl>                          
                      </div>
                      <div class="col-md-3">
                           <dl>
                            <dt>Competenze commerciali</dt>
                            <dd><?=($userCv['cv_comp_commerciali'] == 0 ? 'No': 'Si')?></dd>
                          </dl>                          
                      </div>
                      <div class="col-md-3">
                           <dl>
                            <dt>Esperienza settore profumeria</dt>
                            <dd><?=($userCv['cv_exp_profumeria'] == 0 ? 'No': 'Si')?></dd>
                          </dl>                          
                      </div>
                       <div class="col-md-3">
                           <dl>
                            <dt>Esperienza settore esterica</dt>
                            <dd><?=($userCv['cv_exp_estetica'] == 0 ? 'No': 'Si')?></dd>
                          </dl>                          
                      </div>
                  </div>
                  <hr>
                  <div class="row">
                      <div class="col-md-3">
                           <dl>
                            <dt>Possiede attestato estetista</dt>
                            <dd><?=($userCv['cv_qualifica_estetista'] == 0 ? 'No': 'Si')?></dd>
                          </dl>                          
                      </div>
                  </div>                  
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="formazione">
                   <div class="row">
                       <div class="container">
                       <div class="col-md-12" style="background-color: #f2f2f2; max-height: 650px; overflow-y: scroll;">
                           <br>
                           <ul class="timeline" id="_tlFormazione">
                               <!-- timeline time label -->
                               <li class="time-label">
                                   <span class="bg-red">
                                       Studi e formazione
                                   </span>
                               </li>
                               <?php foreach ($per_form as $ff){ ?>
                                <li id="">
                                    <i class="fa fa-book bg-yellow"></i>
                                    <div class="timeline-item">
                                        <div class="timeline-header">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h4><span class="text-light-blue" id=""><?=$ff['titolo_conseguito']?></span></h4>
                                                </div>
                                                <div class="col-md-6">
                                                    <h4><span class="text-light-blue text-bold" >Anno: </span><span id="F_dal_-ID-"><?=$ff['anno']?></span></h4>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="timeline-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <span class="text-light-blue"><b>Presso: </b></span> <span id="F_presso_-ID-"><?=$ff['conseguito_presso']?></span>
                                                </div>
                                                <div class="col-md-4">
                                                    <span class="text-light-blue"><b>Citta: </b></span> <span id="F_citta_-ID-"><?=$ff['citta_titolo']?></span>
                                                </div>
                                                <div class="col-md-4">
                                                    <span class="text-light-blue"><b>Provincia: </b></span> <span id="F_prov_-ID-"><?=$ff['provincia_titolo']?></span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <br>
                                                    <p id="F_descr_-ID-"><?=$ff['attivita_svolte']?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>                                       
                               <?php } ?>
                           </ul>
                           <br>                  
                       </div>
                       </div>
                   </div>
              </div>
              <!-- /.tab-pane -->

              <div class="tab-pane" id="lavoro">
                   <div class="row">
                       <div class="container">
                       <div class="col-md-12" style="background-color: #f2f2f2; max-height: 650px; overflow-y: scroll;">
                           <br>
                           <ul class="timeline" id="_tlFormazione">
                               <!-- timeline time label -->
                               <li class="time-label">
                                   <span class="bg-blue">
                                       Esperienze lavorative
                                   </span>
                               </li>
                               <?php foreach ($per_lav as $ff){ ?>
                                <li id="">
                                    <i class="fa fa-book bg-yellow"></i>
                                    <div class="timeline-item">
                                        <div class="timeline-header">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h4><span class="text-light-blue" id=""><?=$ff['titolo_conseguito']?></span></h4>
                                                </div>
                                                <div class="col-md-6">
                                                    <h4><span class="text-light-blue text-bold" >Dal: </span><span id="F_dal_-ID-"><?=$ff['data_inizio_form']?></span><span class="text-light-blue text-bold" > Al: </span><span id="F_al_-ID-"><?=$ff['data_fine_form']?></span></h4>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="timeline-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <span class="text-light-blue"><b>Presso: </b></span> <span id="F_presso_-ID-"><?=$ff['conseguito_presso']?></span>
                                                </div>
                                                <div class="col-md-4">
                                                    <span class="text-light-blue"><b>Citta: </b></span> <span id="F_citta_-ID-"><?=$ff['citta_titolo']?></span>
                                                </div>
                                                <div class="col-md-4">
                                                    <span class="text-light-blue"><b>Provincia: </b></span> <span id="F_prov_-ID-"><?=$ff['provincia_titolo']?></span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <br>
                                                    <p id="F_descr_-ID-"><?=$ff['attivita_svolte']?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>                                       
                               <?php } ?>
                           </ul>
                           <br>                  
                       </div>
                       </div>
                   </div>               
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
            </section><!-- </div>/.content -->
        </div><!-- /.content-wrapper -->
    </div><!-- ./wrapper -->
    <!-- Optionally, you can add Slimscroll and FastClick plugins.
         Both of these plugins are recommended to enhance the
         user experience. Slimscroll is required when using the
         fixed layout. -->
    <!-- jQuery 3 -->
    <div class="modal fade" id="_saveOk">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Salvataggio effettuato con successo!</h4>
                </div>                
                <div class="modal-body">
                    Le informazioni contenute nel tuo cv sono state aggiornate.
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Chiudi</button>
                </div>
            </div>         
        </div> 
    </div>
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
    <script src="<?php echo $url; ?>templates/js/jquery.paging.min.js"></script>
    <!-- date -->
    <script src="<?php echo $url; ?>templates/plugins/datepicker/bootstrap-datepicker.js"></script>
    <script src="<?php echo $url; ?>templates/plugins/datepicker/locales/bootstrap-datepicker.it.js"></script>

    <script src="<?php echo $url; ?>templates/plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="<?php echo $url; ?>templates/plugins/jquery-validation/additional-methods.js"></script>
    <script src="<?php echo $url; ?>templates/plugins/jquery-validation/localization/messages_it.js"></script>
    <script src="<?php echo $url; ?>js/cvdetail.js"></script>
    <?php require_once('footer_tpl' . config_item('template_extension')); ?>