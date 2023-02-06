<?php session_start();
include('../include/db.php');
include('../include/connexion_check.php');


$email = $_SESSION['email'];

$q='SELECT id,pseudo,image,avatar_actif FROM utilisateurs WHERE email= ?';
$reponse = $bdd->prepare($q);
$reponse->execute([$email]);
$user_infos = $reponse->fetch(PDO::FETCH_ASSOC);
$reponse->closeCursor();

$q='SELECT ordre,image,type FROM skins,collection WHERE id_skin = id AND actif = 1 AND id_utilisateur = ' . $user_infos['id'] ;
$reponse = $bdd->query($q);
$skins_actifs = $reponse->fetchAll(PDO::FETCH_ASSOC);
$reponse->closeCursor();

$q='SELECT COUNT(id_skin) FROM collection,skins WHERE id_skin = id AND type = "cosmetique" AND image != "patty" AND actif=1 AND id_utilisateur = ' . $user_infos['id'];
$reponse=$bdd->query($q);
$cosmetique=$reponse->fetch(PDO::FETCH_ASSOC);
$reponse->closeCursor();

if($user_infos['avatar_actif'] == 0){
		$q='UPDATE utilisateurs SET avatar_actif = 1 WHERE id = ' .$user_infos['id'];
		$bdd->exec($q);

		echo '<img id="rectangles-kin" src="images/rectangle.png">';


		foreach ($skins_actifs as $image => $value) {
			if ($skins_actifs[$image]['type'] != 'cheveux'){
					echo '<img class="skin-img" src="uploads/avatar_custom/' . $skins_actifs[$image]['type'] . '/' . $skins_actifs[$image]['image'] . '.png" style="z-index : ' . $skins_actifs[$image]['ordre'] .'">';
		 	}else if($cosmetique['COUNT(id_skin)'] == 0){
		 		echo '<img class="skin-img" src="uploads/avatar_custom/' . $skins_actifs[$image]['type'] . '/' . $skins_actifs[$image]['image'] .'.png" style="z-index : ' . $skins_actifs[$image]['ordre'] .'">';
			} 
		}
	}else if($user_infos['avatar_actif'] == 1){
		$q='UPDATE utilisateurs SET avatar_actif = 0 WHERE id = ' .$user_infos['id'];
		$bdd->exec($q);

		echo '<img src="uploads/avatars/'.$user_infos['image'].'">';
	}



// DELETE FROM joue_partie; DELETE FROM contient_theme; DELETE FROM partie_q; DELETE FROM contient_theme; DELETE FROM partie; DELETE FROM rejoin_session; DELETE FROM session;

			


?>