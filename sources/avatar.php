<?php 
session_start();
include('include/connexion_check.php');
include('include/db.php');
include('include/ban_check.php');
include('include/cookie_print.php');
include('include/print_error.php');
include('include/logs.php');

$email = $_SESSION['email'];

include('include/admin_check.php');

$title = 'Avatar';

$msg = 'L\'utilisateur ' . $_SESSION['email'] . ' a visité la page ' . $title . ' le ' . $date . ' a ' . $heure;
new_log('visite_page.txt',$msg);

$q='SELECT pseudo,id FROM utilisateurs WHERE email=?';
$req = $bdd->prepare($q);
$req->execute([$email]);
$user_infos = $req->fetch(PDO:: FETCH_ASSOC);

include('include/in_game_check.php');

$q='SELECT COUNT(id_skin) FROM collection,skins WHERE id_skin = id AND id_utilisateur = ' . $user_infos['id'] .' AND (type="visage" OR type="sourcil" OR type="fond")';
$reponse = $bdd->query($q);
$result = $reponse->fetch(PDO:: FETCH_ASSOC);
$reponse->closeCursor();

if ($result['COUNT(id_skin)'] == 0){
	$q='INSERT INTO collection(id_skin,id_utilisateur,actif) VALUES ((SELECT id FROM skins WHERE image="head_1"),' .$user_infos['id'] . ',1);
INSERT INTO collection(id_skin,id_utilisateur,actif) VALUES ((SELECT id FROM skins WHERE image="fond_bleu"),' .$user_infos['id'] . ',1);
INSERT INTO collection(id_skin,id_utilisateur,actif) VALUES ((SELECT id FROM skins WHERE image="yeux_1"),' .$user_infos['id'] . ',1);
INSERT INTO collection(id_skin,id_utilisateur,actif) VALUES ((SELECT id FROM skins WHERE image="bouche_1"),' .$user_infos['id'] . ',1)';
$reponse=$bdd->query($q);
$reponse->closeCursor();
}

$types = 		['Visages' => 'visage',
				'Couleurs de fond' => 'fond',
				'Pilosité' => 'barbe',
				'Bouches' => 'bouche',
				'Yeux' => 'yeux',
				'Sourcils' => 'sourcil',
				'Lunettes' => 'lunette',
				'Cheveux' => 'cheveux',
				'Cosmétiques' => 'cosmetique'];


if(isset($_POST['skin_type']) && !empty($_POST['skin_type'])){
	$type = $types[$_POST['skin_type']];

}else{
	$type = $types['Couleurs de fond'];
}

$q='SELECT ordre,image,type FROM skins,collection WHERE id_skin = id AND actif = 1 AND id_utilisateur = ' . $user_infos['id'] ;
$reponse = $bdd->query($q);
$skins_actifs = $reponse->fetchAll(PDO::FETCH_ASSOC);
$reponse->closeCursor();

$q='SELECT COUNT(id_skin) FROM collection,skins WHERE id_skin = id AND type = "cosmetique" AND image != "patty" AND actif=1 AND id_utilisateur = ' . $user_infos['id'];
$reponse=$bdd->query($q);
$cosmetique=$reponse->fetch(PDO::FETCH_ASSOC);
$reponse->closeCursor();



?>


<!DOCTYPE html>
<html>
<head>
	<?php include('include/head.php'); ?>
