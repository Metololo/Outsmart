<?php session_start();

	include('include/connexion_check.php');
	include('include/db.php');
	include('include/ban_check.php');
	include('include/msg_error.php');

	$email = $_SESSION['email'];
	
	var_dump($_POST);

?>