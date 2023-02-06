<?php session_start();

include('../include/db.php');
include('../include/connexion_check.php');


$email = $_SESSION['email'];

$q='SELECT id,pseudo,image FROM utilisateurs WHERE email= ?';
$reponse = $bdd->prepare($q);
$reponse->execute([$email]);
$user_infos = $reponse->fetch(PDO::FETCH_ASSOC);
$reponse->closeCursor();

$q='SELECT COUNT(id) AS nb FROM session WHERE createur = ' . $user_infos['id'].' AND statut = 0';
$reponse = $bdd->query($q);
$result = $reponse->fetch(PDO::FETCH_ASSOC);

$statut = 0;

// NON CREATEUR
if($result['nb'] == 0){
	$q='SELECT COUNT(session) AS nb FROM rejoin_session WHERE joueur = '.$user_infos['id'].' AND session IN (SELECT id FROM session WHERE statut = 0 OR statut = 1)';
	$reponse = $bdd->query($q);
	$result = $reponse->fetch(PDO::FETCH_ASSOC);

	if($result['nb'] == 0){
		$statut = 'finis';
		$lobby_infos[0] ='null';
		$lobby_infos[1] ='null';
		$lobby_infos[2] = $statut;
		echo json_encode($lobby_infos);
		exit;
	}else{
		$q='SELECT session AS id FROM rejoin_session WHERE joueur='.$user_infos['id']. ' AND session IN (SELECT id FROM session WHERE statut = 0 OR statut = 1)';
		$reponse = $bdd->query($q);
		$session = $reponse->fetch(PDO::FETCH_ASSOC);
		$reponse->closeCursor();
	}

	
	
}else{ // CREATEUR
	$q='SELECT id FROM session WHERE createur = ' .$user_infos['id'] . ' AND statut = 0';
	$reponse = $bdd->query($q);
	$session = $reponse->fetch(PDO::FETCH_ASSOC);
	$reponse->closeCursor();

}

					$q='SELECT pseudo,image,avatar_actif FROM utilisateurs WHERE id IN (SELECT joueur FROM rejoin_session WHERE session='.$session['id'].') OR id = (SELECT createur FROM session WHERE id = '.$session['id'].')';
					$req = $bdd->query($q);
					$players = $req->fetchAll(PDO::FETCH_ASSOC);

				
					$q='SELECT nb_joueurs,statut,code FROM session WHERE id =' .$session['id'];
					$req = $bdd->query($q);
					$session_infos = $req->fetch(PDO::FETCH_ASSOC);

					$lobby_infos[0] = $session_infos['nb_joueurs'];

					$players_div ='';

					$lobby_infos[2] = $session_infos['statut'];


					$i = 0;

					foreach ($players as $player) {
						 $players_div = $players_div.'<div class="player-container">
								<div class="player">
									<img src="uploads/avatars/'.$player['image'].'">
								</div>				
								<p class="name-player">'.$player['pseudo'].'</p>
							</div>';

						$i = $i+1;
					}

					while ($i < 16) {
						$i = $i+1;
						$players_div = $players_div.'
							<div class="player-container">
								<div class="player">
									
								</div>				
								<p class="name-player"></p>
							</div>';
					}

					$lobby_infos[1] = $players_div;

					$lobby_infos[3] = $session_infos['code'];

					echo json_encode($lobby_infos);


					






?>