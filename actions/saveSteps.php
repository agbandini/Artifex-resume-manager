<?php
//error_reporting(E_ERROR);
//Include the common file
require('../common.php');

$cv_id = filter_input(INPUT_POST, 'cv_id', FILTER_SANITIZE_NUMBER_INT);
$step = filter_input(INPUT_GET, 'step', FILTER_SANITIZE_NUMBER_INT);


switch ($step) {
    case 1:
        $immagine_canditato = filter_input(INPUT_POST, 'img_candidato', FILTER_DEFAULT);
        $date_add = date('Y-m-d H:i:s');
        
        $stepData = [
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
            'data_inserimento' => $date_add,
            'page_token' => filter_input(INPUT_POST, 'pageToken', FILTER_SANITIZE_STRING),
            'img_new' => ''
        ];
        //se stiamo inserendo un cv x la prima volta creaimo il record in tabella, diversamente lo aggiorniamo
        if ($cv_id == 0) {
            if (!empty($_FILES['img_new']['name'])) {
		$image = $upload->upload_image('img_new', config_item('med_width'), config_item('med_height'),0);
		
                //inserisco
		$stepData['img_new'] = $image;
            }
            
            //var_dump($stepData);
            
            //inserisco il cv in tabella
            $retuned = [
                'id' => $curriculum->newStep1cv($stepData),
                'img' => $image
            ];

        } else {
            if ((int)$immagine_canditato == 0){
                if (!empty($_FILES['img_new']['name'])) {
                    $image = $upload->upload_image('img_new', config_item('med_width'), config_item('med_height'),0);
                    //inserisco
                    $stepData['img_new'] = $image;
                }                  
            } else {
                $image = $immagine_canditato;
                $stepData['img_new'] = $image;
            }
          
            
            $retuned = [
                'id' => $curriculum->updateStep($step, $stepData),
                'img' => $image
            ];
        
        }
        
        echo json_encode($retuned);
        break;
    case 2:

        //qui dobbiamo solo controllare che almeno un elmento sia stato inserito....
        $retuned = [
           'id' => $cv_id,
           'img' => ''
        ];
        echo json_encode($retuned);
        break;
    case "3":
       //qui dobbiamo solo controllare che almeno un elmento sia stato inserito....
        $retuned = [
           'id' => $cv_id,
           'img' => ''
        ];
        echo json_encode($retuned);
        break;
    case "4":
        
        $json_lingue = json_encode(filter_input(INPUT_POST, 'altre_lingue', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY));
        $json_sedi = json_encode(filter_input(INPUT_POST, 'punti_vendita', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY));
        if ($json_lingue == 'null') $json_lingue = null;
        $stepData = [
            'lingua_madre' => filter_input(INPUT_POST, 'lingua_madre', FILTER_SANITIZE_STRING),
            'altre_lingue' => $json_lingue,
            'patente' => filter_input(INPUT_POST, 'patente', FILTER_SANITIZE_STRING),
            //'comp_comunicative' => filter_input(INPUT_POST, 'competenze_comunicative', FILTER_SANITIZE_STRING),
            //'comp_organizzative' => filter_input(INPUT_POST, 'competenze_organizzative', FILTER_SANITIZE_STRING),
            //'comp_professionali' => filter_input(INPUT_POST, 'competenze_professionali', FILTER_SANITIZE_STRING),
            //'comp_digitali' => filter_input(INPUT_POST, 'competenze_digitali', FILTER_SANITIZE_STRING),
            'comp_sw_email' => filter_input(INPUT_POST, 'comp_sw_email', FILTER_DEFAULT),
            'comp_social_network' => filter_input(INPUT_POST, 'comp_social_network', FILTER_DEFAULT),
            'comp_sw_grafica' => filter_input(INPUT_POST, 'comp_sw_grafica', FILTER_DEFAULT),
            'comp_commerciali' => filter_input(INPUT_POST, 'comp_commerciali', FILTER_DEFAULT),
            'esperienza_profumeria' => filter_input(INPUT_POST, 'esperienza_profumeria', FILTER_DEFAULT),
            'esperienza_estetica' => filter_input(INPUT_POST, 'esperienza_estetica', FILTER_DEFAULT),
            'attestato_estetista' => filter_input(INPUT_POST, 'attestato_estetista', FILTER_DEFAULT),
            'punti_vendita' => $json_sedi,
            'cv_id' => $cv_id
        ];
        
        //restituisco id cv alla funzione jquery
        $retuned = [
           'id' => $curriculum->updateStep($step, $stepData),
           'img' => ''
        ];
        echo json_encode($retuned);
        break;
    default:
        echo "qesto non dovrebbe mai accadere!";
}