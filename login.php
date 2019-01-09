<?php
//Include the common file
require('common.php');

//Check if the user is logged in and is admin
if ($authentication->logged_in() && $authentication->is_admin()) header("Location: index.php");

//Display the template
$tpl->display('login_tpl');