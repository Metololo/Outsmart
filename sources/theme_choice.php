<?php 
session_start();
include('include/connexion_check.php');
include('include/db.php');
$title = 'Themes';

$email = $_SESSION['email'];

$q='SELECT id FROM utilisateurs WHERE email=?';
$req = $bdd->prepare($q);
$req->execute([$email]);
$user_infos = $req->fetch(PDO:: FETCH_ASSOC);

include('include/in_game_check.php');


if(!isset($_POST['mode'])){
	header('location:index.php?error=Erreur lors du choix de mode de jeu');
	exit;
}

$mode = $_POST['mode'];
if($mode != 'solo' && $mode != 'brawl' && $mode != 'one' && $mode != 'tournament'){
	header('location:index.php?error=Erreur lors du choix de mode de jeu');
	exit;
}

$q='SELECT numero,nom,couleur,image FROM theme';
$req = $bdd->query($q);
$themes = $req->fetchAll(PDO:: FETCH_ASSOC);

$q='SELECT COUNT(id) AS total_q FROM question';
$req = $bdd->query($q);
$total = $req->fetch(PDO:: FETCH_ASSOC);



?>


<!DOCTYPE html>
<html>
	<?php include('include/head.php'); ?>
<body>

	<main>


		<h1 class="main-title">Choisir vos thèmes</h1>

		<form method="post" onsubmit="return verif_btn()" action="session_create.php">
			<button type="submit" onclick="send_themes()" class="suivant" id="suivant-theme" name="themes">
				<p><?php 

				if($mode === 'solo'){
					echo'LANCER';
				}else{
					echo'SUIVANT';
				}

			?></p>
			</button>

			<div id="conf-container">
				<div id="conf-flex">
					<div class="col-12 col-sm-8 col-md-6 col-lg-4 config-choice">
						<p>Nombres de questions :</p>
						<select onchange="verif_btn()" name="nombre" class="config-select" id="select-q">
							<option>10</option>
							<option>15</option>
							<option>20</option>
						</select>
					</div>


					<div class="col-12 col-sm-8 col-md-6 col-lg-4 config-choice" id="tmp-config">
						<p>Temps de réponse :</p>
						<select onchange="verif_btn()" name="temps" class="config-select">
							<option value="10">10s</option>
							<option value="15">15s</option>
							<option value="20">20s</option>
						</select>
					</div>
				</div>

			</div>



			<input type="hidden" name="mode" value="<?= $mode ?>">
		</form>

		<div id="select-all-container">
			<div id="select-all" onclick="select_all()">
				<svg  id="check-svg" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path id="path1" d="M9 11.0769L12 13.8462L22 4.61539" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
				<path id="path2" d="M21 12V18.4615C21 18.9512 20.7893 19.4207 20.4142 19.767C20.0391 20.1132 19.5304 20.3077 19 20.3077H5C4.46957 20.3077 3.96086 20.1132 3.58579 19.767C3.21071 19.4207 3 18.9512 3 18.4615V5.53845C3 5.04881 3.21071 4.57924 3.58579 4.23302C3.96086 3.8868 4.46957 3.69229 5 3.69229H16" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>

				<h3 id="select-all-text">Tout séléctionner : <span id="nb_q_select">0</span>/<?= $total['total_q']; ?> questions</h3>
			</div>
		</div>


		<div class="container-fluid" id="theme-choice">

			<?php 

			foreach($themes as $theme => $value) {
				echo'<div class="theme-total theme-choice-div supra-container">
					<div class="theme-container supra-theme" onclick="select_theme(\''. $themes[$theme]['numero'] .'\')" id="'. $themes[$theme]['numero'] .'" style="background: '. $themes[$theme]['couleur'] .';">
						<img src="images/themes/'. $themes[$theme]['image'] .'">
					</div>
					<div>
						<h3 class="theme-name supra-theme-h3">'. $themes[$theme]['nom'] .'</h3>
					</div>
				</div>';
			}

			?>

		</div>


			
	</main>

	<?php
		  include('include/header_js.php');
	?>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
	<script src="js/themes.js"></script>


</body>
</html>