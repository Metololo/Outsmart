<?php session_start();
include('../include/db.php');
include('../include/connexion_check.php');


$email = $_SESSION['email'];

$q='SELECT id,pseudo,image FROM utilisateurs WHERE email= ?';
$reponse = $bdd->prepare($q);
$reponse->execute([$email]);
$user_infos = $reponse->fetch(PDO::FETCH_ASSOC);
$reponse->closeCursor();

if(isset($_POST['diff']) && isset($_POST['game'])){

	$game = $_POST['game'];
	$diff = $_POST['diff'];

	$q='UPDATE joue_partie SET diff_tmp = ? WHERE partie = ? AND joueur = ? ';
	$req = $bdd->prepare($q);
	$req->execute([$diff,$game,$user_infos['id']]);

}



?>