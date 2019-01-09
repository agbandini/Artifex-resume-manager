<?php
require('common.php');
require_once 'libraries/pdf/vendor/autoload.php';

if (!$authentication->logged_in()) die();
if (!$authentication->is_group('admin') and !$authentication->is_group('backoffice')) die();

$cv_id = filter_input(INPUT_GET, 'cv_id', FILTER_SANITIZE_NUMBER_INT);

ob_start();

$userCv = $curriculum->getCvById($cv_id);
foreach ($statiCv as $stat_key => $stat_value) {
    if ($userCv['cv_status'] == $stat_key){
        $userCv['status_descr'] = $stat_value;
    }
}

$str = str_replace('"','',$userCv['cv_lingue']);
$str = rtrim($str,"]");
$str = ltrim($str,"[");
$cvLingue = explode(',',$str);

$str = str_replace('"','',$userCv['cv_preferenza_sede']);
$str = rtrim($str,"]");
$str = ltrim($str,"[");
$cvSedi = explode(',',$str);

$per_form = $curriculum->getItemsByCvId($cv_id,'formazione');
$per_lav = $curriculum->getItemsByCvId($cv_id,'lavoro');

$cv_city = $curriculum->getCityFromCv();

require ('html/cv_pdf_layout.php');

$pdfOutput = ob_get_contents();

ob_end_clean();

$mpdf = new \Mpdf\Mpdf();
$mpdf->WriteHTML($pdfOutput);
$mpdf->Output();