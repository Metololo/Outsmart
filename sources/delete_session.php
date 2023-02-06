<?php session_start();

include('include/db.php');
include('include/connexion_check.php');


$email = $_SESSION['email'];

$q='SELECT id,pseudo,image FROM utilisateurs WHERE email= ?';
$reponse = $bdd->prepare($q);
$reponse->execute([$email]);
$user_infos = $reponse->fetch(PDO::FETCH_ASSOC);
$reponse->closeCursor();

if(!isset($_POST['partie']) && empty($_POST['partie']) && $_POST['partie'] != 'oui' && $_POST['partie'] != 'non'){
	header('location:index.php?error=Arrete d\'essayer de modifier le post du button MERCI....');
	exit;
}

$q='SELECT COUNT(id) AS nb FROM session WHERE createur = ' . $user_infos['id'];
	$reponse = $bdd->query($q);
	$creator = $reponse->fetch(PDO::FETCH_ASSOC);


if($_POST['partie'] == 'non'){


	$q='SELECT COUNT(id) AS nb FROM session WHERE createur = ' . $user_infos['id'];
	$reponse = $bdd->query($q);
	$result = $reponse->fetch(PDO::FETCH_ASSOC);

		// NON CREATEUR
	if($creator['nb'] == 0){
		$q='SELECT session AS id FROM rejoin_session WHERE joueur='.$user_infos['id'].' AND session IN (SELECT id FROM session WHERE statut = 0)';
		$reponse = $bdd->query($q);
		$session = $reponse->fetch(PDO::FETCH_ASSOC);
		$reponse->closeCursor();

		$q='UPDATE session SET nb_joueurs = nb_joueurs - 1 WHERE id = ' .$session['id'];
		$bdd->exec($q);

		$q='DELETE FROM rejoin_session WHERE joueur = ' .$user_infos['id'];
		$bdd->exec($q);

		$q='DELETE FROM joue_partie WHERE joueur = ' .$user_infos['id'];
		$bdd->exec($q);

		header('location:index.php?validateMSG=Session quitté');
		exit;
	}else{ // CREATEUR
		$q='SELECT id FROM session WHERE createur = ' .$user_infos['id'] .' AND statut = 0';
		$reponse = $bdd->query($q);
		$session = $reponse->fetch(PDO::FETCH_ASSOC);
		$reponse->closeCursor();

		$q='DELETE FROM contient_theme WHERE session = '.$session['id'].';DELETE FROM rejoin_session WHERE session = '.$session['id'].';DELETE FROM session WHERE id = '.$session['id'];

		$bdd->exec($q);

		header('location:index.php?validateMSG=Session supprimé');
		exit;
	}

}else if($_POST['partie'] == 'oui'){

	// il nous quitte :'( !!!!!

	if($creator['nb'] == 0){
		
		$q='DELETE FROM joue_partie WHERE joueur = ' .$user_infos['id'];
		$bdd->exec($q);

		$q='DELETE FROM rejoin_session WHERE joueur = ' .$user_infos['id'];
		$bdd->exec($q);

		header('location:index.php?validateMSG=Game left ( in english for the usa talker like me)');
		exit;
	}else{

		$q='SELECT id FROM session WHERE createur = ' .$user_infos['id'] .' AND statut = 1';
		$reponse = $bdd->query($q);
		$session = $reponse->fetch(PDO::FETCH_ASSOC);
		$reponse->closeCursor();
		
		$q='DELETE FROM joue_partie WHERE joueur = ' .$user_infos['id'];
		$bdd->exec($q);

		$q='UPDATE session SET createur = 0 WHERE id = ' .$session['id'];
		$bdd->exec($q);

		header('location:index.php?validateMSG=Game left ( in english for the usa talker like me)');
		exit;
	}

	
		
}









?>