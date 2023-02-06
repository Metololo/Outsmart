<?php 
 include('include/db.php');
 include('include/ban_check.php');

if(isset($_GET['cle']) && !empty($_GET['cle']) && isset($_GET['id']) && !empty($_GET['id'])){

	$q ='SELECT * FROM utilisateurs WHERE id = ? AND cle = ?';
	$req = $bdd->prepare($q);
	$req->execute([$_GET['id'],$_GET['cle']]);
	if($req->rowCount() > 0){
		$userInfo = $req->fetch();
		if($userInfo['verifie'] != 1){
			$q='UPDATE utilisateurs SET verifie = 1 WHERE id = ?';
			$req = $bdd->prepare($q);
			$req ->execute([
				$_GET['id']
			]);

			session_start();
			$_SESSION['email'] = $userInfo['email'];
			header('location:index.php?validateMSG=Inscription terminé ! Bienvenue : ' . $userInfo['pseudo']);
            exit;
		}else{
			echo 'Le compte a déja été vérifié.';
		}
	}else{
		echo "ERREUR : cle ou identifiant incorrect.";
	}

}else{
	echo 'AUCUN UTILISATEUR TROUVE';
}

?>