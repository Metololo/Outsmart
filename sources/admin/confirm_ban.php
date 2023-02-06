<?php 

include('../include/db.php');


if(isset($_POST['pseudo']) && !empty($_POST['pseudo'])){
	$q='UPDATE utilisateurs SET bannis = 1 WHERE pseudo = "' . $_POST['pseudo'] . '"';
	$bdd->exec($q);
}
 
header('location:admin_dashboard.php?yes=Utilisateur ' . $_POST['pseudo'] . ' bannis !');
exit;

?>