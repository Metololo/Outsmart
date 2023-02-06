<?php
include('include/db.php');

?>

<!DOCTYPE html>
<html>

<?php include('include/head.php') ?>

<body>
    <h2>Forgot password</h2>
    <form method="post">
        <div class="container">
            <label for="email"><b>Email</b></label>
            <input type="email" placeholder="Enter Email" name="email" required>
            <button type="submit">Send me a random password</button>
        </div>
    </form>
</body>

</html>

<?php

if (isset($_POST['email'])) {
    $password = uniqid();
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $subject = 'Mot de passe oublié';
    $message = "Bonjour, voici votre nouveau mot de passe : $password";
    $headers = 'Content-Type: text/plain; charset="UTF-8"';

    if (mail($_POST['email'], $subject, $message, $headers)) {
        $stmt = $db->prepare("UPDATE utilisateurs SET mdp = ? WHERE email = ?");
        $stmt->execute([$hashedPassword, $_POST['email']]);
        echo "E-mail envoyé";
    } else {
        echo "Une erreur est survenue";
    }
}