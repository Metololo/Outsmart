<?php 

$sessions='SELECT id FROM session WHERE date_creation < (NOW() - INTERVAL 30 MINUTE)';

$parties='SELECT id FROM partie WHERE session IN ('.$sessions.')';

$q='DELETE FROM contient_theme WHERE session IN ('.$sessions.')';
$bdd->exec($q);

$q='DELETE FROM rejoin_session WHERE session IN ('.$sessions.')';
$bdd->exec($q);

$q='DELETE FROM partie_q WHERE partie IN ('.$parties.')';
$bdd->exec($q);

$q='DELETE FROM joue_partie WHERE partie IN ('.$parties.') AND finis = 0';
$req = $bdd->exec($q);

if($req){
	$q='DELETE FROM partie WHERE session IN ('.$sessions.') AND statut = 1';
	$bdd->exec($q);

	$q='DELETE FROM session WHERE date_creation < (NOW() - INTERVAL 30 MINUTE)';
	$bdd->exec($q);
}






?>