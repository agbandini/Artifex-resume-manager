<?php
require('../common.php');

$elemId = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
$itemData = $curriculum->get_formazione($elemId);
echo json_encode($itemData);