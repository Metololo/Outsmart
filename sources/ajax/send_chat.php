<?php session_start();

	include('../include/connexion_check.php');
	include('../include/db.php');

	$email = $_SESSION['email'];

	$q='SELECT id FROM utilisateurs WHERE email = "' . $_SESSION['email'] . '"';
	$reponse = $bdd->query($q);
	$user_infos = $reponse->fetch();
	$reponse->closeCursor();


	if(isset($_POST['friend']) && !empty($_POST['friend'])){
	$friend = $_POST['friend'];

	$q='SELECT pseudo,image,id FROM utilisateurs WHERE id IN (SELECT ami1 FROM est_ami WHERE ami2 = '. $user_infos['id'] .' AND ami1 = 56) OR id IN (SELECT ami2 FROM est_ami WHERE ami1 = '. $user_infos['id'] .' AND ami2 = '. $friend .')';
	$reponse = $bdd->query($q);
	$ami = $reponse->fetch();
	$reponse->closeCursor();

	$msg = $_POST['msg'];

	
	$q='SELECT COUNT(ami1) AS nb FROM est_ami WHERE (ami1 = ? AND ami2 = ' .$user_infos['id']. ' AND bloque != 1) OR (ami2 = ? AND ami1 = ' .$user_infos['id']. ' AND bloque != 1)';
	$req = $bdd->prepare($q);
	$req->execute([$friend,$friend]);
	$exist = $req->fetch(PDO:: FETCH_ASSOC);

	if($exist['nb'] == 0){
		header('location:../amis.php?error=Echec de l\'envoie du message.');
		exit;
	}

	$q='INSERT INTO envoie_message(id_envoie,id_recoit,date_envoie,contenue,vue) VALUES(' . $user_infos['id'] .',?,NOW(),?,0)';
	$req = $bdd->prepare($q);
	$result = $req->execute([$friend,$msg]);

	if(!$result){
		header('location:amis.php?error=Erreur lors de l\'envoie du message');
		exit;
	}


	}else
	




?>