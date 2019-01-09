<?php
require('../common.php');

$elemId = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
$itemData = $curriculum->deleteCvItem($elemId);
echo json_encode($itemData);