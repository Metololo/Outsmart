<?php session_start();

include('../include/db.php');
include('../include/connexion_check.php');


$email = $_SESSION['email'];

$q='SELECT id,pseudo,image FROM utilisateurs WHERE email= ?';
$reponse = $bdd->prepare($q);
$reponse->execute([$email]);
$user_infos = $reponse->fetch(PDO::FETCH_ASSOC);
$reponse->closeCursor();

if(isset($_POST['code']) && !empty($_POST['code'])){
	$code = $_POST['code'];

	$q='SELECT partie.id AS partie FROM session,partie WHERE partie.session = session.id AND code = ?';
	$req = $bdd->prepare($q);
	$req->execute([$code]);
	$session = $req->fetch(PDO::FETCH_ASSOC);

	$q='UPDATE joue_partie SET finis = 1 WHERE partie = ' .$session['partie'];
	$bdd->exec($q);

}else{
	exit;
}






?>