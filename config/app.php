<?php if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) exit('No direct access allowed.');
return [
    'site_title' => 'Curriculum web app',
    'site_url' => 'http://www.studioartifex.it/cv_webapp/',
    'absolute_path' => '/web/htdocs/www.studioartifex.it/home/cv_webapp/',
    'admin_email' => 'info@studioartifex.it',    
    'admin_group' => '1',
    'notifica_attivazione' => false,
    'approve_registration' => false,
    //mail
    'system_email' => 'info@studioartifex.it',
    'smtp_host' => 'smtp.3tw.it',
    'smtp_port' => '25',
    'smtp_username' => 'noreply@3tw.it',
    'smtp_password' => '1q2w3e4r',
    //template
    'template_extension' => '.php',   
    //immagini - upload
    'upload_path' => '/web/htdocs/www.studioartifex.it/home/cv_webapp/uploads/',
    'allowed_filetypes' => array('png', 'jpg', 'gif', 'pdf', 'zip', 'rar'),
    'max_filesize' => 3048576,
    'max_width_thumbnail' => 80,
    'max_height_thumbnail' => 110,
    'med_width' => 500,
    'med_height' => 620,
    'max_width' => 800,
    'max_height' => 1200
];


