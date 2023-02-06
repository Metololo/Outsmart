<?php session_start();
include('include/connexion_check.php');
include('include/db.php');
include('include/logs.php');

$id_msg = $_POST['id'];
$email = $_SESSION['email'];

$q='SELECT id FROM utilisateurs WHERE email = "' . $_SESSION['email'] . '"';
$reponse = $bdd->query($q);
$user_infos = $reponse->fetch();
$reponse->closeCursor();

$q='SELECT topic FROM message_forum WHERE id = ' . $id_msg;
$reponse = $bdd->query($q);
$topic = $reponse->fetch();
$reponse->closeCursor();

$q='DELETE FROM message_forum WHERE id = ' . $id_msg . ' AND auteur = ' . $user_infos['id'];
$bdd->exec($q);

$q='UPDATE topic SET nb_message = nb_message - 1 WHERE id = ' . $topic['topic'];
$bdd->exec($q);

header('location:topic.php?topic=' . $topic['topic']);
exit;

?>