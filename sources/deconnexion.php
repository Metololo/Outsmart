<?php 

include('include/logs.php');

session_start();

$msg = 'L\'utilisateur ' . $_SESSION['email'] . ' s\'est déconnécté le ' . $date . ' a ' . $heure;

new_log('deconnexion.txt',$msg);
session_destroy();
header('location:connexion.php');
exit;
?>