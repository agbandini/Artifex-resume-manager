<?php
require('../common.php');

$elemId = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
$itemData = $curriculum->getCvById($elemId);

$itemData['cv_privacy'] = 1;
$itemData['cv_mess_comm'] = 0;

$pwd = $authentication->getRandomPassword();

$authentication->create_user($itemData['cv_email'], $pwd, $itemData);

echo json_encode(array('result' => 1));