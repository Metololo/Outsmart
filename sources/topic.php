<?php session_start();

include('include/connexion_check.php');
include('include/db.php');
include('include/ban_check.php');
include('include/cookie_print.php');
include('include/print_error.php');
include('include/global_error.php');

$email = $_SESSION['email'];
include('include/admin_check.php');

if(isset($_GET['topic']) && !empty($_GET['topic'])){
	$topic = $_GET['topic'];
}else{
	$topic = $_GET['id_topic'];
}


$q='SELECT id,pseudo,email,description,image FROM utilisateurs WHERE email=?';
$req = $bdd->prepare($q);
$req->execute([$email]);
$user_infos = $req->fetch(PDO:: FETCH_ASSOC);

include('include/in_game_check.php');

$q='SELECT date_creation,nom,nb_message,introduction,pseudo AS createur,topic.id AS id_topic FROM topic,utilisateurs WHERE utilisateurs.id = auteur AND topic.id = ' . $topic;
$reponse=$bdd->query($q);
$topic_infos = $reponse->fetch();
$reponse->closeCursor();

$fichier = 'topics/'.$topic.'.txt';

if(!file_exists($fichier)){
	$fichier_create = fopen($fichier,'a+');
	fputs($fichier_create,0);
	fclose($fichier_create);
}else{
	$fichier_open = fopen($fichier,'r+');
	$nb_vues = fgets($fichier_open);
	$nb_vues++;
	fseek($fichier_open,0);
	fputs($fichier_open,$nb_vues);
	fclose($fichier_open);
}





$title = 'Outsmart/' . $topic_infos['nom'];

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

					<?php 

					if(isset($_GET['error']) && !empty($_GET['error']))
					super_error('error','Aie ..');

					?>
					<div id="topic-header">
						<p class="topic-header-p"><strong class="topic-header-strong"><?= $title ?></strong> • Posté par <?= $topic_infos['createur']?> - <?= $topic_infos['date_creation'] ?></p>
						<h1 id="topic-header-title"><?= $topic_infos['nom']; ?></h1>

						<div id="topic-first-message">
							<p class="topic-message-p">
								<?= htmlspecialchars($topic_infos['introduction']) ?>
							</p>
						</div>
						<div id="topic-chat">

							<div id="topic-infos">
								<div class="topic-info">
									<img src="images/comments.png">
									<p class="topic-info-p"><?= $topic_infos['nb_message'] ?> Commentaires</p>
								</div>
								<div class="topic-info">
									<img src="images/views.png">
									<p class="topic-info-p"><?php 

									$fichier = 'topics/'.$topic.'.txt'; 

									$fichier_open = fopen($fichier,'r+');
									$nb_vues = fgets($fichier_open);

									echo $nb_vues;

								?> Vues</p>
								</div>
							</div>


							<div id=chat>
								<p id="label-commentaire">Poster un commentaire en tant que <span id="commentaire-pseudo"><?= $user_infos['pseudo'] ?></span></p>
								<form class="chat-form" onsubmit="return comment_verif()" method="post" action="send_msg.php">
									<input type="hidden" name="topic" value="<?= $topic_infos['id_topic'] ?>">
									<textarea name="msg" oninput="comment_verif()" onfocus="focus_change(1)" onblur="focus_change(0)" placeholder="L'accueil est une cérémonie réservée à un nouvel arrivant, consistant généralement à lui souhaiter la bienvenue et à faciliter son intégration." id="commentaire-topic"></textarea>
									<div id="commentaire-send">
										<button type="submit" id="commentaire-go">Envoyer</button>
									</div>
								</form>
							</div>

							<?php 

							$q='SELECT pseudo,utilisateurs.id AS auteur,message_forum.id AS id,image,topic,date_envoie,contenue FROM message_forum,utilisateurs WHERE auteur = utilisateurs.id AND topic = ' . $topic . ' ORDER BY date_envoie desc';
							$reponse = $bdd->query($q);
							$messages = $reponse->fetchAll();
							$reponse->closeCursor();

							foreach ($messages as $msg => $value) {
								echo'

							<div class="topic-answer">
								<div class="topic-answer-head">
									<div class="user-info-topic">
										<img src="uploads/avatars/' . $messages[$msg]['image'] .'">
										<p class="topic-header-p"><strong class="topic-header-strong">' . $messages[$msg]['pseudo'] .'</strong> • ' . $messages[$msg]['date_envoie'] .' </p>
									</div>';

									if($messages[$msg]['auteur'] == $user_infos['id']){
										echo '<div class="delete-message" onclick="delete_msg('. $messages[$msg]['id'] .')" data-bs-toggle="modal" data-bs-target="#delete_msg"><img src="images/trash.png"></div>';
									}
									
								echo '</div>
								<p class="topic-message-p adapt" c>' . $messages[$msg]['contenue'] .'</p>
							</div>


							';
							}


							?>
							
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

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
	<script src="js/comment_script.js"></script>
	<script src="js/delete_topic.js"></script>


</body>
</html>



