<?php 
session_start();

include('include/db.php');
include('include/ban_check.php');
$pseudo = $_POST['pseudo'];

$q='SELECT COUNT(pseudo)AS nombre,id FROM utilisateurs WHERE pseudo ="' . $pseudo . '"';
$req = $bdd->prepare($q);
$req->execute([$q]);
$receive_info = $req->fetch(); 

if($receive_info['nombre'] == 0){
	header('location:amis.php?error=Aucun utilisateur trouvé');
	exit;
}else{

	$q='SELECT id FROM utilisateurs WHERE email = "' . $_SESSION['email'] . '"';
	$reponse = $bdd->query($q);
	$user_id = $reponse->fetch(PDO::FETCH_ASSOC);
	$reponse->closeCursor();

	if($user_id['id'] == $receive_info['id']){
		header('location:amis.php?error=Vous ne pouvez pas vous ajouter vous-même en amis');
		exit;
	}

	$q='SELECT COUNT(id_envoie) AS send FROM demande_amis WHERE id_envoie = ' . $user_id['id'] . ' AND id_recoit = ' .$receive_info['id'];
	$reponse = $bdd->query($q);
	$result = $reponse->fetch(PDO::FETCH_ASSOC);
	$reponse->closeCursor();

	if ($result['send'] == 1){
		header('location:amis.php?error=Demande d\'amis déja envoyé !');
		exit;
	}

	$q='SELECT COUNT(id_envoie) AS send FROM demande_amis WHERE id_recoit = ' . $user_id['id'] . ' AND id_envoie = ' .$receive_info['id'];
	$reponse = $bdd->query($q);
	$result = $reponse->fetch(PDO::FETCH_ASSOC);
	$reponse->closeCursor();

	if ($result['send'] == 1){

		$q ='UPDATE demande_amis SET accepte = 1 WHERE id_recoit = ' . $user_id['id'] . ' AND id_envoie = ' . $receive_info['id'];
		$bdd->exec($q);

		$q ='INSERT INTO est_ami(ami1,ami2,date_ajout,bloque) VALUES('. $user_id['id'] .','. $receive_info['id'] .',NOW(),0)';
		$bdd->exec($q);

			header('location:amis.php?sucess=Demande d\'amis accépté !');
			exit;
	}


	$q='INSERT INTO demande_amis VALUES('. $user_id['id'] .',' .$receive_info['id'] . ',0)';
	$bdd->exec($q);

	header('location:amis.php?sucess=Demande d\'amis envoyé !');
	exit;

}

?>