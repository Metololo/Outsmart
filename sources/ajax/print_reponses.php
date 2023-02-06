<?php session_start();
include('../include/db.php');
include('../include/connexion_check.php');


if(isset($_GET['question']) && !empty($_GET['question'])){
	$question = $_GET['question'];


	$q='SELECT type,audio,image FROM question WHERE id = ?';
	$req = $bdd->prepare($q);
	$req->execute([$question]);
	$reponse = $req->fetch(PDO::FETCH_ASSOC);
	
		if($reponse['type'] === 'i'){
			echo '
			<div class="quizz-container-img">
						<img class="q-image" src="images/quiz/'.$reponse['image'].'.png">		
					</div>

					<div class="reponse-contain">

							<div class="reponse-div i-type">
								<div class="reponse-q"  id="rep1" onclick="select_reponse(\'1\')">
									<h3 class="reponse-t" id="text-rep-1">loading...</h3>
									<img class="select-r-triangle-left select-r-1" src="images/select-left.png">
									<img class="select-r-triangle-right select-r-1" src="images/select-right.png">
								</div>
							</div>

							<div class="reponse-div i-type" >
								<div class="reponse-q"  id="rep2" onclick="select_reponse(\'2\')">
									<h3 class="reponse-t" id="text-rep-2">loading...</h3>
									<img class="select-r-triangle-left select-r-2" src="images/select-left.png">
									<img class="select-r-triangle-right select-r-2" src="images/select-right.png">
								</div>
							</div>

							<div class="reponse-div i-type">
								<div class="reponse-q"  id="rep3" onclick="select_reponse(\'3\')">
									<h3 class="reponse-t" id="text-rep-3">loading...</h3>
									<img class="select-r-triangle-left select-r-3" src="images/select-left.png">
									<img class="select-r-triangle-right select-r-3" src="images/select-right.png">
								</div>
							</div>

							<div class="reponse-div i-type">
								<div class="reponse-q"  id="rep4" onclick="select_reponse(\'4\')">
									<h3 class="reponse-t" id="text-rep-4">loading...</h3>
									<img class="select-r-triangle-left select-r-4" src="images/select-left.png">
									<img class="select-r-triangle-right select-r-4" src="images/select-right.png">
								</div>
							</div>


					</div>
		';
		}else{
			if($reponse['type'] === 'a'){
				echo '<audio controls autoplay>
					  <source src="audio/'.$reponse['audio'].'.mp3" type="audio/ogg">
					  Your browser does not support the audio element.
					</audio>';
			}
			


					echo'<div class="reponse-contain">

							<div class="reponse-div q-classic">
								<div class="reponse-q" id="rep1" onclick="select_reponse(\'1\')">
									<h3 class="reponse-t" id="text-rep-1">loading...</h3>
									<img class="select-r-triangle-left select-r-1" src="images/select-left.png">
									<img class="select-r-triangle-right select-r-1" src="images/select-right.png">
								</div>
							</div>

							<div class="reponse-div q-classic">
								<div class="reponse-q"  id="rep2" onclick="select_reponse(\'2\')">
									<h3 class="reponse-t" id="text-rep-2">loading...</h3>
									<img class="select-r-triangle-left select-r-2" src="images/select-left.png">
									<img class="select-r-triangle-right select-r-2" src="images/select-right.png">
								</div>
							</div>

							<div class="reponse-div q-classic">
								<div class="reponse-q"  id="rep3" onclick="select_reponse(\'3\')">
									<h3 class="reponse-t" id="text-rep-3">loading...</h3>
									<img class="select-r-triangle-left select-r-3" src="images/select-left.png">
									<img class="select-r-triangle-right select-r-3" src="images/select-right.png">
								</div>
							</div>

							<div class="reponse-div q-classic">
								<div class="reponse-q"  id="rep4" onclick="select_reponse(\'4\')">
									<h3 class="reponse-t" id="text-rep-4">loading...</h3>
									<img class="select-r-triangle-left select-r-4" src="images/select-left.png">
									<img class="select-r-triangle-right select-r-4" src="images/select-right.png">
								</div>
							</div>


					</div>';
		}
	}

?>