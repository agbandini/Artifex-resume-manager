<?php
require('common.php');

//Check if the user is logged in
if (!$authentication->logged_in()) header("Location: login.php");
if (!$authentication->is_group('default')) header("Location: index.php");

$cv = $curriculum->getCvById($session->get('cv_id'));

$arr_lingue = json_decode($cv['cv_lingue']);
$arr_punti_vendita = json_decode($cv['cv_preferenza_sede']);


$tpl->set('cv', $cv);
$tpl->set('arr_lingue', $arr_lingue);
$tpl->set('arr_punti_vendita', $arr_punti_vendita);
$tpl->set('authentication', $authentication);
$tpl->set('lingue', $curriculum->getLingue());
$tpl->set('per_form', $curriculum->getItemsByCvId($session->get('cv_id'),'formazione'));
$tpl->set('per_lav', $curriculum->getItemsByCvId($session->get('cv_id'),'lavoro'));
$tpl->display('myCv_tpl');