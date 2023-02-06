<?php session_start();

include('include/connexion_check.php');
include('include/db.php');
include('include/ban_check.php');
include('include/logs.php');
include('include/global_error.php');

$title = 'Amis';
$email = $_SESSION['email'];

include('include/admin_check.php');


$msg = 'L\'utilisateur ' . $_SESSION['email'] . ' a visité la page ' . $title . ' le ' . $date . ' a ' . $heure;
new_log('visite_page.txt',$msg);


$q='SELECT pseudo,image,id FROM utilisateurs WHERE email= ?';
$reponse = $bdd->prepare($q);
$reponse->execute([$email]);
$user_infos = $reponse->fetch(PDO::FETCH_ASSOC);
$reponse->closeCursor();

include('include/in_game_check.php');




?>

<!DOCTYPE html>
<html>
	<?php include('include/head.php'); ?>
	<body>

		<?php include('include/header.php'); ?>

			<main>
				<div class="container-fluid">
					<div class="row justify-content-center">
						<div class="col-12 col-md-8" id="friend-container">

							<?php 

								if(isset($_GET['error']) && !empty($_GET['error'])){
									super_error('error','');
								}
								if(isset($_GET['sucess']) && !empty($_GET['sucess'])){
									super_sucess('sucess','Utilisateur trouvé !');
								}
								if(isset($_GET['deleted']) && !empty($_GET['deleted'])){
									super_sucess('deleted','Succès !');
								}


							?>
		
							<div>
								<button type="button" class="btn btn-primary add-friend" data-bs-toggle="modal" data-bs-target="#ajouter_modal">
								  Ajouter
								</button>


								<!-- Modal -->
								<div class="modal fade" id="ajouter_modal" tabindex="-1" aria-hidden="true">
								  <div class="modal-dialog">
								    <div class="modal-content">
								      <div class="modal-header">
								        <h5 class="modal-title" id="exampleModalLabel">Ajouter Un nouvel ami</h5>
								        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">Fermer</button>
								      </div>
								      <form action="add_friend.php" method="post">
									      <div class="modal-body">
									       		 <div class="form-group">
												    <label >Pseudo</label>
												    <input type="texte" class="form-control" aria-describedby="emailHelp" placeholder="Ex : Johnnnyyyyy32" name="pseudo">
												  </div>
									      </div>
									      <div class="modal-footer">
									        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
									        <button type="submit" class="btn btn-primary">Envoyer</button>
									      </div>
									  </form>
								    </div>
								  </div>
								</div>

								<button type="button" class="btn btn-primary add-friend" data-bs-toggle="modal" data-bs-target="#demandes_modal">
								  Demandes d'amis
								</button>


								<!-- Modal -->
								<div class="modal fade" id="demandes_modal" tabindex="-1" aria-hidden="true">
								  <div class="modal-dialog">
								    <div class="modal-content">
								      <div class="modal-header">
								       	<h5>Demandes reçus</h5>
								      </div>

								      <div class="modal-body" id="demande-container">

								      	

								      </div>

								      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">Fermer</button>
						
								    </div>
								  </div>
								</div>

								
							</div>

							<div class="modal fade" id="supprimer" tabindex="-1" aria-hidden="true">
								  <div class="modal-dialog">
								    <div class="modal-content">
								      <div class="modal-header" id="delete-modal-title">
								        <h5 class="modal-title" id="delete_title"></h5>
								      </div>

								      	<form class="delete-confirm" method="post" action="delete_friend.php">
								      		<button  class="super-delete" name="id" id="confirm_delete" type="submit">Oui je le veut 😡</button>
								      	<button class="annuler-modal" type="button" data-bs-dismiss="modal">Non j'annule 😇</button>
								      	</form>
								  
								    </div>
								  </div>
							</div>

							<div id="my-friends">
							
							</div>
							

						</div>
					</div>
				</div>
				
			</main>

			<?php include('include/footer.php')?>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
	<script src="js/show_hide.js"></script>

	<script src="js/demande_amis.js"></script>
	<script src="js/delete_friend.js"></script>
	</body>
</html>