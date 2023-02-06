<?php session_start();

	include('include/connexion_check.php');
	include('include/db.php');
	include('include/ban_check.php');
	include('include/msg_error.php');

	$email = $_SESSION['email'];
	$skin = $_POST['skin'];

	$q='SELECT id,quizz_point FROM utilisateurs WHERE email=?';
	$req = $bdd->prepare($q);
	$req->execute([$email]);
	$user_infos = $req->fetch(PDO:: FETCH_ASSOC);

	$reponse=$bdd->query('SELECT id_utilisateur FROM collection WHERE id_utilisateur =' . $user_infos['id'] . ' AND id_skin = ' . $skin);
	$result = $reponse->fetchAll(PDO::FETCH_ASSOC);
	$reponse->closeCursor();

	if(count($result) != 0){
            error_msg('boutique','achatMSG','Vous possèdez déja ce skin');
        }

	$reponse=$bdd->query('SELECT prix FROM skins WHERE id =' . $skin);
	$skin_infos = $reponse->fetch(PDO::FETCH_ASSOC);
	$reponse->closeCursor();

	if($user_infos['quizz_point'] < $skin_infos['prix']){
		error_msg('boutique','achatMSG','Vous n\'avez pas assez de quizz points pour pouvoir acheter ce skin !');
	}

 	$reponse=$bdd->query('INSERT INTO collection(id_utilisateur,id_skin) VALUES(' . $user_infos['id'] . ',' . $skin . ')');
	$reponse->closeCursor();

	$reponse=$bdd->query('UPDATE utilisateurs SET quizz_point = quizz_point - '. $skin_infos['prix'] . ' WHERE id = ' . $user_infos['id']);
	$reponse->closeCursor();

	header('location:boutique.php?achatReussis=Votre achat a été éfféctué ! 💰');

?>