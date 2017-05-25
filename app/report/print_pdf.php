<a href='../../library/mpdf/vendor/autoload.php'>print</a>
<?php

if ($_GET['html']){
    $html=$_GET['html'];
    require_once '../../library/mpdf/vendor/autoload.php';


    $mpdf = new mPDF('th','A4-L','','',32,25,27,25,16,13);

    $mpdf->SetDisplayMode('fullpage');

    $mpdf->list_indent_first_level = 0;	// 1 or 0 - whether to indent the first level of a list

    // LOAD a stylesheet
    $stylesheet = file_get_contents('mpdfstyletables.css');
    $mpdf->WriteHTML($stylesheet,1);	// The parameter 1 tells that this is css/style only and no body/html/text

    $mpdf->WriteHTML($html,2);

    $mpdf->Output('stu_03.pdf','I');
   // $mpdf->Output();
    exit;
}
