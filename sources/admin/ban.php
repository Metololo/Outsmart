<?php session_start(); 

$title='Bannissement'; 
$email = $_SESSION['email'];

include('../include/db.php');

include('../include/connexion_check.php');
include('../include/no_admin.php');

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
<body id="ban-body">

	<main>
		<div class="container-fluid">
			<div class="row justify-content-center align-items-center" id="ban-container">
				<div class="col-12 col-sm-8 col-md-6 col-lg-4" id="ban-msg">
					<h2 id="ban-title">Bannir <?= $_POST['pseudo']?> ?</h2>
					<div id="btn-ban">
						<form method="post" action="confirm_ban.php">
							<button type="submit" class="btn btn-danger" name="pseudo" value="<?= $_POST['pseudo']; ?>">😂BANNIR🤣</button>
						</form>
						<a href="admin_dashboard.php">
							<button type="button" class="btn btn-secondary">🥰Annuler😍</button>
						</a>
					</div>
				</div>
			</div>
		</div>
	</main>

</body>
</html>