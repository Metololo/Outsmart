<?php 
session_start();
include('include/connexion_check.php');
include('include/db.php');

if(isset($_GET['code'])){
	$code = $_GET['code'];
}else{
	header('location:index.php?error=Lien invalide');
	exit;
}
$email = $_SESSION['email'];

$q='SELECT id FROM utilisateurs WHERE email= ?';
$reponse = $bdd->prepare($q);
$reponse->execute([$email]);
$user_infos = $reponse->fetch(PDO::FETCH_ASSOC);
$reponse->closeCursor();


$q='SELECT COUNT(id) as nb FROM session WHERE code = ?';
$req = $bdd->prepare($q);
$req->execute([$code]);
$result = $req->fetch(PDO::FETCH_ASSOC);
if($result['nb'] == 0){
	header('location:index.php?error=Aucune session trouvé');
	exit;
}

$q='SELECT * FROM session WHERE code = ?';
$req = $bdd->prepare($q);
$req->execute([$code]);
$session_infos = $req->fetch(PDO::FETCH_ASSOC);

if($session_infos['statut'] === 1){
	header('location:index.php?error=La partie a déja commencé');
	exit;
}

if($session_infos['statut'] === 2){
	header('location:game.php?code='.$session_infos['code']);
	exit;
}

$q='SELECT COUNT(id) AS nb FROM partie WHERE session = '.$session_infos['id'];
$req = $bdd->query($q);
$result = $req->fetch(PDO::FETCH_ASSOC);

if($result['nb'] == 1){

	$q='SELECT * FROM partie WHERE session = ?';
	$req = $bdd->prepare($q);
	$req->execute([$session_infos['id']]);
	$partie = $req->fetch(PDO::FETCH_ASSOC);

	$q='SELECT COUNT(joueur) AS nb FROM joue_partie WHERE joueur = ' .$user_infos['id']. ' AND partie = ' . $partie['id'];
	$req = $bdd->query($q);
	$result = $req->fetch(PDO::FETCH_ASSOC);

	if($result['nb'] == 0){
		header('location:index.php?error=La partie a déja commencé !');
		exit;
	}
}




$q='SELECT COUNT(session) AS nb FROM rejoin_session WHERE joueur = ? AND session = ? AND joueur != '.$session_infos['createur'];
$req = $bdd->prepare($q);
$req->execute([$user_infos['id'],$session_infos['id']]);
$result = $req->fetch(PDO::FETCH_ASSOC);


if($result['nb'] == 0){

	if($user_infos['id'] != $session_infos['createur']){
		$q='SELECT id,nb_joueurs,code FROM session WHERE code = ?';
		$req = $bdd->prepare($q);
		$req->execute([$code]);
		$session = $req->fetch(PDO::FETCH_ASSOC);

		if($session['nb_joueurs'] >= 16){
			header('location:index.php?error=Nombre de joueurs maximum atteint.');
			exit;
		}

	$q='INSERT INTO rejoin_session VALUES('.$session_infos['id'].','.$user_infos['id'].')';
	$bdd->exec($q);

	$q='UPDATE session SET nb_joueurs = nb_joueurs + 1 WHERE id = ' .$session_infos['id'];
	$bdd->exec($q);
	}

}

$q='SELECT COUNT(partie) AS nb FROM joue_partie WHERE joueur = '.$user_infos['id'].' AND partie = (SELECT id FROM partie WHERE session = '.$session_infos['id'].')';
$req = $bdd->query($q);
$result = $req->fetch(PDO::FETCH_ASSOC);

if($result['nb'] == 1){
	header('location:game.php?code=' .$session_infos['code']);
	exit;
}

$q='SELECT COUNT(id) AS nb FROM session WHERE createur = ' . $user_infos['id'] . ' AND statut = 0';
$reponse = $bdd->query($q);
$result = $reponse->fetch(PDO::FETCH_ASSOC);


$creator = 0;
if($result['nb'] == 1){
	$creator = 1;
}





$title = 'LOBBY';


?>


<!DOCTYPE html>
<html>
	<?php include('include/head.php'); ?>
<body onload="start_refresh()">

	<main>


		<h1 class="main-title">Lobby</h1>

		<div id="session-head">
			<div id="code-div">
				CODE : <?= $session_infos['code'] ?>
			</div>

			<div id="leave-session" data-bs-toggle="modal" data-bs-target="#leave-modal">
				QUITTER 
			</div>

		</div>

		<div>
			<div class="session-container">
				
				<h2 id="session_nb">Nombre de joueurs : <span id="session_joueurs"><?= $session_infos['nb_joueurs'] ?></span>/16</h2>

				
				<?php 
					if($creator === 1){
						echo '<form method="post" onsubmit="return verif_start()" action="start_game.php">
								<button type="submit" name="session" value="'.$session_infos['id'].'" class="suivant" id="suivant-theme">
									<p>LANCER</p>
								</button>
							</form>';
					}
				 ?>
				

				<div id="players-container">

					<?php 

					$q='SELECT pseudo,image FROM utilisateurs WHERE id IN (SELECT joueur FROM rejoin_session WHERE session='.$session_infos['id'].') OR id = (SELECT createur FROM session WHERE id = '.$session_infos['id'].')';
					$req = $bdd->query($q);
					$players = $req->fetchAll(PDO::FETCH_ASSOC);

					$i = 0;

					foreach ($players as $player) {
						echo'

							<div class="player-container">
								<div class="player">
									<img src="uploads/avatars/'.$player['image'].'">
								</div>				
								<p class="name-player">'.$player['pseudo'].'</p>
							</div>

						';

						$i = $i+1;
					}

					while ($i < 16) {
						$i = $i+1;
						echo'
							<div class="player-container">
								<div class="player">
									
								</div>				
								<p class="name-player"></p>
							</div>
						';
					}

					?>
		

				</div>

			</div>
		</div>

		<div class="modal fade" id="leave-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				  <div class="modal-dialog" role="document">
				    <div class="modal-content leave-modal-better">
				      <div class="modal-header modal-head-custom">
				        <h5 class="modal-title">Êtes vous sur de vouloir quitter ?</h5>
				        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
				          <span aria-hidden="true">&times;</span>
				        </button>
				      </div>
				      <div class="modal-body">
				      	<div class="modal-bod">
				      		<img src="images/sadge.gif">
				      		<p class="modal-p">Si vous ête le créateur, la session sera détruite.</p>
				      	</div>


				      </div>

				      	<form class="delete-confirm" method="post" action="delete_session.php">
				      		<button  class="super-delete" name="partie" value="non" id="confirm_delete" type="submit">Oui je le veut 😡</button>
				      		<button class="annuler-modal" type="button" data-bs-dismiss="modal">Non j'annule 😇</button>
			      		</form>
				 
				    </div>
				  </div>
				</div>


			
	</main>

	<?php
		  include('include/header_js.php');
	?>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
	<script src="js/lobby.js"></script>


</body>
</html>