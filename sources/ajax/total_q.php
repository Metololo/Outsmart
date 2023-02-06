<?php 
include('../include/db.php');

$q='SELECT COUNT(id) AS tt_q FROM question';
$req = $bdd->query($q);
$total_question = $req->fetch(PDO::FETCH_ASSOC);


echo json_encode($total_question);

?>