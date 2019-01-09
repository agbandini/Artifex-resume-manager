<?php if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) exit('No direct access allowed.');
$current_page = basename($_SERVER['PHP_SELF']);
$url = config_item('site_url');

$statiCv = require_once('config/cvStatus.php');
$puntiVendita = require_once('config/cvPuntiVendita.php');
$certificazioni = require_once('config/cvCertificazioni.php');

$appData = require_once('config/app.php');

//Initialize core objects
//$db = new Database();
$dbData = require_once('config/database.php');

$authentication = new Authentication($dbData);
$errore = new Errore();
$session = new Session();
//$validate = new Validate();
$upload = new Upload();
$curriculum = new Curriculum($dbData);
$email = new Email();
$tpl = new Template($appData['absolute_path']);

//Template values

//$tpl->set('db', $db);
//$tpl->set('authentication', $authentication);
$tpl->set('curriculum', $curriculum);
$tpl->set('errore', $errore);
$tpl->set('session', $session);

$tpl->set('current_page', $current_page);
$tpl->set('url', $url);
$tpl->set('statiCv', $statiCv);
$tpl->set('puntiVendita', $puntiVendita);
$tpl->set('certificazioni', $certificazioni);
/**
 * Autoloading classes
 */
function __autoload($class_name) {
    require_once('libraries/' . $class_name . '.php');
    require_once('PHPMailer/class.phpmailer.php');
}


//Logout
if (isset($_GET['logout']) && !$_POST) {
    $authentication->logout();
    header("Location: index.php");
}


function config_load() {
    global $appData;
    return $appData;
}

function config_item($key) {
    global $appData;
    return $appData[$key];
}


function sconfig_load($name) {

    $configuration = array();

    if (!file_exists(dirname(__FILE__) . '/config/' . $name . '.php'))
        die('The file ' . dirname(__FILE__) . '/config/' . $name . '.php does not exist.');

    require(dirname(__FILE__) . '/config/' . $name . '.php');

    if (!isset($config) OR ! is_array($config))
        die('The file ' . dirname(__FILE__) . '/config/' . $name . '.php file does not appear to be formatted correctly.');

    if (isset($config) AND is_array($config))
        $configuration = array_merge($configuration, $config);

    return $configuration;
}

/**
 * Load a config item 
 */
function sconfig_item($name, $item) {

    static $config_item = array();

    if (!isset($config_item[$item])) {

        $config = config_load($name);

        if (!isset($config[$item]))
            return FALSE;

        $config_item[$item] = $config[$item];
    }

    return $config_item[$item];
}