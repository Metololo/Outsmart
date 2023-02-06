<!DOCTYPE html>
<html>

<?php 
$title = 'Connexion';
include('include/head.php');
include('include/header.php');
include('include/cookie_print.php');
include('include/msg_error.php');
include('include/print_error.php');

?>

<body>
	<div class="container-fluid connexion-container-1" >
  		<div class="row justify-content-center mt-2">
      			<img src="images/logosite.svg" class="col-4 col-lg-3 col-xl-2 img-fluid" alt="">
  		</div>
  		</div>
	</div>

	<div class="container-fluid">
		<div class="row justify-content-center">
			<div class="col-sm-10 col-md-6 col-xl-4 connexion-container">
				<h1>BIENVENUE.</h1>

				<?php if(!empty($_GET['validateMSG']))
				validate_msg($_GET['validateMSG']);?>

				<?php 
					if(isset($_GET['errorMsg']) && !empty($_GET['errorMsg'])){
						echo '<div id="coucou">' . htmlspecialchars($_GET['errorMsg']) . '</div>';
					}
				?>
				<form action="verif_connexion.php" method="post" class="super-form">
				  <div class="mb-3 full-width">
				  	<div class="label-container">
				  		<img src="images/email.svg" alt="email-logo">
				    	<label class="identif-label" for="emailInput">Adresse Email</label>
				  	</div>
				    <input type="email" name="email" value="<?php if(!empty($_COOKIE['email'])) cookie_print('email'); ?>" placeholder="Email" class="form-input form-control <?php if(!empty($_GET['mailMsg'])) invalid_class('mailMsg'); ?>" id="exampleInputEmail1" aria-describedby="emailHelp">
							<?php if(!empty($_GET['mailMsg'])) bad_feedback('mailMsg'); ?>

		  		  </div>
				  <div class="mb-3 full-width">
					    <div class="label-container">
					  		<img src="images/lock.svg" alt="email-logo">
					    	<label class="identif-label" for="passwordInput" class="form-label">Mot de Passe</label>
					  	</div>
					    <input type="password" name="password" placeholder="Mot De Passe" class="form-input form-control <?php if(!empty($_GET['mdpMsg'])) invalid_class('mdpMsg'); ?>" id="exampleInputPassword1">

							<?php if(!empty($_GET['mdpMsg'])) bad_feedback('mdpMsg'); ?>

					    <a href="forget_password.php"><div class="form-text">mot de passe oublié ?</div>
				  </div></a>
				  <button type="submit" class="connexion-btn">Se connecter</button>
				</form>

				<img src="images/black-line.svg" alt="">

				<a href="inscription.php">
					<div class="connexion-btn" id="inscription-btn" >S'inscrire</div>
				</a>

			</div>
		</div>
	</div>

<?php
	include('include/footer.php');
	include('include/header_js.php');
?>

</body>
</html>