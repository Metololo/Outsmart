<?php session_start(); 

$email = $_SESSION['email'];

include('../include/db.php');

include('../include/connexion_check.php');
include('../include/no_admin.php');
include('../include/global_error.php');

$q='SELECT pseudo,image FROM utilisateurs WHERE email = "' . $email . '"';
$reponse = $bdd->query($q);
$admin_infos = $reponse->fetch();
$reponse->closeCursor();

$q='SELECT COUNT(id) AS nb FROM session';
$reponse = $bdd->query($q);
$session = $reponse->fetch();
$reponse->closeCursor();

$sessions = $session['nb'];

$q='SELECT COUNT(id) FROM utilisateurs WHERE droit != 1';
$reponse = $bdd->query($q);
$nb_inscrits = $reponse->fetch();
$reponse->closeCursor();

require_once '/var/www/html/admin/create_pdf.php';
die;

require_once '../include/dompdf/autoload.inc.php';
die;

use Dompdf\Dompdf;



$dompdf = new Dompdf();





/*$dompdf->loadHtml($html);
$dompdf->render();
$dompdf->stream();*/

?>
