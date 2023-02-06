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

if($session['statut'] != '2'){
	header('location:index.php?error:Aucune partie trouvé');
	exit;
}

$q='SELECT * FROM partie WHERE session = ?';
$req = $bdd->prepare($q);
$req->execute([$session['id']]);
$partie = $req->fetch(PDO::FETCH_ASSOC);

$title = 'game';

?>

<!DOCTYPE html>
<html>
	<?php include('include/head.php'); ?>
<body class="quizz-body" onload="wow()">

	<div class="quizz-container">
		<div class="row justify-content-center quizz-super">
			<div class="col-12 col-md-8 col-lg-6" id="qq">

				<h1 id="score_final">Tableau des scores</h1>

				
				

				<div id="participants">

					<a href="index.php">
						<div id="retour-menu">
							<img src="images/home.png">
							MENU
						</div>
					</a>

					<div id="leaderboard_cool">
						
						<div id="no-border">
									
							<h3>EN ATTENTE DES AUTRES JOUEURS ...</h3>
						</div>
						<img src="images/homer.gif">
					</div>

					

			
				</div>
				

			</div>
		</div>
	</div>



	<?php
		  include('include/header_js.php');
	?>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
	<script src="js/leaderboard.js"></script>
	

</body>
</html>