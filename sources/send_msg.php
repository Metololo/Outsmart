<?php session_start();

	include('include/connexion_check.php');
	include('include/db.php');
	include('include/ban_check.php');


	$q='SELECT id FROM utilisateurs WHERE email = "' . $_SESSION['email'] . '"';
	$reponse = $bdd->query($q);
	$user_infos = $reponse->fetch();
	$reponse->closeCursor();

	$msg = $_POST['msg'];
	$topic = $_POST['topic'];

	$q='SELECT COUNT(id) AS nb FROM topic WHERE id = ?';
	$req = $bdd->prepare($q);
	$req->execute([$topic]);
	$result = $req->fetch();

	if($result['nb'] == 0){
		header('location:forum.php?error="Le topic n\'existe pas/plus.."');
		exit;
	}

	$q='INSERT INTO message_forum(auteur,topic,date_envoie,contenue) VALUES(' . $user_infos['id'] .',:topic,NOW(),:contenue)';
	$req = $bdd->prepare($q);
	$result = $req->execute([
		'topic' => $topic,
		'contenue' => $msg
	]);
	if(!$result){
		header('location:forum.php?error=Erreur lors de l\'envoie du message');
		exit;
	}else{

		$q='UPDATE topic SET nb_message = nb_message + 1 WHERE id = ' . $topic;
		$bdd->exec($q);


		header('location:topic.php?topic=' . $topic);
		exit;
	}





?>