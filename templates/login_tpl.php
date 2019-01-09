<?php require_once('header_tpl' . config_item('template_extension')); ?>
<div class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="<?php echo config_item('site_url'); ?>"><b><?php echo config_item('site_title'); ?></b></a>
        </div><!-- /.login-logo -->
        	    <div class="well">
	    Benvenuto, questo &egrave; un applicativo pensato per le aziende che intendono gestire le candidature presentate dagli aspiranti dipendenti, 
	    si compone in due sezioni, la pagina pubblica di inserimento cv e il pannello amministrativo che consente all'amministratore di gestire 
	    i curriculum pervenuti e al candidato di modificare i dati del propio cv. Il progetto puo essere adattato anche a contesti piu complessi.
	    Di seguito i dati relativi all'accesso demo:
	    <br><br>
	    Amministratore:<br>
	    access mail: demouser@demo.it<br>
	    password: demo
	    <br><br>
	    Candidato:<br>
	    access mail: testuser@demo.it<br>
	    password: demo	    
	    </div>  
	    <br>
        <div class="login-box-body" id="_loginPage">
            <p class="login-box-msg">Autenticati per accedere<br>al pannello di controllo</p>
            <div class="alert alert-warning hide" id="_boxAvviso" >
                <h4><i class="icon fa fa-ban"></i> Avviso!</h4>
                <p id="_testoAvviso"></p>
            </div>
            <form action="" method="post" id="_lgnFrm">
                <div class="form-group has-feedback">
                    <input required type="email" class="form-control" placeholder="Email" name="email" id="_email">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input required type="password" class="form-control" placeholder="Password" name="password" id="_password">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="row">
                    <div class="col-xs-8">
                        <div class="checkbox icheck">
                            <label>
                                <input type="checkbox" name="remember" id="_remember" value="1"> Ricordami
                            </label>
                        </div>
                    </div><!-- /.col -->
                    <div class="col-xs-4">
                        <button type="button" id="_loginBtn" class="btn btn-primary btn-block btn-flat">Accedi  <i id="_icoLogin" class="fa fa-sign-in"></i></button>
                    </div><!-- /.col -->
                </div>
            </form>

            <p>- - -</p>
            <a href="lost_pwd.php">Ho dimenticato la password</a><br>
            <a href="inserisci_curriculum.php">Vai a inserimento CV</a><br>

        </div><!-- /.login-box-body -->
        <br>
      
    </div><!-- /.login-box -->

</div>
<script src="<?php echo $url; ?>templates/plugins/jquery/dist/jquery.min.js"></script>
<script src="<?php echo $url; ?>templates/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Bootstrap 3.3.5 -->
<script src="<?php echo $url; ?>templates/bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="<?php echo $url; ?>templates/plugins/iCheck/icheck.min.js"></script>

<script src="<?php echo $url; ?>templates/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="<?php echo $url; ?>templates/plugins/jquery-validation/additional-methods.js"></script>
<script src="<?php echo $url; ?>templates/plugins/jquery-validation/localization/messages_it.js"></script>

<script src="<?php echo $url; ?>js/sha512.js"></script>
<script src="<?php echo $url; ?>js/login.js"></script>

<?php require_once('footer_tpl' . config_item('template_extension')); ?>
