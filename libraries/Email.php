<?php

if (__FILE__ == $_SERVER['SCRIPT_FILENAME'])
    exit('No direct access allowed.');

/**
 * Email class
 */
class Email {

    /**
     * Config
     *
     * @access private 
     */
    private static $config;

    /**
     * Database
     *
     * @access private 
     */
    private $db;

    /**
     * Session
     *
     * @access private 
     */
    private $session;

    /**
     * Constructor
     * 
     * @access public 
     */
    public function __construct() {

        self::$config = config_load();

        //$this->db = new Database();
        $this->session = new Session();
    }

    public function mail_attivazione_account($email, $pwd) {

        try {
            $mail = new PHPMailer();
            $mail->IsSMTP(); // set mailer to use SMTP
            $mail->SMTPAuth = true;
            $mail->From = self::$config['system_email'];
            $mail->CharSet = "UTF-8";
            $mail->FromName = "Griffe Profumerie";
            $mail->Host = self::$config['smtp_host']; // specify main and backup server
            $mail->Port = self::$config['smtp_port']; // Porta SMTP
            $mail->Username = self::$config['smtp_username']; // SMTP account username
            $mail->Password = self::$config['smtp_password']; // SMTP account password
            //$mail->SMTPSecure = "ssl";
            $mail->AddReplyTo(self::$config['system_email']);
            $mail->WordWrap = 50; // set word wrap
            $mail->IsHTML(true); // set email format to HTML

            $message = file_get_contents(self::$config['absolute_path'] . 'templates/mail/welcome_tpl.php');
            
            $mail->Subject = "Abilitazione servizi web Profumerie Griffe";

            $message = str_replace('%%EMAIL%%', $email, $message);
            $message = str_replace('%%PWD%%', $pwd, $message);

            $mail->Body = $message;
            $mail->ClearAddresses();
            $mail->AddAddress($email); // name is optional
            //$mail->Send();
        } catch (Exception $e) {
            return self::$config['smtp_host'];
        }
    }
    
    public function mail_reset_password($email, $pwd) {
        try {
            $mail = new PHPMailer();
            $mail->IsSMTP(); // set mailer to use SMTP
            $mail->SMTPAuth = true;
            $mail->From = self::$config['system_email'];
            $mail->CharSet = "UTF-8";
            $mail->FromName = "Griffe Profumerie";
            $mail->Host = self::$config['smtp_host']; // specify main and backup server
            $mail->Port = self::$config['smtp_port']; // Porta SMTP
            $mail->Username = self::$config['smtp_username']; // SMTP account username
            $mail->Password = self::$config['smtp_password']; // SMTP account password
            //$mail->SMTPSecure = "ssl";
            $mail->AddReplyTo(self::$config['system_email']);
            $mail->WordWrap = 50; // set word wrap
            $mail->IsHTML(true); // set email format to HTML

            $message = file_get_contents(self::$config['absolute_path'] . 'templates/mail/new_password_tpl.php');
            $mail->Subject = "Reset password accesso Procedura CV - Profumerie Griffe!";

            $message = str_replace('%%EMAIL%%', $email, $message);
            $message = str_replace('%%PASSWORD%%', $pwd, $message);

            $mail->Body = $message;
            $mail->ClearAddresses();
            $mail->AddAddress($email); // name is optional
            //$mail->AddBCC("info@3techweb.it"); // name is optional
            //$mail->Send();
        } catch (Exception $e) {
            return self::$config['smtp_host'];
        }
    }

