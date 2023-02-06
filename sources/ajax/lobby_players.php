<?php session_start();

include('../include/db.php');
include('../include/connexion_check.php');


$email = $_SESSION['email'];

$q='SELECT id,pseudo,image FROM utilisateurs WHERE email= ?';
$reponse = $bdd->prepare($q);
$reponse->execute([$email]);
$user_infos = $reponse->fetch(PDO::FETCH_ASSOC);
$reponse->closeCursor();

$q='SELECT COUNT(id) AS nb FROM session WHERE createur = ' . $user_infos['id'];
$reponse = $bdd->query($q);
$result = $reponse->fetch(PDO::FETCH_ASSOC);

// NON CREATEUR
if($result['nb'] == 0){
	$q='SELECT session AS id FROM rejoin_session WHERE joueur='.$user_infos['id'];
	$reponse = $bdd->query($q);
	$session = $reponse->fetch(PDO::FETCH_ASSOC);
	$reponse->closeCursor();
	
}else{ // CREATEUR
	$q='SELECT id FROM session WHERE createur = ' .$user_infos['id'];
	$reponse = $bdd->query($q);
	$session = $reponse->fetch(PDO::FETCH_ASSOC);
	$reponse->closeCursor();

}

					$q='SELECT nb_joueurs FROM session WHERE id =' .$session['id'];
					$req = $bdd->query($q);
					$players = $req->fetch(PDO::FETCH_ASSOC);

					echo $players['nb_joueurs'];

					
?>