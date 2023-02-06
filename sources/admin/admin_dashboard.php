<?php session_start(); 

$title='Administration'; 
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


	<main>

		<div class="container-fluid">
			<div class="row">
				<div class="col-12 col-sm-6 col-lg-3 admin-stat">
					<div>
						<img src="../uploads/avatars/<?= $admin_infos['image']?>">
						<div id="admin-name">
							<div id="admin-logo">
								<img src="images/sword.png">
								<h3>Administrateur</h3>
							</div>
							<h3><?= $admin_infos['pseudo'] ?></h3>
						</div>
					</div>
				</div>
				<div class="col-12 col-sm-6 col-lg-3 admin-stat">
					<div>
						<img src="images/database.svg">
						<div class="text-admin">
							<h2><?= $nb_inscrits['COUNT(id)'] ?></h2>
							<p>Inscrits</p>
						</div>
					</div>
				</div>
				<div class="col-12 col-sm-6 col-lg-3 admin-stat">
					<div>
						<img src="images/slack.svg">
						<div class="text-admin">
							<h2><?= $sessions ?></h2>
							<p>Parties jouées</p>
						</div>
					</div>
				</div>
				<div class="col-12 col-sm-6 col-lg-3 admin-stat">
					<div>
						<img src="images/users.svg">
						<div class="text-admin">
							<h2>32</h2>
							<p>Utilisateurs connéctés</p>
						</div>
					</div>
				</div>
			</div>

			<div class="row admin-dashboard-section">
				<?php 
				if(isset($_GET['yes'])){
					super_sucess('yes','🤭🤭🤭🤭');
				}

				$q='SELECT id,pseudo,email,quizz_point FROM utilisateurs WHERE droit = 0 ORDER BY id desc LIMIT 15';
				$reponse = $bdd->query($q);
				$recent_users = $reponse->fetchAll();
				$reponse->closeCursor();

				?> 
				<div class="col-12 admin-table">
					<div class="admin-dashboard-title">
						<h1>Utilisateurs récents</h1>
						<a href="utilisateurs.php">
							<div class="see-more">
								<p>Voir plus</p>
								<img src="images/plus.svg">
							</div>
						</a>
					</div>
					<table class="table table-hover">
				  <thead>
				    <tr>
				      <th scope="col">#</th>
				      <th scope="col">Pseudo</th>
				      <th scope="col">Email</th>
				      <th scope="col">Quizz_Point</th>
				      <th scope="col">Action</th>
				    </tr>
				  </thead>
				  <tbody>
				  	<?php 

				  	foreach ($recent_users as $user => $value) {
				  		echo '
				  			 <tr>
						      <th scope="row">' . $recent_users[$user]['id'] .'</th>
						      <td>' . $recent_users[$user]['pseudo'] .'</td>
						      <td>' . $recent_users[$user]['email'] .'</td>
						      <td>' . $recent_users[$user]['quizz_point'] .'</td>
						      <td>
						      	<div>
						      		

						      		<form method="post" action="ban.php">
						      			<button type="submit" name="pseudo" class="btn btn-danger"  value="' . $recent_users[$user]['pseudo'] .'">Bannir</button>
						      		<form>
						      	</div>
						      </td>
						    </tr>
				  		';
				  	}
				  	?>

				  </tbody>
				</table>	
				</div>

				<div class="col-12 admin-table">
					<div class="admin-dashboard-title">
						<h1>Topics réçents</h1>
						<a href="">
							<div class="see-more">
								<p>Voir plus</p>
								<img src="images/plus.svg">
							</div>
						</a>
					</div>
					<table class="table table-hover">
				  <thead>
				    <tr>
				      <th scope="col">#</th>
				      <th scope="col">Nom</th>
				      <th scope="col">Date de création</th>
				      <th scope="col">Créateur</th>
				      <th scope="col">Actions</th>
				    </tr>
				  </thead>
				  <tbody>
				    <tr>
				      <th scope="row">1</th>
				      <td>Quel est la réponse ?</td>
				      <td>24-32-1932</td>
				      <td>SuperBOSS32</td>
				      <td>
				      	<div>
				      		<button type="button" class="btn btn-primary">Plus</button>
				      		<button type="button" class="btn btn-danger">Bannir</button>
				      	</div>
				      </td>
				    </tr>
				    <tr>
				      <th scope="row">2</th>
				      <td>Shakira Ou Beyonce ?</td>
				      <td>24-32-1930</td>
				      <td>ShakiraFan43</td>
				      <td>
				      	<div>
				      		<button type="button" class="btn btn-primary">Plus</button>
				      		<button type="button" class="btn btn-danger">Bannir</button>
				      	</div>
				      </td>
				    </tr>
				     <tr>
				      <th scope="row">2</th>
				      <td>AIDEZ MOI</td>
				      <td>24-32-1940</td>
				      <td>Johnnyyyy</td>
				      <td>
				      	<div>
				      		<button type="button" class="btn btn-primary">Plus</button>
				      		<button type="button" class="btn btn-danger">Bannir</button>
				      	</div>
				      </td>
				    </tr>
				  </tbody>
				</table>	
				</div>
				
			</div>
		

		</div>
	</main>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>
</html>