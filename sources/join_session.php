<?php session_start();

include('include/connexion_check.php');
include('include/db.php');

$email = $_SESSION['email'];

$q='SELECT id FROM utilisateurs WHERE email = "' . $_SESSION['email'] . '"';
	$reponse = $bdd->query($q);
	$user_infos = $reponse->fetch();
	$reponse->closeCursor();


if(isset($_POST['code']) && !empty($_POST['code'])){
	$code = $_POST['code'];
}else{
	header('location:index.php?error=Erreur lors de l\'envoie du code');
	exit;
}

$q='SELECT COUNT(id) as nb FROM session WHERE code = ?';
$req = $bdd->prepare($q);
$req->execute([$code]);
$result = $req->fetch(PDO::FETCH_ASSOC);
if($result['nb'] == 0){
	header('location:index.php?error=Aucune session trouvé');
	exit;
}

$q='SELECT * FROM session WHERE code = ?';
$req = $bdd->prepare($q);
$req->execute([$code]);
$session_infos = $req->fetch(PDO::FETCH_ASSOC);

if($session_infos['statut'] === 1){
	header('location:index.php?error=La partie a déja commencé');
	exit;
}

if($session_infos['statut'] === 2){
	header('location:game.php?code='.$session_infos['code']);
	exit;
}

$q='SELECT COUNT(partie) AS nb FROM joue_partie WHERE joueur = '.$user_infos['id'].' AND partie = (SELECT id FROM partie WHERE session = '.$session_infos['id'].')';
$req = $bdd->query($q);
$result = $req->fetch(PDO::FETCH_ASSOC);

if($result['nb'] == 1){
	header('location:game.php?code=' .$session_infos['code']);
	exit;
}

$q='SELECT COUNT(id) AS nb FROM session WHERE code = ?';
$req = $bdd->prepare($q);
$req->execute([$code]);
$result = $req->fetch(PDO::FETCH_ASSOC);

if($result['nb'] == 0){
	header('location:index.php?error=Aucune session trouvé');
	exit;
}

$q='SELECT id,nb_joueurs,code FROM session WHERE code = ?';
$req = $bdd->prepare($q);
$req->execute([$code]);
$session = $req->fetch(PDO::FETCH_ASSOC);

if($session['nb_joueurs'] >= 16){
	header('location:index.php?error=Nombre de joueurs maximum atteint.');
	exit;
}

$q='SELECT COUNT(id) AS nb FROM partie WHERE session = '.$session_infos['id'];
$req = $bdd->query($q);
$result = $req->fetch(PDO::FETCH_ASSOC);

if($result['nb'] == 1){

	$q='SELECT * FROM partie WHERE session = ?';
	$req = $bdd->prepare($q);
	$req->execute([$session_infos['id']]);
	$partie = $req->fetch(PDO::FETCH_ASSOC);

	$q='SELECT COUNT(joueur) AS nb FROM joue_partie WHERE joueur = ' .$user_infos['id']. ' AND partie = ' . $partie['id'];
	$req = $bdd->query($q);
	$result = $req->fetch(PDO::FETCH_ASSOC);

	if($result['nb'] == 0){
		header('location:index.php?error=La partie a déja commencé !');
		exit;
	}
}

$q='SELECT COUNT(joueur) AS nb FROM rejoin_session WHERE joueur = ' .$user_infos['id']. ' AND session = ' . $session_infos['id'];
	$req = $bdd->query($q);
	$result = $req->fetch(PDO::FETCH_ASSOC);

	if($result['nb'] == 1){
		header('location:lobby.php?code='.$session_infos['code']);
		exit;
	}


$q='INSERT INTO rejoin_session VALUES('.$session['id'].','.$user_infos['id'].')';
$bdd->exec($q);

$q='UPDATE session SET nb_joueurs = nb_joueurs + 1 WHERE id = ' .$session['id'];
	$bdd->exec($q);

header('location:lobby.php?code='.$code);
exit;

?>