<?php 
session_start();

$title='QUIZZ ADMIN'; 
include('../include/connexion_check.php');
include('../include/db.php');


$email = $_SESSION['email'];

$q='SELECT id,droit FROM utilisateurs WHERE email= ?';
$reponse = $bdd->prepare($q);
$reponse->execute([$email]);
$user_infos = $reponse->fetch(PDO::FETCH_ASSOC);
$reponse->closeCursor();


if($user_infos['droit'] !== '3' OR $user_infos['id'] !== '27'){
	header('location:https://www.google.com/');
	exit;
}

$q='SELECT * FROM question ORDER BY id desc';
$req = $bdd->query($q);
$questions = $req->fetchAll(PDO::FETCH_ASSOC);


if(isset($_POST)){

	var_dump($_POST);

	$question = $_POST['question'];
	$b_rep = $_POST['b_rep'];
	$rep2 = $_POST['rep2'];
	$rep3 = $_POST['rep3'];
	$rep4 = $_POST['rep4'];
	$type = $_POST['type'];
	$theme = $_POST['theme'];
	$image = $_POST['image'];
	$audio = $_POST['audio'];

	if($type=='c'){

		$q='INSERT INTO question(question,b_rep,rep2,rep3,rep4,type,image,audio,theme) VALUES("'.$question.'","'.$b_rep.'","'.$rep2.'","'.$rep3.'","'.$rep4.'","'.$type.'",NULL,NULL,"'.$theme.'")';
		$bdd->exec($q);

	}else if($type == 'i'){
		$q='INSERT INTO question(question,b_rep,rep2,rep3,rep4,type,image,audio,theme) 
			VALUES("'.$question.'","'.$b_rep.'","'.$rep2.'","'.$rep3.'","'.$rep4.'","'.$type.'","'.$image.'",NULL,"'.$theme.'")';
			$bdd->exec($q);
	}else if($type == 'a'){
		$q='INSERT INTO question(question,b_rep,rep2,rep3,rep4,type,image,audio,theme) 
			VALUES("'.$question.'","'.$b_rep.'","'.$rep2.'","'.$rep3.'","'.$rep4.'","'.$type.'",NULL,"'.$audio.'","'.$theme.'")';
			$bdd->exec($q);
	}


}



?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?= $title?></title>
	<meta lang="fr-FR">
	<link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<meta name="viewport" content="width-device-width, initial-scale=1.0">
	<meta name="OutSmart">
