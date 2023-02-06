<?php 
session_start();
include('include/connexion_check.php');
include('include/db.php');
include('include/ban_check.php');
include('include/cookie_print.php');
include('include/print_error.php');
include('include/global_error.php');
include('include/logs.php');


$title = 'Boutique';

$msg = 'L\'utilisateur ' . $_SESSION['email'] . ' a visité la page ' . $title . ' le ' . $date . ' a ' . $heure;
new_log('visite_page.txt',$msg);


$email = $_SESSION['email'];
include('include/admin_check.php');




$q='SELECT id,pseudo,email,description,image,quizz_point FROM utilisateurs WHERE email=?';
$req = $bdd->prepare($q);
$req->execute([$email]);
$user_infos = $req->fetch(PDO::FETCH_ASSOC);

include('include/in_game_check.php');


if(isset($_POST['cacher_cher'])){
	$cacher_cher = ' AND prix <' . $user_infos['quizz_point'];
}else{
	$cacher_cher = '';
}

if(isset($_POST['cacher_posseder'])){
	$cacher_posseder=' AND id NOT IN (SELECT id_skin from collection,utilisateurs WHERE id_utilisateur = id)';
}else{
	$cacher_posseder='';
}


if(isset($_POST['option']) && !empty($_POST['option'])){
	if($_POST['option'] == 'nom'){
	$q ='SELECT id,nom,type,image,prix,rarete FROM skins WHERE prix IS NOT NULL AND rarete IS NOT NULL ' . $cacher_cher . $cacher_posseder . '  ORDER BY nom';
	}else if($_POST['option'] == 'rarete_dsc'){
	$q ="SELECT id,nom,type,image,prix,rarete FROM skins WHERE prix IS NOT NULL AND rarete IS NOT NULL " . $cacher_cher . $cacher_posseder ."  ORDER BY case when rarete= 'l' then 0 when rarete = 'e' then 1 when rarete= 'r' then 2 end;";
	}else if($_POST['option'] == 'rarete_asc'){
	$q ="SELECT id,nom,type,image,prix,rarete FROM skins WHERE prix IS NOT NULL AND rarete IS NOT NULL " . $cacher_cher . $cacher_posseder ."  ORDER BY case when rarete= 'r' then 0 when rarete = 'e' then 1 when rarete= 'l' then 2 end;";
	}
	else if($_POST['option'] == 'prix_asc'){
	$q ="SELECT id,nom,type,image,prix,rarete FROM skins WHERE prix IS NOT NULL AND rarete IS NOT NULL " . $cacher_cher . $cacher_posseder ."  ORDER BY prix asc";
	}else if($_POST['option'] == 'prix_dsc'){
	$q ="SELECT id,nom,type,image,prix,rarete FROM skins WHERE prix IS NOT NULL AND rarete IS NOT NULL " . $cacher_cher . $cacher_posseder . "  ORDER BY prix desc";
	}
}else{
	$q = 'SELECT id,nom,type,image,prix,rarete FROM skins WHERE prix IS NOT NULL AND rarete IS NOT NULL ' . $cacher_cher . $cacher_posseder ;
	}
$reponse=$bdd->query($q);
$skin_infos = $reponse->fetchAll(PDO::FETCH_ASSOC);
$reponse->closeCursor();

?>