    public function mail_rapporto_cv($dati) {
        try {
            $mail = new PHPMailer();
            $mail->IsSMTP(); // set mailer to use SMTP
            $mail->SMTPAuth = true;
            $mail->From = self::$config['system_email'];
            $mail->CharSet = "UTF-8";
            $mail->FromName = "Griffe Profumerie";
            $mail->Host = self::$config['smtp_host']; // specify main and backup server
            $mail->Port = self::$config['smtp_port']; // Porta SMTP
            $mail->Username = self::$config['smtp_username']; // SMTP account username
            $mail->Password = self::$config['smtp_password']; // SMTP account password
            //$mail->SMTPSecure = "ssl";
            $mail->AddReplyTo(self::$config['system_email']);
            $mail->WordWrap = 50; // set word wrap
            $mail->IsHTML(true); // set email format to HTML

            $message = file_get_contents(self::$config['absolute_path'] . 'templates/mail/cv_tpl.php');
            $message = str_replace('%%NOME%%', $dati['cv_nome'], $message);
            $message = str_replace('%%COGNOME%%', $dati['cv_cognome'], $message);
            $message = str_replace('%%DATANASCITA%%', $dati['cv_data_nascita'], $message);
            $message = str_replace('%%LUOGONASCITA%%', $dati['cv_luogo_nascita'], $message);
            $message = str_replace('%%CF%%', $dati['cv_codice_fiscale'], $message);
            $message = str_replace('%%EMAIL%%', $dati['cv_email'], $message);
            $message = str_replace('%%TEL%%', $dati['cv_telefono'], $message);
            $message = str_replace('%%INDIRIZZO%%', $dati['cv_indirizzo'], $message);
            $message = str_replace('%%CITTA%%', $dati['cv_citta'], $message);
            $message = str_replace('%%CAP%%', $dati['cv_cap'], $message);
            $message = str_replace('%%PROV%%', $dati['cv_provincia'], $message);
            $message = str_replace('%%SEX%%', $dati['cv_sesso'], $message);
            $message = str_replace('%%IMG%%', $dati['cv_file_foto'], $message);
            $message = str_replace('%%LINGUAMADRE%%', $dati['cv_lingua_madre'], $message);
            $message = str_replace('%%ALTRELINGUE%%', $dati['cv_lingue'], $message);
            $message = str_replace('%%PATENTE%%', $dati['cv_patente'], $message);
            $message = str_replace('%%COMPMAIL%%', $dati['cv_mail_client'], $message);
            $message = str_replace('%%COMPSN%%', $dati['cv_social_network'], $message);
            $message = str_replace('%%COMPSG%%', $dati['cv_sw_grafica'], $message);
            $message = str_replace('%%COMPCOMM%%', $dati['cv_comp_commerciali'], $message);
            $message = str_replace('%%EPROFUM%%', $dati['cv_exp_profumeria'], $message);
            $message = str_replace('%%EESTETICA%%', $dati['cv_exp_estetica'], $message);
			$message = str_replace('%%ATTEST%%', $dati['cv_qualifica_estetista'], $message);
            $message = str_replace('%%PUNTOVENDITA%%', $dati['cv_preferenza_sede'], $message);
            $message = str_replace('%%ESP_FORMAZIONE%%', $dati['esp_formazione'], $message);
            $message = str_replace('%%ESP_LAVORO%%', $dati['esp_lavoro'], $message);
                        
            $mail->Subject = "Nuovo cv inserito per Profumerie Griffe";
            $mail->Body = $message;
            $mail->ClearAddresses();
            $mail->AddAddress(self::$config['system_email']); // name is optional 
            $mail->AddAddress(self::$config['admin_email']); // name is optional 
            //$mail->AddAddress("m.casella@profumeriegriffe.com"); 
            //$mail->Send();
            
            return true;
        } catch (Exception $e) {
            return self::$config['smtp_host'];
        }
    }



