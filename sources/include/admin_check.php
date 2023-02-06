<?php

$q='SELECT droit FROM utilisateurs WHERE email = "' . $email . '"';
$reponse = $bdd->query($q);
$result = $reponse->fetch();
$reponse->closeCursor();


if ($result['droit'] == 1){
	header('location:admin/admin_dashboard.php');
	exit;
}

?>