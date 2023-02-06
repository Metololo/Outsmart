<?php session_start();

include('../include/connexion_check.php');
include('../include/db.php');
include('../include/logs.php');

$receive = $_POST['receive'];
$send = $_POST['send'];

if(isset($receive) && isset($send)){
	$q ='UPDATE demande_amis SET accepte = 1 WHERE id_envoie = ' . $send . ' AND id_recoit = ' . $receive;
	$bdd->exec($q);

	$q ='INSERT INTO est_ami(ami1,ami2,date_ajout,bloque) VALUES('. $send .','. $receive .',NOW(),0)';
	$bdd->exec($q);
}



?>