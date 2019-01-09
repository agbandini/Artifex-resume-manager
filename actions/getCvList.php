<?php
require('../common.php');

if (!$authentication->logged_in()) die();
if (!$authentication->is_group('admin') and !$authentication->is_group('backoffice')) die();

$strFilters = filter_input(INPUT_POST, 'filters', FILTER_DEFAULT);
$arrFilters = json_decode($strFilters, true);

$params = array(
    'start' => filter_input(INPUT_POST, 'start', FILTER_SANITIZE_NUMBER_INT),
    'end' => filter_input(INPUT_POST, 'end', FILTER_SANITIZE_NUMBER_INT),
    'page' => filter_input(INPUT_POST, 'page', FILTER_SANITIZE_NUMBER_INT),
    'filters' => $arrFilters
);

$itemsData = $curriculum->getAllCv($params);

$icv = 0;
foreach ($itemsData as $curricula) {
    foreach ($statiCv as $stat_key => $stat_value) {
        if ($curricula['cv_status'] == $stat_key){
            $itemsData[$icv]['status_descr'] = $stat_value;
        } 
    }
    $icv++;
}

echo json_encode($itemsData);