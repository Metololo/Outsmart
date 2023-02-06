<?php session_start();

include('include/connexion_check.php');
include('include/db.php');

$email = $_SESSION['email'];

$q='SELECT id FROM utilisateurs WHERE email = "' . $_SESSION['email'] . '"';
	$reponse = $bdd->query($q);
	$user_infos = $reponse->fetch();
	$reponse->closeCursor();


if(isset($_POST['themes']) && !empty($_POST['themes']) &&
	isset($_POST['nombre']) && !empty($_POST['nombre']) &&
	isset($_POST['temps']) && !empty($_POST['temps']) &&
	isset($_POST['mode']) && !empty($_POST['mode'])){

	$themes = explode('-',$_POST['themes']);
	$nombre = $_POST['nombre'];
	$temps = $_POST['temps'];
	$mode = $_POST['mode'];
}else{
	header('location:index.php?error=Erreur lors de la création de la partie. Veuillez réessayer');
	exit;
}

$q = 'INSERT INTO session(nb_joueurs,statut,mode,nb_questions,tmp_reponse,date_creation,createur)
 	VALUES (1,0,?,?,?,NOW(),?)';
$req = $bdd->prepare($q);
$result = $req->execute([$mode,$nombre,$temps,$user_infos['id']]);
if(!$result){
	header('location:index.php?error=Erreur lors de la création de la partie. Veuillez réessayer');
	exit;
}

$q = 'SELECT id FROM session WHERE createur = ? AND statut = 0';
$req = $bdd->prepare($q);
$req->execute([$user_infos['id']]);
$session = $req->fetch(PDO::FETCH_ASSOC);

if($session){
	$code_part = '';
	for($i = 0;$i<4-strlen($session['id']);$i++){
		$code_part = $code_part . '0';
	}
	$code = $code_part . $session['id'];
}


$q = 'UPDATE session set code = "' .$code. '" WHERE id=' . $session['id'];
$bdd->exec($q);

$q='INSERT INTO contient_theme VALUES('.$session['id'].',?)';
	$req = $bdd->prepare($q);

	foreach ($themes as $value) {
		$req->execute([$value]);
	}


header('location:lobby.php?code=' .$code);
exit;

?>