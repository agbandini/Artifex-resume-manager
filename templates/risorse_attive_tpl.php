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
                    Gestione Risorse Attive
                    <small>Cv app</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Gestione cv</li>
                </ol>
            </section>
            <!-- Main content -->
            <section class="content">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title"><i class="fa fa-tag"></i> Totale Risorse Attive: <span id="_tot_cv"><?=$tot_cv?></span></h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-lg-3 col-sm-6 col-xs-12">
                                <div class="box box-success">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Cerca per cognome</h3>
                                    </div>
                                    <div class="box-body">
                                        <div class="form-group">
                                            <input required class="form-control cvfilter" type="text" id="_cognome_candidato" name="cognome_candidato" placeholder="Cognome del candidato" />
                                        </div>
                                    </div>
                                </div>
                                <div class="box box-success">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Filtri</h3>
                                    </div>
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label>Anno di nascita</label>
                                            <select required class="form-control select2 cvfilter" name="anno_nascita" id="_anno_nascita" Title="Anno di nascita">
                                                <option value="">-- Selezionare l'anno di nascita --</option>
                                                <?php foreach ($cv_anni_nascita as $anno){ ?>
                                                <option value="<?=$anno['anno_nascita']?>"><?=$anno['anno_nascita']?></option>
                                                <?php } ?>
                                            </select>
                                        </div>                                    
                                        <div class="form-group">
                                            <label>Sesso</label>
                                            <select required class="form-control select2 cvfilter" name="sesso" id="_sesso" Title="Sesso">
                                                <option value="">-- Seleziona --</option>
                                                <option value="M">Uomo</option>
                                                <option value="F">Donna</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Città</label>
                                            <select required class="form-control select2 cvfilter" name="citta" id="_citta" Title="Città">
                                                <option value="">-- Selezionare la città --</option>
                                                <?php foreach ($cv_city as $ct_value){ ?>
                                                <option value="<?=$ct_value['cv_citta']?>"><?=$ct_value['cv_citta']?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Punto vendita di preferenza</label>
                                            <select required class="form-control select2 cvfilter" name="punto_vendita" id="_punto_vendita" Title="Punto Vendita">
                                                <option value="">-- Selezionare il punto vendita --</option>
                                                <?php foreach ($puntiVendita as $pv_key => $pv_value){ ?>
                                                <option value="<?=$pv_value?>"><?=$pv_value?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Esperienza Settore Estetica</label>
                                            <select required class="form-control select2 cvfilter" name="esp_estetica" id="_esp_estetica" Title="Esperienza Estetica">
                                                <option value="">-- Seleziona --</option>
                                                <option value="1">Si</option>
                                                <option value="0">No</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Esperienza Settore Profumeria</label>
                                            <select required class="form-control select2 cvfilter" name="esp_profumeria" id="_esp_profumeria" Title="Esperienza Profumeria">
                                                <option value="">-- Seleziona --</option>
                                                <option value="1">Si</option>
                                                <option value="0">No</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Stato della candidatura</label>
                                            <select required class="form-control select2 cvfilter" name="stato_candidatura" id="_stato_candidatura" Title="Stato candidatura">
                                                <option value="">-- Selezionare lo stato --</option>
                                                <?php foreach ($statiCv as $stat_key => $stat_value){ ?>
                                                <option value="<?=$stat_key?>"><?=$stat_value?></option>
                                                <?php } ?>
                                            </select>
                                        </div>                                         
                                    </div>
                                </div>
                             </div>
                            <div class="col-lg-9 col-sm-6 col-xs-12">
                                <div class="row">
                                        <div class="container-fluid" id="_listaProfili">
                                          
                                        </div>
                                        <div class="clearfix">
                                            <div class="container">
                                                <div id="_avviso" class="callout callout-warning">
                                                    <h4>Attenzione!</h4>
                                                    <p>Nessun risultato disponibile</p>
                                                </div>
                                                <ul id="pagination" class="pagination pagination-sm no-margin"></ul>
                                            </div>
                                        </div>                                        
                                </div>        
                            </div>
                        </div>
                    </div>
            </section><!-- </div>/.content -->
        </div><!-- /.content-wrapper -->
    </div><!-- ./wrapper -->
    <!-- Optionally, you can add Slimscroll and FastClick plugins.
         Both of these plugins are recommended to enhance the
         user experience. Slimscroll is required when using the
         fixed layout. -->
    <!-- jQuery 3 -->
    <div id="_schedaCv" style="display: none;">
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="box box-primary">
                <div class="box-body box-profile">
                    <img class="profile-user-img img-responsive img-circle" src="<?php echo $url; ?>uploads/images/%%IMG%%" alt="%%NOMINATIVO%%">

                    <h3 class="profile-username text-center">%%NOMINATIVO%%</h3>
                    
                    <p class="text-muted text-center"><b>Registrato il:</b> %%DATAISCRIZIONE%%</p>
                    <p class="text-muted text-center">%%STATOCV%%</p>
                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <b>Data Incontro</b> 
                            <p class="text-muted">
                            %%DATAINCONTRO%%
                            </p>
                        </li>                        
                        <li class="list-group-item">
                            <b>Valutazione</b> 
                            <p class="text-muted">
                            %%VALUTAZIONE%%
                            </p>
                        </li>
                        <li class="list-group-item">
                            <b>Telefono</b> 
                            <p class="text-muted">
                            %%TELEFONO%%
                            </p>
                        </li>
                        <li class="list-group-item">
                            <b>Email</b> 
                            <p class="text-muted">
                            %%EMAIL%%
                            </p>
                        </li>
                        <li class="list-group-item">
                            <b>Punto vendita di interesse</b> 
                            <p class="text-muted">
                            %%PUNTOVENDITA%%
                            </p>
                        </li>
                    </ul>
                    <form action="cvdetail.php" method="post">
                        <input type="hidden" name="cv_id" id="_cv_id" value="%%ID%%">
                        <button type="submit" class="btn btn-default btn-block"><b>Dettagli</b></button>                        
                    </form>

                    
                </div>
                <!-- /.box-body -->
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

    <script src="<?php echo $url; ?>templates/plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="<?php echo $url; ?>templates/plugins/jquery-validation/additional-methods.js"></script>
    <script src="<?php echo $url; ?>templates/plugins/jquery-validation/localization/messages_it.js"></script>
    <script src="<?php echo $url; ?>js/risorse_attive.js"></script>
    <?php require_once('footer_tpl' . config_item('template_extension')); ?>