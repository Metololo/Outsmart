<?php session_start();

	$email = $_SESSION['email'];

	include('../include/connexion_check.php');
	include('../include/db.php');

	$q='SELECT pseudo,image,id FROM utilisateurs WHERE email= ?';
	$reponse = $bdd->prepare($q);
	$reponse->execute([$email]);
	$user_infos = $reponse->fetch(PDO::FETCH_ASSOC);
	$reponse->closeCursor();

	$q='SELECT pseudo,image,description,id FROM utilisateurs WHERE id IN (SELECT ami1 FROM est_ami WHERE ami2 = '. $user_infos['id'] .' AND bloque != 1) OR id IN (SELECT ami2 FROM est_ami WHERE ami1 = '. $user_infos['id'] .' AND bloque != 1)';

	$reponse = $bdd->query($q);
	$amis = $reponse->fetchAll();
	$reponse->closeCursor();

	$q='SELECT COUNT(id_envoie) AS vue,id_envoie FROM envoie_message WHERE id_recoit="'. $user_infos['id'] .'" AND vue=0 GROUP BY id_envoie';
	$reponse = $bdd->query($q);
	$vues = $reponse->fetchAll();
	$reponse->closeCursor();

	foreach ($amis as $ami => $value) {
		echo'

		<div class="friend-div">
			<div>
				<img class="friend-profile" src="uploads/avatars/'. $amis[$ami]['image'] .'">
			</div>
			<div class="friend-text-contain">
				<div class="friend-text">
					<div>
						<h3>'. $amis[$ami]['pseudo'] .'</h3>
						<p class="friend-stats">43 victoires</p>
					</div>
					<div class="icon-friend">
						<a href="">
							<div class="chat-friend">
								<a href="chat.php?friend='. $amis[$ami]['id'] .'"><img src="images/chat.png" class="go-chat"></a>
								<p class="notif">

								';

								if(count($vues) == 0){
									echo'😴';
								}else{
										foreach ($vues as $vu => $value) {
											if($vues[$vu]['id_envoie'] == $amis[$ami]['id'] ){
												if($vues[$vu]['vue'] > 9){
													echo '<span style="font-size:11px;">9+</span>';
												}else{
													echo $vues[$vu]['vue'];
												}
											}
										}
									}



								echo '

								</p>
							</div>
						</a>';

						$deleteid = "delete" . $amis[$ami]['id'];

						echo'	
						
						<div onclick="show(\''.$amis[$ami]['id'].'\')" class="friend-action">
							<img class="more-option" src="images/more.png">
							<div class="super-options" id="op-'.$amis[$ami]['id'].'">
								<div class="delete" data-bs-toggle="modal" data-bs-target="#supprimer" id="delete'. $amis[$ami]['id'] .'"  onclick="delete_friend(\'' . $deleteid . '\',\'' . $amis[$ami]['pseudo'] . '\')">
									<img src="images/delete.svg">
									<p>Supprimer</p>
								</div>
								<div class="block">
									<img src="images/lock_black.svg">
									<p>Bloquer</p>
								</div>
							</div>
						</div>
					</div>		
				</div>
				<div>
					<p class="friend-desc">'. $amis[$ami]['description'] .'</p>
				</div>
			</div>								
		</div>

		';
	}
	

?>