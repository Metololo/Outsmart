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

$title = 'Forum';

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
	<?php include('include/head.php'); ?>
<body>

	<?php include('include/header.php'); ?>


	<main>

		<?php 
		if(isset($_GET['error']) && !empty($_GET['error']))
					super_error('error','Aie ..');
		if(isset($_GET['sucess']) && !empty($_GET['sucess']))
			super_sucess('sucess','Succès');
		?>

		<div class="validate-index">
						<?php if(!empty($_GET['validateMSG']))
						validate_msg($_GET['validateMSG']);?>					
		</div>

		<h1 class="main-title">FORUM : TOUT LES TOPICS</h1>

		<div class="container-fluid">
			<div class="row admin-dashboard-section">

				<div class="col-12 search-container">
					<div id="search-bar-contain">
						<input  class="search-input form-input form-control" id="search-forum" type="text" name="" placeholder="Chercher" oninput="search()">
						<div id="result"></div>
					</div>
						
						


		  			<button class=" btn btn-primary infos-btn topic-btn" id="create_topic" data-bs-toggle="modal" data-bs-target="#add_topic">
		    			<p>Creer un TOPIC</p>
		    		</button>
		    		<form method="post" id="see_topic">
		    			<button class=" btn btn-primary infos-btn topic-btn" type="submit" value="<?php 

		    			if(isset($_POST['my_topic']) && !empty($_POST['my_topic'])){
		    				if($_POST['my_topic'] == 1){
		    					echo '0';
		    				}else{
		    					echo '1';
		    				}
		    			}else{
		    				echo'1';
		    			}
		    		?>" name="my_topic">
		    				<p><?php

		    				
				    			if(isset($_POST['my_topic']) && !empty($_POST['my_topic'])){
				    				if($_POST['my_topic'] == 1){
				    					echo 'Voir tout les topics';
				    				}else{
				    					echo 'Voir mes topics';
				    				$choice = 1;
				    				}
				    			}else{
				    				echo 'Voir mes topics';
				    			}

		    				?></p>
		    			</button>
		    		</form>

					
				</div>


				<div class="modal fade" id="add_topic" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				  <div class="modal-dialog" role="document">
				    <div class="modal-content">
				      <div class="modal-header">
				        <h5 class="modal-title" id="exampleModalLabel">Creer Un Topic</h5>
				        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
				          <span aria-hidden="true">&times;</span>
				        </button>
				      </div>
				      <div class="modal-body">
				        <form method="post" action="create_topic.php" onsubmit="return verif_form('subject_input','desc_input')">
				          <div class="form-group" id="sujet_div">
				            <label  for="recipient-name" class="col-form-label">Sujet</label>
				            <input oninput="name_verif('subject_input')" type="text" class="form-control" id="subject_input" name="sujet" placeholder="J'adore ce site !">
				             <div id="subject_input_feedback"></div>

				          </div>
				          <div class="form-group">
				            <label for="message-text" class="col-form-label">Texte</label>
				            <textarea name="introduction" oninput="text_verif('desc_input')" class="form-control" placeholder="Je vais vous exposer mes 104 arguments justifiant le titre" id="desc_input"></textarea>
				            <div id="desc_input_feedback"></div>
				          </div>
				           <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
				        	<button type="submit" class="btn btn-primary">Envoyer</button>
				        </form>
				      </div>
				      <div class="modal-footer">
				      </div>
				    </div>
				  </div>
				</div>
	

				<div class="col-12 admin-table full-table">
					<table class="table table-striped">
				  <thead>
				    <tr>
				      <th scope="col">#</th>
				      <th scope="col">Sujet</th>
				      <th scope="col">Auteur</th>
				      <th scope="col">NB Réponses</th>
				      <th scope="col">Dernier message</th>
				      <?php if(isset($_POST['my_topic']) && !empty($_POST['my_topic'])){
				      	if ($_POST['my_topic'] == 1){
				      		echo '<th scope="col">Supprimer</th>';
				      	}
				      } 

				      ?>
				    </tr>
				  </thead>
				  <tbody>

				  	<?php 

			  		if(isset($_POST['my_topic']) && !empty($_POST['my_topic'])){
			  			if($_POST['my_topic'] == 1){
			  				$choice=1;
			  				$q='SELECT topic.id AS id,nom,pseudo,nb_message FROM topic,utilisateurs WHERE auteur = utilisateurs.id AND auteur = ' . $user_infos['id'] . ' ORDER BY nb_message desc';
			  			}else{
			  				$choice=2;
			  				$q='SELECT topic.id AS id,nom,pseudo,nb_message FROM topic,utilisateurs WHERE auteur = utilisateurs.id ORDER BY CASE WHEN DATEDIFF(date_creation,NOW()) > -1 THEN nb_message END desc';
			  			}
			  		}else{
			  			$choice=2;
			  			$q='SELECT topic.id AS id,nom,pseudo,nb_message FROM topic,utilisateurs WHERE auteur = utilisateurs.id ORDER BY CASE WHEN DATEDIFF(date_creation,NOW()) > -1 THEN nb_message END desc';
			  		}

				  	$reponse=$bdd->query($q);
				  	$topics = $reponse->fetchAll();
				  	$reponse->closeCursor();


				  	foreach ($topics as $topic => $value) {

				  		$q='SELECT max(date_envoie) AS dernier_msg FROM message_forum WHERE topic = ' . $topics[$topic]['id'];
					  	$reponse=$bdd->query($q);
					  	$dernier_msg = $reponse->fetch();
					  	$reponse->closeCursor();

				  		echo '
				  			 <tr>
						      <td>' . $topics[$topic]['id'] .'</td>
						      <td><form  class="form-topic-title" action="topic.php" method="get"><button class="btn btn-info" value="'.$topics[$topic]['id'].'" name="id_topic">' . $topics[$topic]['nom'] .'</button><form></td>
						      <td>' . $topics[$topic]['pseudo'] .'</td>
						      <td>' . $topics[$topic]['nb_message'] .'</td>
						      <td>'. $dernier_msg['dernier_msg'] .'</td>
						      ';

						      $deleteid = "delete" . $topics[$topic]['id'];

						      if ($choice == 1){
						      	echo '<td><button type="button" data-bs-toggle="modal" data-bs-target="#delete_topic" name="delete" class="btn btn-danger"  id="delete'. $topics[$topic]['id'] .'"  onclick="delete_topic(\'' . $deleteid . '\',\'' . $topics[$topic]['nom'] . '\')">Supprimer</button></td>';
						      }

						      echo '
						    </tr>
				  		';

				  	}

				  	?>

				  </tbody>
				</table>	
				</div>			
			</div>

			<div class="modal fade" id="delete_topic" tabindex="-1" role="dialog"  aria-hidden="true">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <h5 class="modal-title" id="delete_title">Etes-vous sure de vouloir supprimer le topic : Premier Topic du Site ?</h5>
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
				        <form id="form-delete" method="post" action="delete_topic.php">
			        		<button type="submit" class="btn btn-danger" id="confirm_delete" name="id">Supprimer</button>
			        	</form>

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
	<script src="js/verif_form.js"></script>
	<script src="js/delete_topic.js"></script>
	<script src="js/search.js"></script>

</body>
</html>