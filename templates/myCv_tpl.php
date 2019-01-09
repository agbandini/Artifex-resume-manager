<?php require_once('header_tpl' . config_item('template_extension')); ?>
<!-- REQUIRED JS SCRIPTS -->
<style>
    /*
    .file-preview-thumbnails {
        margin: auto;
        width: 60%;
    }
    */
</style>
<body class="hold-transition skin-green-light sidebar-mini">
    <div class="wrapper">

        <!-- Main Header -->
        <header class="main-header">

            <!-- Logo -->
            <a href="index.php" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini"><b>G</b>com</span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg"><?php echo config_item('site_title'); ?></span>
            </a>

            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
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
                    <small>Griffe Profumerie</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Il mio cv</li>
                </ol>
            </section>
            <!-- Main content -->
            <section class="content">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title"><i class="fa fa-tag"></i> Il mio cv: <span id="_tot_cv"><?= strtoupper($session->get('nome') . ' ' . $session->get('cognome')) ?></span></h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-10">
                                <div class="nav-tabs-custom">
                                    <ul class="nav nav-tabs" id="_cvTabs">
                                        <li id="_cvtab1" class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true"><h4><span class="label label-danger">1</span> <b>Informazioni personali</b></h4></a></li>
                                        <li id="_cvtab2" class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false"><h4><span class="label label-danger">2</span> <b>Percorso formativo</b></h4></a></li>
                                        <li id="_cvtab3" class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false"><h4><span class="label label-danger">3</span> <b>Percorso Professionale</b></h4></a></li>
                                        <li id="_cvtab4" class=""><a href="#tab_4" data-toggle="tab" aria-expanded="false"><h4><span class="label label-danger">4</span> <b>Competenze personali</b></h4></a></li>
                                    </ul>
                                    <form name="frmCv" id="_frmCv" type="post" enctype="multipart/form-data">
                                    <input type="hidden" name="cv_id" id="_cv_id" class="cv_id" value="<?= $cv['cv_id'] ?>">                                     
                                    <div class="tab-content gmk-panel-height">
   
                                        <div class="tab-pane fade in active" id="tab_1">
                                            
                                                
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Nome *</label>
                                                            <input required class="form-control" type="text" name="nome_candidato" id="_nome_candidato" value="<?= $cv['cv_nome'] ?>" />
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Cognome *</label>
                                                            <input required class="form-control" type="text" name="cognome_candidato" id="_cognome_candidato" value="<?= $cv['cv_cognome'] ?>" />
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Data di nascita:</label>
                                                            <div class="input-group">
                                                                <div class="input-group-addon">
                                                                    <i class="fa fa-calendar"></i>
                                                                </div>
                                                                <input required readonly="true" type="text" class="form-control pull-right" id="_data_nascita" name="data_nascita" value="<?= $cv['cv_data_nascita'] ?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="luogo_nascita">Luogo di nascita * </label><span>&nbsp;<i id="iconaLuogoNascita" class="fa fa-search"></i></span>
                                                            <input required class="form-control input-md" type="text" id="_luogo_nascita" name="luogo_nascita" size="50" value="<?= $cv['cv_luogo_nascita'] ?>" />
                                                        </div>                   

                                                        <div class="form-group">
                                                            <label>Codice Fiscale *</label>
                                                            <input required style="text-transform:uppercase" class="form-control cfmail" type="text" id="_codice_fiscale" name="codice_fiscale" maxlength="16" value="<?= $cv['cv_codice_fiscale'] ?>" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="form-group">
                                                            <label for="nome">Email *</label>
                                                            <input required class="form-control cfmail" type="text" name="email" id="_email" size="50" value="<?= $cv['cv_email'] ?>" />
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="descrizione">Telefono *</label>
                                                            <input required class="form-control" type="text" name="telefono" id="_telefono" size="11" value="<?= $cv['cv_telefono'] ?>" />
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Indirizzo *</label>
                                                            <input required class="form-control" type="text" name="indirizzo_residenza" id="_indirizzo_residenza" size="50" value="<?= $cv['cv_indirizzo'] ?>" />
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Città *</label>&nbsp;<i id="iconaCitta" class="fa fa-search"></i></span>
                                                            <input required class="form-control input-md" type="text" name="citta" id="_citta" size="50" value="<?= $cv['cv_citta'] ?>" />
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label>Cap</label>
                                                                    <input required class="form-control" type="text" name="cap_residenza" id="_cap_residenza" size="50" value="<?= $cv['cv_cap'] ?>" />
                                                                </div>					
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label>Provincia / Stato</label>
                                                                    <input required maxlength="2" class="form-control" type="text" name="provincia_residenza" id="_provincia_residenza" size="50" value="<?= $cv['cv_provincia'] ?>" />
                                                                </div>					
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label>Sesso</label>
                                                                    <select required class="form-control select2" name="sesso" id="_sesso" Title="Sesso">
                                                                        <option value="M" <?= ($cv['cv_sesso'] == 'M') ? 'selected' : '' ?>>Uomo</option>
                                                                        <option value="F" <?= ($cv['cv_sesso'] == 'F') ? 'selected' : '' ?>>Donna</option>
                                                                    </select>
                                                                </div>					
                                                            </div>
                                                        </div>                        
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>Immagine</label>
                                                            <input class="form-control required" id="_img_url" type="file" name="img_new" accept="image/*"><br>
                                                            <input type="hidden" type="text" id="_url_immagine" name="url_immagine" value="<?php echo $url; ?>uploads/images/<?= $cv['cv_file_foto'] ?>">
                                                            <input type="hidden" type="text" id="_img_candidato" name="img_candidato" value="<?= $cv['cv_file_foto'] ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                        <!-- /.tab-pane -->
                                        <div class="tab-pane fade" id="tab_2">
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
                                                        <?php foreach ($per_form as $ff) { ?>
                                                            <li id="F_id_<?=$ff['id']?>">
                                                                <i class="fa fa-book bg-yellow"></i>
                                                                <div class="timeline-item">
                                                                    <div class="timeline-header">
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <h4><span class="text-light-blue" id=""><?= $ff['titolo_conseguito'] ?></span></h4>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <h4><span class="text-light-blue text-bold" >Anno svolgimento attività: </span><span id="F_anno_<?=$ff['id']?>"><?= $ff['anno'] ?></span></h4>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                    <div class="timeline-body">
                                                                        <div class="row">
                                                                            <div class="col-md-4">
                                                                                <span class="text-light-blue"><b>Presso: </b></span> <span id="F_presso_<?=$ff['id']?>"><?= $ff['conseguito_presso'] ?></span>
                                                                            </div>
                                                                            <div class="col-md-4">
                                                                                <span class="text-light-blue"><b>Citta: </b></span> <span id="F_citta_<?=$ff['id']?>"><?= $ff['citta_titolo'] ?></span>
                                                                            </div>
                                                                            <div class="col-md-4">
                                                                                <span class="text-light-blue"><b>Provincia: </b></span> <span id="F_prov_<?=$ff['id']?>"><?= $ff['provincia_titolo'] ?></span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <br>
                                                                                <p id="F_descr_<?=$ff['id']?>"><?= $ff['attivita_svolte'] ?></p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="timeline-footer">
                                                                        <div class="btn-group">
                                                                            <button type="button" onclick="editFormazione(<?=$ff['id']?>)" class="btn btn-default btn-sm"><i class="fa fa-edit"></i></button>
                                                                            <button type="button" onclick="deleteFormazione(<?=$ff['id']?>)" id="_deleteFItem" class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i></button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </li>                                       
                                                        <?php } ?>
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
                                            <div class="row">
                                                <div class="col-md-12" style="background-color: #f2f2f2; max-height: 650px; overflow-y: scroll;">
                                                    <br>
                                                    <ul class="timeline" id="_tlLavoro">
                                                        <!-- timeline time label -->
                                                        <li class="time-label">
                                                            <span class="bg-blue">
                                                                Esperienze lavorative
                                                            </span>
                                                        </li>
                                                        <?php foreach ($per_lav as $ff) { ?>
                                                            <li id="L_id_<?=$ff['id']?>">
                                                                <i class="fa fa-cogs bg-yellow"></i>
                                                                <div class="timeline-item">
                                                                    <div class="timeline-header">
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <h4><span class="text-light-blue" id=""><?= $ff['titolo_conseguito'] ?></span></h4>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <h4><span class="text-light-blue text-bold" >Dal: </span><span id="L_dal_<?=$ff['id']?>"><?= $ff['data_inizio_form'] ?></span><span class="text-light-blue text-bold" > Al: </span><span id="L_al_<?=$ff['id']?>"><?= $ff['data_fine_form'] ?></span></h4>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                    <div class="timeline-body">
                                                                        <div class="row">
                                                                            <div class="col-md-4">
                                                                                <span class="text-light-blue"><b>Presso: </b></span> <span id="L_presso_<?=$ff['id']?>"><?= $ff['conseguito_presso'] ?></span>
                                                                            </div>
                                                                            <div class="col-md-4">
                                                                                <span class="text-light-blue"><b>Citta: </b></span> <span id="L_citta_<?=$ff['id']?>"><?= $ff['citta_titolo'] ?></span>
                                                                            </div>
                                                                            <div class="col-md-4">
                                                                                <span class="text-light-blue"><b>Provincia: </b></span> <span id="L_prov_<?=$ff['id']?>"><?= $ff['provincia_titolo'] ?></span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <br>
                                                                                <p id="L_descr_<?=$ff['id']?>"><?= $ff['attivita_svolte'] ?></p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="timeline-footer">
                                                                        <div class="btn-group">
                                                                            <button type="button" onclick="editLavoro(<?=$ff['id']?>)" class="btn btn-default btn-sm"><i class="fa fa-edit"></i></button>
                                                                            <button type="button" onclick="deleteLavoro(<?=$ff['id']?>)" id="_deleteLItem" class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i></button>
                                                                        </div>
                                                                    </div>                                  
                                                                </div>
                                                            </li>                                       
                                                        <?php } ?>
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
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>Lingua Madre *</label>
                                                            <input required class="form-control" type="text" name="lingua_madre" id="_lingua_madre" value="<?=$cv['cv_lingua_madre']?>" />
                                                        </div>
                                                    </div>    
                                                    <div class="col-md-3">   
                                                        <div class="form-group">
                                                            <label>Altre lingue</label>
                                                            <div class="wrapper"></div>
                                                            <select class="form-control select2" name="altre_lingue[]" id="_altre_lingue" Title="Altre Lingue" multiple="multiple" style="width:100%">
                                                                <?php foreach ($lingue as $li) { 
                                                                $found = false;
                                                                foreach ($arr_lingue as $ling){
                                                                    if ($li['langIT'] == $ling) {
                                                                        $found = true;
                                                                        break;
                                                                    }
                                                                } ?>
                                                                <option <?=($found == true) ? 'selected' : '' ?> value="<?= $li['langIT'] ?>"><?= $li['langIT'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>      
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>In quale punto vendita vorresti lavorare? *</label>
                                                            <select required class="form-control select2" name="punti_vendita[]" id="_punti_vendita" Title="Punti vendita" multiple="multiple" style="width:100%">
                                                                <?php foreach ($puntiVendita as $pv_key => $pv_value) {
                                                                $found = false;
                                                                foreach ($arr_punti_vendita as $pv){
                                                                    if ($pv_value == html_entity_decode($pv,ENT_QUOTES,'UTF-8')) {
                                                                        $found = true;
                                                                        break;
                                                                    }
                                                                } ?>
                                                                <option <?=($found == true) ? 'selected' : '' ?> value="<?= $pv_value ?>"><?= $pv_value ?></option>
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
                                                                <option <?= ($cv['cv_patente'] == '0') ? 'selected' : '' ?> value="0">No</option>
                                                                <option <?= ($cv['cv_patente'] == '1') ? 'selected' : '' ?>value="1">Si</option>
                                                            </select>
                                                        </div>
                                                    </div>  
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>Utilizzo software email</label>
                                                            <select required class="form-control select2" name="comp_sw_email" id="_comp_sw_email" Title="Utilizzo sw email">
                                                                <option <?= ($cv['cv_mail_client'] == '0') ? 'selected' : '' ?> value="0">No</option>
                                                                <option <?= ($cv['cv_mail_client'] == '1') ? 'selected' : '' ?> value="1">Si</option>
                                                            </select>
                                                        </div>
                                                    </div>                           
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>Utilizzo Social Network</label>
                                                            <select required class="form-control select2" name="comp_social_network" id="_comp_social_network" Title="Utilizzo social network">
                                                                <option <?= ($cv['cv_social_network'] == '0') ? 'selected' : '' ?> value="0">No</option>
                                                                <option <?= ($cv['cv_social_network'] == '1') ? 'selected' : '' ?> value="1">Si</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>Competenze software grafici</label>
                                                            <select required class="form-control select2" name="comp_sw_grafica" id="_comp_sw_grafica" Title="Utilizzo software grafici">
                                                                <option <?= ($cv['cv_sw_grafica'] == '0') ? 'selected' : '' ?> value="0">No</option>
                                                                <option <?= ($cv['cv_sw_grafica'] == '1') ? 'selected' : '' ?> value="1">Si</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>Competenze commerciali</label>
                                                            <select required class="form-control select2" name="comp_commerciali" id="_comp_commerciali" Title="Comptenze commerciali">
                                                                <option <?= ($cv['cv_comp_commerciali'] == '0') ? 'selected' : '' ?> value="0">No</option>
                                                                <option <?= ($cv['cv_comp_commerciali'] == '1') ? 'selected' : '' ?> value="1">Si</option>
                                                            </select>
                                                        </div>
                                                    </div>   
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>Esperienza settore profumeria *</label>
                                                            <select required class="form-control select2" name="esperienza_profumeria" id="_esperienza_profumeria" Title="esperienza profumeria">
                                                                <option <?= ($cv['cv_exp_profumeria'] == '0') ? 'selected' : '' ?> value="0">No</option>                                      
                                                                <option <?= ($cv['cv_exp_profumeria'] == '1') ? 'selected' : '' ?>value="1">Si</option>
                                                            </select>
                                                        </div>					
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>Esperienza settore estetica *</label>
                                                            <select required class="form-control select2" name="esperienza_estetica" id="_esperienza_estetica" Title="esperienza estetica">
                                                                <option <?= ($cv['cv_exp_estetica'] == '0') ? 'selected' : '' ?> value="0">No</option>
                                                                <option <?= ($cv['cv_exp_estetica'] == '1') ? 'selected' : '' ?> value="1">Si</option>
                                                            </select>
                                                        </div>					
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group" id="_box_att_est" style="display:<?=($cv['cv_exp_estetica'] == '0') ? 'none' : 'block' ?>">
                                                            <label>Ho una qualifica per esecitare</label>
                                                            <select required class="form-control select2" name="attestato_estetista" id="_attestato_estetista" Title="attestato estetista">
                                                                <option <?= ($cv['cv_qualifica_estetista'] == '0') ? 'selected' : '' ?> value="0">No</option>
                                                                <option <?= ($cv['cv_qualifica_estetista'] == '1') ? 'selected' : '' ?> value="1">Si</option>
                                                            </select>
                                                        </div>					
                                                    </div>
                                                </div>

                                        </div>
                                        <!-- /.tab-pane -->
                                        
                                    </div>
                                    <!-- /.tab-content -->
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div id="_erroriBox" class="alert alert-warning" style="display:none;">
                                    <h4><i class="icon fa fa-info"></i> Attenzione - Campi non validi!</h4>
                                    <ul id="_erroriList">
                                        
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="button" class="btn btn-success" id="_salvaCv">Salva le modifiche al cv <i id="_icoSalva" class="fa fa-floppy-o"></i></button> 
                    </div>
            </section><!-- </div>/.content -->
        </div><!-- /.content-wrapper -->
    </div><!-- ./wrapper -->
     <!-- Optionally, you can add Slimscroll and FastClick plugins.
         Both of these plugins are recommended to enhance the
         user experience. Slimscroll is required when using the
         fixed layout. -->
    <!-- jQuery 3 -->
    <div class="modal fade" id="_alertSave">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Attenzione!</h4>
                </div>                
                <div class="modal-body">
                    Per poter salvare le modifiche è necessario inserire almeno un elemento sia nel percorso <b>formativo</b> che in quello <b>professionale</b>.                    
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Chiudi</button>
                </div>
            </div>         
        </div> 
    </div>
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

    <script src="<?php echo $url; ?>templates/plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="<?php echo $url; ?>templates/plugins/jquery-validation/additional-methods.js"></script>
    <script src="<?php echo $url; ?>templates/plugins/jquery-validation/localization/messages_it.js"></script>
    <script src="<?php echo $url; ?>js/in_common.js"></script>
    <script src="<?php echo $url; ?>js/myCv.js"></script>
    <?php require_once('modFormazione_tpl' . config_item('template_extension')); ?>
    <?php require_once('modLavoro_tpl' . config_item('template_extension')); ?>    
    <?php require_once('footer_tpl' . config_item('template_extension')); ?>