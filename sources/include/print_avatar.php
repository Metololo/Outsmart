<?php 

$q='SELECT ordre,image,type FROM skins,collection WHERE id_skin = id AND actif = 1 AND id_utilisateur = ' . $user_infos['id'] ;
$reponse = $bdd->query($q);
$skins_actifs = $reponse->fetchAll(PDO::FETCH_ASSOC);
$reponse->closeCursor();

$q='SELECT COUNT(id_skin) FROM collection,skins WHERE id_skin = id AND type = "cosmetique" AND image != "patty" AND actif=1 AND id_utilisateur = ' . $user_infos['id'];
$reponse=$bdd->query($q);
$cosmetique=$reponse->fetch(PDO::FETCH_ASSOC);
$reponse->closeCursor();



if($user_infos['avatar_actif'] == 1){
	echo '<img id="rectangles-kin" src="images/rectangle.png">';


		foreach ($skins_actifs as $image => $value) {
		if ($skins_actifs[$image]['type'] != 'cheveux'){
				echo '<img class="skin-img" src="uploads/avatar_custom/' . $skins_actifs[$image]['type'] . '/' . $skins_actifs[$image]['image'] . '.png" style="z-index : ' . $skins_actifs[$image]['ordre'] .'">';
	 	}else if($cosmetique['COUNT(id_skin)'] == 0){
	 		echo '<img class="skin-img" src="uploads/avatar_custom/' . $skins_actifs[$image]['type'] . '/' . $skins_actifs[$image]['image'] .'.png" style="z-index : ' . $skins_actifs[$image]['ordre'] .'">';
			} 
	}
}else{
	echo '<img src="uploads/avatars/'.$user_infos['image'].'">';
}


?>