<?php
require('../common.php');

$data_incontro = date("Y-m-d", strtotime(filter_input(INPUT_POST, 'data_incontro', FILTER_SANITIZE_STRING)));
if("" == trim($_POST['data_incontro'])){
    $data_incontro = null;
}

$in_forze = 0;
if (filter_input(INPUT_POST, 'stato_candidatura', FILTER_SANITIZE_NUMBER_INT) == 8){
    $in_forze = 1;
}

$cvData = [
        'cv_id' => filter_input(INPUT_POST, 'cv_id', FILTER_SANITIZE_NUMBER_INT),
        'cv_status' => filter_input(INPUT_POST, 'stato_candidatura', FILTER_SANITIZE_NUMBER_INT),
        'cv_data_incontro' => $data_incontro,
        'cv_valutazione' => filter_input(INPUT_POST, 'valutazione', FILTER_SANITIZE_NUMBER_INT),
        'cv_considerazioni' => filter_input(INPUT_POST, 'osservazioni', FILTER_SANITIZE_STRING),
        'cv_in_forze' => $in_forze,
    ];

$res = array(
    'status' => $curriculum->updateCvAdmById($cvData)
);

echo json_encode($res);