<!DOCTYPE html>
<html>
	<?php include ('include/head.php'); ?>
	<body>

		<?php include('include/header.php'); ?>

		<main>

			<h1 class="main-title">BOUTIQUE</h1>


			<div class="container-fluid" id="shop-head">
				<div class="row">
					<div class="col-6 col-md-3">
						<form id="shop-form"  action="" method="post">
						  <div class="form-group">
							    <label for="Trie Boutique">Trier par : </label>
							    <select name="option" class="form-control">
							      <option value="">------</option>
							      <option value="nom">Nom</option>
							      <option value="rarete_dsc">Rareté (décroissant)</option>
							      <option value="rarete_asc">Rareté (croissant)</option>
							      <option value="prix_dsc">Prix (decroissant)</option>
							      <option value="prix_asc">Prix (croissant)</option>
							    </select>
						  </div>

						   <div class="form-check">
						    	<input type="checkbox" class="form-check-input" name="cacher_posseder" value="1" <?php 

						    	if(isset($_POST['cacher_posseder']))
									echo 'checked';
						    ?>>
						    	<label class="form-check-label" >Cacher les skins déja possèder</label>
						  	</div>
						  	<div class="form-check">
						    	<input type="checkbox" class="form-check-input" name="cacher_cher" value="1" <?php 

						    	if(isset($_POST['cacher_cher']))
									echo 'checked';
						    ?>>
						    	<label class="form-check-label" >Cacher les skins trop cher</label>
						  	</div>

						  <button type="submit" class="btn btn-primary mb-2 mt-2">Appliquer</button>
						</form>

						<div id="sold">
								<img id="coin" src="images/coin.png" alt="COIN">
								<p class="blue-p"><?= $user_infos['quizz_point']; ?></p>
						</div>
					</div>
				</div>

			</div>
			<?php 
				if(isset($_GET['achatMSG']) && !empty($_GET['achatMSG']))
					super_error('achatMSG','Achat Impossible !');
				if(isset($_GET['achatReussis']) && !empty($_GET['achatReussis']))
					super_sucess('achatReussis','C\'est fait !');
	        
			?>
			

			<div class="container-fluid">
				<div class="row">

					<?php 

					if (count($skin_infos) == 0){
						echo '<div class="alert alert-info" role="alert">
	  							Aucun résultat trouvé
								</div>';
					}else{

						foreach ($skin_infos as $key => $info) {
							echo'
								<div class="col col-md-3 skin-container ' . $skin_infos[$key]['rarete']  .'">
									<p class="skin-name">' . $skin_infos[$key]['nom'] .'</p>

									<div class="avatar-container">
										<img id="rectangle-transparent" src="images/rectangle.png">
										<img class="skin-img" src="uploads/avatar_custom/visage/head_5.png">
										<img class="skin-img" src="uploads/avatar_custom/'. $skin_infos[$key]['type'] .'/' . $skin_infos[$key]['image'] .'.png">	
									</div>			
									<p>'. $skin_infos[$key]['type'] .' : ';

								if($skin_infos[$key]['rarete'] == 'r'){
									echo 'Rare</p>';
								}else if($skin_infos[$key]['rarete'] == 'l'){
									echo 'legendaire</p>';
								}else{
									echo 'epique</p>';
								}

								$reponse=$bdd->query('SELECT id_utilisateur FROM collection WHERE id_utilisateur =' . $user_infos['id'] . ' AND id_skin = ' . $skin_infos[$key]['id']);
								$result = $reponse->fetchAll(PDO::FETCH_ASSOC);
								$reponse->closeCursor();


								if(count($result) != 0){
							            echo '
									    	<div class="buy-btn possede">
												<p> 🥶 Possédé 🔥</p>
											</div>';
							        }else if($user_infos['quizz_point'] >= $skin_infos[$key]['prix']){
										echo '<form action="achat_skin.php" method="post">
										    	<button type="submit" name="skin" value="' . $skin_infos[$key]['id'] .'" class="buy-btn">
													<img src="images/coin.png" alt="coin">
													<p>' . $skin_infos[$key]['prix'] .'</p>
													<img src="images/shopping-cart.svg" alt="shop">
												</button>
										</form>';
									}else{
										echo '
										    	<div class="buy-btn poor">
													<img src="images/coin.png" alt="coin">
													<p>' . $skin_infos[$key]['prix'] .'</p>
													<img src="images/lock_red.svg" alt="shop">
												</div>';
									}


								

							echo '</div>';
							
						}
				}

					?>


				</div>
			</div>


	  



		<?php include('include/footer.php'); 
			  include('include/header_js.php');
		?>



		</body>
</html>