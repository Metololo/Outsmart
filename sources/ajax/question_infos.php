<?php session_start();
include('../include/db.php');
include('../include/connexion_check.php');


$email = $_SESSION['email'];

$q='SELECT id,pseudo,image FROM utilisateurs WHERE email= ?';
$reponse = $bdd->prepare($q);

$reponse->execute([$email]);
$user_infos = $reponse->fetch(PDO::FETCH_ASSOC);
$reponse->closeCursor();

if(isset($_GET['partie'])){
	$partie = $_GET['partie'];

	$q='SELECT question.question AS question,question.id AS id,b_rep,rep2,rep3,rep4,ordre,debut,partie_q.partie AS partie FROM partie_q,question WHERE partie_q.question = question.id AND statut = 0 AND partie = '.$partie.' ORDER BY ordre asc LIMIT 1';

	$req = $bdd->query($q);
	$question_infos = $req->fetch(PDO::FETCH_ASSOC);


	echo json_encode($question_infos);
}





?>