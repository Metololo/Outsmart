<?php session_start();

include('include/connexion_check.php');
include('include/db.php');
include('include/ban_check.php');
include('include/logs.php');

$intro = $_POST['introduction'];
$sujet = $_POST['sujet'];


$q='SELECT id FROM utilisateurs WHERE email = "' . $_SESSION['email'] . '"';
$reponse = $bdd->query($q);
$user_infos = $reponse->fetch();
$reponse->closeCursor();

$q='INSERT INTO topic(nom,date_creation,nb_message,introduction,auteur) VALUES(:nom,NOW(),0,:introduction,'. $user_infos['id'] .')';
$req=$bdd->prepare($q);
$result = $req->execute([
	'nom' => $sujet,
	'introduction' => $intro
]);

if(!$result){
	header('location:forum.php?error=Erreur lors de la création du topic');
	exit;
}else{

	$msg = 'L\'utilisateur ' . $_SESSION['email'] . ' a crée un topic nommé :  ' . $sujet . ' le ' . $date . ' a ' . $heure;
	new_log('creation_topic.txt',$msg);

	header('location:forum.php?sucess=Topic crée !');
	exit;
}



?>