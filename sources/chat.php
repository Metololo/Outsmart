<?php session_start();

include('include/connexion_check.php');
include('include/db.php');
include('include/ban_check.php');
include('include/cookie_print.php');
include('include/print_error.php');
include('include/global_error.php');

$email = $_SESSION['email'];
include('include/admin_check.php');

$q='SELECT id,pseudo,email,description,image FROM utilisateurs WHERE email=?';
	$req = $bdd->prepare($q);
	$req->execute([$email]);
	$user_infos = $req->fetch(PDO:: FETCH_ASSOC);

	include('include/in_game_check.php');

if(isset($_GET['friend']) && !empty($_GET['friend'])){
	$friend = $_GET['friend'];


	$q='SELECT COUNT(ami1) AS nb FROM est_ami WHERE (ami1 = ? AND ami2 = ' .$user_infos['id']. ' AND bloque != 1) OR (ami2 = ? AND ami1 = ' .$user_infos['id']. ' AND bloque != 1)';
	$req = $bdd->prepare($q);
	$req->execute([$friend,$friend]);
	$exist = $req->fetch(PDO:: FETCH_ASSOC);

if($exist['nb'] == 0){
	header('location:amis.php?error=Page introuvable. Aucun amis trouvé');
	exit;
	}
}else{
	header('location:amis.php?error=Page introuvable. Aucun amis trouvé');
	exit;
}

$q='SELECT pseudo,image,id FROM utilisateurs WHERE id IN (SELECT ami1 FROM est_ami WHERE ami2 = '. $user_infos['id'] .' AND ami1 = '. $friend .') OR id IN (SELECT ami2 FROM est_ami WHERE ami1 = '. $user_infos['id'] .' AND ami2 = '. $friend .')';
$reponse = $bdd->query($q);
$ami = $reponse->fetch();
$reponse->closeCursor();

$title = 'Chat w/' . $ami['pseudo'];

?>

<!DOCTYPE html>
<html>
	<?php include('include/head.php'); ?>
<body>

	<?php include('include/header.php'); ?>


	<main>
		<div class="container-fluid">
			<div class="row justify-content-center">
				<div class="col-12 col-sm-10 col-md-8 scroll-custom" id="topic-container">

					<div id="topic-header">
						<p class="topic-header-p"><strong class="topic-header-strong">@<?= $ami['pseudo']; ?></strong></p>

						<div id="super-chat-div">
							<div id="chat-container">
					
							</div>
							<div id="new-msg-check" onclick="come_back();">
								<img src="images/see-msg.png">
								<p id="new-msg-p">Revenir aux messages</p>
							</div>
						</div>

							<div id=chat>
								<p id="label-commentaire">Envoyer un message à <span class="friend-chat"><?= $ami['pseudo']; ?></span></p>
								<div class="chat-form">
									<input type="hidden" name="friend" id="friend-super-id" value="<?= $ami['id']; ?>">
									<textarea class="area-chat" name="msg" oninput="comment_verif()" onfocus="focus_change(1)" onblur="focus_change(0)" placeholder="L'accueil est une cérémonie réservée à un nouvel arrivant, consistant généralement à lui souhaiter la bienvenue et à faciliter son intégration." id="commentaire-topic"></textarea>
									<div id="commentaire-send">
										<button type="submit" id="commentaire-go" onclick="send_msg()">Envoyer</button>
									</div>
								</div>
							</div>
							
						</div>

						<div class="modal fade" id="delete_msg" tabindex="-1" role="dialog"  aria-hidden="true">
					 	 <div class="modal-dialog" role="document">
						    <div class="modal-content">
						      <div class="modal-header">
						        <h5 class="modal-title" id="delete_title">Etes-vous sure de vouloir supprimer ce message ?</h5>
						        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
						          <span aria-hidden="true">&times;</span>
						        </button>
						      </div>
						      <div class="modal-body">
						        Cette étape est définitive, contactez le support en cas de mauvaise manipulation.
						      </div>
							    <div class="modal-footer">
							        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
							        <form></form>
							        <form id="form-delete" method="post" action="delete_msg.php">
						        		<button type="submit" class="btn btn-danger" id="confirm_delete_msg" name="id">Supprimer</button>
						        	</form>

						      </div>
						    </div>
						  </div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</main>



	<?php include('include/footer.php'); 
		  include('include/header_js.php');
	?>
	<script src="js/comment_script.js"></script>
	<script src="js/chat.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>


</body>
</html>



