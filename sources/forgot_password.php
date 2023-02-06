<!DOCTYPE html>
<html>

<?php 
$title = 'Oublie de mot de passe';
include('include/head.php');
include('include/db.php');
include('include/cookie_print.php');
include('include/print_error.php');

?>

<body>
	<?php include('include/header.php');?>

	<div class="container-fluid connexion-container-1">
  		<div class="row justify-content-center mt-2">
      			<img src="images/logosite.svg" class="col-4 col-lg-3 col-xl-2 img-fluid" alt="">
  		</div>
	</div>

	<main class="container-fluid">
		<div class="row justify-content-center">
			<div class="col-sm-10 col-md-6 col-xl-5 connexion-container">
				<h1 id="recup-mdp-title">RECUPERATION DE MOT DE PASSE</h1>

				<form action="verif_inscription.php" class="super-form" method="post" enctype="multipart/form-data">
				  	<div class="mb-3 full-width">
					  	<div class="label-container">
					    	<label class="identif-label" for="emailInput" class="form-label">Adresse Email </label>
					  	</div>
					    <input type="email" name="email" value="<?php if(!empty($_COOKIE['email'])) cookie_print('email'); ?>" placeholder="Email" class="form-input form-control <?php if(!empty($_GET['mailMsg'])) invalid_class('mailMsg'); ?>" id="inputEmail">
						<?php if(!empty($_GET['mailMsg'])) bad_feedback('mailMsg'); ?>

		  		  	</div>

				  <button type="submit" class="connexion-btn btn-connexion">ENVOYER</button>
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