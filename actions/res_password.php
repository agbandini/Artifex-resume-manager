<?php
require('../common.php');

$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

$res = $authentication->new_password($email);

echo $res;