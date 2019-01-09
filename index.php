<?php
require('common.php');

//Check if the user is logged in
if (!$authentication->logged_in()) header("Location: login.php");

//Logout
if (isset($_GET['logout'])) {
    $authentication->logout('login.php');
    header("Location: login.php");
}

if ($authentication->is_group('admin')) header("Location: gestione_cv.php");
if ($authentication->is_group('default')) header("Location: myCv.php");

