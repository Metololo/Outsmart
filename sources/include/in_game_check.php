<?php 

$q='SELECT COUNT(id) AS nb FROM utilisateurs WHERE id = (SELECT joueur FROM rejoin_session WHERE joueur='.$user_infos['id'].') OR id=(SELECT createur FROM session WHERE createur ='.$user_infos['id'].' AND statut=0 OR statut=1 LIMIT 1)';
$req = $bdd->query($q);
$result = $req->fetch(PDO::FETCH_ASSOC);

if($result['nb'] > 0){
	$q='SELECT code FROM rejoin_session,session WHERE id = session AND joueur = '.$user_infos['id'].' OR createur='.$user_infos['id'].' GROUP BY session;
		';
$req = $bdd->query($q);
$result = $req->fetch(PDO::FETCH_ASSOC);

header('location:lobby.php?code='.$result['code']);
exit;
}


?>