<?php
//Include the common file
require_once('../common.php');

$login_email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$password = filter_input(INPUT_POST, 'password', FILTER_DEFAULT);

$remember = false;
isset($_POST['remember']) == true ? $remember = true : $remember = false;	

$res = $authentication->login($login_email, $password, $remember);
echo json_encode($res);