    public function mail_rapporto_cvTest($dati) {
        try {
            $mail = new PHPMailer();
            $mail->IsSMTP(); // set mailer to use SMTP
            $mail->SMTPAuth = true;
            $mail->From = self::$config['system_email'];
            $mail->CharSet = "UTF-8";
            $mail->FromName = "Griffe Profumerie";
            $mail->Host = self::$config['smtp_host']; // specify main and backup server
            $mail->Port = self::$config['smtp_port']; // Porta SMTP
            $mail->Username = self::$config['smtp_username']; // SMTP account username
            $mail->Password = self::$config['smtp_password']; // SMTP account password
            //$mail->SMTPSecure = "ssl";
            $mail->AddReplyTo(self::$config['system_email']);
            $mail->WordWrap = 50; // set word wrap
            $mail->IsHTML(true); // set email format to HTML

            $message = file_get_contents(self::$config['absolute_path'] . 'templates/mail/cv_tpl.php');
            $message = str_replace('%%NOME%%', $dati['cv_nome'], $message);
            $message = str_replace('%%COGNOME%%', $dati['cv_cognome'], $message);
            $message = str_replace('%%DATANASCITA%%', $dati['cv_data_nascita'], $message);
            $message = str_replace('%%LUOGONASCITA%%', $dati['cv_luogo_nascita'], $message);
            $message = str_replace('%%CF%%', $dati['cv_codice_fiscale'], $message);
            $message = str_replace('%%EMAIL%%', $dati['cv_email'], $message);
            $message = str_replace('%%TEL%%', $dati['cv_telefono'], $message);
            $message = str_replace('%%INDIRIZZO%%', $dati['cv_indirizzo'], $message);
            $message = str_replace('%%CITTA%%', $dati['cv_citta'], $message);
            $message = str_replace('%%CAP%%', $dati['cv_cap'], $message);
            $message = str_replace('%%PROV%%', $dati['cv_provincia'], $message);
            $message = str_replace('%%SEX%%', $dati['cv_sesso'], $message);
            $message = str_replace('%%IMG%%', $dati['cv_file_foto'], $message);
            $message = str_replace('%%LINGUAMADRE%%', $dati['cv_lingua_madre'], $message);
            $message = str_replace('%%ALTRELINGUE%%', $dati['cv_lingue'], $message);
            $message = str_replace('%%PATENTE%%', $dati['cv_patente'], $message);
            $message = str_replace('%%COMPCOMUN%%', $dati['cv_comp_comunicative'], $message);
            $message = str_replace('%%COMPORG%%', $dati['cv_comp_organizzative'], $message);
            $message = str_replace('%%COMPERS%%', $dati['cv_comp_professionali'], $message);
            $message = str_replace('%%COMPDIG%%', $dati['cv_comp_digitali'], $message);
            $message = str_replace('%%EPROFUM%%', $dati['cv_exp_profumeria'], $message);
            $message = str_replace('%%EESTETICA%%', $dati['cv_exp_estetica'], $message);
            $message = str_replace('%%PUNTOVENDITA%%', $dati['cv_preferenza_sede'], $message);
            $message = str_replace('%%ESP_FORMAZIONE%%', $dati['esp_formazione'], $message);
            $message = str_replace('%%ESP_LAVORO%%', $dati['esp_lavoro'], $message);
                        
            $mail->Subject = "Nuovo cv inserito per Profumerie Griffe";
            $mail->Body = $message;
            $mail->ClearAddresses();
            //$mail->AddAddress(self::$config['system_email']); // name is optional 
            //$mail->AddAddress(self::$config['admin_email']); // name is optional 
            $mail->AddAddress("info@studioartifex.it"); 
            $mail->Send();
            
            return true;
        } catch (Exception $e) {
            return self::$config['smtp_host'];
        }
    }

    public function mail_creazione_annuncio($dati) {

        try {

            $mail = new PHPMailer();
            $mail->IsSMTP(); // set mailer to use SMTP
            $mail->SMTPAuth = true;
            $mail->From = "info@potenzaffari.it";
            $mail->CharSet = "UTF-8";
            $mail->FromName = "Potenza Affari";
            $mail->Host = self::$config['smtp_host']; // specify main and backup server
            $mail->Port = self::$config['smtp_port']; // Porta SMTP
            $mail->Username = self::$config['smtp_username']; // SMTP account username
            $mail->Password = self::$config['smtp_password']; // SMTP account password
            //$mail->SMTPSecure = "ssl";
            $mail->AddReplyTo("info@potenzaffari.it", "Potenza Affari");
            $mail->WordWrap = 50; // set word wrap
            $mail->IsHTML(true); // set email format to HTML

            $message = file_get_contents(self::$config['percorso_assoluto'] . 'templates/mail/creazione_annuncio.tpl');
            $message = str_replace('%%NOME%%', $dati['nomereferente'], $message);
            $message = str_replace('%%TITOLOAD%%', $dati['titolo_ad'], $message);
            $message = str_replace('%%IDAD%%', $dati['id_ad'], $message);
            $message = str_replace('%%DAL%%', $dati['dal'], $message);
            $message = str_replace('%%AL%%', $dati['al'], $message);
            $message = str_replace('%%TESTATE%%', $dati['testate'], $message);

            $mail->Subject = "Notifica pubblicazione annuncio Potenza Affari";
            $mail->Body = $message;
            $mail->ClearAddresses();
            $mail->AddAddress($dati['mailreferente']); // name is optional
            $mail->AddBCC("annunci@potenzaffari.it"); // name is optional
            $mail->AddBCC("info@3techweb.it"); // c
            //$mail->Send();
        } catch (Exception $e) {
            return self::$config['smtp_host'];
        }
    }

