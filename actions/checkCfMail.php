<?php
require('../common.php');

$pageToken = $strFilters = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRING);
$cfmail = array(
    'cf' => $strFilters = filter_input(INPUT_POST, 'cf', FILTER_SANITIZE_STRING),
    'mail' => $strFilters = filter_input(INPUT_POST, 'mail', FILTER_SANITIZE_EMAIL),
);

$cv = $curriculum->checkCfMail($cfmail);

//se il risultato della query fa capo ad un vecchio record di un cv non ultimato
//eliminalo, prima però controlla che il token attuale della pagina sia diverso dal token del db
//perche se è uguale vuol dire che lo sta inserendo adesso
if (isset($cv['cv_token']) && $pageToken <> $cv['cv_token']){
    if(isset($cv['cv_all_steps']) && $cv['cv_all_steps'] == 0){
        $curriculum->deleteCvItemsByCvid($cv['cv_id']);
        $curriculum->deleteCv($cv['cv_id']);
        unlink(config_item('upload_path').'images/'.$cv['cv_file_foto']);
        unset($cv);
        $cv = array();
    }    
}

echo json_encode($cv);