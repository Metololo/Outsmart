<?php 
    require "PHPMailer/PHPMailerAutoload.php";
    include('include/db.php');
    include('include/msg_error.php');
    include('include/salt.php');

    $email = $_POST['email'];
    $password = $_POST['password'];
    $conf_pass = $_POST['confpass'];
    $pseudo = $_POST['pseudo'];
    $desc = $_POST['description'];
    
    $image = $_FILES['image'];

    $msg1 ='Veuillez entrer une adresse e-mail';
    $msg2 ='Saisir une adresse e-mail valide';
    $msg3 ='Entrer un mot de passe';
    $msg4 ='Le mot de passe doit faire entre 6 et 20 caractères';
    $msg5 ='Veuillez entrer un pseudonyme';
    $msg6 ='Votre pseudonyme doit faire entre 3 et 15 caractères';
    $msg7 ='Remplir ce champ';
    $msg8 ='Les mots de passe ne correspondent pas';
    $msg9 ='Addresse mail déja utilisé';
    $msg10 ='Ce pseudo est déja utilisé';

    if (!isset($email) || empty($email)){
       error_msg('inscription','mailMsg',$msg1);
    }else{
        setcookie('email',$email,time() + 24*3600);
    }
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
      error_msg('inscription','mailMsg',$msg2);
   }
    if(!isset($pseudo) || empty($pseudo)){
         error_msg('inscription','pseudoMsg',$msg5);
       exit;
    }else{
        setcookie('pseudo',$pseudo,time() + 24*3600);
    }
   if(strlen($pseudo) < 3 || strlen($pseudo) > 15){
         error_msg('inscription','pseudoMsg',$msg6);
    }

    verif_champ($desc,'inscription','descMsg',$msg7);

    setcookie('desc',$desc,time() + 24 * 3600);

    if (strlen($desc) > 128){
        error_msg('inscription','descMsg','La description ne doit pas dépasser 128 caractères');
    }

    verif_champ($password,'inscription','mdpMsg',$msg3);

    if(strlen($password) < 6 || strlen($password) > 50){
         error_msg('inscription','mdpMsg',$msg4);
    }
    verif_champ($conf_pass,'inscription','mdpcMsg',$msg7);

   if ($conf_pass != $password){
        error_msg('inscription','mdpcMsg',$msg8);
    }

        $q='SELECT id FROM utilisateurs WHERE email = ? OR pseudo = ?';
        $req = $bdd->prepare($q);
        $req->execute([$email,$pseudo]);
        $result = $req->fetchAll();
    
        if(count($result) != 0){
            error_msg('inscription','mailMsg',$msg9);
        }

        $q='SELECT id FROM utilisateurs WHERE pseudo = ?';
        $req = $bdd->prepare($q);
        $req->execute([$pseudo]);
        $result = $req->fetchAll();
    
        if(count($result) != 0){
            error_msg('inscription','pseudoMsg',$msg10);
        }

        if($image['name'] != ''){

        $acceptable = [
        'image/jpeg',
        'image/png',
        'image/gif'
        ];

        if (!in_array($image['type'],$acceptable)){
            error_msg('inscription','imageMsg','Type de fichier incorrect');
        }

        $maxSize = 2 * 1024 * 1024;

        if($image['size'] > $maxSize){
            error_msg('inscription','imageMsg','Image trop volumineuse ( 2 mo MAX )');
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
        
    }else{
        $filename = 'default.png';
    }

    $mdpSalee = hash('sha512', $salt . $password);

        $cle = uniqid();

        $empreinteSalee = hash('sha512', $salt . $password);

        $q='INSERT INTO utilisateurs (pseudo,mdp,description,email,cle,image) VALUES(:pseudo,:mdp,:description,:email,:cle,:image)';
        $req = $bdd->prepare($q);
        $result = $req->execute([
            'pseudo' => $pseudo,
            'mdp' => $empreinteSalee,
            'email' => $email,
            'cle' => $cle,
            'image' => $filename,
            'description' => $desc
        ]);

        if($result){
            
        }else{
            error_msg('inscription','Erreur lors de la création de compte.');
            exit;
        }

        $q='SELECT * FROM utilisateurs WHERE email = ?';
        $req = $bdd->prepare($q);
        $req->execute([$email]);
        $result = $req->fetch();
        if(count($result) > 0){
            $id = $result['id'];
        }


function smtpmailer($to, $from, $from_name, $subject, $body)
    {
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPAuth = true; 
 
        $mail->SMTPSecure = 'ssl'; 
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 465;  
        $mail->Username = 'outsmartquizz@gmail.com';
        $mail->Password = 'masafadoumyhim';   
   
   //   $path = 'reseller.pdf';
   //   $mail->AddAttachment($path);
   
        $mail->IsHTML(true);
        $mail->From="outsmartquizz@gmail.com";
        $mail->FromName=$from_name;
        $mail->Sender=$from;
        $mail->AddReplyTo($from, $from_name);
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->AddAddress($to);
        if(!$mail->Send())
        {
            $error ="Please try Later, Error Occured while Processing...";
            return $error; 
        }
        else 
        {
            $error = "Thanks You !! Your email is sent.";  
            return $error;
        }
    }
    
    $to   = $email;
    $from = 'outsmartquizz@gmail.com';
    $name = 'OutSmart Quizz';
    $subj = 'Confirmation de compte - OutSmart';
    $msg = '<h2>Bienvenue : ' . $pseudo . ' !</h2>' . '<br /> <p>Pour confirmer votre inscription, il vous suffit de cliquer <a href="164.132.225.184/verif_mail.php?id=' . $id . '&cle=' . $cle . '">ICI</a><br />';


    
    $error=smtpmailer($to,$from, $name ,$subj, $msg);

    header('location:connexion.php?validateMSG=Compte crée avec succès ! Un email de confirmation vous a été envoyer !');
            exit;

?>