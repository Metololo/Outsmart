<?php session_start();
include('include/connexion_check.php');
include('include/db.php');
include('include/logs.php');

$id_friend = $_POST['id'];


$q='SELECT id FROM utilisateurs WHERE email = "' . $_SESSION['email'] . '"';
$reponse = $bdd->query($q);
$user_infos = $reponse->fetch();
$reponse->closeCursor();



$q='DELETE FROM est_ami WHERE (ami1 = '. $id_friend .' AND ami2 = '. $user_infos['id'] .') OR (ami2 = '. $id_friend .' AND ami1 = '. $user_infos['id'] .')';
$bdd->exec($q);

$q ='DELETE FROM demande_amis WHERE (id_envoie = '. $id_friend .' AND id_recoit = '. $user_infos['id'] .') OR (id_recoit = '. $id_friend .' AND id_envoie = '. $user_infos['id'] .')';
	$bdd->exec($q);

$msg = 'L\'utilisateur ' . $_SESSION['email'] . ' a supprimer l\'amis :  ' . $id_friend . ' le ' . $date . ' a ' . $heure;
new_log('amis.txt',$msg);


header('location:amis.php?deleted=Amis supprimé de votre liste.');
exit;




?>