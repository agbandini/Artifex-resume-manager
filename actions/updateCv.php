<?php
require_once('../common.php');

$invalid = array();
if (empty($_POST['nome_candidato'])) {
    $invalid[] = array(
        'campo' => 'nome candidato',
        'tab' => '1'
    );
}
if (empty($_POST['cognome_candidato'])) {
    $invalid[] = array(
        'campo' => 'cognome candidato',
        'tab' => '1'
    );
}
if (empty($_POST['data_nascita'])) {
    $invalid[] = array(
        'campo' => 'data di nascita',
        'tab' => '1'
    );
}
if (empty($_POST['luogo_nascita'])) {
    $invalid[] = array(
        'campo' => 'luogo di nascita',
        'tab' => '1'
    );
}
if (empty($_POST['codice_fiscale'])) {
    $invalid[] = array(
        'campo' => 'codice fiscale',
        'tab' => '1'
    );
}
if (empty($_POST['email'])) {
    $invalid[] = array(
        'campo' => 'email',
        'tab' => '1'
    );
}
if (empty($_POST['telefono'])) {
    $invalid[] = array(
        'campo' => 'telefono',
        'tab' => '1'
    );
}
if (empty($_POST['indirizzo_residenza'])) {
    $invalid[] = array(
        'campo' => 'indirizzo',
        'tab' => '1'
    );
}
if (empty($_POST['citta'])) {
    $invalid[] = array(
        'campo' => 'citta',
        'tab' => '1'
    );
}
if (empty($_POST['cap_residenza'])) {
    $invalid[] = array(
        'campo' => 'cap',
        'tab' => '1'
    );
}
if (empty($_POST['provincia_residenza'])) {
    $invalid[] = array(
        'campo' => 'provincia',
        'tab' => '1'
    );
}
if (empty($_POST['lingua_madre'])) {
    $invalid[] = array(
        'campo' => 'lingua madre',
        'tab' => '4'
    );
}
if (empty($_POST['punti_vendita'])) {
    $invalid[] = array(
        'campo' => 'punti vendita',
        'tab' => '4'
    );
}

if (empty($invalid)){
    
    $immagine_canditato = filter_input(INPUT_POST, 'img_candidato', FILTER_DEFAULT);
    
    $json_lingue = json_encode(filter_input(INPUT_POST, 'altre_lingue', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY));
    $json_sedi = json_encode(filter_input(INPUT_POST, 'punti_vendita', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY));
    
    $cvData = [
        'cv_id' => filter_input(INPUT_POST, 'cv_id', FILTER_SANITIZE_NUMBER_INT),
        'nome_candidato' => filter_input(INPUT_POST, 'nome_candidato', FILTER_SANITIZE_STRING),
        'cognome_candidato' => filter_input(INPUT_POST, 'cognome_candidato', FILTER_SANITIZE_STRING),
        'data_nascita' => filter_input(INPUT_POST, 'data_nascita', FILTER_SANITIZE_STRING),
        'luogo_nascita' => filter_input(INPUT_POST, 'luogo_nascita', FILTER_SANITIZE_STRING),
        'codice_fiscale' => strtoupper(filter_input(INPUT_POST, 'codice_fiscale', FILTER_SANITIZE_STRING)),
        'email' => filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL),
        'telefono' => filter_input(INPUT_POST, 'telefono', FILTER_SANITIZE_STRING),
        'indirizzo_residenza' => filter_input(INPUT_POST, 'indirizzo_residenza', FILTER_SANITIZE_STRING),
        'citta' => filter_input(INPUT_POST, 'citta', FILTER_SANITIZE_STRING),
        'cap_residenza' => filter_input(INPUT_POST, 'cap_residenza', FILTER_SANITIZE_STRING),
        'provincia_residenza' => filter_input(INPUT_POST, 'provincia_residenza', FILTER_SANITIZE_STRING),
        'sesso' => filter_input(INPUT_POST, 'sesso', FILTER_SANITIZE_STRING),
        'lingua_madre' => filter_input(INPUT_POST, 'lingua_madre', FILTER_SANITIZE_STRING),
        'altre_lingue' => $json_lingue,
        'punti_vendita' => $json_sedi,
        'patente' => filter_input(INPUT_POST, 'patente', FILTER_SANITIZE_STRING),
        'comp_sw_email' => filter_input(INPUT_POST, 'comp_sw_email', FILTER_DEFAULT),
        'comp_social_network' => filter_input(INPUT_POST, 'comp_social_network', FILTER_DEFAULT),
        'comp_sw_grafica' => filter_input(INPUT_POST, 'comp_sw_grafica', FILTER_DEFAULT),
        'comp_commerciali' => filter_input(INPUT_POST, 'comp_commerciali', FILTER_DEFAULT),
        'esperienza_profumeria' => filter_input(INPUT_POST, 'esperienza_profumeria', FILTER_DEFAULT),
        'esperienza_estetica' => filter_input(INPUT_POST, 'esperienza_estetica', FILTER_DEFAULT),
        'attestato_estetista' => filter_input(INPUT_POST, 'attestato_estetista', FILTER_DEFAULT),
        'img_new' => ''
    ];  
    
    if (!empty($_FILES['img_new']['name'])) {
        $image = $upload->upload_image('img_new', config_item('med_width'), config_item('med_height'),0);
        //inserisco
        $cvData['img_new'] = $image;
    } else {
        $cvData['img_new'] = $immagine_canditato;
    }
    
    $res = array(
        'status' => $curriculum->updateCvById($cvData),
        'details' => array('img' => $cvData['img_new'])
    );
    
} else {
    $res = array(
        'status' => 0,
        'details' => $invalid
    );
}

echo json_encode($res);