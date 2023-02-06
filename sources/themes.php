<?php 
session_start();
include('include/connexion_check.php');
include('include/db.php');
include('include/ban_check.php');
include('include/cookie_print.php');
include('include/print_error.php');
include('include/global_error.php');
include('include/logs.php');

$email = $_SESSION['email'];
include('include/admin_check.php');

$title = 'Themes';

include('include/admin_check.php');

$msg = 'L\'utilisateur ' . $_SESSION['email'] . ' a visité la page ' . $title . ' le ' . $date . ' a ' . $heure;
new_log('visite_page.txt',$msg);

$q='SELECT id,pseudo,email,description,image FROM utilisateurs WHERE email=?';
$req = $bdd->prepare($q);
$req->execute([$email]);
$user_infos = $req->fetch(PDO:: FETCH_ASSOC);


include('include/in_game_check.php');

?>

<!DOCTYPE html>
<html>
<head>
	<?php include('include/head.php'); ?>
</head>
<body>

	<?php include('include/header.php'); ?>


	<main>
		<h1 class="main-title">THEMES</h1>

		<div class="container">
			<div class="row">


				<?php 

				$q='SELECT COUNT(id) AS nb,theme,theme.image,nom,couleur FROM question,theme WHERE question.theme = theme.numero GROUP BY theme;
';
				$reponse = $bdd->query($q);
				$themes = $reponse->fetchAll();
				$reponse->closeCursor();

				foreach ($themes as $t => $value) {
					echo '

					<div class="col-12 col-md-6 col-lg-4 theme-div">
					<div class="theme-container-div">
						<div class="theme-total">
							<div class="theme-container" style="background: '. $themes[$t]['couleur'] .';">
								<img src="images/themes/'. $themes[$t]['image'] .'">
							</div>
							<div>
								<h3 class="theme-name">'. $themes[$t]['nom'] .'</h3>
							</div>
						</div>
					</div>
					<div clas="scroll-custom">
						<div>
							<p class="note-theme globale">Note globale : 4.5</p>
							
						</div>
						<div>
							<p class="note-theme">Mettre une note</p>
							<p class="star-rating">
								<span onclick="rate(\'star-p-1-1\')" id="star-p-1-1" class="star">⭐</span>
								<span onclick="rate(\'star-p-2-1\')" id="star-p-2-1" class="star">⭐</span>
								<span onclick="rate(\'star-p-3-1\')" id="star-p-3-1" class="star">⭐</span>
								<span onclick="rate(\'star-p-4-1\')" id="star-p-4-1" class="star">⭐</span>
								<span onclick="rate(\'star-p-5-1\')" id="star-p-5-1" class="star">⭐</span>
							</p>
							<div class="theme-info">
								<img class="question-image" src="images/question.png" alt="question">
								<p class="note-theme">'. $themes[$t]['nb'] .' Questions</p>
							</div>
						</div>
					</div>
				</div>


					';
				}

				?>


			</div>
		</div>
	</main>

	<?php include('include/footer.php'); 
	include('include/header_js.php');?>
	<script src="js/star_rate.js"></script>




</body>
</html>