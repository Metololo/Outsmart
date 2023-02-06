<?php session_start();

include('include/connexion_check.php');
include('include/db.php');

$email = $_SESSION['email'];

$q='SELECT id,pseudo,image FROM utilisateurs WHERE email= ?';
$reponse = $bdd->prepare($q);
$reponse->execute([$email]);
$user_infos = $reponse->fetch(PDO::FETCH_ASSOC);
$reponse->closeCursor();

if(!isset($_GET['code']) && empty($_GET['code'])){
	header('location:index.php?error=La partie n\'éxiste pas');
}

$code = $_GET['code'];

$q='SELECT COUNT(session.id) AS nb FROM session,partie WHERE partie.session = session.id AND code = ?';
$req = $bdd->prepare($q);
$req->execute([$code]);
$result = $req->fetch(PDO::FETCH_ASSOC);

if($result['nb'] == 0){
	header('location:index.php?error=Aucune partie trouvé');
	exit;
}

$q='SELECT * FROM session WHERE code = ?';
$req = $bdd->prepare($q);
$req->execute([$code]);
$session = $req->fetch(PDO::FETCH_ASSOC);


$q='SELECT * FROM partie WHERE session = ?';
$req = $bdd->prepare($q);
$req->execute([$session['id']]);
$partie = $req->fetch(PDO::FETCH_ASSOC);


if($session['statut'] == 2){
	header('location:game_score.php?code='.$session['code']);
	exit;
}else{
	$q='SELECT COUNT(joueur) AS nb FROM joue_partie WHERE joueur = ' .$user_infos['id']. ' AND partie = ' . $partie['id'];
	$req = $bdd->query($q);
	$result = $req->fetch(PDO::FETCH_ASSOC);

	if($result['nb'] == 0){
		header('location:index.php?error=La partie a déja commencé !');
		exit;
	}

	$q='SELECT ordre,question.question AS question,image,audio,type FROM partie_q,question WHERE partie_q.question = question.id AND statut = 0 AND partie = '.$partie['id'] .' ORDER BY ordre asc LIMIT 1;
	';

	$req = $bdd->prepare($q);
	$req->execute([$user_infos['id']]);
	$question_infos = $req->fetch(PDO::FETCH_ASSOC);

	$q='SELECT score FROM joue_partie WHERE joueur = ? AND partie = ?';
	$req = $bdd->prepare($q);
	$req->execute([$user_infos['id'],$partie['id']]);
	$score = $req->fetch(PDO::FETCH_ASSOC);
}




$title = 'game';

?>

<!DOCTYPE html>
<html>
	<?php include('include/head.php'); ?>
<body class="quizz-body" onload="get_session_infos()">

	<div class="quizz-container">
		<div class="row justify-content-center quizz-super">
			<div class="col-12 col-md-8 col-lg-6" id="qq">

				<div class="head-quizz">
					<div class="player1">
						<img src="uploads/avatars/<?= $user_infos['image'] ?>">
						<h3 id="score-p1"><?= $score['score'] ?></h3>
					</div>
					<div class="left-time">
						<h2 id="left-time-text"><?= $session['tmp_reponse']?></h2>
					</div>
					<div class="player1 options-game" id="leave-game" data-bs-toggle="modal" data-bs-target="#leave-modal">
						<img src="images/leave.png">
					</div>
				</div>
				<h2 class="nb-question">Question <span id="question_actuel"><?= $question_infos['ordre'] ?></span>/<span id="nb_question"><?= $session['nb_questions'] ?><span></h2>

				<p id="question-quizz">
					<?= $question_infos['question']?>
				</p>
				<div id="super-reponse">	

					<?php 

						if($question_infos['type'] === 'i'){
							echo '
							<div class="quizz-container-img">
								<img class="q-image" src="images/quiz/'.$question_infos['image'].'.png">		
							</div>

						';
						}else if($question_infos['type'] === 'a'){
							echo '<div class="q-audio">
									<audio controls autoplay>
									  <source src="audio/loading.mp3" type="audio/ogg">
									  Your browser does not support the audio element.
									</audio>
								  </div>';
						}

					?>
				

					<div class="reponse-contain">

						<?php 


						if($question_infos['type'] === 'i'){

								echo'
								<div class="reponse-div i-type">
									<div class="reponse-q">
										<h3 class="reponse-t">loading...</h3>
									</div>
								</div>

								<div class="reponse-div i-type">
									<div class="reponse-q">
										<h3 class="reponse-t">loading...</h3>
									</div>
								</div>

								<div class="reponse-div i-type">
									<div class="reponse-q">
										<h3 class="reponse-t">loading...</h3>
									</div>
								</div>

								<div class="reponse-div i-type">
									<div class="reponse-q">
										<h3 class="reponse-t">loading...</h3>
									</div>
								</div>

								';
						}else{
							echo'
							<div class="reponse-div q-classic">
								<div class="reponse-q">
									<h3 class="reponse-t">loading...</h3>
								</div>
							</div>

							<div class="reponse-div q-classic">
								<div class="reponse-q">
									<h3 class="reponse-t">loading...</h3>
								</div>
							</div>

							<div class="reponse-div q-classic">
								<div class="reponse-q">
									<h3 class="reponse-t">loading...</h3>
								</div>
							</div>

							<div class="reponse-div q-classic">
								<div class="reponse-q">
									<h3 class="reponse-t">loading...</h3>
								</div>
							</div>';
						}

						?>

					</div>

				</div>

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
	      		<p class="modal-p">Vous ne pourrez plus revenir dans la partie après avoir quitter, êtes vous sur ?</p>
	      	</div>


	      </div>

	      	<form class="delete-confirm" method="post" action="delete_session.php">
	      		<button  class="super-delete" name="partie" value="oui" id="confirm_delete" type="submit">Oui je le veut 😡</button>
	      		<button class="annuler-modal" type="button" data-bs-dismiss="modal">Non j'annule 😇</button>
      		</form>
	 
	    </div>
	  </div>
	</div>

	<?php
		  include('include/header_js.php');
	?>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
	<script src="js/in_game.js"></script>
	
	

</body>
</html>