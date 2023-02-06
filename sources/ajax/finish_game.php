<?php session_start();
include('../include/db.php');
include('../include/connexion_check.php');


$email = $_SESSION['email'];

$q='SELECT id,pseudo,image FROM utilisateurs WHERE email= ?';
$reponse = $bdd->prepare($q);

$reponse->execute([$email]);
$user_infos = $reponse->fetch(PDO::FETCH_ASSOC);
$reponse->closeCursor();


if(isset($_POST['score']) &&  isset($_POST['partie'])){
	$score = $_POST['score'];
	$partie = $_POST['partie'];

	$q='UPDATE joue_partie SET score = score + ? WHERE partie = ? AND joueur = ? ';
	$req = $bdd->prepare($q);
	$req->execute([$score,$partie,$user_infos['id']]);

	$q='UPDATE joue_partie SET finis = 1 WHERE partie = ? AND joueur = ? ';
	$req = $bdd->prepare($q);
	$req->execute([$partie,$user_infos['id']]);

	$q='DELETE FROM partie_q WHERE partie = ?';
	$req = $bdd->prepare($q);
	$req->execute([$partie]);

	$q='SELECT session FROM partie WHERE id = '.$partie;
	$reponse = $bdd->query($q);
	$session = $reponse->fetch(PDO::FETCH_ASSOC);

	$q='UPDATE partie SET statut = 1 WHERE id = ?';
	$req = $bdd->prepare($q);
	$req->execute([$partie]);

	$q='DELETE FROM contient_theme WHERE session = ?';
	$req = $bdd->prepare($q);
	$req->execute([$session['session']]);


	$q='DELETE FROM rejoin_session WHERE session = ?';
	$req = $bdd->prepare($q);
	$req->execute([$session['session']]);

	$q='UPDATE session SET statut = 2 WHERE id = ' .$session['session'];
	$req = $bdd->exec($q);





}



?>