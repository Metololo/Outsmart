<?php session_start();

include('../include/connexion_check.php');
include('../include/db.php');
include('../include/logs.php');

$receive = $_POST['receive'];
$send = $_POST['send'];

if(isset($receive) && isset($send)){
	$q ='DELETE FROM demande_amis WHERE id_envoie = ' . $send . ' AND id_recoit = ' . $receive;
	$bdd->exec($q);
}



?>