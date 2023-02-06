<?php 

include('../include/db.php');

$search = $_GET['search'];


if ($search != "") {
    $q = "SELECT nom,id FROM topic WHERE nom LIKE :topic";
    $req = $bdd->prepare($q);
    $req->execute([
        'topic' => '%' . $search . '%'

    ]);

    $result = $req->fetchALL();
    foreach ($result as $mamadou) {
        echo "<a href='topic.php?id_topic=" . $mamadou['id'] . "'>" . $mamadou['nom'] . "</a><br>";
    }
}

?>