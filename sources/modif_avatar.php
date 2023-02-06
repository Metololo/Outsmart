<?php 


	session_start();
	include('include/connexion_check.php');
	include('include/db.php');
	include('include/ban_check.php');
	include('include/head.php');
	include('include/cookie_print.php');
	include('include/print_error.php');
	include('include/global_error.php');

	$email = $_SESSION['email'];
	$skin = $_POST['skin'];
	
	// ON PREND LES INFOS DE L'USER

	$q='SELECT id,pseudo,email,description,image,quizz_point FROM utilisateurs WHERE email=?';
	$req = $bdd->prepare($q);
	$req->execute([$email]);
	$user_infos = $req->fetch(PDO::FETCH_ASSOC);


	if(isset($_POST['none']) && !empty($_POST['none'])){

		 $q="SELECT prix,id_skin FROM collection,skins WHERE id = id_skin AND type = '" . $_POST['none'] . "' AND actif = 1 AND id_utilisateur = " . $user_infos['id'] ;
		 $reponse = $bdd->query($q);
		 $no_skin = $reponse->fetch(PDO::FETCH_ASSOC);
		 $reponse->closeCursor();

		 if ($no_skin){
		 	if(isset($no_skin['prix'])){
	 			$q='UPDATE collection SET actif = 0 WHERE id_skin = ' . $no_skin['id_skin'] . ' AND id_utilisateur = ' . $user_infos['id'];
				$reponse = $bdd->query($q);
				$reponse->closeCursor();
		 	}else{
		 		$q='DELETE FROM collection WHERE id_skin = "' . $no_skin['id_skin'] .  '" AND id_utilisateur ="' . $user_infos['id'] . '"';
				$reponse = $bdd->query($q);
				$reponse->closeCursor();
		 	}

		}

		header('location:avatar.php');
	}



	// ON PREND LES INFOS DU SKIN A UTILISER

	 $q="SELECT id,prix,type FROM skins WHERE image= '" . $skin . "'";
	 $reponse = $bdd->query($q);
	 $skin_infos = $reponse->fetch(PDO::FETCH_ASSOC);
	 $reponse->closeCursor();



				// UN SKIN DU MEME TYPE EST DEJA ACTIF ?

			$q='SELECT id_skin,prix from skins,collection WHERE id_skin = id AND id_utilisateur ="' . $user_infos['id'] .'" AND type = "' . $skin_infos['type'] . '" AND actif = 1';
			$reponse = $bdd->query($q);
			$active_skin = $reponse->fetch(PDO::FETCH_ASSOC);
			$reponse->closeCursor();

			 if($active_skin){ // SI OUI

			 	// SI OUI ALORS ON LE SUPPRIME SI C'EST UN SKIN "DEFAULT" OU ON LE DESACTIVE SI C'EST UN SKIN PAYANT
			 if(isset($skin_infos['prix'])){

			 	$q='UPDATE collection SET actif = 0 WHERE id_skin = ' . $active_skin['id_skin'] . ' AND id_utilisateur = ' . $user_infos['id'];
				$reponse = $bdd->query($q);
				$reponse->closeCursor();

				$q='UPDATE collection SET actif = 1 WHERE id_skin = "' . $skin_infos['id'] . '" AND id_utilisateur ="' . $user_infos['id'] . '"';
			 	$reponse = $bdd->query($q);
				$reponse->closeCursor();

			 }else{

				 	$q='SELECT COUNT(id_utilisateur) FROM collection WHERE id_skin = "' . $skin_infos['id'] . '" AND id_utilisateur = "' . $user_infos['id'] . '"';
					$reponse = $bdd->query($q);
					$count = $reponse->fetch(PDO::FETCH_ASSOC);
					$reponse->closeCursor();

					if($count['COUNT(id_utilisateur)'] == 0){
						$q='DELETE FROM collection WHERE id_skin = "' . $active_skin['id_skin'] .  '" AND id_utilisateur ="' . $user_infos['id'] . '"';
						$reponse = $bdd->query($q);
						$reponse->closeCursor();

						// SKIN GRATUIT = ON L'AJOUTE A LA COLLECTION ET ON L'ACTIVE
						$q='INSERT INTO collection(id_utilisateur,id_skin,actif) VALUES(' . $user_infos['id'] .','. $skin_infos['id'] .',1)';
				 		$reponse = $bdd->query($q);
				 		$reponse->closeCursor();
					}
			 	}	

			}else if(!$active_skin){
				if(isset($skin_infos['prix'])){
					$q='UPDATE collection SET actif = 1 WHERE id_skin = "' . $skin_infos['id'] . '" AND id_utilisateur ="' . $user_infos['id'] . '"';
			 		$reponse = $bdd->query($q);
					$reponse->closeCursor();
				}else{
					$q='INSERT INTO collection(id_utilisateur,id_skin,actif) VALUES(' . $user_infos['id'] .','. $skin_infos['id'] .',1)';
			 		$reponse = $bdd->query($q);
			 		$reponse->closeCursor();
				}
			}

			header('location:avatar.php');
			exit;


?>

	
