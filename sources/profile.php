<?php 
session_start();
include('include/db.php');
include('include/ban_check.php');
include('include/cookie_print.php');
include('include/print_error.php');
include('include/logs.php');

$email = $_SESSION['email'];
include('include/admin_check.php');

$title = 'Profile';

include('include/admin_check.php');

$msg = 'L\'utilisateur ' . $_SESSION['email'] . ' a visité la page ' . $title . ' le ' . $date . ' a ' . $heure;
new_log('visite_page.txt',$msg);

$q='SELECT id,pseudo,email,avatar_actif,description,image FROM utilisateurs WHERE email=?';
$req = $bdd->prepare($q);
$req->execute([$email]);
$user_infos = $req->fetch(PDO:: FETCH_ASSOC);

include('include/in_game_check.php');


?>

<!DOCTYPE html>
<html>
<head>
 	<?php include ('include/head.php'); ?>
</head>
<body>

	<?php include('include/header.php'); ?>


	<main>

		<div class="validate-index">
						<?php if(!empty($_GET['validateMSG']))
						validate_msg($_GET['validateMSG']);?>					
		</div>

		<h1 class="main-title">MES INFORMATIONS</h1>

		<div class="container-fluid">
			<div class="row">
				<div class='col-md-6 profile-container'>
					<div id="profile_infos">
						<div id="profile-avatar">
							<div class="pp-container">
								<div class="avatar-show">
								<?php 

								include('include/print_avatar.php');


								?>
								
								
								
								</div>
							</div>
							

							<h3 class="h3-blue"><?= $user_infos['pseudo'];?></h3>
						</div>
						<div>
							<div class="avatar-infos"><img src="images/email.svg"><p><?= $user_infos['email'];?></p></div>
						</div>
						<div id="desc-info">
							<h4>Description</h4>
							<p><?= $user_infos['description'];?></p>
						</div>
					</div>
				</div>
				<div class='col-md-6 profile-container'>

					<h3 id="change-infos">Changer mes infos</h3>

					<form action="verif_profile.php" method="post" class="super-form" enctype="multipart/form-data">
				  		<div class="mb-3 full-width">
					  	<div class="label-container">
					    	<label class="identif-label" for="pseudo" class="form-label">Pseudo</label>
					  	</div>
					    <input type="text" name="pseudo" value="<?php echo $user_infos['pseudo'];?>" placeholder="Pseudonyme" class="form-input form-control <?php if(!empty($_GET['pseudoMsg'])) invalid_class('pseudoMsg'); ?>" id="pseudoInput" aria-describedby="pseudoSaisis">
						<?php if(!empty($_GET['pseudoMsg'])) bad_feedback('pseudoMsg');
							  else
						    	echo '<small id="passwordHelpInline" class="text-muted">
	      									3-15 caractères.
	    							</small>';
						 ?>

		  		  	</div>
					<div class="mb-3 full-width">
					  	<div class="label-container">
					    	<label class="identif-label" for="emailInput" class="form-label">Description</label>
					  	</div>

					  	<textarea class="form-control desc-input <?php if(!empty($_GET['descMsg'])) invalid_class('descMsg'); ?>" name="description" placeholder="Description"><?php echo $user_infos['description']?></textarea>

					  	<?php if(!empty($_GET['descMsg'])) bad_feedback('descMsg'); 
							  else
							  	echo '<small id="passwordHelpInline" class="text-muted">
      									Max 128 caractères.
    							</small>';

					    	
					    ?>


					</div>


					<div class="mb-3 full-width file-input-custom">
					    <div class="label-container">
					    	<label class="identif-label" for="imageInput" class="form-label">Image De Profil</label>
					  	</div>
					  	<div id="avatar-or-img">
					  		<input type="file" name="image"  class="file-input-custom" accept="image/png, image/jpeg, image/gif">
					  		<h3>OU</h3>
					  			<div class="infos-btn" onclick="select_avatar()" id="choose-avatar">
					    			<img src="images/arrow-right.svg">
					    			<p>Changer Avatar</p>
					    			
					    			
					    		</div>
					  		</div>
						</div>

				  <button type="submit" class="connexion-btn">Enregistrer</button>
				</form>
					
				</div>
			</div>
		</div>
		
	</main>
	<script src="js/avatar.js"></script>

	<?php include('include/footer.php'); 
		  include('include/header_js.php');
	?>



</body>
</html>