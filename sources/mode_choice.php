<?php 
session_start();
include('include/connexion_check.php');
include('include/db.php');

$title = 'Forum';



?>

<!DOCTYPE html>
<html>
	<?php include('include/head.php'); ?>
<body>

	<main id="mode-main">


		<h1 class="absolute-title">Choisir un mode de jeu</h1>

			<form id="bobobo" method="post" action="theme_choice.php">

				<div class="mode-choice">
					<div class="mode-concern">
						<button class="super-mode" name="mode" type="submit" value="solo" id="SOLO-choice">
							<div class="help-mode" data-bs-toggle="modal" data-bs-target="#more-solo"><img src="images/help.svg"></div>
							<h2 class="choice-h">SOLO</h2>
						</button>
					</div>
				</div>

				<div class="mode-choice">
					<div class="mode-concern">
						<button class="super-mode" name="mode" type="submit" value="one" id="one-choice">
							<div class="help-mode" data-bs-toggle="modal" data-bs-target="#more-one"><img src="images/help.svg"></div>
							<h2 class="choice-h">1V1</h2>
						</button>
					</div>
				</div>

				<div class="mode-choice">
					<div class="mode-concern">
						<button class="super-mode" name="mode" type="submit" value="brawl" id="two-choice">
							<div class="help-mode" data-bs-toggle="modal" data-bs-target="#more-two"><img src="images/help.svg"></div>
							<h2 class="choice-h">BRAWL</h2>
						</button>
					</div>
				</div>


				<div class="mode-choice">
					<div class="mode-concern">
						<button class="super-mode" name="mode" type="submit" value="tournament" id="TOURNAMENT-choice">
							<div class="help-mode" data-bs-toggle="modal" data-bs-target="#more-tournament"><img src="images/help.svg"></div>
							<h2 class="choice-h">TOURNOI</h2>
						</button>
					</div>
				</div>




				<div class="modal fade" id="more-solo" tabindex="-1" role="dialog"  aria-hidden="true">
			 	 <div class="modal-dialog" role="document">
				    <div class="modal-content modal-custom">
				      <div class="modal-header">
				        <h5 class="modal-title choice-title-modal" id="delete_title">SOLO</h5>
				        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
				          <span aria-hidden="true">&times;</span>
				        </button>
				      </div>
				      <div class="modal-body modal-custom-p">
				        Le mode SOLO est un mode de jeu dans lequel vous jouer seul contre le temps. 
				        <br />Chaque partie gagné rapporte 10 QP
				      </div>
				    </div>
				  </div>
				</div>

				<div class="modal fade" id="more-one" tabindex="-1" role="dialog"  aria-hidden="true">
			 	 <div class="modal-dialog" role="document">
				    <div class="modal-content modal-custom">
				      <div class="modal-header">
				        <h5 class="modal-title choice-title-modal" id="delete_title">1V1</h5>
				        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
				          <span aria-hidden="true">&times;</span>
				        </button>
				      </div>
				      <div class="modal-body modal-custom-p">
				        Le mode 1V1 est un mode de jeu dans lequel vous jouer affrontez un autre joueur. 
				        <br />Chaque partie gagné rapporte 40 QP.
				      </div>
				    </div>
				  </div>
				</div>


				<div class="modal fade" id="more-two" tabindex="-1" role="dialog"  aria-hidden="true">
			 	 <div class="modal-dialog" role="document">
				    <div class="modal-content modal-custom">
				      <div class="modal-header">
				        <h5 class="modal-title choice-title-modal" id="delete_title">2V2</h5>
				        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
				          <span aria-hidden="true">&times;</span>
				        </button>
				      </div>
				      <div class="modal-body modal-custom-p">
				        Le mode 2V2 est un affrontement entre deux équipes de deux joueurs. Le cumule des points de chaque joueur d'une équipe détermine le vainqueur.
				        Chaque partie gagné rapporte 40 QP par joueur gagnant.
				      </div>
				    </div>
				  </div>
				</div>

				<div class="modal fade" id="more-tournament" tabindex="-1" role="dialog"  aria-hidden="true">
			 	 <div class="modal-dialog" role="document">
				    <div class="modal-content modal-custom">
				      <div class="modal-header">
				        <h5 class="modal-title choice-title-modal" id="delete_title">TOURNOI</h5>
				        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
				          <span aria-hidden="true">&times;</span>
				        </button>
				      </div>
				      <div class="modal-body modal-custom-p">
				        Il faut être au minimum 4 joueurs pour participer au mode tournoi. Les joueurs s'affrontent dans un arbre en 1V1 jusqu'a la finale.
				        <br />Gagner un tournoi vous rapportera 120 QP.
				      </div>
				    </div>
				  </div>
				</div>

			</form>





	</main>

	<?php
		  include('include/header_js.php');
	?>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>