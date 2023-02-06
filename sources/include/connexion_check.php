<?php 

if(!isset($_SESSION['email'])){
		header('location:connexion.php');
		exit;
	}

?>