<?php
require('../common.php');

$elemId = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
$itemData = $curriculum->getCvById($elemId);

$itemData['cv_codice_fiscale'] = strtoupper($itemData['cv_codice_fiscale']);
$imgUrl = config_item('site_url').'uploads/images/'.$itemData['cv_file_foto'];
$itemData['cv_file_foto'] = "<a href='$imgUrl'>Visualizza Immagine</a>";

$expFormative = $curriculum->getItemsByCvId($elemId, 'formazione');
$strF = '';
foreach ($expFormative as $ef){
    //$dal = date("d/m/Y", strtotime($ef['data_inizio_form']));
    //$al = date("d/m/Y", strtotime($ef['data_fine_form']));
    $strF .= "$ef[titolo_conseguito] - $ef[citta_titolo] - $ef[anno]<br>";
}
$itemData['esp_formazione'] = $strF;

$expLavoro = $curriculum->getItemsByCvId($elemId, 'lavoro');
$strL = '';
foreach ($expLavoro as $el){
    $dal = date("d/m/Y", strtotime($el['data_inizio_form']));
    $al = date("d/m/Y", strtotime($el['data_fine_form']));
    $strL .= "$el[titolo_conseguito] - $el[citta_titolo] - $dal - $al<br>";
}
$itemData['esp_lavoro'] = $strL;

/*
$str = str_replace('"','',$itemData['cv_preferenza_sede']);
$str = rtrim($str,"]");
$str = ltrim($str,"[");
$itemData['cv_preferenza_sede'] = explode(',',$str);
*/

$itemData['cv_patente'] = ($itemData['cv_patente'] == 0 ? 'No': 'Si');
$itemData['cv_mail_client'] = ($itemData['cv_mail_client'] == 0 ? 'No': 'Si');
$itemData['cv_social_network'] = ($itemData['cv_social_network'] == 0 ? 'No': 'Si');
$itemData['cv_sw_grafica'] = ($itemData['cv_sw_grafica'] == 0 ? 'No': 'Si');
$itemData['cv_comp_commerciali'] = ($itemData['cv_comp_commerciali'] == 0 ? 'No': 'Si');
$itemData['cv_exp_profumeria'] = ($itemData['cv_exp_profumeria'] == 0 ? 'No': 'Si');
$itemData['cv_exp_estetica'] = ($itemData['cv_exp_estetica'] == 0 ? 'No': 'Si');
$itemData['cv_qualifica_estetista'] = ($itemData['cv_qualifica_estetista'] == 0 ? 'No': 'Si');

if($email->mail_rapporto_cv($itemData)){
    echo json_encode(array('result' => 1));
} else {
    echo json_encode(array('result' => 0));
}