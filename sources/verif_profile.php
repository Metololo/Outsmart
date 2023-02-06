<?php 
	session_start();

    include('include/db.php');
    include('include/ban_check.php');
    include('include/msg_error.php');
    $email = $_SESSION['email'];
    $pseudo = $_POST['pseudo'];
    $desc = $_POST['description'];
    $image = $_FILES['image'];       
    $msg6 ='Votre pseudonyme doit faire entre 3 et 15 caractères';
    $msg10 ='Ce pseudo est déja utilisé';
    

    $q='SELECT pseudo FROM utilisateurs WHERE email = ?';
    $req = $bdd->prepare($q);
    $req->execute([$email]);
    $user = $req->fetch();

    if(isset($pseudo) && !empty($pseudo)){
        if(strlen($pseudo) < 3 || strlen($pseudo) > 15){

         error_msg('profile','pseudoMsg',$msg6);
         }

        $q='SELECT COUNT(id) FROM utilisateurs WHERE pseudo = ?';
        $req = $bdd->prepare($q);
        $req->execute([$pseudo]);
        $result = $req->fetch();


        if($result['COUNT(id)'] != 0){
            if($user['pseudo'] != $pseudo){
               error_msg('profile','pseudoMsg',$msg10);
               exit;
            }
        }
    }

        $q="UPDATE utilisateurs SET pseudo = ? WHERE email = ?";
        $req = $bdd->prepare($q);
        $result = $req->execute([$pseudo,$email]);

        if($result){
            
        }else{
            error_msg('profile','Erreur lors de la modification.');
            exit;
            }


         if(isset($desc) && !empty($desc)){
       
         if (strlen($desc) > 128){
           error_msg('profile','descMsg','La description ne doit pas dépasser 128 caractères');
         }

        $q="UPDATE utilisateurs SET description = ? WHERE email = ?";
        $req = $bdd->prepare($q);
        $result = $req->execute([$desc,$email]);

        if($result){
            
        }else{
            error_msg('profile','Erreur lors de la modification.');
            exit;
            }

        }	

        if($image['name'] != ''){

        $acceptable = [
        'image/jpeg',
        'image/png',
        'image/gif'
        ];

        if (!in_array($image['type'],$acceptable)){
            error_msg('profile','imageMsg','Type de fichier incorrect');
        }

        $maxSize = 2 * 1024 * 1024;

        if($image['size'] > $maxSize){
            error_msg('profile','imageMsg','Image trop volumineuse ( 2 mo MAX )');
        }

        $path = "uploads/avatars/";

        if(!file_exists($path)){
            mkdir($path, 777);
        }

        $filename = $image['name'];
        $array = explode('.',$filename);
        $ext = end($array);
        $filename = 'image-' . time() . '.' . $ext;
        
        $destination = $path . $filename;
        move_uploaded_file($image['tmp_name'],$destination);

        $q='SELECT image FROM utilisateurs WHERE email=?';
		$reponse = $bdd->prepare($q);
		$reponse->execute([$email]);
		$image_info = $reponse->fetch(PDO::FETCH_ASSOC);
		$reponse->closeCursor();

		if(file_exists($path . $image_info['image'])){
            unlink($path . $image_info['image']);
        }

        $q="UPDATE utilisateurs SET image = ? WHERE email = ?";
        $req = $bdd->prepare($q);
        $result = $req->execute([$filename,$email]);

        if($result){
            
        }else{
            error_msg('profile','Erreur lors de la modification.');
            exit;
        }
        
    }    

    header('location:profile.php?validateMSG=Modifications effectués !');
    exit; 
?>