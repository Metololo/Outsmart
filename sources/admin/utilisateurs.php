<?php session_start(); 

$title='Administration'; 
$email = $_SESSION['email'];

include('../include/db.php');

include('../include/connexion_check.php');
include('../include/no_admin.php');

$q='SELECT pseudo,image FROM utilisateurs WHERE email = "' . $email . '"';
$reponse = $bdd->query($q);
$admin_infos = $reponse->fetch();
$reponse->closeCursor();

$q='SELECT COUNT(id) FROM utilisateurs WHERE droit != 1';
$reponse = $bdd->query($q);
$nb_inscrits = $reponse->fetch();
$reponse->closeCursor();

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?= $title?></title>
	<meta lang="fr-FR">
	<link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<meta name="viewport" content="width-device-width, initial-scale=1.0">
	<meta name="OutSmart">
</head>
<body>



	<?php include('admin_header.php');?>

	<main class="full-main">


		<h1 class="big-title">Utilisateurs du site</h1>
		<div class="container-fluid">
			<div class="row admin-dashboard-section">
				<?php 

				$q='SELECT id,pseudo,image,verifie,email,quizz_point FROM utilisateurs WHERE droit = 0 ORDER BY id desc';
				$reponse = $bdd->query($q);
				$recent_users = $reponse->fetchAll();
				$reponse->closeCursor();

				?> 
				<div class="col-12 admin-table full-table">
					<table class="table table-hover">
				  <thead>
				    <tr>
				      <th scope="col">#</th>
				      <th scope="col">image</th>
				      <th scope="col">Pseudo</th>
				      <th scope="col">Email</th>
				      <th scope="col">Verification</th>
				      <th scope="col">QP</th>
				      <th scope="col">Actions</th>
				    </tr>
				  </thead>
				  <tbody>
				  	<?php 

				  	foreach ($recent_users as $user => $value) {
				  		echo '
				  			 <tr>
						      <th scope="row">' . $recent_users[$user]['id'] .'</th>
						      <td><img class="table-img"src="../uploads/avatars/' . $recent_users[$user]['image'] .'"></td>
						      <td>' . $recent_users[$user]['pseudo'] .'</td>
						        <td>' . $recent_users[$user]['email'] .'</td>
						      <td>' . $recent_users[$user]['verifie'] .'</td>
						      <td>' . $recent_users[$user]['quizz_point'] .'</td>
						      <td>
						      <a href=""><div type="button" class="btn btn-primary table-btn">Consulter</div><a>
						      </td>

						      				

	
						    </tr>
				  		';
				  	}
				  	?>

				  </tbody>
				</table>	
				</div>			
			</div>
		

		</div>
	</main>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>


</body>


</html>