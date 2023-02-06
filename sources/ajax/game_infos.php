<?php session_start();
include('../include/db.php');
include('../include/connexion_check.php');


$email = $_SESSION['email'];



$q='SELECT id,pseudo,image FROM utilisateurs WHERE email= ?';
$reponse = $bdd->prepare($q);
$reponse->execute([$email]);
$user_infos = $reponse->fetch(PDO::FETCH_ASSOC);
$reponse->closeCursor();

$q='SELECT session FROM joue_partie,partie WHERE joue_partie.partie = partie.id AND joueur = ? AND statut = 0';
$req = $bdd->prepare($q);
$req->execute([$user_infos['id']]);
$result = $req->fetch(PDO::FETCH_ASSOC);

$session_id = $result['session'];

$q='SELECT nb_questions,tmp_reponse,code,partie.id AS partie FROM session,partie WHERE session.id = partie.session AND session.id = ? ;
';
$req = $bdd->prepare($q);
$req->execute([$session_id]);
$session_infos = $req->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($session_infos);

?>