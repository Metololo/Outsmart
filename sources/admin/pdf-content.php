<?php 
session_start();
$title = 'caca';
$email = $_SESSION['email'];

include('../include/db.php');

include('../include/connexion_check.php');
include('../include/no_admin.php');
include('../include/global_error.php');

$q='SELECT pseudo,image FROM utilisateurs WHERE email = "' . $email . '"';
$reponse = $bdd->query($q);
$admin_infos = $reponse->fetch();
$reponse->closeCursor();

$q='SELECT COUNT(id) AS nb FROM session';
$reponse = $bdd->query($q);
$session = $reponse->fetch();
$reponse->closeCursor();

$sessions = $session['nb'];

$q='SELECT COUNT(id) FROM utilisateurs WHERE droit != 1';
$reponse = $bdd->query($q);
$nb_inscrits = $reponse->fetch();
$reponse->closeCursor();

$q='SELECT pseudo,email FROM utilisateurs';
$req = $bdd->query($q);
$users = $req->fetchAll(PDO::FETCH_ASSOC);



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



	<main>

		<div class="container-fluid">

			<div class="row">
				<h1>LISTE DES UTILISATEURS</h1>
				<div class="col-12">
					<div class=>
						
					</div>
					<table class="table table-hover">
				  <thead>
				    <tr>
				      <th scope="col">Pseudo</th>
				      <th scope="col">Email</th>
				    </tr>
				  </thead>
				  <tbody>
				  	<?php 

				  	foreach ($users as $user => $value) {
				  		echo '
				  			 <tr>
						      <th scope="row">' . $users[$user]['pseudo'] .'</th>
						      <td>' . $users[$user]['email'] .'</td>
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