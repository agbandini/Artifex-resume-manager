<?php
if (__FILE__ == $_SERVER['SCRIPT_FILENAME'])
    exit('No direct access allowed.');

/**
 * Cart class
 */
class Curriculum {

    private static $config;
    private $db;
    private $session;
    private $mysqli;

    public function __construct($dbData) {

        $db = Database::getInstance($dbData);
        
        $this->mysqli = $db->getConnection();
        //$this->db = $db;
        $this->session = new Session();
        //$this->errore = new Errore();
        //$this->email = new Email();

    }

    public function getLingue() {

        $stmt = $this->mysqli->prepare('select * from ecv_world_languages');

        // Execute statement
        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        // Get result 
        $result = $stmt->get_result(); // This method requies mysqlnd drives. pleas eamke sure it is available or else you will get errors.
        // Check number of rows returned from database.

        while ($row = mysqli_fetch_array($result)) {
            $lang[] = array(
                'langIT' => $row['langIT']
            );
        }
        $stmt->close();
        return $lang;
    }

    public function getCitta($searchString) {

        $searchString = "" . mysqli_escape_string($this->mysqli, $searchString) . "%";
        $stmt = $this->mysqli->prepare("SELECT * FROM ecv_comuni WHERE Comune LIKE ? ");
        if (!$stmt->bind_param("s", $searchString)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        // Execute statement
        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        // Get result 
        $result = $stmt->get_result(); // This method requies mysqlnd drives. pleas eamke sure it is available or else you will get errors.
        // Check number of rows returned from database.
        while ($row = mysqli_fetch_array($result)) {
            $row['value'] = htmlentities(stripslashes($row['Comune']));
            $row_set[] = $row;
        }
        $stmt->close();
        return json_encode($row_set);
    }

    public function newStep1Cv($cvDataArr) {

        $sql = "INSERT INTO `ecv_curricula`("
                . "`cv_nome`, "
                . "`cv_cognome`, "
                . "`cv_data_nascita`, "
                . "`cv_luogo_nascita`, "
                . "`cv_codice_fiscale`, "
                . "`cv_indirizzo`, "
                . "`cv_citta`, "
                . "`cv_cap`, "
                . "`cv_provincia`, "
                . "`cv_telefono`, "
                . "`cv_email`, "
                . "`cv_sesso`, "
                . "`cv_data_inserimento`, "
                . "`cv_token`, "
                . "`cv_file_foto`) "
                . "VALUES (? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,?)";

        $stmt = $this->mysqli->prepare($sql);

        if (!$stmt->bind_param("sssssssssssssss", $cvDataArr['nome_candidato'], $cvDataArr['cognome_candidato'], $cvDataArr['data_nascita'], $cvDataArr['luogo_nascita'], $cvDataArr['codice_fiscale'], $cvDataArr['indirizzo_residenza'], $cvDataArr['citta'], $cvDataArr['cap_residenza'], $cvDataArr['provincia_residenza'], $cvDataArr['telefono'], $cvDataArr['email'], $cvDataArr['sesso'], $cvDataArr['data_inserimento'], $cvDataArr['page_token'], $cvDataArr['img_new'])) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        // Execute statement
        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        $lastId = $this->mysqli->insert_id;

        $stmt->close();

        return $lastId;
    }

    public function newFormazione($cvDataArr) {

        $sql = "INSERT INTO `ecv_experiences`("
                . "`ex_id_cv`, "
                . "`ex_tipologia`, "
                . "`ex_data_inizio`, "
                . "`ex_data_fine`, "
                . "`ex_anno`, "
                . "`ex_titolo`, "
                . "`ex_azienda_org`, "
                . "`ex_citta`, "
                . "`ex_provincia`, "
                . "`ex_descrizione`"
                . ") VALUES (?,?,?,?,?,?,?,?,?,?)";

        $stmt = $this->mysqli->prepare($sql);

        if (!$stmt->bind_param("isssssssss", $cvDataArr['cv_id'], $cvDataArr['tipologia'], $cvDataArr['data_inizio_form'], $cvDataArr['data_fine_form'], $cvDataArr['anno_attivita'], $cvDataArr['titolo_conseguito'], $cvDataArr['conseguito_presso'], $cvDataArr['citta_titolo'], $cvDataArr['provincia_titolo'], $cvDataArr['attivita_svolte'])) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        // Execute statement
        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $lastId = $this->mysqli->insert_id;
        $stmt->close();

        $cvDataArr['id'] = $lastId;

        return $cvDataArr;
    }

    public function getItem($id_act) {

        $stmt = $this->mysqli->prepare("SELECT * FROM ecv_experiences WHERE ex_id = ? ");

        if (!$stmt->bind_param("i", $id_act)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        // Execute statement
        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        // Get result 
        $result = $stmt->get_result(); // This method requies mysqlnd drives. pleas eamke sure it is available or else you will get errors.
        // Check number of rows returned from database.
        while ($row = mysqli_fetch_array($result)) {
            $form_act = array(
                'id' => $row['ex_id'],
                'cv_id' => $row['ex_id_cv'],
                'data_inizio_form' => $row['ex_data_inizio'],
                'data_fine_form' => $row['ex_data_fine'],
                'anno' => $row['ex_anno'],
                'titolo_conseguito' => $row['ex_titolo'],
                'conseguito_presso' => $row['ex_azienda_org'],
                'citta_titolo' => $row['ex_citta'],
                'provincia_titolo' => $row['ex_provincia'],
                'attivita_svolte' => $row['ex_descrizione'],
                'tipologia' => $row['ex_tipologia']                
            );
        }
        $stmt->close();
        return $form_act;
    }

    public function updateFormazione($cvDataArr) {

        $sql = "UPDATE `ecv_experiences` SET "
                . "`ex_tipologia`=?,"
                . "`ex_data_inizio`=?,"
                . "`ex_data_fine`=?,"
                . "`ex_anno`=?,"
                . "`ex_titolo`=?,"
                . "`ex_azienda_org`=?,"
                . "`ex_citta`=?,"
                . "`ex_provincia`=?,"
                . "`ex_descrizione`=? "
                . "WHERE `ex_id`=?";

        $stmt = $this->mysqli->prepare($sql);

        if (!$stmt->bind_param("sssssssssi", $cvDataArr['tipologia'], $cvDataArr['data_inizio_form'], $cvDataArr['data_fine_form'], $cvDataArr['anno_attivita'], $cvDataArr['titolo_conseguito'], $cvDataArr['conseguito_presso'], $cvDataArr['citta_titolo'], $cvDataArr['provincia_titolo'], $cvDataArr['attivita_svolte'], $cvDataArr['id'])) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        // Execute statement
        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        
        $stmt->close();

        return $cvDataArr;
    }

    public function deleteCvItem($itemId) {

        $sql = "DELETE FROM `ecv_experiences` WHERE `ex_id`=?";

        $stmt = $this->mysqli->prepare($sql);

        if (!$stmt->bind_param("i", $itemId)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        // Execute statement
        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            $esito = ['result' => 0];
        }

        $esito = ['result' => 1];
        $stmt->close();

        return $esito;
    }

    public function newLavoro($cvDataArr) {

        $sql = "INSERT INTO `ecv_experiences`("
                . "`ex_id_cv`, "
                . "`ex_tipologia`, "
                . "`ex_data_inizio`, "
                . "`ex_data_fine`, "
                . "`ex_titolo`, "
                . "`ex_azienda_org`, "
                . "`ex_citta`, "
                . "`ex_provincia`, "
                . "`ex_descrizione`"
                . ") VALUES (?,?,?,?,?,?,?,?,?)";

        $stmt = $this->mysqli->prepare($sql);

        if (!$stmt->bind_param("issssssss", $cvDataArr['cv_id'], $cvDataArr['tipologia'], $cvDataArr['data_inizio_lav'], $cvDataArr['data_fine_lav'], $cvDataArr['mansione'], $cvDataArr['azienda'], $cvDataArr['citta_azienda'], $cvDataArr['provincia_azienda'], $cvDataArr['descrizione_mansione'])) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        // Execute statement
        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        $lastId = $this->mysqli->insert_id;
        $stmt->close();

        $cvDataArr['id'] = $lastId;

        return $cvDataArr;
    }

    public function updateLavoro($cvDataArr) {

        $sql = "UPDATE `ecv_experiences` SET "
                . "`ex_tipologia`=?,"
                . "`ex_data_inizio`=?,"
                . "`ex_data_fine`=?,"
                . "`ex_titolo`=?,"
                . "`ex_azienda_org`=?,"
                . "`ex_citta`=?,"
                . "`ex_provincia`=?,"
                . "`ex_descrizione`=? "
                . "WHERE `ex_id`=?";

        $stmt = $this->mysqli->prepare($sql);

        if (!$stmt->bind_param("ssssssssi", $cvDataArr['tipologia'], $cvDataArr['data_inizio_lav'], $cvDataArr['data_fine_lav'], $cvDataArr['mansione'], $cvDataArr['azienda'], $cvDataArr['citta_azienda'], $cvDataArr['provincia_azienda'], $cvDataArr['descrizione_mansione'], $cvDataArr['id'])) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        // Execute statement
        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        
        $stmt->close();

        return $cvDataArr;
    }

    public function updateStep($step, $cvDataArr) {

        switch ($step) {
            case 1:
                $sql = "UPDATE `ecv_curricula` SET "
                    . "`cv_nome`=?,"
                    . "`cv_cognome`=?,"
                    . "`cv_data_nascita`=?,"
                    . "`cv_luogo_nascita`=?,"
                    . "`cv_codice_fiscale`=?,"
                    . "`cv_indirizzo`=?,"
                    . "`cv_citta`=?,"
                    . "`cv_cap`=?,"
                    . "`cv_provincia`=?,"
                    . "`cv_telefono`=?,"
                    . "`cv_email`=?,"
                    . "`cv_sesso`=?,"
                    . "`cv_file_foto`=? "
                    . "WHERE `cv_id` = ?";
                
                $stmt = $this->mysqli->prepare($sql);

                //var_dump($cvDataArr);
                
                if (!$stmt->bind_param("sssssssssssssi", $cvDataArr['nome_candidato'], $cvDataArr['cognome_candidato'], $cvDataArr['data_nascita'], $cvDataArr['luogo_nascita'], $cvDataArr['codice_fiscale'], $cvDataArr['indirizzo_residenza'], $cvDataArr['citta'], $cvDataArr['cap_residenza'], $cvDataArr['provincia_residenza'], $cvDataArr['telefono'], $cvDataArr['email'], $cvDataArr['sesso'], $cvDataArr['img_new'], $cvDataArr['cv_id'])) {
                    echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
                }
                
                break;
            case 2:
                break;
            case 3:
                break;
            case 4:
                $sql = "UPDATE `ecv_curricula` SET "
                    . "`cv_lingua_madre`=?,"
                    . "`cv_lingue`=?,"
                    . "`cv_patente`=?,"
                    //. "`cv_comp_comunicative`=?,"
                    //. "`cv_comp_organizzative`=?,"
                    //. "`cv_comp_professionali`=?,"
                    //. "`cv_comp_digitali`=?,"
                    . "`cv_mail_client`=?,"
                    . "`cv_social_network`=?,"
                    . "`cv_sw_grafica`=?,"
                    . "`cv_comp_commerciali`=?,"
                    . "`cv_exp_profumeria`=?,"
                    . "`cv_exp_estetica`=?,"
                    . "`cv_qualifica_estetista`=?,"
                    . "`cv_preferenza_sede`=?, "
                    . "`cv_all_steps`=? "
                    . "WHERE `cv_id` = ?";
                
                $stmt = $this->mysqli->prepare($sql);
                
                //var_dump($cvDataArr);
                $all_steps = 1;
                if (!$stmt->bind_param("ssiiiiiiiisii", $cvDataArr['lingua_madre'], $cvDataArr['altre_lingue'], $cvDataArr['patente'], $cvDataArr['comp_sw_email'], $cvDataArr['comp_social_network'], $cvDataArr['comp_sw_grafica'], $cvDataArr['comp_commerciali'], $cvDataArr['esperienza_profumeria'], $cvDataArr['esperienza_estetica'], $cvDataArr['attestato_estetista'], $cvDataArr['punti_vendita'], $all_steps , $cvDataArr['cv_id'])) {
                    echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
                }

                break;
            default:
                break;
        }
        
        // Execute statement
        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        $lastId = $cvDataArr['cv_id'];

        $stmt->close();

        return $lastId;
    }

    public function getCvById($cv_id) {
        
        $stmt = $this->mysqli->prepare("SELECT * FROM ecv_curricula WHERE cv_id = ? ");
        if (!$stmt->bind_param("i", $cv_id)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        // Execute statement
        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        // Get result 
        $result = $stmt->get_result(); // This method requies mysqlnd drives. pleas eamke sure it is available or else you will get errors.
        // Check number of rows returned from database.
        while ($row = mysqli_fetch_array($result)) {
            $cv_data = $row;
        }
        $stmt->close();
        return $cv_data;
    }

    public function getItemsByCvId($cv_id,$categoria) {

        $stmt = $this->mysqli->prepare("SELECT * FROM ecv_experiences WHERE ex_id_cv = ? AND ex_tipologia = ? ORDER BY ex_data_inizio ASC");
        $categoria = (string)$categoria;
        if (!$stmt->bind_param("is", $cv_id, $categoria)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        // Execute statement
        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        // Get result 
        $result = $stmt->get_result(); // This method requies mysqlnd drives. pleas eamke sure it is available or else you will get errors.
        // Check number of rows returned from database.
        $form_acts = array();
        while ($row = mysqli_fetch_array($result)) {
            $form_acts[] = array(
                'id' => $row['ex_id'],
                'cv_id' => $row['ex_id_cv'],
                'data_inizio_form' => date("d-m-Y", strtotime($row['ex_data_inizio'])),
                'data_fine_form' => date("d-m-Y", strtotime($row['ex_data_fine'])),
                'anno' => $row['ex_anno'],
                'titolo_conseguito' => $row['ex_titolo'],
                'conseguito_presso' => $row['ex_azienda_org'],
                'citta_titolo' => $row['ex_citta'],
                'provincia_titolo' => $row['ex_provincia'],
                'attivita_svolte' => $row['ex_descrizione'],
                'tipologia' => $row['ex_tipologia']                
            );
        }
        $stmt->close();
        return $form_acts;
    }

    public function getAllCv($params, $inForze = 0) {

        if(!empty($params)){
            
            $limitStart = (int)$params['start'];
            $limitLen = ((int)$params['end'] - (int)$params['start']);
            
            $where = 'WHERE cv_all_steps = 1 AND cv_in_forze = '.$inForze;
            if (!empty($params['filters'])){
                $where .= ' AND';
                foreach ($params['filters'] as $key => $par){
                    if ($key == 'cv_cognome'){
                        $searchString = "" . mysqli_escape_string($this->mysqli, $par) . "%";
                        $where .= " cv_cognome LIKE '$searchString%' AND";
                        continue;
                    }                    
                    if ($key == 'cv_anno_nascita'){
                        $where .= " cv_data_nascita BETWEEN CAST('$par-01-01' AS DATE) AND CAST('$par-12-31' AS DATE) AND";
                        continue;
                    }
                    //$par = htmlentities($par, ENT_QUOTES);
                    $par = str_replace("'", '&#39;', $par);
                    $where .= " $key = '$par' AND";
                }
                $where = substr($where, 0, -4);
            }
            
            $stmt = $this->mysqli->prepare("SELECT * FROM ecv_curricula $where ORDER BY cv_data_inserimento DESC LIMIT ?, ?");
        }
        //echo $where;
        if (!$stmt->bind_param("ii", $limitStart, $limitLen)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }          
        
        // Execute statement
        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        // Get result 
        $result = $stmt->get_result(); // This method requies mysqlnd drives. pleas eamke sure it is available or else you will get errors.
        //
        //var_dump($result);
        // Check number of rows returned from database.
        if ($result->num_rows){
            foreach ($result as $row) {
                $cv_data[] = $row;
            }
        } else {
            $cv_data = array();
        }

        return $cv_data;
    }

    public function getCvCount($params, $inForze) {
        
        $where = 'WHERE cv_all_steps = 1 AND cv_in_forze = '.$inForze;
        if (!empty($params)) {
            $where .= ' AND';
            foreach ($params as $key => $par){
                if ($key == 'cv_cognome'){
                    $searchString = "" . mysqli_escape_string($this->mysqli, $par) . "%";
                    $where .= " cv_cognome LIKE '$searchString%' AND";
                    continue;
                }
                if ($key == 'cv_anno_nascita'){
                    $where .= " cv_data_nascita BETWEEN CAST('$par-01-01' AS DATE) AND CAST('$par-12-31' AS DATE) AND";
                    continue;
                }
                //$par = htmlentities($par, ENT_QUOTES);
                $par = str_replace("'", '&#39;', $par);
                $where .= " $key = '$par' AND";
            }
            $where = substr($where, 0, -4);
            
        }
        $sql = "SELECT COUNT(cv_id) as totale_cv FROM ecv_curricula $where";
        $stmt = $this->mysqli->prepare($sql);

        // Execute statement
        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            $esito = ['result' => 0];
        }

        $result = $stmt->get_result();
        
        while ($row = mysqli_fetch_array($result)) {
            $totale_cv = $row['totale_cv'];
        }
        
        $stmt->close();
        return $totale_cv;
    }
    
    public function getCityFromCv() {

        $stmt = $this->mysqli->prepare("SELECT cv_citta FROM ecv_curricula WHERE cv_all_steps = 1 group by cv_citta order by cv_citta asc");

        // Execute statement
        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        // Get result 
        $result = $stmt->get_result(); // This method requies mysqlnd drives. pleas eamke sure it is available or else you will get errors.
        //
        //var_dump($result);
        // Check number of rows returned from database.
        $cv_city = array();
        foreach ($result as $row) {
            $cv_city[] = array(
                'cv_citta' => $row['cv_citta']
            );
        }

        //var_dump($cv_data);

        return $cv_city;
    }
    
    public function getBirthYearsFromCv() {

        $stmt = $this->mysqli->prepare("SELECT YEAR(`cv_data_nascita`) as anno_nascita from ecv_curricula WHERE cv_all_steps = 1 GROUP by anno_nascita order by anno_nascita desc");

        // Execute statement
        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        // Get result 
        $result = $stmt->get_result(); // This method requies mysqlnd drives. pleas eamke sure it is available or else you will get errors.
        //
        //var_dump($result);
        // Check number of rows returned from database.
        $cv_anno = array();
        foreach ($result as $row) {
            $cv_anno[] = array(
                'anno_nascita' => $row['anno_nascita']
            );
        }

        return $cv_anno;
    }
    
    public function getCvBySurname($searchString, $inForze = 0) {

        $searchString = "" . mysqli_escape_string($this->mysqli, $searchString) . "%";
        
        $stmt = $this->mysqli->prepare("SELECT cv_cognome FROM ecv_curricula WHERE cv_all_steps = 1 AND cv_in_forze = $inForze AND cv_cognome LIKE ? GROUP BY cv_cognome");
        if (!$stmt->bind_param("s", $searchString)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        // Execute statement
        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        // Get result 
        $result = $stmt->get_result(); // This method requies mysqlnd drives. pleas eamke sure it is available or else you will get errors.
        // Check number of rows returned from database.
        $row_set = array();
        while ($row = mysqli_fetch_array($result)) {
            $row['value'] = htmlentities(stripslashes($row['cv_cognome']));
            $row_set[] = $row;
        }
        $stmt->close();
        return json_encode($row_set);
    }
    
    

    public function checkCfMail($cfMailData) {

        $stmt = $this->mysqli->prepare("SELECT * FROM ecv_curricula WHERE cv_codice_fiscale = ? OR cv_email = ?");
        if (!$stmt->bind_param("ss", $cfMailData['cf'], $cfMailData['mail'])) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        // Execute statement
        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        // Get result 
        $result = $stmt->get_result(); // This method requies mysqlnd drives. pleas eamke sure it is available or else you will get errors.
        // Check number of rows returned from database.
        
        $cv_data = array();
        while ($row = mysqli_fetch_array($result)) {
            $cv_data = array(
                'cv_id' => $row['cv_id'],
                'cv_nome' => $row['cv_nome'],
                'cv_cognome' => $row['cv_cognome'],
                'cv_data_nascita' => $row['cv_data_nascita'],
                'cv_luogo_nascita' => $row['cv_luogo_nascita'],
                'cv_codice_fiscale' => $row['cv_codice_fiscale'],
                'cv_sesso' => $row['cv_sesso'],
                'cv_patente' => $row['cv_patente'],
                'cv_indirizzo' => $row['cv_indirizzo'],
                'cv_citta' => $row['cv_citta'],
                'cv_cap' => $row['cv_cap'],
                'cv_provincia' => $row['cv_provincia'],
                'cv_telefono' => $row['cv_telefono'],
                'cv_email' => $row['cv_email'],
                'cv_file_foto' => $row['cv_file_foto'],
                'cv_exp_estetica' => $row['cv_exp_estetica'],
                'cv_qualifica_estetista' => $row['cv_qualifica_estetista'],
                'cv_exp_profumeria' => $row['cv_exp_profumeria'],
                'cv_lingua_madre' => $row['cv_lingua_madre'],
                'cv_lingue' => $row['cv_lingue'],
                //'cv_comp_comunicative' => $row['cv_comp_comunicative'],
                //'cv_comp_organizzative' => $row['cv_comp_organizzative'],
                //'cv_comp_professionali' => $row['cv_comp_professionali'],
                //'cv_comp_digitali' => $row['cv_comp_digitali'],
                'cv_mail_client' => $row['cv_mail_client'],
                'cv_social_network' => $row['cv_social_network'],
                'cv_sw_grafica' => $row['cv_sw_grafica'],
                'cv_comp_commerciali' => $row['cv_comp_commerciali'],
                'cv_preferenza_sede' => $row['cv_preferenza_sede'],
                'cv_status' => $row['cv_status'],
                'cv_data_inserimento' => $row['cv_data_inserimento'],
                'cv_all_steps' => $row['cv_all_steps'],
                'cv_token' => $row['cv_token'],
            );
        }
        $stmt->close();
        return $cv_data;
    }

    public function deleteCvItemsByCvid($cvId) {

        $sql = "DELETE FROM `ecv_experiences` WHERE `ex_id_cv`=?";

        $stmt = $this->mysqli->prepare($sql);

        if (!$stmt->bind_param("i", $cvId)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        // Execute statement
        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            $esito = ['result' => 0];
        }

        $esito = ['result' => 1];
        $stmt->close();

        return $esito;
    }

    public function deleteCv($cvId) {

        $sql = "DELETE FROM `ecv_curricula` WHERE `cv_id`=?";

        $stmt = $this->mysqli->prepare($sql);

        if (!$stmt->bind_param("i", $cvId)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        // Execute statement
        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            $esito = ['result' => 0];
        }

        $esito = ['result' => 1];
        $stmt->close();

        return $esito;
    }
    
    public function getPageToken() {
        return uniqid();
    }
        

    public function updateCvById($cvDataArr) {

        $sql = "UPDATE `ecv_curricula` SET "
                . "`cv_nome`=?,"
                . "`cv_cognome`=?,"
                . "`cv_data_nascita`=?,"
                . "`cv_luogo_nascita`=?,"
                . "`cv_codice_fiscale`=?,"
                . "`cv_indirizzo`=?,"
                . "`cv_citta`=?,"
                . "`cv_cap`=?,"
                . "`cv_provincia`=?,"
                . "`cv_telefono`=?,"
                . "`cv_email`=?,"
                . "`cv_sesso`=?,"
                . "`cv_file_foto`=?,"
                . "`cv_lingua_madre`=?,"
                . "`cv_lingue`=?,"
                . "`cv_patente`=?,"
                . "`cv_mail_client`=?,"
                . "`cv_social_network`=?,"
                . "`cv_sw_grafica`=?,"
                . "`cv_comp_commerciali`=?,"
                . "`cv_exp_profumeria`=?,"
                . "`cv_exp_estetica`=?,"
                . "`cv_qualifica_estetista`=?,"
                . "`cv_preferenza_sede`=? "
                . "WHERE `cv_id` = ?";

        $stmt = $this->mysqli->prepare($sql);

        //var_dump($cvDataArr);

        if (!$stmt->bind_param("ssssssssssssssiiiiiiiiisi", $cvDataArr['nome_candidato'], $cvDataArr['cognome_candidato'], $cvDataArr['data_nascita'], $cvDataArr['luogo_nascita'], $cvDataArr['codice_fiscale'], $cvDataArr['indirizzo_residenza'], $cvDataArr['citta'], $cvDataArr['cap_residenza'], $cvDataArr['provincia_residenza'], $cvDataArr['telefono'], $cvDataArr['email'], $cvDataArr['sesso'], $cvDataArr['img_new'], $cvDataArr['lingua_madre'], $cvDataArr['altre_lingue'], $cvDataArr['patente'], $cvDataArr['comp_sw_email'], $cvDataArr['comp_social_network'], $cvDataArr['comp_sw_grafica'], $cvDataArr['comp_commerciali'], $cvDataArr['esperienza_profumeria'], $cvDataArr['esperienza_estetica'], $cvDataArr['attestato_estetista'], $cvDataArr['punti_vendita'], $cvDataArr['cv_id'])) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        // Execute statement
        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        $lastId = $cvDataArr['cv_id'];

        $stmt->close();

        return $lastId;
    }

public static function Utf8_ansi($valor='') {

    $utf8_ansi2 = array(
    "\u00c0" =>"À",
    "\u00c1" =>"Á",
    "\u00c2" =>"Â",
    "\u00c3" =>"Ã",
    "\u00c4" =>"Ä",
    "\u00c5" =>"Å",
    "\u00c6" =>"Æ",
    "\u00c7" =>"Ç",
    "\u00c8" =>"È",
    "\u00c9" =>"É",
    "\u00ca" =>"Ê",
    "\u00cb" =>"Ë",
    "\u00cc" =>"Ì",
    "\u00cd" =>"Í",
    "\u00ce" =>"Î",
    "\u00cf" =>"Ï",
    "\u00d1" =>"Ñ",
    "\u00d2" =>"Ò",
    "\u00d3" =>"Ó",
    "\u00d4" =>"Ô",
    "\u00d5" =>"Õ",
    "\u00d6" =>"Ö",
    "\u00d8" =>"Ø",
    "\u00d9" =>"Ù",
    "\u00da" =>"Ú",
    "\u00db" =>"Û",
    "\u00dc" =>"Ü",
    "\u00dd" =>"Ý",
    "\u00df" =>"ß",
    "\u00e0" =>"à",
    "\u00e1" =>"á",
    "\u00e2" =>"â",
    "\u00e3" =>"ã",
    "\u00e4" =>"ä",
    "\u00e5" =>"å",
    "\u00e6" =>"æ",
    "\u00e7" =>"ç",
    "\u00e8" =>"è",
    "\u00e9" =>"é",
    "\u00ea" =>"ê",
    "\u00eb" =>"ë",
    "\u00ec" =>"ì",
    "\u00ed" =>"í",
    "\u00ee" =>"î",
    "\u00ef" =>"ï",
    "\u00f0" =>"ð",
    "\u00f1" =>"ñ",
    "\u00f2" =>"ò",
    "\u00f3" =>"ó",
    "\u00f4" =>"ô",
    "\u00f5" =>"õ",
    "\u00f6" =>"ö",
    "\u00f8" =>"ø",
    "\u00f9" =>"ù",
    "\u00fa" =>"ú",
    "\u00fb" =>"û",
    "\u00fc" =>"ü",
    "\u00fd" =>"ý",
    "\u00ff" =>"ÿ");

    return strtr($valor, $utf8_ansi2);      

}

    public function updateCvAdmById($cvDataArr) {

        $sql = "UPDATE `ecv_curricula` SET "
                . "`cv_status`=?,"
                . "`cv_data_incontro`=?,"
                . "`cv_valutazione`=?,"
                . "`cv_considerazioni`=?, "
                . "`cv_in_forze`=? "
                . "WHERE `cv_id` = ?";

        $stmt = $this->mysqli->prepare($sql);

        //var_dump($cvDataArr);

        if (!$stmt->bind_param("isisii", $cvDataArr['cv_status'], $cvDataArr['cv_data_incontro'], $cvDataArr['cv_valutazione'], $cvDataArr['cv_considerazioni'], $cvDataArr['cv_in_forze'], $cvDataArr['cv_id'])) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        // Execute statement
        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        $lastId = $cvDataArr['cv_id'];
        $stmt->close();
        return $lastId;
    }

//--------------------------------------------------------------------------------------------------------------------  
    
    public function is_on_paper($id_annuncio) {

        $id_annuncio = filter_var($id_annuncio, FILTER_SANITIZE_NUMBER_INT);
        $oggi = date("Y-m-d");

        $config1 = config_load('database');
        $link = mysql_connect($config1['hostname'], $config1['username'], $config1['password']) or die("Non riesco a connettermi");
        mysql_select_db($config1['dbname'], $link) or die("Errore nella selezione del database");

        $sql = "SELECT data_prevista_uscita FROM " . config_item('impianti', 'table_relazione') . " rel
		inner join " . config_item('impianti', 'table_annunci') . " ads on rel.id_annuncio = ads.id 
		where ads.approvato = '1' and ads.status = '1' and rel.id_annuncio = '" . $id_annuncio . "' order by data_prevista_uscita desc";
        $result = mysql_query($sql);
        $conteggio = false;
        while ($row1 = mysql_fetch_array($result)) {
            //$conteggio = $row1['contoannunci'];
            if ($row1['data_prevista_uscita'] >= $oggi) {
                $conteggio = true;
            }
        }
        return $conteggio;
    }

    public function get_count_annunci_pay($id_testata, $data_uscita) {

        $id_testata = filter_var($id_testata, FILTER_SANITIZE_NUMBER_INT);

        $config1 = config_load('database');
        $link = mysql_connect($config1['hostname'], $config1['username'], $config1['password']) or die("Non riesco a connettermi");
        mysql_select_db($config1['dbname'], $link) or die("Errore nella selezione del database");

        $sql = "SELECT count(rel.id) as contoannunci FROM " . config_item('impianti', 'table_relazione') . " rel
		inner join " . config_item('impianti', 'table_annunci') . " ads on rel.id_annuncio = ads.id
		where ads.approvato = '1' and ads.status = '1' and ads.annuncio_pagamento = '1' and rel.id_testata = '" . $id_testata . "' and rel.data_prevista_uscita = '" . $data_uscita . "'";
        $result = mysql_query($sql);

        while ($row1 = mysql_fetch_array($result)) {
            $conteggio = $row1['contoannunci'];
        }
        return $conteggio;
    }

    public function get_count_annunci_all($id_testata, $data_uscita) {

        $id_testata = filter_var($id_testata, FILTER_SANITIZE_NUMBER_INT);

        $config1 = config_load('database');
        $link = mysql_connect($config1['hostname'], $config1['username'], $config1['password']) or die("Non riesco a connettermi");
        mysql_select_db($config1['dbname'], $link) or die("Errore nella selezione del database");

        $sql = "SELECT count(rel.id) as contoannunci FROM " . config_item('impianti', 'table_relazione') . " rel
		inner join " . config_item('impianti', 'table_annunci') . " ads on rel.id_annuncio = ads.id
		where ads.approvato = '1' and ads.status = '1' and rel.id_testata = '" . $id_testata . "' and rel.data_prevista_uscita = '" . $data_uscita . "'";
        $result = mysql_query($sql);

        while ($row1 = mysql_fetch_array($result)) {
            $conteggio = $row1['contoannunci'];
        }
        return $conteggio;
    }

    public function get_count_inserzionisti() {

        $config1 = config_load('database');
        $link = mysql_connect($config1['hostname'], $config1['username'], $config1['password']) or die("Non riesco a connettermi");
        mysql_select_db($config1['dbname'], $link) or die("Errore nella selezione del database");

        $sql = "SELECT count(profile_id) as contoclienti FROM " . config_item('authentication', 'table_profiles');
        $result = mysql_query($sql);

        while ($row1 = mysql_fetch_array($result)) {
            $conteggio = $row1['contoclienti'];
        }
        return $conteggio;
    }

    public function get_list_annunci_free($id_testata, $data_uscita) {

        $id_testata = filter_var($id_testata, FILTER_SANITIZE_NUMBER_INT);

        $config1 = config_load('database');
        $link = mysql_connect($config1['hostname'], $config1['username'], $config1['password']) or die("Non riesco a connettermi");
        mysql_select_db($config1['dbname'], $link) or die("Errore nella selezione del database");

        $sql = "SELECT *, cat.titolo as titolocat, ads.descrizione as testoad FROM " . config_item('impianti', 'table_relazione') . " rel
		inner join " . config_item('impianti', 'table_annunci') . " ads on rel.id_annuncio = ads.id
		inner join " . config_item('impianti', 'table_categories') . " cat on cat_id = id_categoria
		where ads.approvato = '1' and ads.status = '1' and ads.annuncio_pagamento = '0' and rel.id_testata = '" . $id_testata . "' and rel.data_prevista_uscita = '" . $data_uscita . "' order by id_categoria, testoad";
        $result = mysql_query($sql);
        return $result;
    }

    public function get_list_annunci_pay($id_testata, $data_uscita) {

        $id_testata = filter_var($id_testata, FILTER_SANITIZE_NUMBER_INT);

        $config1 = config_load('database');
        $link = mysql_connect($config1['hostname'], $config1['username'], $config1['password']) or die("Non riesco a connettermi");
        mysql_select_db($config1['dbname'], $link) or die("Errore nella selezione del database");

        $sql = "SELECT *, cat.titolo as titolocat, ads.descrizione as testoad FROM " . config_item('impianti', 'table_relazione') . " rel
		inner join " . config_item('impianti', 'table_annunci') . " ads on rel.id_annuncio = ads.id
		inner join " . config_item('impianti', 'table_categories') . " cat on cat_id = id_categoria
		where ads.approvato = '1' and ads.status = '1' and ads.annuncio_pagamento = '1' and rel.id_testata = '" . $id_testata . "' and rel.data_prevista_uscita = '" . $data_uscita . "' order by id_categoria, testoad";
        $result = mysql_query($sql);
        return $result;
    }

    public function get_list_annunci_all($id_testata, $data_uscita) {

        $id_testata = filter_var($id_testata, FILTER_SANITIZE_NUMBER_INT);

        $config1 = config_load('database');
        $link = mysql_connect($config1['hostname'], $config1['username'], $config1['password']) or die("Non riesco a connettermi");
        mysql_select_db($config1['dbname'], $link) or die("Errore nella selezione del database");

        $sql = "SELECT *, cat.titolo as titolocat, ads.descrizione as testoad FROM " . config_item('impianti', 'table_relazione') . " rel
		inner join " . config_item('impianti', 'table_annunci') . " ads on rel.id_annuncio = ads.id
		inner join " . config_item('impianti', 'table_categories') . " cat on cat_id = id_categoria
		where ads.approvato = '1' and ads.status = '1' and rel.id_testata = '" . $id_testata . "' and rel.data_prevista_uscita = '" . $data_uscita . "' order by id_categoria, testoad";
        $result = mysql_query($sql);
        return $result;
    }

    /**
     * Empty cart
     * 
     * @access public 
     */
    public function empty_cart() {


        $pag = array(
            'payed' => "1"
        );

        $where = array(
            'cart_session' => $this->session->get('cart_session')
        );

        $this->db->where($where);
        $this->db->update(self::$config['table_ads_cart'], $pag);


        $this->session->delete('cart_session');
    }

    public function getcount_ads_pending_by_user($profile_id) {

        $profile_id = filter_var($profile_id, FILTER_SANITIZE_NUMBER_INT);

        $config1 = config_load('database');
        $link = mysql_connect($config1['hostname'], $config1['username'], $config1['password']) or die("Non riesco a connettermi");
        mysql_select_db($config1['dbname'], $link) or die("Errore nella selezione del database");

        $sql = "SELECT count(id) as contoannunci FROM " . config_item('impianti', 'table_annunci') . " where approvato = '0' and profile_id = '" . $profile_id . "'";
        $result = mysql_query($sql);
        while ($row1 = mysql_fetch_array($result)) {
            $conteggio = $row1['contoannunci'];
        }
        return $conteggio;
    }

    public function remove_item_idcart($cart_id) {

        $cart_id = filter_var($cart_id, FILTER_SANITIZE_NUMBER_INT);

        $where = array(
            'cart_id' => $cart_id
        );

        $this->db->where($where);
        $this->db->delete(self::$config['table_carts']);
    }

    public function get_array_testate() {

        $test = array();
        $sql = "select * from " . config_item('impianti', 'table_testate');

        foreach ($this->db->query($sql) as $row) {

            $test[] = array(
                'id_testata' => $row['tes_id'],
                'nome_testata' => $row['tes_descrizione']
            );
        }

        if (isset($test))
            return $test;
    }

    public function get_latest_ads($limit) {

        $config1 = config_load('database');
        $link = mysql_connect($config1['hostname'], $config1['username'], $config1['password']) or die("Non riesco a connettermi");
        mysql_select_db($config1['dbname'], $link) or die("Errore nella selezione del database");
        mysql_query("SET character_set_results=utf8", $link);
        mb_internal_encoding('utf8');
        mysql_query("set names 'utf8'", $link);
        $sql = "select *, ads.titolo as titoload, cat.titolo as titolocat from " . config_item('impianti', 'table_annunci') . " ads
		inner join " . config_item('impianti', 'table_categories') . " cat on cat_id = id_categoria 
		where ads.status = '1' and ads.approvato = '1' order by id desc limit " . $limit;
        $result = mysql_query($sql);
        return $result;
    }

    public function del_ad_from_annunci($ad_id) {
        $config1 = config_load('database');
        $link = mysql_connect($config1['hostname'], $config1['username'], $config1['password']) or die("Non riesco a connettermi");
        mysql_select_db($config1['dbname'], $link) or die("Errore nella selezione del database");
        $sql = "delete from " . config_item('impianti', 'table_annunci') . " where id ='" . $ad_id . "'";
        $result = mysql_query($sql);
        return true;
    }

    public function del_ad_from_relazione($ad_id) {
        $config1 = config_load('database');
        $link = mysql_connect($config1['hostname'], $config1['username'], $config1['password']) or die("Non riesco a connettermi");
        mysql_select_db($config1['dbname'], $link) or die("Errore nella selezione del database");
        $sql = "delete from " . config_item('impianti', 'table_relazione') . " where id_annuncio ='" . $ad_id . "'";
        $result = mysql_query($sql);
        return true;
    }

    public function del_ad_from_carrello($ad_id) {
        $config1 = config_load('database');
        $link = mysql_connect($config1['hostname'], $config1['username'], $config1['password']) or die("Non riesco a connettermi");
        mysql_select_db($config1['dbname'], $link) or die("Errore nella selezione del database");
        $sql = "delete from " . config_item('impianti', 'table_ads_cart') . " where ad_id ='" . $ad_id . "'";
        $result = mysql_query($sql);
        return true;
    }

    public function get_auto_km($valore) {
        switch ($valore) {
            case "0":
                $km = "Km 0";
                break;
            case "1":
                $km = "0 - 4.999";
                break;
            case "2":
                $km = "5.000 - 9.999";
                break;
            case "3":
                $km = "10.000 - 14.999";
                break;
            case "4":
                $km = "15.000 - 19.999";
                break;
            case "5":
                $km = "20.000 - 24.999";
                break;
            case "6":
                $km = "25.000 - 29.999";
                break;
            case "7":
                $km = "30.000 - 34.999";
                break;
            case "8":
                $km = "35.000 - 39.999";
                break;
            case "9":
                $km = "40.000 - 44.999";
                break;
            case "10":
                $km = "45.000 - 49.999";
                break;
            case "11":
                $km = "50.000 - 54.999";
                break;
            case "12":
                $km = "55.000 - 59.999";
                break;
            case "13":
                $km = "60.000 - 64.999";
                break;
            case "14":
                $km = "65.000 - 69.999";
                break;
            case "15":
                $km = "70.000 - 74.999";
                break;
            case "16":
                $km = "75.000 - 79.999";
                break;
            case "17":
                $km = "80.000 - 84.999";
                break;
            case "18":
                $km = "85.000 - 89.999";
                break;
            case "19":
                $km = "90.000 - 94.999";
                break;
            case "20":
                $km = "95.000 - 99.999";
                break;
            case "21":
                $km = "100.000 - 109.999";
                break;
            case "22":
                $km = "110.000 - 119.999";
                break;
            case "23":
                $km = "120.000 - 129.999";
                break;
            case "24":
                $km = "130.000 - 139.999";
                break;
            case "25":
                $km = "140.000 - 149.999";
                break;
            case "26":
                $km = "150.000 - 159.999";
                break;
            case "27":
                $km = "160.000 - 169.999";
                break;
            case "28":
                $km = "170.000 - 179.999";
                break;
            case "29":
                $km = "180.000 - 189.999";
                break;
            case "30":
                $km = "190.000 - 199.999";
                break;
            case "31":
                $km = "200.000 - 249.999";
                break;
            case "32":
                $km = "250.000 - 299.999";
                break;
            case "33":
                $km = "300.000 - 349.999";
                break;
            case "34":
                $km = "350.000 - 399.999";
                break;
            case "35":
                $km = "400.000 - 449.999";
                break;
            case "36":
                $km = "450.000 - 499.999";
                break;
            case "37":
                $km = "Più di 500.000";
                break;
            default:
                $km = "-";
        }

        return $km;
    }

    /**
     * Get product categories
     * 
     * @access public 
     */
    public function get_auto_carburante($valore) {
        switch ($valore) {
            case "1":
                $km = "Benzina";
                break;
            case "2":
                $km = "Diesel";
                break;
            case "3":
                $km = "Gpl";
                break;
            case "4":
                $km = "Elettrica";
                break;
            case "5":
                $km = "Altro";
                break;
            case "6":
                $km = "Ibrida";
                break;
            case "7":
                $km = "Metano";
                break;
            default:
                $km = "-";
        }
        return $km;
    }

    public function get_auto_tipologia($valore) {
        switch ($valore) {
            case "1":
                $km = "Utilitaria";
                break;
            case "2":
                $km = "Berlina";
                break;
            case "3":
                $km = "Station Wagon";
                break;
            case "4":
                $km = "Monovolume";
                break;
            case "5":
                $km = "Fuoristrada/SUV";
                break;
            case "6":
                $km = "Cabrio";
                break;
            case "7":
                $km = "Coupé";
                break;
            case "10":
                $km = "Altro";
                break;
            default:
                $km = "-";
        }
        return $km;
    }

    public function get_auto_emissioni($valore) {
        switch ($valore) {
            case "1":
                $km = "Pre-Euro";
                break;
            case "2":
                $km = "Euro 1";
                break;
            case "3":
                $km = "Euro 2";
                break;
            case "4":
                $km = "Euro 3";
                break;
            case "5":
                $km = "Euro 4";
                break;
            case "6":
                $km = "Euro 5";
                break;
            case "7":
                $km = "Euro 6";
                break;
            default:
                $km = "-";
        }
        return $km;
    }

    public function get_auto_posti($valore) {
        switch ($valore) {
            case "1":
                $km = "2";
                break;
            case "2":
                $km = "3";
                break;
            case "3":
                $km = "4";
                break;
            case "4":
                $km = "5";
                break;
            case "5":
                $km = "6";
                break;
            case "6":
                $km = "7";
                break;
            case "7":
                $km = "8";
                break;
            case "8":
                $km = "Più di 8";
                break;
            default:
                $km = "-";
        }
        return $km;
    }

    public function get_auto_porte($valore) {
        switch ($valore) {
            case "1":
                $km = "2/3";
                break;
            case "2":
                $km = "4/5";
                break;
            case "3":
                $km = "6/7";
                break;
            default:
                $km = "-";
        }
        return $km;
    }

    public function get_auto_colore($valore) {

        switch ($valore) {
            case "1":
                $km = "Bianco";
                break;
            case "2":
                $km = "Grigio";
                break;
            case "3":
                $km = "Marrone";
                break;
            case "4":
                $km = "Nero";
                break;
            case "5":
                $km = "Rosso";
                break;
            case "6":
                $km = "Giallo";
                break;
            case "7":
                $km = "Verde";
                break;
            case "8":
                $km = "Blu";
                break;
            default:
                $km = "-";
        }
        return $km;
    }

    public function get_auto_cambio($valore) {

        switch ($valore) {
            case "1":
                $km = "Manuale";
                break;
            case "2":
                $km = "Automatico";
                break;
            case "3":
                $km = "Sequenziale";
                break;
            case "4":
                $km = "Altro";
                break;
            default:
                $km = "-";
        }
        return $km;
    }

    public function get_casa_tipo($valore) {
        switch ($valore) {
            case "0":
                $tipo = "Fitto";
                break;
            case "1":
                $tipo = "Vendita";
                break;
            default:
                $tipo = "-";
        }
        return $tipo;
    }

    public function get_casa_yn($valore) {
        switch ($valore) {
            case "0":
                $tipo = "No";
                break;
            case "1":
                $tipo = "Si";
                break;
            default:
                $tipo = "-";
        }
        return $tipo;
    }

    public function get_casa_ipe($valorejs) {

        $ipe = json_decode($valorejs, true);
        return $ipe;
    }

    public function get_casa_caratteristiche($valorejs) {

        $caratteristiche = json_decode($valorejs, true);
        return $caratteristiche;
    }

    public function get_profile_fromid($profile_id) {
        /*
          $config1 = config_load('database');
          $link = mysql_connect ($config1['hostname'], $config1['username'], $config1['password']) or die ("Non riesco a connettermi");
          mysql_select_db($config1['dbname'], $link) or die("Errore nella selezione del database");
          $sql = "select * from ". config_item('authentication', 'table_profiles') ." where profile_id = ".$profile_id;
          //return $sql;
          $result = mysql_query($sql);
          return $result;
         */
        $test = array();
        $sql = "select * from " . config_item('authentication', 'table_profiles') . " where profile_id = " . $profile_id;

        foreach ($this->db->query($sql) as $row) {

            $test[] = array(
                'profile_id' => $row['profile_id'],
                'user_id' => $row['user_id'],
                'nome' => $row['nome'],
                'cognome' => $row['cognome'],
                'indirizzo' => $row['indirizzo'],
                'citta' => $row['citta'],
                'cap' => $row['cap'],
                'provincia' => $row['provincia'],
                'email' => $row['email'],
                'telefono' => $row['telefono'],
                'cellulare' => $row['cellulare'],
                'data_nascita' => $row['data_nascita'],
                'sesso' => $row['sesso'],
                'aut_privacy' => $row['aut_privacy'],
                'aut_mess_commerciali' => $row['aut_mess_commerciali'],
                'ragione_sociale' => $row['ragione_sociale'],
                'logo' => $row['logo'],
                'web_url' => $row['web_url'],
                'info_azienda' => $row['info_azienda']
            );
        }

        if (isset($test))
            return $test;
    }

    /**
     * Get coupon
     * 
     * @access public 
     */
    public function get_annunci_frontend($cat_id, $start_from, $ads_x_page) {

        $config1 = config_load('database');
        $link = mysql_connect($config1['hostname'], $config1['username'], $config1['password']) or die("Non riesco a connettermi");
        mysql_select_db($config1['dbname'], $link) or die("Errore nella selezione del database");
        mysql_query("SET character_set_results=utf8", $link);
        mb_internal_encoding('utf8');
        mysql_query("set names 'utf8'", $link);

        if ($cat_id == 0) {
            $sql = "SELECT *, cat.titolo as categoria, ads.titolo as titoload FROM " . config_item('impianti', 'table_annunci') . " ads 
			inner join " . config_item('impianti', 'table_categories') . " cat on ads.cat_id = cat.id_categoria 
			left join " . config_item('authentication', 'table_profiles') . " p on ads.profile_id = p.profile_id
			left join " . config_item('authentication', 'table_users') . " u on u.user_id = p.user_id 
			left join " . config_item('authentication', 'table_groups') . " g on u.group_id = g.group_id 			
			where " . $this->filtrodata . " and ads.status = '1' and ads.approvato = '1' order by ads.data_inizio desc limit " . $start_from . ", " . $ads_x_page;
        } else {
            //controllo se è una maincat
            $sql = "SELECT id_categoria FROM " . config_item('impianti', 'table_categories') . " where id_cat_principale = '" . $cat_id . "'";
            $result = mysql_query($sql);

            if (mysql_num_rows($result) <> 0) {
                $in = "";
                $ar = array();
                while ($row1 = mysql_fetch_array($result)) {
                    //$in = $in.",".$row1['id_categoria'];
                    array_push($ar, $row1['id_categoria']);
                }
                $in = implode(",", $ar);
            } else {
                $in = $cat_id;
            }
            $sql = "SELECT *, cat.titolo as categoria, ads.titolo as titoload FROM " . config_item('impianti', 'table_annunci') . " ads 
			inner join " . config_item('impianti', 'table_categories') . " cat on ads.cat_id = cat.id_categoria 
			left join " . config_item('authentication', 'table_profiles') . " p on ads.profile_id = p.profile_id
			left join " . config_item('authentication', 'table_users') . " u on u.user_id = p.user_id 
			left join " . config_item('authentication', 'table_groups') . " g on u.group_id = g.group_id 		
			where ads.status = '1' and ads.approvato = '1' and ads.cat_id in (" . $in . ") order by ads.data_inizio desc limit " . $start_from . ", " . $ads_x_page;
        }

        $result = mysql_query($sql);

        while ($row = mysql_fetch_array($result)) {
            $ads[] = array(
                'id' => $row['id'],
                'immagini' => $row['immagini'],
                'categoria' => $row['categoria'],
                'testate' => $row['testate'],
                'titolo' => $row['titoload'],
                'data_pub' => $row['data_inizio'],
                'gruppo' => $row['group_name'],
                'profile_id' => $row['profile_id'],
                'user_id' => $row['user_id'],
                'ragsoc' => $row['ragione_sociale'],
                'logo' => $row['logo']
            );
        }

        return $ads;
    }

    public function get_annunci_frontend_byprof($profile_id, $start_from, $ads_x_page) {

        $config1 = config_load('database');
        $link = mysql_connect($config1['hostname'], $config1['username'], $config1['password']) or die("Non riesco a connettermi");
        mysql_select_db($config1['dbname'], $link) or die("Errore nella selezione del database");
        mysql_query("SET character_set_results=utf8", $link);
        mb_internal_encoding('utf8');
        mysql_query("set names 'utf8'", $link);

        $sql = "SELECT *, cat.titolo as categoria, ads.titolo as titoload FROM " . config_item('impianti', 'table_annunci') . " ads 
		inner join " . config_item('impianti', 'table_categories') . " cat on ads.cat_id = cat.id_categoria 
		left join " . config_item('authentication', 'table_profiles') . " p on ads.profile_id = p.profile_id
		left join " . config_item('authentication', 'table_users') . " u on u.user_id = p.user_id 
		left join " . config_item('authentication', 'table_groups') . " g on u.group_id = g.group_id 		
		where ads.status = '1' and ads.approvato = '1' and ads.profile_id = " . $profile_id . " order by ads.data_inizio desc limit " . $start_from . ", " . $ads_x_page;

        $result = mysql_query($sql);

        while ($row = mysql_fetch_array($result)) {
            $ads[] = array(
                'id' => $row['id'],
                'immagini' => $row['immagini'],
                'categoria' => $row['categoria'],
                'testate' => $row['testate'],
                'titolo' => $row['titoload'],
                'data_pub' => $row['data_inizio'],
                'gruppo' => $row['group_name'],
                'profile_id' => $row['profile_id'],
                'user_id' => $row['user_id'],
                'ragsoc' => $row['ragione_sociale'],
                'logo' => $row['logo']
            );
        }

        return $ads;
    }

    /*
      //vecchia ricerca
      public function get_annunci_cerca($stringa, $cat_id, $start_from, $ads_x_page) {

      $config1 = config_load('database');
      $link = mysql_connect ($config1['hostname'], $config1['username'], $config1['password']) or die ("Non riesco a connettermi");
      mysql_select_db($config1['dbname'], $link) or die("Errore nella selezione del database");
      mysql_query("SET character_set_results=utf8", $link);
      mb_internal_encoding('utf8');
      mysql_query("set names 'utf8'",$link);

      $stringa = str_replace("'","''",$stringa);
      $sql = "SELECT *, cat.titolo as categoria, ads.titolo as titoload FROM " . config_item('impianti', 'table_annunci') . " ads inner join ". config_item('impianti', 'table_categories') ." cat on ads.cat_id = cat.id_categoria where ads.status = '1' and ads.approvato = '1'";

      $implode = array();
      $implode[] = " LCASE(ads.descrizione) LIKE '%" . strtolower($stringa) . "%'";
      if ($implode)
      $sql .= " and " . implode(" AND ", $implode);

      if ($cat_id == 0){
      $sql .= " order by ads.data_inizio desc limit ".$start_from.", ".$ads_x_page;
      } else {
      //controllo se è una maincat
      $sql1 = "SELECT id_categoria FROM " . config_item('impianti', 'table_categories') . " where id_cat_principale = '" . $cat_id . "'";
      $result = mysql_query($sql1);

      if (mysql_num_rows($result) <> 0){
      $in = "";
      $ar = array();
      while ($row1 = mysql_fetch_array($result)) {
      //$in = $in.",".$row1['id_categoria'];
      array_push($ar,$row1['id_categoria']);
      }
      $in = implode(",",$ar);
      } else {
      $in = $cat_id;
      }
      $sql .= " and ads.cat_id in (" . $in . ") order by ads.data_inizio desc limit ".$start_from.", ".$ads_x_page;
      }

      $result = mysql_query($sql);

      while ($row = mysql_fetch_array($result)) {
      $ads[] = array(
      'id'		=> $row['id'],
      'immagini'	=> $row['immagini'],
      'categoria'	=> $row['categoria'],
      'testate'	=> $row['testate'],
      'titolo'	=> $row['titoload'],
      'data_pub'	=> $row['data_inizio']
      );
      }

      return $ads;
      //return $sql;
      }
     */

    public function get_annunci_cerca($stringa, $cat_id, $start_from, $ads_x_page) {

        $config1 = config_load('database');
        $link = mysql_connect($config1['hostname'], $config1['username'], $config1['password']) or die("Non riesco a connettermi");
        mysql_select_db($config1['dbname'], $link) or die("Errore nella selezione del database");
        mysql_query("SET character_set_results=utf8", $link);
        mb_internal_encoding('utf8');
        mysql_query("set names 'utf8'", $link);

        $stringa = str_replace("'", "''", $stringa);
        $sql = "SELECT *, cat.titolo as categoria, ads.titolo as titoload FROM " . config_item('impianti', 'table_annunci') . " ads 
		inner join " . config_item('impianti', 'table_categories') . " cat on ads.cat_id = cat.id_categoria 
		left join " . config_item('authentication', 'table_profiles') . " p on ads.profile_id = p.profile_id
		left join " . config_item('authentication', 'table_users') . " u on u.user_id = p.user_id 
		left join " . config_item('authentication', 'table_groups') . " g on u.group_id = g.group_id ";

        $armark = explode(" ", strtolower($stringa));
        $x = 0;
        $construct = " ";
        foreach ($armark as $search_each) {
            $x++;
            $search_each = trim($search_each);
            if ($x == 1) {
                $construct .= "LCASE(ads.descrizione) LIKE '%$search_each%' ";
            } else {
                $construct .= "AND LCASE(ads.descrizione) LIKE '%$search_each%' ";
            }
        }


        //$implode[] = " LCASE(ads.descrizione) LIKE '%" . strtolower($stringa) . "%'";
        if ($armark)
            $sql .= "where " . $this->filtrodata . " and ads.status = '1' and ads.approvato = '1' and " . $construct;

        if ($cat_id == 0) {
            $sql .= " order by ads.data_inizio desc limit " . $start_from . ", " . $ads_x_page;
        } else {
            //controllo se è una maincat
            $sql1 = "SELECT id_categoria FROM " . config_item('impianti', 'table_categories') . " where id_cat_principale = '" . $cat_id . "'";
            $result = mysql_query($sql1);

            if (mysql_num_rows($result) <> 0) {
                $in = "";
                $ar = array();
                while ($row1 = mysql_fetch_array($result)) {
                    //$in = $in.",".$row1['id_categoria'];
                    array_push($ar, $row1['id_categoria']);
                }
                $in = implode(",", $ar);
            } else {
                $in = $cat_id;
            }
            $sql .= " and ads.cat_id in (" . $in . ") order by ads.data_inizio desc limit " . $start_from . ", " . $ads_x_page;
        }

        $result = mysql_query($sql);

        while ($row = mysql_fetch_array($result)) {
            $ads[] = array(
                'id' => $row['id'],
                'immagini' => $row['immagini'],
                'categoria' => $row['categoria'],
                'testate' => $row['testate'],
                'titolo' => $row['titoload'],
                'data_pub' => $row['data_inizio'],
                'gruppo' => $row['group_name'],
                'profile_id' => $row['profile_id'],
                'user_id' => $row['user_id'],
                'ragsoc' => $row['ragione_sociale'],
                'logo' => $row['logo']
            );
        }

        return $ads;
        //return $sql;	
    }

    public function get_conteggio_ricerca($stringa, $cat_id) {

        $category_id = filter_var($category_id, FILTER_SANITIZE_NUMBER_INT);
        $stringa = str_replace("'", "''", $stringa);
        $config1 = config_load('database');
        $link = mysql_connect($config1['hostname'], $config1['username'], $config1['password']) or die("Non riesco a connettermi");
        mysql_select_db($config1['dbname'], $link) or die("Errore nella selezione del database");

        /*
          $sql = "SELECT count(id) as contoannunci FROM " . config_item('impianti', 'table_annunci') . " ads where ads.status = '1' and ads.approvato = '1'";
          $implode = array();
          $implode[] = " LCASE(ads.descrizione) LIKE '%" . strtolower($stringa) . "%'";
          if ($implode)
          $sql .= " and " . implode(" AND ", $implode);
         */

        $sql = "SELECT count(id) as contoannunci FROM " . config_item('impianti', 'table_annunci') . " ads ";

        $armark = explode(" ", strtolower($stringa));
        $x = 0;
        $construct = " ";
        foreach ($armark as $search_each) {
            $x++;
            $search_each = trim($search_each);
            if ($x == 1) {
                $construct .= "LCASE(ads.descrizione) LIKE '%$search_each%' ";
            } else {
                $construct .= "AND LCASE(ads.descrizione) LIKE '%$search_each%' ";
            }
        }

        if ($armark)
            $sql .= "where " . $this->filtrodata . " and ads.status = '1' and ads.approvato = '1' and " . $construct;

        if ($cat_id == 0) {
            //$sql .= " order by ads.data_inizio desc limit ".$start_from.", ".$ads_x_page;
        } else {
            //controllo se è una maincat
            $sql1 = "SELECT id_categoria FROM " . config_item('impianti', 'table_categories') . " where id_cat_principale = '" . $cat_id . "'";
            $result = mysql_query($sql1);

            if (mysql_num_rows($result) <> 0) {
                $in = "";
                $ar = array();
                while ($row1 = mysql_fetch_array($result)) {
                    //$in = $in.",".$row1['id_categoria'];
                    array_push($ar, $row1['id_categoria']);
                }
                $in = implode(",", $ar);
            } else {
                $in = $cat_id;
            }
            $sql .= " and ads.cat_id in (" . $in . ")";
        }

        $result = mysql_query($sql);

        while ($row = mysql_fetch_array($result)) {
            $conteggio = $row['contoannunci'];
        }

        return $conteggio;
    }

    /**
     * Checkout
     * 
     * @access public 
     */
    public function checkout() {

        $count = 1;

        $checkout = "?cmd=_xclick";
        //$checkout .= "&upload=1";
        $checkout .= "&business=" . urlencode(self::$config['paypal_email']);
        //$checkout .= "&custom=" . urlencode($ad_id);
        $checkout .= "&currency_code=" . urlencode(self::$config['currency_code']);
        //$checkout .= "&country=" . urlencode($result['iso_code_2']);
        $checkout .= "&return=" . urlencode(self::$config['paypal_return']);
        $checkout .= "&cancel_return=" . urlencode(self::$config['paypal_cancel_return']);
        $checkout .= "&notify_url=" . urlencode(self::$config['paypal_notify_url']);


        foreach ($this->get_cart() as $value) {

            $checkout .= "&item_number=" . urlencode($value['ad_id']);
            $checkout .= "&item_name=" . urlencode("Annuncio Potenza Affari - " . $value['titolo']);
            $checkout .= "&amount=" . urlencode(number_format($value['ad_price'], 2, '.', ','));
            //$checkout .= "&amount=" . urlencode(number_format("0.10", 2, '.', ',')); //10 centesimi di test
            $checkout .= "&quantity=1";
        }

        $this->empty_cart();

        if (config_item('impianti', 'paypal_sandbox'))
            header('Location: https://www.sandbox.paypal.com/cgi-bin/webscr' . $checkout);
        else
        //return $checkout;
            header('Location: https://www.paypal.com/cgi-bin/webscr' . $checkout);
    }

}