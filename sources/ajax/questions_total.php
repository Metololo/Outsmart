<?php 
include('../include/db.php');

$q='SELECT COUNT(question.id) AS total,theme.numero AS theme FROM question,theme WHERE theme.numero = question.theme GROUP BY question.theme';
$req = $bdd->query($q);
$nb_questions = $req->fetchAll(PDO::FETCH_ASSOC);


echo json_encode($nb_questions);

?>