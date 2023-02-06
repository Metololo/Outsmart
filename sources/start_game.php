<?php session_start();

include('include/connexion_check.php');
include('include/db.php');

$email = $_SESSION['email'];

$q='SELECT id FROM utilisateurs WHERE email = "' . $_SESSION['email'] . '"';
	$reponse = $bdd->query($q);
	$user_infos = $reponse->fetch();
	$reponse->closeCursor();


if(!isset($_POST['session']) && empty($_POST['session'])){
	header('location:index.php?error=ERREUR, revenez dans la session');
	exit;
}


$q='SELECT COUNT(id) as nb FROM session WHERE id = ?';
$req = $bdd->prepare($q);
$req->execute([$_POST['session']]);
$result = $req->fetch(PDO::FETCH_ASSOC);
if($result['nb'] == 0){
	header('location:index.php?error=ERREUR, revenez dans la session');
	exit;
}

$q = 'SELECT * FROM session WHERE id = ' .  $_POST['session'];
$req = $bdd->prepare($q);
$req->execute([$user_infos['id']]);
$session = $req->fetch(PDO::FETCH_ASSOC);

//MODE BRAWL :

if($session['mode'] === 'brawl'){

	$q = 'INSERT INTO partie(session,statut) VALUES('.$session['id'].',0)';
	$bdd->exec($q);

	$q='SELECT id FROM partie WHERE session = ' .$session['id'];
	$req = $bdd->query($q);
	$partie = $req->fetch(PDO::FETCH_ASSOC);

	$q='SELECT id FROM utilisateurs WHERE id IN (SELECT joueur FROM rejoin_session WHERE session='.$session['id'].') OR id = (SELECT createur FROM session WHERE id = '.$session['id'].')';
	$req = $bdd->query($q);
	$players = $req->fetchAll(PDO::FETCH_ASSOC);


	$q='INSERT INTO joue_partie VALUES(?,'.$partie['id'].',0,0,0)';
	$req = $bdd->prepare($q);

	foreach($players as $player){
		$req->execute([$player['id']]);
	}

	$q='SELECT theme FROM contient_theme WHERE session = ' . $session['id'];
	$req = $bdd->query($q);
	$themes = $req->fetchAll(PDO::FETCH_ASSOC);
	var_dump($themes);
	$themes_select = ' AND (';

	$i = 0;
	foreach ($themes as $value) {
		if($i === 0){
			$themes_select = $themes_select . 'theme.numero = "' . $value['theme'];
			$i = 1;
		}else{
			$themes_select = $themes_select . '" OR theme.numero="' . $value['theme'];
		}
	}
	$themes_select = $themes_select . '")';



	$q='SELECT question.id AS rand_q FROM question,theme WHERE question.theme = theme.numero '.$themes_select.' ORDER BY RAND() LIMIT ' .$session['nb_questions'];
	$reponse = $bdd->query($q);
	$questions_random = $reponse->fetchAll(PDO::FETCH_ASSOC);

	$q='INSERT INTO partie_q VALUES('.$partie['id'].',?,0,?,?,0)';
	$req = $bdd->prepare($q);

	$i = 1;


	foreach($questions_random as $question){
		if($i === 1){
			$debut = round(microtime(true) * 1000);
            
            $req->execute([$question['rand_q'],$i,$debut]);
            $i++;		
		}else{
			$req->execute([$question['rand_q'],$i,'NULL']);
            $i++;	
		}	
	}

	$q='UPDATE session SET statut = 1 WHERE id =' .$session['id'];
	$bdd->exec($q);

	header('location:game.php?code=' . $session['code']);
	exit;

	

}

?>