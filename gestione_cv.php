<?php
require('common.php');
//Check if the user is logged in
if (!$authentication->logged_in()) header("Location: login.php");
if ($authentication->is_group('default')) header("Location: myCv.php");

$a = array();
$tpl->set('authentication', $authentication);
$tpl->set('tot_cv', $curriculum->getCvCount($a,0));
$tpl->set('cv_city', $curriculum->getCityFromCv());
$tpl->set('cv_anni_nascita', $curriculum->getBirthYearsFromCv());
//Display the template
$tpl->display('gestione_cv_tpl');