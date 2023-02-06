<?php session_start();
include('include/connexion_check.php');
include('include/db.php');
include('include/logs.php');

$id_topic = $_POST['id'];
$email = $_SESSION['email'];

$q='SELECT id FROM utilisateurs WHERE email = "' . $_SESSION['email'] . '"';
$reponse = $bdd->query($q);
$user_infos = $reponse->fetch();
$reponse->closeCursor();




$q='SELECT COUNT(id) AS nb FROM topic WHERE id = ' . $id_topic . ' AND auteur = ' . $user_infos['id'];
$reponse = $bdd->query($q);
$result = $reponse->fetch();
$reponse->closeCursor();


if($result['nb'] == 0){
	header('location:forum.php?error=Erreur, vous n\'êtes pas le créateur de ce topic');
	exit;
}

$q='DELETE FROM message_forum WHERE topic = ' . $id_topic;
$bdd->exec($q);

$q='DELETE FROM topic WHERE id = ' . $id_topic;
$bdd->exec($q);

$msg = 'L\'utilisateur ' . $_SESSION['email'] . ' a supprimer le topic :  ' . $id_topic . ' le ' . $date . ' a ' . $heure;
new_log('creation_topic.txt',$msg);

$fichier = 'topics/'.$id_topic.'.txt';

if(file_exists($fichier)){
	unlink($fichier);
}


header('location:forum.php?sucess=Le topic a été supprimé avec succès !');
exit;




?>