<?php
//Include the common file
require('common.php');

//Check if the user is logged in
if (!$authentication->logged_in()) header("Location: login.php");
if (!$authentication->is_group('admin') and !$authentication->is_group('backoffice')) header("Location: login.php");
$cv_id = filter_input(INPUT_POST, 'cv_id', FILTER_SANITIZE_NUMBER_INT);
if (!isset($cv_id)) header("Location: gestione_cv.php");

$userCv = $curriculum->getCvById($cv_id);

foreach ($statiCv as $stat_key => $stat_value) {
    if ($userCv['cv_status'] == $stat_key){
        $userCv['status_descr'] = $stat_value;
    }
}

$str = str_replace('"','',$userCv['cv_lingue']);
$str = rtrim($str,"]");
$str = ltrim($str,"[");
$tpl->set('cvLingue', explode(',',$str));

$str = str_replace('"','',$userCv['cv_preferenza_sede']);
$str = rtrim($str,"]");
$str = ltrim($str,"[");
$tpl->set('cvPuntiVendita', explode(',',$str));

$tpl->set('userCv', $userCv);

$tpl->set('per_form', $curriculum->getItemsByCvId($cv_id,'formazione'));
$tpl->set('per_lav', $curriculum->getItemsByCvId($cv_id,'lavoro'));

$tpl->set('cv_city', $curriculum->getCityFromCv());

$tpl->set('authentication', $authentication);
$tpl->display('cvdetail_tpl');