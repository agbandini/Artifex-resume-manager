<?php
require('common.php');

$tpl->set('token', $curriculum->getPageToken());
$tpl->set('lingue', $curriculum->getLingue());
$tpl->display('inserisci_curriculum_blank_tpl');