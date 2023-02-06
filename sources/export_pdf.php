<?php 

use Dompdf\Dompdf;

require_once 'include/dompdf/autoload.inc.php';

$dompdf = new Dompdf();

$dompdf->loadHtml('TEST');

$dompdf->render();
$dompdf->stream();



?>