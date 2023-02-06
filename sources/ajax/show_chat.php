<?php session_start();
include('../include/connexion_check.php');
include('../include/db.php');

if(isset($_GET['friend']) && !empty($_GET['friend'])){
	$friend = $_GET['friend'];


	$email = $_SESSION['email'];

	$q='SELECT id,pseudo,email,description,image FROM utilisateurs WHERE email=?';
		$req = $bdd->prepare($q);
		$req->execute([$email]);
		$user_infos = $req->fetch(PDO:: FETCH_ASSOC);



	$q='SELECT pseudo,image,id FROM utilisateurs WHERE id IN (SELECT ami1 FROM est_ami WHERE ami2 = '. $user_infos['id'] .' AND ami1 = '. $friend .') OR id IN (SELECT ami2 FROM est_ami WHERE ami1 = '. $user_infos['id'] .' AND ami2 = '. $friend .')';
	$reponse = $bdd->query($q);
	$ami = $reponse->fetch();
	$reponse->closeCursor();



	$q='SELECT id,date_envoie,contenue,id_envoie FROM envoie_message WHERE (id_envoie = ' . $ami['id'] . ' AND id_recoit = ' . $user_infos['id'] . ') OR (id_recoit = ' . $ami['id'] . ' AND id_envoie = ' . $user_infos['id'] . ')';
		$reponse = $bdd->query($q);
		$messages = $reponse->fetchAll();
		$reponse->closeCursor();

	$q='UPDATE envoie_message SET vue=1 WHERE id_envoie = ' . $ami['id'] . ' AND id_recoit = ' . $user_infos['id'];
	$bdd->exec($q);


	foreach ($messages as $msg => $value) {

		if($messages[$msg]['id_envoie'] == $ami['id']){
			echo'

			<div class="topic-answer">
				<div class="topic-answer-head">
					<div class="user-info-topic">
						<img src="uploads/avatars/' . $ami['image'] .'">
						<p class="topic-header-p"><strong class="topic-header-strong friend-chat">' . $ami['pseudo'] .'</strong> • ' . $messages[$msg]['date_envoie'] .' </p>
					</div>								
				</div>
				<p class="topic-message-p adapt" c>' . htmlspecialchars($messages[$msg]['contenue'])  .'</p>
			</div>


			';
		}else{
			echo'

			<div class="topic-answer">
				<div class="topic-answer-head">
					<div class="user-info-topic">
						<img src="uploads/avatars/' . $user_infos['image'] .'">
						<p class="topic-header-p"><strong class="topic-header-strong myself-chat">' . $user_infos['pseudo'] .'</strong> • ' . $messages[$msg]['date_envoie'] .' </p>
					</div>

					<div class="delete-message" onclick="delete_msg('. $messages[$msg]['id'] .')" data-bs-toggle="modal" data-bs-target="#delete_msg"><img src="images/trash.png"></div>
					
				</div>
				<p class="topic-message-p adapt" c>' . htmlspecialchars($messages[$msg]['contenue']) .'</p>
			</div>


			';
		}
	}

}


?>