</head>
<body>



		<form method="post" style="padding:16px;">
		  <div class="form-row">
		  	<div class="col">
		  		<input type="text" name="question" class="form-control" placeholder="question">
		  	</div>
		      
		      <input type="text" name="b_rep" class="form-control" placeholder="b_rep">
		      <input type="text" name="rep2" class="form-control" placeholder="rep2">
		      <input type="text" name="rep3" class="form-control" placeholder="rep3">
		      <input type="text" name="rep4" class="form-control" placeholder="rep4">
		      <select name="type">
		      	<option value="c">classique</option>
		      	<option value="i">image</option>
		      	<option value="a">audio</option>
		      </select>
		      <input type="text" name="image" class="form-control" placeholder="iomg">
		      <input type="text" name="audio" class="form-control" placeholder="audio">
		      <select name="theme">
		      	<option value="ani">Animaux</option>
		      	<option value="cin">Cinema</option>
		      	<option value="cui">Cui</option>
		      	<option value="cul">Culture G</option>
		      	<option value="des">Dessin animés</option>
		      	<option value="dra">Drapeaux</option>
		      	<option value="geo">Geographie</option>
		      	<option value="jeu">JV</option>
		      	<option value="man">Mangas</option>
		      	<option value="mus">Musique</option>
		      	<option value="qui">Qui es-ce</option>
		      	<option value="rap">Rap</option>
		      	<option value="sci">Science</option>
		      	<option value="spo">Sport</option>
		      </select>

		      <button type="submit">AJOUTER</button>

		  </div>
		</form>

		<button onclick="refresh_question()">ACTUALISER</button>

	<div style="padding: 16px; overflow-x: auto;">
		<table class="table table-dark">
		  <thead>
		    <tr>
		      <th scope="col">id</th>
		      <th scope="col">Question</th>
		      <th scope="col">b_rep</th>
		      <th scope="col">rep2</th>
		      <th scope="col">rep3</th>
		      <th scope="col">rep4</th>
		      <th scope="col">type</th>
		      <th scope="col">image</th>
		      <th scope="col">audio</th>
		      <th scope="col">theme</th>
		      <th scope="col">ACTIONS</th>
		    </tr>
		  </thead>
		  <tbody id="table-quiz">
		    <?php 
		    foreach ($questions as $question) {
		    	echo '

		    	<tr>
			      <th scope="row">'.$question['id'].'</th>
			      <td>'.$question['question'].'</td>
			      <td>'.$question['b_rep'].'</td>
			      <td>'.$question['rep2'].'</td>
			      <td>'.$question['rep3'].'</td>
			      <td>'.$question['rep4'].'</td>
			      <td>'.$question['type'].'</td>
			      <td>'.$question['image'].'</td>
			      <td>'.$question['audio'].'</td>
			      <td>'.$question['theme'].'</td>
			      <td><button type="button" data-bs-toggle="modal" data-bs-target="#delete_question" class="btn btn-danger" id="delete'.$question['id'].'">SUPPRIMER</button><button data-bs-toggle="modal" data-bs-target="#modify_question" type="button" class="btn btn-primary">MODIFIER</button></td>
			    </tr>

		    	';
		    }

		    ?>
		  </tbody>
		</table>
	</div>


	<div class="modal fade" id="delete_question" tabindex="-1" role="dialog"  aria-hidden="true">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <h5 class="modal-title" id="delete_title">Supprimer question ?</h5>
			        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
				    <div class="modal-footer">
				        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
			        		<button type="submit" class="btn btn-danger" data-bs-dismiss="modal" id="confirm_delete" name="id">Supprimer</button>


			      </div>
			    </div>
			  </div>
			</div>


			<div class="modal fade" id="modify_question" tabindex="-1" role="dialog"  aria-hidden="true">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			       
			        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body">
			        <form>
						  <div class="form-group">
						    <label for="exampleInputEmail1">Question</label>
						    <input type="text" class="form-control" name="question" aria-describedby="emailHelp" placeholder="Enter email">
						  </div>
						  <div class="form-group">
						    <label for="exampleInputPassword1">b_rep</label>
						    <input type="text" class="form-control" name="b_rep">
						  </div>
						  <div class="form-group">
						    <label for="exampleInputPassword1">REP2</label>
						    <input type="text" class="form-control" name="rep2">
						  </div>
						  <div class="form-group">
						    <label for="exampleInputPassword1">REP3</label>
						    <input type="text" class="form-control" name="rep3">
						  </div>
						  <div class="form-group">
						    <label for="exampleInputPassword1">REP4</label>
						    <input type="text" class="form-control" name="rep4">
						  </div>
						  <select name="type" class="form-control">
					      	<option value="c">classique</option>
					      	<option value="i">image</option>
					      	<option value="a">audio</option>
					      </select>
					      <div class="form-group">
						    <label for="exampleInputPassword1">Image</label>
						    <input type="text" class="form-control" name="image">
						  </div>
						  <div class="form-group">
						    <label for="exampleInputPassword1">Audio</label>
						    <input type="text" class="form-control" name="audio">
						  </div>
						   <select name="theme" class="form-control">
						      	<option value="ani">Animaux</option>
						      	<option value="cin">Cinema</option>
						      	<option value="cui">Cui</option>
						      	<option value="cul">Culture G</option>
						      	<option value="des">Dessin animés</option>
						      	<option value="dra">Drapeaux</option>
						      	<option value="geo">Geographie</option>
						      	<option value="jeu">JV</option>
						      	<option value="man">Mangas</option>
						      	<option value="mus">Musique</option>
						      	<option value="qui">Qui es-ce</option>
						      	<option value="rap">Rap</option>
						      	<option value="sci">Science</option>
						      	<option value="spo">Sport</option>
						      </select>

						  <button type="submit" class="btn btn-primary">enregistrer</button>
						</form>
			      </div>

				        
										    <div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>

			      </div>
			    </div>
			  </div>
			</div>

		
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
	<script src="quiz.js"></script>

</body>
</html>