    public function mail_dal_sito($datidainserire) {

        $email_destinatario = $datidainserire['mail_cliente'];
        $messaggio = $datidainserire['messaggio'];

        try {

            $mail = new PHPMailer();
            $mail->IsSMTP(); // set mailer to use SMTP
            $mail->SMTPAuth = true;
            $mail->CharSet = "UTF-8";
            $mail->From = "info@potenzaffari.it";
            $mail->FromName = "Potenza Affari";
            $mail->Host = self::$config['smtp_host']; // specify main and backup server
            $mail->Port = self::$config['smtp_port']; // Porta SMTP
            $mail->Username = self::$config['smtp_username']; // SMTP account username
            $mail->Password = self::$config['smtp_password']; // SMTP account password
            //$mail->SMTPSecure = "ssl";
            $mail->AddReplyTo("info@potenzaffari.it", "Potenza Affari");
            $mail->WordWrap = 50; // set word wrap
            $mail->IsHTML(true); // set email format to HTML

            $message = file_get_contents(self::$config['absolute_path'] . 'templates/mail/messaggio_email.tpl');
            $message = str_replace('%%IDAD%%', $datidainserire['id_ad'], $message);
            $message = str_replace('%%TITOLOAD%%', $datidainserire['titolo_ad'], $message);
            $message = str_replace('%%NOME%%', $datidainserire['nome_mittente'], $message);
            $message = str_replace('%%EMAIL%%', $datidainserire['mail_mittente'], $message);
            $message = str_replace('%%TEL%%', $datidainserire['cellulare'], $message);
            $message = str_replace('%%MESS%%', $datidainserire['messaggio'], $message);

            $mail->Subject = "Una risposta alla tua inserzione";
            $mail->Body = $message;
            $mail->ClearAddresses();
            $mail->AddAddress($datidainserire['mail_destinatario']); // name is optional
            //$mail->AddAddress("info@3techweb.it"); // name is optional
            //$mail->AddBCC("info@3techweb.it"); // c
            $mail->Send();
        } catch (Exception $e) {
            return self::$config['smtp_host'];
        }
    }

    public function contatto_profilo($datidainserire) {

        $email_destinatario = $datidainserire['mail_cliente'];
        $messaggio = $datidainserire['messaggio'];

        try {

            $mail = new PHPMailer();
            $mail->IsSMTP(); // set mailer to use SMTP
            $mail->SMTPAuth = true;
            $mail->CharSet = "UTF-8";
            $mail->From = "info@potenzaffari.it";
            $mail->FromName = "Potenza Affari";
            $mail->Host = self::$config['smtp_host']; // specify main and backup server
            $mail->Port = self::$config['smtp_port']; // Porta SMTP
            $mail->Username = self::$config['smtp_username']; // SMTP account username
            $mail->Password = self::$config['smtp_password']; // SMTP account password
            //$mail->SMTPSecure = "ssl";
            $mail->AddReplyTo("info@potenzaffari.it", "Potenza Affari");
            $mail->WordWrap = 50; // set word wrap
            $mail->IsHTML(true); // set email format to HTML

            $message = file_get_contents(self::$config['absolute_path'] . 'templates/mail/contatto_profilo.tpl');
            $message = str_replace('%%NOME%%', $datidainserire['nome_mittente'], $message);
            $message = str_replace('%%EMAIL%%', $datidainserire['mail_mittente'], $message);
            $message = str_replace('%%TEL%%', $datidainserire['cellulare'], $message);
            $message = str_replace('%%MESS%%', $datidainserire['messaggio'], $message);

            $mail->Subject = "Un contatto dal sito potenza affari";
            $mail->Body = $message;
            $mail->ClearAddresses();
            $mail->AddAddress($datidainserire['mail_destinatario']); // name is optional
            //$mail->AddAddress("info@3techweb.it"); // name is optional
            $mail->AddBCC("info@3techweb.it"); // c
            $mail->Send();
        } catch (Exception $e) {
            return self::$config['smtp_host'];
        }
    }

