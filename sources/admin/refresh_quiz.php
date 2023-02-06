<?php 

session_start();

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