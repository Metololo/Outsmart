<?php session_start();
include('../include/db.php');
include('../include/connexion_check.php');


$email = $_SESSION['email'];

$q='SELECT id,pseudo,image FROM utilisateurs WHERE email= ?';
$reponse = $bdd->prepare($q);
$reponse->execute([$email]);
$user_infos = $reponse->fetch(PDO::FETCH_ASSOC);
$reponse->closeCursor();

if(isset($_GET['code']) && !empty($_GET['code'])){
	$code = $_GET['code'];
}else{
	exit;
} 
$q='SELECT session.id AS id,nb_joueurs,partie.id AS partie,tmp_reponse FROM session,partie WHERE partie.session = session.id AND code = ?';
$req = $bdd->prepare($q);
$req->execute([$code]);
$session = $req->fetch(PDO::FETCH_ASSOC);

$q='SELECT COUNT(partie) AS nb FROM joue_partie WHERE partie = ' .$session['partie']. ' AND finis = 1';
$req = $bdd->query($q);
$finis = $req->fetch(PDO::FETCH_ASSOC);



$q='SELECT COUNT(partie) AS nb FROM joue_partie WHERE partie = ' .$session['partie']. ' AND a_gagne = 1';
$req = $bdd->query($q);
$a_gagne = $req->fetch(PDO::FETCH_ASSOC);



if($finis['nb'] == $session['nb_joueurs']){



		$q=' SELECT COUNT(joueur) AS nb FROM joue_partie WHERE partie='.$session['partie'].' AND score = (SELECT max(score) FROM joue_partie WHERE partie = '.$session['partie'].')';
		$req=$bdd->query($q);
		$egalites = $req->fetch(PDO::FETCH_ASSOC);
		$egalite = $egalites['nb'];

		$q='SELECT score,pseudo,image,utilisateurs.id AS id FROM joue_partie,utilisateurs WHERE joueur = utilisateurs.id AND partie = '.$session['partie'].' ORDER BY score desc';
		$req = $bdd->query($q);
		$scores = $req->fetchAll(PDO::FETCH_ASSOC);

		if($a_gagne['nb'] == 0){
			$q='UPDATE utilisateurs SET quizz_point = quizz_point + ? WHERE id = ?';
			$req = $bdd->prepare($q);
		}

		

		$i = 1;
		foreach($scores as $score){

			if($a_gagne['nb'] == 0){
				if($egalite > 0){
					$q='UPDATE joue_partie SET a_gagne = 1 WHERE partie = '.$session['partie'].' AND joueur = '.$score['id'];
					$bdd->exec($q);

					if($score['score'] > 6){
						$quizz_point = $session['nb_joueurs'] * 10;
					}else{
						$quizz_point = 0;
					}

					
					$req->execute([$quizz_point,$score['id']]);
					$egalite--;
				}else{

					if($i === 1){
						$q='UPDATE joue_partie SET a_gagne = 1 WHERE partie = '.$session['partie'].' AND joueur = '.$score['id'];
						$bdd->exec($q);
					}
					if($score['score'] > 6){
						$quizz_point = round(($session['nb_joueurs'] *10)/$i);
					}else{
						$quizz_point = 0;
					}
					
					$req->execute([$quizz_point,$score['id']]);
				}
		}else{
			if($egalite > 0){

					if($score['score'] > 6){
						$quizz_point = $session['nb_joueurs'] * 10;
					}else{
						$quizz_point = 0;
					}
			
					
					$egalite--;
				}else{

					if($score['score'] > 6){
						$quizz_point = round(($session['nb_joueurs'] *10)/$i);
					}else{
						$quizz_point = 0;
					}
				}

		}


			

			// AFFICHAGE
			if($i === 1){
				echo '


				<div id="winner">
					<img src="uploads/avatars/'.$score['image'].'">
					<h3>🥇 1.  '.$score['pseudo'].'</h3>
					<h3>👉 +'.$quizz_point.' QP  |  '.$score['score'].' pts 👈</h3>
				</div>

				';
			}else if($i === 2){
				echo'
				<div class="other-score" id="top-2">
					<h3>🥈 2. '.$score['pseudo'].'</h3>
					<h3>+'.$quizz_point.' QP | '.$score['score'].' pts</h3>
				</div>';
			}else if($i === 3){
				echo'
				<div class="other-score" id="top-3">
					<h3>🥉 3. '.$score['pseudo'].'</h3>
					<h3>+'.$quizz_point.' QP | '.$score['score'].' pts</h3>
				</div>';
			}else{
				echo'

				<div class="other-score">
					<h3><span class="leaderboard-space">🏅 </span>4. '.$score['pseudo'].'</h3>
					<h3>+'.$quizz_point.' QP | '.$score['score'].' pts</h3>
				</div>
				';
			}

			$i++;

		} 
	
}else{
	echo'<div id="no-border">					
			<h3>EN ATTENTE DES AUTRES JOUEURS ...</h3>
		</div>

		<img src="images/homer.gif">';
}

?>