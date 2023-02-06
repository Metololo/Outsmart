<?php session_start();

include('include/connexion_check.php');
include('include/print_error.php');
include('include/db.php');
include('include/ban_check.php');
include('include/logs.php');
include('include/global_error.php');

include('include/clear_session.php');
$title = 'Accueil';
$email = $_SESSION['email'];

include('include/admin_check.php');







$q='SELECT id,avatar_actif,pseudo,image,quizz_point FROM utilisateurs WHERE email= ?';
$reponse = $bdd->prepare($q);
$reponse->execute([$email]);
$user_infos = $reponse->fetch(PDO::FETCH_ASSOC);
$reponse->closeCursor();

include('include/in_game_check.php');

$msg = 'L\'utilisateur ' . $_SESSION['email'] . ' a visité la page ' . $title . ' le ' . $date . ' a ' . $heure;
new_log('visite_page.txt',$msg);



$q='SELECT COUNT(joueur) AS partie FROM joue_partie WHERE joueur = '.$user_infos['id'];
$req = $bdd->query($q);
$games = $req->fetch(PDO::FETCH_ASSOC);

$q='SELECT COUNT(joueur) AS partie FROM joue_partie WHERE a_gagne = 1 AND joueur = '.$user_infos['id'];
$req = $bdd->query($q);
$wins = $req->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html>
	<?php include('include/head.php'); ?>
	<body>

		<?php include('include/header.php'); ?>

			<main>

				<?php if(isset($_GET['error']) && !empty($_GET['error']))
					super_error('error','Aie ..'); ?>

				<div id="responsive-container">

					<div class="validate-index">
						<?php if(!empty($_GET['validateMSG']) && isset($_GET['validateMSG']))
						validate_msg($_GET['validateMSG']);?>					
					</div>

					<section id="section-1">
						<div class="Money">
							<img id="coin" src="images/coin.png" alt="COIN">
							<p><?= $user_infos['quizz_point'] ?></p>
						</div>

						<div id="section-1-buttons">
							<a href="boutique.php">
								<div class="shop-button">
									<p>Boutique</p>
									<img  id="shopping-cart-btn" src="images/shopping-cart.svg">
								</div>
							</a>
							
							<a href="amis.php">
								<div id="friends-button">
									<img src="images/friends.svg" alt="friends">
								</div>
							</a>
							
							
						</div>
					</section>

					<div id="container-1">
						<div id="avatar">
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
									echo '<div id="main-avatar">';
									echo '<img id="rectangles-kin" src="images/rectangle.png">';


										foreach ($skins_actifs as $image => $value) {
										if ($skins_actifs[$image]['type'] != 'cheveux'){
												echo '<img class="skin-img" src="uploads/avatar_custom/' . $skins_actifs[$image]['type'] . '/' . $skins_actifs[$image]['image'] . '.png" style="z-index : ' . $skins_actifs[$image]['ordre'] .'">';
									 	}else if($cosmetique['COUNT(id_skin)'] == 0){
									 		echo '<img class="skin-img" src="uploads/avatar_custom/' . $skins_actifs[$image]['type'] . '/' . $skins_actifs[$image]['image'] .'.png" style="z-index : ' . $skins_actifs[$image]['ordre'] .'">';
											} 
									}
									echo '</div>';
								}else{
									echo '<img src="uploads/avatars/'.$user_infos['image'].'">';
								}


								?>

							<h2><?php echo $user_infos['pseudo']?></h2>
						</div>

						<section id="section-2">
							<a href="mode_choice.php">
								<div id="create">
									<h2>Creer une partie</h2>
								</div>
							</a>
							
								<div id="join" data-bs-toggle="modal" data-bs-target="#leave-modal">
									<h2>Rejoindre une partie</h2>
								</div>
							
					
						</section>
					</div>

					
						<div id="stats">
							<h2>Statistiques</h1>

							<div id="flex-stats">
								<?php 
								if($games['partie'] == 0){
									echo'
										<div id="game-number">
											<p>Jouez une premiere partie pour obtenir vos statistiques 👆</p>
										</div>
									';

								}else{
									echo'

										<div id="game-number">
											<p>Parties jouées :</p>
											<p>'.$games['partie'].'</p>
										</div>
										<div id="game-number">
											<p>Victoires :</p>
											<p>'.$wins['partie'].'</p>
										</div>
										<div id="game-number">
											<p>WINRATE</p>
											<p>'.(round(($wins['partie']/$games['partie'])*100)).'%</p>
										</div>
									';
								}

								?>
								
							</div>

							
								<?php 
								if($games['partie'] == 0){
									echo'';

								}else{
									echo'
										<div id="ligue">';


									if($wins['partie'] < 5){
										echo '<img src="images/ranks/fer.png">';
										echo '<h4>FER</h4>';
									}else if($wins['partie'] < 10){
										echo '<img src="images/ranks/bronze.png">';
										echo '<h4>BRONZE</h4>';
									}else if($wins['partie'] < 20){
										echo '<img src="images/ranks/argent.png">';
										echo '<h4>ARGENT</h4>';
									}else if($wins['partie'] < 30){
										echo '<img src="images/ranks/Gold.png">';
										echo '<h4>OR</h4>';
									}else if($wins['partie'] < 40){
										echo '<img src="images/ranks/platine.png">';
										echo '<h4>PLATINE</h4>';
									}else if($wins['partie'] < 70){
										echo '<img src="images/ranks/diamant.png">';
										echo '<h4>DIAMANT</h4>';
									}else if($wins['partie'] < 100){
										echo '<img src="images/ranks/immortel.png">';
										echo '<h4>IMMORTEL</h4>';
									}else{
										echo '<img src="images/ranks/radiant.png">';
										echo '<h4>CHAMPION</h4>';
									}

									echo '</div>';

								}

								?>
								

							



						</div>
					

					
						<div id="best-themes">
							<h2>Thèmes les mieux notés</h2>
							<a href=""><img id="see-more" src="images/plus.svg"></a>
							<div id="themes-rated">
								<div>
									<img src="images/themes/culture.png" alt="culture générale">
									<p>9.7<p>
								</div>
								<div>
									<img src="images/themes/animal.png" alt="qui-est-ce">
									<p>9.3<p>
								</div>
								<div>
									<img src="images/themes/donut.png" alt="animaux">
									<p>8.5<p>
								</div>
								<div>
									<img src="images/themes/jv.png" alt="jeux-videos">
									<p>8.1<p>
								</div>
							</div>
						</div>
					
				</div>		
			</main>



			<div class="modal fade" id="leave-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				  <div class="modal-dialog" role="document">
				    <div class="modal-content leave-modal-better">
				      <div class="modal-header modal-head-custom">
				        <h5 class="modal-title">Entrer le code de la session à rejoindre</h5>
				        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
				          <span aria-hidden="true">&times;</span>
				        </button>
				      </div>
				      <div class="modal-body">
				      	<div class="modal-bod">
				      		<img src="images/shrek.png" id="shrekos">
				      	</div>
				      </div>

				      <form class="delete-confirm" method="post" action="join_session.php">						
				      	<input type="text" class="form-control" name="code">
								      		<button  class="super-delete" name="id" id="confirm_delete" type="submit">REJOINDRE</button>
								      	<button class="annuler-modal" type="button" data-bs-dismiss="modal">ANNULER</button>
			      	   </form>
				 
				    </div>
				  </div>
				</div>

			<?php include('include/footer.php')?>

			<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>


	</body>
</html>