    public function contactus($datidainserire) {

        try {

            $mail = new PHPMailer();
            $mail->IsSMTP(); // set mailer to use SMTP
            $mail->SMTPAuth = true;
            $mail->CharSet = "UTF-8";
            $mail->From = "info@potenzaffari.it";
            $mail->FromName = "Potenza Affari";
            $mail->Host = self::$config['smtp_host']; // specify main and backup server
            $mail->Port = self::$config['smtp_port']; // Porta SMTP
            $mail->Username = self::$config['smtp_username']; // SMTP account username
            $mail->Password = self::$config['smtp_password']; // SMTP account password
            //$mail->SMTPSecure = "ssl";
            $mail->AddReplyTo("info@potenzaffari.it", "Potenza Affari");
            $mail->WordWrap = 50; // set word wrap
            $mail->IsHTML(true); // set email format to HTML

            $message = file_get_contents(self::$config['absolute_path'] . 'templates/mail/contactus.tpl');
            $message = str_replace('%%NOME%%', $datidainserire['nome'], $message);
            $message = str_replace('%%COGNOME%%', $datidainserire['cognome'], $message);
            $message = str_replace('%%AZIENDA%%', $datidainserire['azienda'], $message);
            $message = str_replace('%%EMAIL%%', $datidainserire['email'], $message);
            $message = str_replace('%%MESS%%', $datidainserire['messaggio'], $message);

            $mail->Subject = "Una richiesta di contatto dal sito";
            $mail->Body = $message;
            $mail->ClearAddresses();
            $mail->AddAddress("annunci@potenzaffari.it"); // name is optional
            //$mail->AddBCC("info@3techweb.it"); // c
            $mail->Send();
        } catch (Exception $e) {
            return self::$config['smtp_host'];
        }
    }

    public function codice_ga($datidainserire) {

        try {

            $mail = new PHPMailer();
            $mail->IsSMTP(); // set mailer to use SMTP
            $mail->SMTPAuth = true;
            $mail->CharSet = "UTF-8";
            $mail->From = "info@potenzaffari.it";
            $mail->FromName = "Potenza Affari";
            $mail->Host = self::$config['smtp_host']; // specify main and backup server
            $mail->Port = self::$config['smtp_port']; // Porta SMTP
            $mail->Username = self::$config['smtp_username']; // SMTP account username
            $mail->Password = self::$config['smtp_password']; // SMTP account password
            //$mail->SMTPSecure = "ssl";
            $mail->AddReplyTo("info@potenzaffari.it", "Potenza Affari");
            $mail->WordWrap = 50; // set word wrap
            $mail->IsHTML(true); // set email format to HTML

            $message = file_get_contents(self::$config['absolute_path'] . 'templates/mail/codice_ga.tpl');
            $message = str_replace('%%IDAD%%', $datidainserire['id_annuncio'], $message);
            $message = str_replace('%%CODICE%%', $datidainserire['codice'], $message);

            $mail->Subject = "Pagamento con grattino";
            $mail->Body = $message;
            $mail->ClearAddresses();
            $mail->AddAddress("annunci@potenzaffari.it"); // name is optional
            $mail->AddBCC("info@3techweb.it"); // c
            $mail->Send();
        } catch (Exception $e) {
            return self::$config['smtp_host'];
        }
    }

    public function notifica_annuncio_scaduto($dati) {
        try {
            $mail = new PHPMailer();
            $mail->IsSMTP(); // set mailer to use SMTP
            $mail->SMTPAuth = true;
            $mail->From = "info@potenzaffari.it";
            $mail->CharSet = "UTF-8";
            $mail->FromName = "Potenza Affari";
            $mail->Host = self::$config['smtp_host']; // specify main and backup server
            $mail->Port = self::$config['smtp_port']; // Porta SMTP
            $mail->Username = self::$config['smtp_username']; // SMTP account username
            $mail->Password = self::$config['smtp_password']; // SMTP account password
            //$mail->SMTPSecure = "ssl";
            $mail->AddReplyTo("info@potenzaffari.it", "Potenza Affari");
            $mail->WordWrap = 50; // set word wrap
            $mail->IsHTML(true); // set email format to HTML
            //$message = file_get_contents(self::$config['absolute_path'] . 'templates/mail/annuncio_scaduto.tpl');
            $message = file_get_contents('D:/xampp/htdocs/pza/templates/mail/annuncio_scaduto.tpl');
            $message = str_replace('%%NOME%%', ($dati['nome'] . " " . $dati['cognome']), $message);
            $message = str_replace('%%IDAD%%', $dati['id'], $message);
            $message = str_replace('%%TITOLOAD%%', $dati['titolo'], $message);
            $message = str_replace('%%DATASCADENZA%%', $dati['data_scadenza'], $message);


            $mail->Subject = "Il tuo annuncio è scaduto - Potenza Affari";
            $mail->Body = $message;
            $mail->ClearAddresses();
            $mail->AddAddress($dati['email']); // name is optional
            $mail->AddBCC("info@3techweb.it"); // name is optional
            $mail->Send();
        } catch (Exception $e) {
            return self::$config['smtp_host'];
        }
    }

}