</head>
<body>

	<?php include('include/header.php'); ?>


	<main id="avatar-main">

		<h1 class="main-title">AVATAR</h1>

		<div class="container">
			<div class="row justify-content-center">
				<div class="col-10 col-sm-6 col-lg-4" id="avatar_custom" class="avatar-container">
						
				<?php
				echo '<img id="rectangles-kin" src="images/rectangle.png">';


				foreach ($skins_actifs as $image => $value) {
					if ($skins_actifs[$image]['type'] != 'cheveux'){
			 			echo '<img class="skin-img" src="uploads/avatar_custom/' . $skins_actifs[$image]['type'] . '/' . $skins_actifs[$image]['image'] . '.png" style="z-index : ' . $skins_actifs[$image]['ordre'] .'">';
				 	}else if($cosmetique['COUNT(id_skin)'] == 0){
				 		echo '<img class="skin-img" src="uploads/avatar_custom/' . $skins_actifs[$image]['type'] . '/' . $skins_actifs[$image]['image'] .'.png" style="z-index : ' . $skins_actifs[$image]['ordre'] .'">';
		 			} 
				}



				?>

				</div>
			</div>
		</div>

		<div>
			<h3 class="h3-blue center-title">SuperBoss</h3>
		</div>

		<form action="" method="post">
		  <div class="form-row">
		    <div class="col-3" id="skin-type-select">
		      <select class="custom-select" name="skin_type">
			      <option value="Couleurs de fond">Couleurs de fond</option>
			      <option value="Visages">Visages</option>
			      <option value="Bouches">Bouches</option>
			      <option value="Yeux">Yeux</option>
			      <option value="Sourcils">Sourcils</option>
			      <option value="Cheveux">Cheveux</option>
			      <option value="Pilosité">Pilosité</option>
			      <option value="Lunettes">Lunettes</option>
			      <option value="Cosmétiques">Cosmétiques</option>
			    </select>
		    </div>
		    <div class="col-3">
		      <button type="submit" class="btn btn-primary mb-2 mt-2">Appliquer</button>
		    </div>
		  </div>

			
		</form>

			<h3 class="h3-blue"><?php 
			if(isset($_POST['skin_type'])){
				echo $_POST['skin_type'];
			}else{
				echo 'Couleur de fond';
			}
		?><h3>


			<form action="modif_avatar.php" method="post" class="skin-choice-container">
				
			 <?php 

			 $q="SELECT type,image,ordre FROM skins WHERE type = '" . $type . "' AND (nom IS NULL OR id IN (SELECT id_skin FROM collection WHERE id_utilisateur = " . $user_infos['id'] ."));";
			 $reponse = $bdd->query($q);
			 $all_skins = $reponse->fetchAll(PDO::FETCH_ASSOC);
			 $reponse->closeCursor();

			 $q='SELECT image FROM skins,collection WHERE id_skin = id AND actif = 1 AND id_utilisateur = ' . $user_infos['id'] . ' AND type = "' . $type . '"';
			$reponse = $bdd->query($q);
			$skin_selected = $reponse->fetch(PDO::FETCH_ASSOC);
			$reponse->closeCursor();



			 if($type != 'fond' AND $type != 'visage' AND $type != 'bouche' AND $type != 'yeux' ){
			 	echo '<div class="skin-choice">
			 			<button type=submit class="avatar-container" name="none" value="' . $type . '">
			 				<img src="images/none_selected.png">
			 			</button>
		 			</div>';
			}

			 foreach ($all_skins as $skin => $value) {
			 	echo '<div class="skin-choice">
			 			<button type=submit class="avatar-container ';
			 			if ($skin_selected){
			 				if ($all_skins[$skin]['image'] == $skin_selected['image'] && isset($skin_selected))
			 				echo ' selected-skin';
			 			}


		 			echo '" name="skin" value="' . $all_skins[$skin]['image'] .'">
			 					<img src="images/rectangle.png">
								<img class="skin-img" src="uploads/avatar_custom/' . $all_skins[$skin]['type']  .'/' . $all_skins[$skin]['image'] .'.png"  style="z-index: ' . $all_skins[$skin]['ordre'] .';">';
								if($skin_selected){
									if ($all_skins[$skin]['image'] == $skin_selected['image'])
									echo '<img class="skin-img" src="images/selected.png" style="z-index: 10;">';
								}
								
								if ($all_skins[$skin]['image'] == 'cheveux_13'){
									echo '<img class="skin-img" src="uploads/avatar_custom/head/head_1.png" style="z-index: 2;">';
								}else{
									echo '<img class="skin-img" src="uploads/avatar_custom/head/head_1.png" style="z-index: 1;">';
								}

				echo '				
			 			</button>
					</div>';
			 	}

			 ?>
			    
			 </form>

			

		
		
				
		
	</main>

	<?php

	     include('include/footer.php'); 
		  include('include/header_js.php');
	?>



</body>
</html>