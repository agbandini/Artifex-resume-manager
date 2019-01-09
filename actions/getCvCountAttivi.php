<?php
require('../common.php');

if (!$authentication->logged_in()) die();
if (!$authentication->is_group('admin') and !$authentication->is_group('backoffice')) die();

$strFilters = filter_input(INPUT_POST, 'filters', FILTER_DEFAULT);
$arrFilters = json_decode($strFilters, true);

$itemsData = $curriculum->getCvCount($arrFilters,1);
echo json_encode($itemsData);