<?php
if (__FILE__ == $_SERVER['SCRIPT_FILENAME'])
    exit('No direct access allowed.');

/**
 * Authentication class
 */
class Authentication {

    /**
     * Config
     *
     * @access private 
     */
    private static $config;

    /**
     * Database
     *
     * @access private 
     */
    private $db;
    private $mysqli;
    private $session;

    /**
     * Constructor
     * 
     * @access public 
     */
    public function __construct($dbData) {

        self::$config = config_load();

        $db = Database::getInstance($dbData);
        $this->mysqli = $db->getConnection();
        
        $this->session = new Session();
        $this->email = new Email();

        $this->auto_login();
        $this->delete_inactive_users();
    }

    
    public function getRandomPassword() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }
    
    
    public function create_user($email, $password, $cv_data = NULL) {

        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $password = filter_var($password, FILTER_SANITIZE_STRING);

        $values = array(
            'user_email' => $email,
            'user_password' => hash('sha512', $password),
            'user_created' => time(),
            'group_id' => 3,
            'user_status' => 1,
            'user_approved' => 1
        );

        $stmt = $this->mysqli->prepare("INSERT INTO `ecv_users`(`group_id`, `user_email`, `user_password`, `user_status`, `user_approved`, `user_created`) VALUES (?,?,?,?,?,?)");

        if (!$stmt->bind_param("issiii", $values['group_id'], $values['user_email'], $values['user_password'], $values['user_status'], $values['user_approved'], $values['user_created'])) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        // Execute statement
        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        $user_id = $this->mysqli->insert_id;

        if ($cv_data) {

            $stmt = $this->mysqli->prepare("INSERT INTO `ecv_user_profiles`(`user_id`, `cv_id`, `nome`, `cognome`, `indirizzo`, `citta`, `cap`, `provincia`, `email`, `cellulare`, `data_nascita`, `sesso`, `aut_privacy`, `aut_mess_commerciali`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

            if (!$stmt->bind_param("iissssssssssii", $user_id, $cv_data['cv_id'], $cv_data['cv_nome'], $cv_data['cv_cognome'], $cv_data['cv_indirizzo'], $cv_data['cv_citta'], $cv_data['cv_cap'], $cv_data['cv_provincia'], $cv_data['cv_email'], $cv_data['cv_telefono'], $cv_data['cv_data_nascita'], $cv_data['cv_sesso'], $cv_data['cv_privacy'], $cv_data['cv_mess_comm'])) {
                echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
            }
            // Execute statement
            if (!$stmt->execute()) {
                echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            }          

        }

        if (self::$config['notifica_attivazione'] == true) {
            $this->email->mail_attivazione_account($email, $password);
        }
        
        return true;
    }

    /**
     * New password
     * 
     * @access public 
     */
    public function new_password($email) {

        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        
        $stmt = $this->mysqli->prepare("SELECT user_email FROM `ecv_users` WHERE `user_email` = ?");
        if (!$stmt->bind_param("s", $email)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        // Execute statement
        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }        
        $result = $stmt->get_result();
        
        if (count($result->fetch_assoc()) === 1) {
            $pwd = $this->getRandomPassword();
            $encPwd = hash('sha512', $pwd);
            
            $stmt = $this->mysqli->prepare("UPDATE `ecv_users` SET `user_password` = ? WHERE `user_email` = ?");
            
            if (!$stmt->bind_param("ss", $encPwd, $email)) {
                echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
            }
            // Execute statement
            if (!$stmt->execute()) {
                echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            }            
            
            $this->email->mail_reset_password($email, $pwd);

            return 1;
        } else {
            return 0;
        }
    }    
    
    /**
     * Update user
     * 
     * @access public 
     */
    public function update_user($user_id, $email, $password = false, $additional_data = NULL, $parameters = NULL) {

        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $password = filter_var($password, FILTER_SANITIZE_STRING);

        $values = array(
            'user_email' => $email
        );

        if ($password)
            $values['user_password'] = sha1($password);

        if (isset($parameters)) {

            if (isset($parameters['user_status'])) {

                $values['user_status'] = $parameters['user_status'];
                $values['user_approved'] = $parameters['user_status'];
            }

            if (isset($parameters['group_id']))
                $values['group_id'] = $parameters['group_id'];
        }

        $where = array(
            'user_id' => $user_id
        );

        $this->db->where($where);
        $t = $this->db->update(self::$config['table_users'], $values);

        if (isset($additional_data)) {

            $where = array(
                'user_id' => $user_id
            );

            $this->db->where($where);
            $this->db->update(self::$config['table_profiles'], $additional_data);
        }
        return $values;
    }

    /**
     * Delete user
     * 
     * @access public 
     */
    public function delete_user($user_id) {

        $where = array(
            'user_id' => $user_id
        );

        $this->db->where($where);
        $this->db->delete(self::$config['table_users']);
        $this->db->delete(self::$config['table_profiles']);
    }

    /**
     * Delete inactive users
     * 
     * @access private 
     */
    private function delete_inactive_users() {
        /*
          foreach ($this->db->query("SELECT * FROM " . self::$config['table_users'] . " WHERE user_status = 0 AND activation_code != '' AND user_created < '" . time() . "' - '" . self::$config['email_activation_expire'] . "'") as $row) {

          $where = array(
          'user_id' => $row['user_id']
          );

          $this->db->where($where);
          $this->db->delete(self::$config['table_users']);

          }
         */
    }

    /**
     * Get user
     * 
     * @access public 
     */
    public function get_user($user_id) {
        
        $stmt = $this->mysqli->prepare("SELECT * FROM ecv_users WHERE user_id = ? ");

        if (!$stmt->bind_param("i", $user_id)) {
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
            $user = array(
                'user_id' => $row['user_id'],
                'group_id' => $row['group_id'],
                'first_name' => $row['nome'],
                'last_name' => $row['cognome'],
                'user_email' => $row['user_email'],
                'user_status' => $row['user_status']               
            );
        }
        $stmt->close();
        return $user;
    }

    /**
     * Get active users
     * 
     * @access public 
     */
    public function get_active_users() {

        foreach ($this->db->query("SELECT * FROM " . self::$config['table_users'] . " users, " . self::$config['table_profiles'] . " profiles WHERE profiles.user_id = users.user_id AND users.user_status = 1") as $row) {

            $users[] = array(
                'user_id' => $row['user_id'],
                'first_name' => $row['first_name'],
                'last_name' => $row['last_name'],
                'user_email' => $row['user_email']
            );
        }

        if (isset($users))
            return $users;
    }

    /**
     * Get inactive users
     * 
     * @access public 
     */
    public function get_inactive_users() {

        foreach ($this->db->query("SELECT * FROM " . self::$config['table_users'] . " users, " . self::$config['table_profiles'] . " profiles WHERE profiles.user_id = users.user_id AND users.user_status = '0'") as $row) {

            $users[] = array(
                'user_id' => $row['user_id'],
                'first_name' => $row['first_name'],
                'last_name' => $row['last_name'],
                'user_email' => $row['user_email']
            );
        }

        if (isset($users))
            return $users;
    }

    /**
     * Get newest users
     * 
     * @access public 
     */
    public function get_newest_users($limit = 10) {

        foreach ($this->db->query("SELECT * FROM " . self::$config['table_users'] . " users, " . self::$config['table_profiles'] . " profiles WHERE profiles.user_id = users.user_id AND users.user_status = 1 ORDER BY user_created DESC LIMIT " . $limit . "") as $row) {

            $users[] = array(
                'user_id' => $row['user_id'],
                'first_name' => $row['first_name'],
                'last_name' => $row['last_name'],
                'user_email' => $row['user_email'],
                'user_status' => $row['user_status'],
                'last_login' => $row['last_login']
            );
        }

        if (isset($users))
            return $users;
    }

    /**
     * Activate user
     * 
     * @access public 
     */
    public function activate_user($email, $code) {

        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $code = filter_var($code, FILTER_SANITIZE_STRING);

        if ($this->db->row_count("SELECT activation_code FROM " . self::$config['table_users'] . " WHERE user_email = '" . $email . "' AND activation_code = '" . $code . "'")) {

            $values = array(
                'activation_code' => '',
                'user_status' => 1,
                'user_approved' => 1
            );

            $where = array(
                'user_email' => $email
            );

            $this->db->where($where);
            $this->db->update(self::$config['table_users'], $values);

            return true;
        } else {

            return false;
        }
    }

    /**
     * Token
     * 
     * @access private 
     */
    private function token() {
        return md5('studioartifex' . $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']);
    }

    public function login($email, $password, $remember = false) {

        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $password = filter_var($password, FILTER_SANITIZE_STRING);
               
        $stmt = $this->mysqli->prepare("SELECT * FROM ecv_users u "
                . "INNER JOIN ecv_user_profiles p ON u.user_id = p.user_id "
                . "WHERE u.user_email = ? AND u.user_password = ? AND u.user_status = 1 AND u.user_approved = 1");

        if (!$stmt->bind_param("ss", $email, $password)) {
            $ret = [
                'stato' => 0,
                'msg' => "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error
            ];
        }
        
        if (!$stmt->execute()) {
            $ret = [
                'stato' => 0,
                'msg' => "Execute failed: (" . $stmt->errno . ") " . $stmt->error
            ];            
        }
        
        $result = $stmt->get_result();
        
        if ($result->num_rows <> 0) {

            session_regenerate_id(true);
            $this->session->set('token', $this->token());
            $this->session->set('logged_in', true);

            $row = $result->fetch_assoc();
            //var_dump($row);
            $user_id = $row['user_id'];
            $group_id = $row['group_id'];
            
            $this->session->set('user_id', $user_id);
            $this->session->set('group_id', $group_id);
            $this->session->set('cv_id', $row['cv_id']);
            $this->session->set('profile_id', $row['profile_id']);
            $this->session->set('user_email', $row['user_email']);
            $this->session->set('user_status', $row['user_status']);
            $this->session->set('last_login', $row['last_login']);
            $this->session->set('last_ip', $row['last_ip']);
            $this->session->set('nome', $row['nome']);
            $this->session->set('cognome', $row['cognome']);
            $this->session->set('email_profilo', $row['email']);
            $this->session->set('cellulare', $row['cellulare']);
            
            
            $stmt = $this->mysqli->prepare("update ecv_users set last_login = ?, last_ip = ? where user_id = ?");
            
            $unixtime = time();
            if (!$stmt->bind_param("ssi", $unixtime, $_SERVER['REMOTE_ADDR'], $user_id)) {
                echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
            }
            
            if (!$stmt->execute()) {
                echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            }            
            
            $stmt = $this->mysqli->prepare("SELECT group_name FROM ecv_user_groups WHERE group_id = ?");

            if (!$stmt->bind_param("i", $group_id)) {
                echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
            }
        
            if (!$stmt->execute()) {
                echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            }
        
            $result = $stmt->get_result();            
            $row = $result->fetch_assoc();
            $this->session->set('group_name', $row['group_name']);
            
            if ($remember){
                $this->remember_user($user_id, $email, $password);
            }

            $ret = [
                'stato' => 1,
                'msg' => "Accesso autorizzato"
            ]; 
        } else {
            $ret = [
                'stato' => 0,
                'msg' => "Nome utente o password non validi."
            ]; 
        }
        
        return $ret;
    }

    /**
     * Remember user
     * 
     * @access public 
     */
    public function remember_user($user_id, $email, $password) {

        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $password = filter_var($password, FILTER_SANITIZE_STRING);
        $key = sha1($email . $password);

        $stmt = $this->mysqli->prepare("UPDATE ecv_users set remember_code = ? WHERE user_id = ?");

        if (!$stmt->bind_param("si", $key, $user_id)) {
            $ret = [
                'stato' => 0,
                'msg' => "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error
            ];
        }
        
        if (!$stmt->execute()) {
            $ret = [
                'stato' => 0,
                'msg' => "Execute failed: (" . $stmt->errno . ") " . $stmt->error
            ];            
        }
        $unixtime = time();
        setcookie('remember_code', $key, $unixtime + (3600 * 24 * 30));
    }

    /**
     * Logged in
     * 
     * @access public 
     */
    public function logged_in() {

        if ($this->session->get('logged_in') && $this->session->get('token') == $this->token()) {
            return true;
        }

        return false;
    }

    /**
     * Auto login
     * 
     * @access public 
     */
    public function auto_login() {
        if (!$this->logged_in() AND !$this->logged_in(false)) {
            if (isset($_COOKIE['remember_code'])) {

            $cookie = filter_var($_COOKIE['remember_code'], FILTER_SANITIZE_STRING);
               
            $stmt = $this->mysqli->prepare("SELECT * FROM ecv_users u, ecv_user_profiles p WHERE u.remember_code = ? AND p.user_id = u.user_id");

            if (!$stmt->bind_param("s", $cookie)) {
                $ret = [
                    'stato' => 0,
                    'msg' => "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error
                ];
            }

            if (!$stmt->execute()) {
                $ret = [
                    'stato' => 0,
                    'msg' => "Execute failed: (" . $stmt->errno . ") " . $stmt->error
                ];            
            }

            $result = $stmt->get_result();
        
            if ($result->num_rows <> 0) {                
                
                    session_regenerate_id(true);
                    $this->session->set('token', $this->token());
                    $this->session->set('logged_in', true);

                    $row = $result->fetch_assoc();
                    $this->session->set('user_id', $row['user_id']);
                    $this->session->set('cv_id', $row['cv_id']);
                    $this->session->set('group_id', $row['group_id']);
                    $this->session->set('profile_id', $row['profile_id']);
                    $this->session->set('user_email', $row['user_email']);
                    $this->session->set('user_status', $row['user_status']);
                    $this->session->set('last_login', $row['last_login']);
                    $this->session->set('last_ip', $row['last_ip']);
                    $this->session->set('nome', $row['nome']);
                    $this->session->set('cognome', $row['cognome']);
                    $this->session->set('email_profilo', $row['email']);
                    $this->session->set('cellulare', $row['cellulare']);


                    $stmt = $this->mysqli->prepare("SELECT group_name FROM ecv_user_groups WHERE group_id = ?");
                    $stmt->bind_param("i", $row['group_id']);
                    $stmt->execute();

                    $result = $stmt->get_result();
                    $group_row = $result->fetch_assoc();
                    
                    $this->session->set('group_name', $group_row['group_name']);
                }
            }
        }

        return false;
    }

    /**
     * Logout
     * 
     * @access public 
     */
    public function logout() {

        $this->session->destroy();
        unset($_COOKIE['remember_code']);
        setcookie('remember_code', '', time() - 1);
    }

    /**
     * Is admin
     * 
     * @access public 
     */
    public function is_admin() {

        if ($this->session->get('group_id')) {

            if (self::$config['admin_group'] == $this->session->get('group_id'))
                return true;
        }

        return false;
    }

    /**
     * Is group
     * 
     * @access public 
     */
    public function is_group($group) {

        if (is_array($group)) {
            return in_array($this->session->get('group_name'), $group);
        }

        return $this->session->get('group_name') == $group;
    }

    /**
     * Check email
     * 
     * @access public 
     */
    public function check_email($email) {

        $email = filter_var($email, FILTER_SANITIZE_EMAIL);

        if ($this->db->row_count("SELECT user_email FROM " . self::$config['table_users'] . " WHERE user_email = '" . $email . "'")) {

            return false;
        } else {

            return true;
        }
    }

    /**
     * Add group
     * 
     * @access public 
     */
    public function add_group($name, $description) {

        $values = array(
            'group_name' => $name,
            'group_description' => $description
        );

        $this->db->insert(self::$config['table_groups'], $values);
    }

    /**
     * Update group
     * 
     * @access public 
     */
    public function update_group($group_id, $name, $description) {

        $values = array(
            'group_id' => $group_id,
            'group_name' => $name,
            'group_description' => $description
        );

        $where = array(
            'group_id' => $group_id
        );

        $this->db->where($where);
        $this->db->update(self::$config['table_groups'], $values);
    }

    /**
     * Delete group
     * 
     * @access public 
     */
    public function delete_group($group_id) {

        $where = array(
            'group_id' => $group_id
        );

        $this->db->where($where);
        $this->db->delete(self::$config['table_groups']);
    }

    /**
     * Get group
     * 
     * @access public 
     */
    public function get_group($group_id) {
        $ret = array();
        $stmt = $this->mysqli->prepare("SELECT * FROM ecv_users WHERE group_id = ?");

        if (!$stmt->bind_param("i", $group_id)) {
            $ret = [
                'stato' => 0,
                'msg' => "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error
            ];
        }
        
        if (!$stmt->execute()) {
            $ret = [
                'stato' => 0,
                'msg' => "Execute failed: (" . $stmt->errno . ") " . $stmt->error
            ];            
        }

        if ($result->num_rows <> 0) {

            $row = $result->fetch_assoc();
            $group = array(
                'group_id' => $row['group_id'],
                'group_name' => $row['group_name'],
                'group_description' => $row['group_description']
            );
        }
        
        if (!empty($ret)){
            return $ret;
        } else {
            return $group;
        }
        
    }

    /**
     * Get groups
     * 
     * @access public 
     */
    public function get_groups() {

        foreach ($this->db->query("SELECT * FROM " . self::$config['table_groups'] . "") as $row) {

            $groups[] = array(
                'group_id' => $row['group_id'],
                'group_name' => $row['group_name'],
                'group_description' => $row['group_description']
            );
        }

        if (isset($groups))
            return $groups;
    }

}
