<?php session_start();
include('../include/db.php');
include('../include/connexion_check.php');


$email = $_SESSION['email'];

$q='SELECT id,pseudo,image FROM utilisateurs WHERE email= ?';
$reponse = $bdd->prepare($q);

$reponse->execute([$email]);
$user_infos = $reponse->fetch(PDO::FETCH_ASSOC);
$reponse->closeCursor();


if(isset($_POST['score']) && isset($_POST['ordre']) && isset($_POST['partie'])){
	$score = $_POST['score'];
	$ordre = $_POST['ordre'];
	$partie = $_POST['partie'];

	$q='UPDATE joue_partie SET score = score + ? WHERE partie = ? AND joueur = ? ';
	$req = $bdd->prepare($q);
	$req->execute([$score,$partie,$user_infos['id']]);

	$q='UPDATE partie_q SET statut = 1,debut = NULL WHERE ordre = ? AND partie = ?';
	$req = $bdd->prepare($q);
	$req->execute([$ordre,$partie]);

	$q='SELECT enclenche FROM partie_q WHERE partie = ? AND statut = 0 ORDER BY ORDRE asc ';
	$req = $bdd->prepare($q);
	$req->execute([$partie]);
	$result = $req->fetch(PDO::FETCH_ASSOC);

	if($result['enclenche'] != 1){
		$debut = round(microtime(true) * 1000);

		$q='UPDATE partie_q SET debut='.$debut.',enclenche=1 WHERE statut = 0 AND partie='.$partie.' ORDER by ORDRE asc
			LIMIT 1';
		$bdd->exec($q);
	}

	


	$q ='SELECT score FROM joue_partie WHERE partie = ? AND joueur = ?';
	$req = $bdd->prepare($q);
	$req->execute([$partie,$user_infos['id']]);
	$result = $req->fetch(PDO::FETCH_ASSOC);


	echo $result['score'];

}



?>