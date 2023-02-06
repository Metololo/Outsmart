<?php 
    include('include/db.php');
    include('include/salt.php');
    include('include/msg_error.php');
    include('include/logs.php');

    $email = $_POST['email'];
    $password = $_POST['password'];


    if (!isset($email) || empty($email) && empty($password)){
        header('location:connexion.php?mailMsg=Veuillez entrer une adresse email&mdpMsg=Veuillez entrer un mot de passe');
        exit;
    }else if(!isset($email) || empty($email)){
         header('location:connexion.php?mailMsg=Veuillez saisir une adresse e-mail');
        exit;
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL) && empty($password)){
        header('location:connexion.php?mailMsg=Saisir une adresse e-mail valide&mdpMsg=Veuillez entrer un mot de passe');
        exit;
    }else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        error_msg('connexion','mailMsg','Saisir une adresse e-mail valide');
    }

   setcookie('email',$email,time() + 24*3600);

    if (empty($password)){
        verif_champ($password,'connexion','mdpMsg','Veuillez entrer un mot de passe');
    }


    $mdpCrypte = hash('sha512', $salt . $password);

    $q = 'SELECT id,verifie,pseudo FROM utilisateurs WHERE email = :email AND mdp = :password';
    $req = $bdd->prepare($q);
    $req->execute([
        'email' => $email,
        'password' => $mdpCrypte
    ]);
    $userInfo = $req->fetch();
    var_dump($userInfo);

    
    if(!$userInfo){
        header('location:connexion.php?errorMsg=Votre adresse e-mail ou votre mot de passe n’est pas correct(e).');
        exit;
    }

    $verifie = $userInfo['verifie'];

    if($verifie == 0){
        header('location:connexion.php?errorMsg=Votre compte n\'est pas encore vérifié. Un mail de confirmation vous a été envoyé.');
        exit;
    }else{

        $q='SELECT bannis FROM utilisateurs WHERE email = "' . $email . '"';
        $reponse = $bdd->query($q);
        $result = $reponse->fetch();
        $reponse->closeCursor();

        if ($result['bannis'] == 1){
             header('location:connexion.php?errorMsg=Votre compte est bannis.');
            exit;
        }
        $log_msg = 'Tentative de connexion de ' . $email . ' réussis le ' . $date . ' à ' . $heure;
        new_log('connexion.txt',$log_msg);


        session_start();
        $_SESSION['email'] = $email;
        header('location:index.php?validateMSG=Bienvenue ' . $userInfo['pseudo']);
        exit;
    }

?>