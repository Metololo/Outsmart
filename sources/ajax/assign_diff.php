<?php session_start();
include('../include/db.php');
include('../include/connexion_check.php');


$email = $_SESSION['email'];

$q='SELECT id,pseudo,image FROM utilisateurs WHERE email= ?';
$reponse = $bdd->prepare($q);
$reponse->execute([$email]);
$user_infos = $reponse->fetch(PDO::FETCH_ASSOC);
$reponse->closeCursor();
	
	if(isset($_GET['game'])){
		$game = $_GET['game'];

	$q='SELECT diff_tmp AS diff FROM joue_partie WHERE partie = ? AND joueur = ?';
	$reponse = $bdd->prepare($q);
	$reponse->execute([$game,$user_infos['id']]);
	$result = $reponse->fetch(PDO::FETCH_ASSOC);
	$reponse->closeCursor();

	echo $result['diff'];
	}


	




?>