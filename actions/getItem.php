<?php
require('../common.php');

$elemId = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
$itemData = $curriculum->getItem($elemId);
echo json_encode($itemData);