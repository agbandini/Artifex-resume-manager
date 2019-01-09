<?php
require('../common.php');
$idItem = (int)filter_input(INPUT_POST, 'formazione_id', FILTER_SANITIZE_NUMBER_INT);
//modifica disabilitazione date ed inserimento anno
//$data_inizio_form = date("Y-m-d", strtotime(filter_input(INPUT_POST, 'data_inizio_form', FILTER_SANITIZE_STRING)));
//$data_fine_form = date("Y-m-d", strtotime(filter_input(INPUT_POST, 'data_fine_form', FILTER_SANITIZE_STRING)));

$annoAct = filter_input(INPUT_POST, 'anno_attivita', FILTER_SANITIZE_STRING);

//if ($data_fine_form == '1970-01-01') $data_fine_form = NULL;

$datiFormazione = [
    'id' => $idItem,
    'cv_id' => filter_input(INPUT_POST, 'cv_id', FILTER_SANITIZE_NUMBER_INT),
    'anno_attivita' => $annoAct,
    //'data_inizio_form' => $data_inizio_form,
    'data_inizio_form' => NULL,
    //'data_fine_form' => $data_fine_form,
    'data_fine_form' => NULL,
    //'titolo_conseguito' => filter_input(INPUT_POST, 'titolo_conseguito', FILTER_DEFAULT),
    'titolo_conseguito' => filter_input(INPUT_POST, 'certificazione', FILTER_DEFAULT),
    'conseguito_presso' => filter_input(INPUT_POST, 'conseguito_presso', FILTER_DEFAULT),
    'citta_titolo' => filter_input(INPUT_POST, 'citta_titolo', FILTER_DEFAULT),
    'provincia_titolo' => filter_input(INPUT_POST, 'provincia_titolo', FILTER_SANITIZE_STRING),
    'attivita_svolte' => filter_input(INPUT_POST, 'attivita_svolte', FILTER_DEFAULT),
    'tipologia' => 'formazione'
];

if ($idItem == 0){
    $savedData = $curriculum->newFormazione($datiFormazione);
} else {
    $savedData = $curriculum->updateFormazione($datiFormazione);
}

echo json_encode($savedData);