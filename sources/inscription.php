<?php 
	$title = 'Inscription';
	include('include/db.php');
	include('include/cookie_print.php');
	include('include/print_error.php');
?>

<!DOCTYPE html>
<html>
	<?php include('include/head.php');?>
<body>

	<?php include('include/header.php'); ?>

	<div class="container-fluid connexion-container-1">
  		<div class="row justify-content-center mt-2">
      			<img src="images/logosite.svg" class="col-4 col-lg-3 col-xl-2 img-fluid" alt="">
  		</div>
	</div>

	<main class="container-fluid">
		<div class="row justify-content-center">
			<div class="col-sm-10 col-md-6 col-xl-5 connexion-container">
				<h1>INSCRIPTION</h1>

				<form action="verif_inscription.php" class="super-form" method="post" enctype="multipart/form-data">
				  	<div class="mb-3 full-width">
					  	<div class="label-container">
					    	<label class="identif-label" for="emailInput" class="form-label">Adresse Email</label>
					  	</div>
					    <input type="email" name="email" value="<?php if(!empty($_COOKIE['email'])) cookie_print('email'); ?>" placeholder="Email" class="form-input form-control <?php if(!empty($_GET['mailMsg'])) invalid_class('mailMsg'); ?>" id="inputEmail">
						<?php if(!empty($_GET['mailMsg'])) bad_feedback('mailMsg'); ?>

		  		  	</div>
		  		   	<div class="mb-3 full-width">
					  	<div class="label-container">
					    	<label class="identif-label" for="pseudo" class="form-label">Pseudo</label>
					  	</div>
					    <input type="text" name="pseudo" value="<?php if(!empty($_COOKIE['pseudo'])) cookie_print('pseudo'); ?>" placeholder="Pseudonyme" class="form-input form-control <?php if(!empty($_GET['pseudoMsg'])) invalid_class('pseudoMsg'); ?>" id="pseudoInput" aria-describedby="pseudoSaisis">
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

					  	<textarea class="form-control desc-input <?php if(!empty($_GET['descMsg'])) invalid_class('descMsg'); ?>" name="description" value="<?php if(!empty($_COOKIE['pseudo'])) cookie_print('pseudo'); ?>" placeholder="Description"></textarea>
					  	<?php if(!empty($_GET['descMsg'])) bad_feedback('descMsg'); 
							  else
							  	echo '<small id="passwordHelpInline" class="text-muted">
      									Max 128 caractères.
    							</small>';

					    	
					    ?>

					</div>

				  	<div class="mb-3 full-width">
					    <div class="label-container">
					    	<label class="identif-label" for="passwordInput" class="form-label">Mot de Passe</label>
					  	</div>
					    <input type="password" name="password" placeholder="Mot De Passe" class="form-input form-control <?php if(!empty($_GET['mdpMsg'])) invalid_class('mdpMsg'); ?>" id="InputPassword1">
						<?php if(!empty($_GET['mdpMsg'])) bad_feedback('mdpMsg'); 
							  else
							  	echo '<small id="passwordHelpInline" class="text-muted">
      									6-50 caractères.
    							</small>';

					    	
					    ?>
					</div>
					<div class="mb-3 full-width">
					    <div class="label-container">
					    	<label class="identif-label" for="passwordInput" class="form-label">Confirmez le mot de passe</label>
					  	</div>
					    <input type="password" name="confpass" placeholder="Entrez le même mot de passe" class="form-input form-control <?php if(!empty($_GET['mdpcMsg'])){ invalid_class('mdpcMsg'); }?>" id="confPassword">

					    <?php if(!empty($_GET['mdpcMsg'])) bad_feedback('mdpcMsg'); ?>
					</div>

					<div class="mb-3 full-width file-input-custom">
					    <div class="label-container">
					    	<label class="identif-label" for="imageInput" class="form-label">Image De Profil (optionnel : un avatar pourra être choisi)</label>
					  	</div>
					    <input type="file" name="image"  class="file-input-custom" accept="image/png, image/jpeg, image/gif">
					    <?php if(!empty($_GET['imageMsg'])){ bad_feedback('mdpcMsg'); } ?>
					</div>
					<?php if(!empty($_GET['imageMsg']))bad_feedback('imageMsg');
					    	  else 
					    	  	echo '<small id="passwordHelpInline" class="text-muted file-desc">
      									MAX 2MO - png,jpg,gif accéptès.
    							</small>';
					    	    ?>

				  <button type="submit" class="connexion-btn btn-connexion">S'INSCRIRE</button>
				</form>


			</div>
		</div>
	</main>

<?php
	include('include/footer.php');
	include('include/header_js.php');
?>

</body>
</html>