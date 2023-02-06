<?php session_start();

	$email = $_SESSION['email'];

	include('../include/connexion_check.php');
	include('../include/db.php');

	$q='SELECT pseudo,image,id FROM utilisateurs WHERE email= ?';
	$reponse = $bdd->prepare($q);
	$reponse->execute([$email]);
	$user_infos = $reponse->fetch(PDO::FETCH_ASSOC);
	$reponse->closeCursor();


	$q='SELECT id,pseudo,description,image FROM utilisateurs WHERE id IN (SELECT id_envoie FROM demande_amis WHERE id_recoit = ' . $user_infos['id'] . ' AND accepte = 0);';
	$reponse = $bdd->query($q);
	$demandes = $reponse->fetchAll();
	$reponse->closeCursor();

	foreach ($demandes as $key => $value) {
		echo '

		<div class="friend-div">
		<div>
			<img class="friend-profile" src="uploads/avatars/' . $demandes[$key]['image'] . '">
		</div>
		<div class="friend-text-contain">
			<div class="friend-text">
				<div>
					<h3>' . $demandes[$key]['pseudo'] . '</h3>
					<p class="friend-stats">43 victoires</p>
				</div>
				<div class="icon-friend">
						<img src="images/accept.png" class="demande-accept" onclick="accept('. $user_infos['id']  .','. $demandes[$key]['id']  .');show_friends();">
					
						<img class="demande-accept" src="images/unaccept.svg" onclick="unaccept('. $user_infos['id']  .','. $demandes[$key]['id']  .')">
				</div>		
			</div>
		</div>								
	</div>

		';
	}

?>