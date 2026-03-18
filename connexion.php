<?php
require "sql/bd.php";
session_start();
if (isset($_SESSION["connexion"])){
if ($_SESSION["connexion"]){
    header('Location:accesRefuse.php');
    exit;
}
}
$erreur = false;
 if (!empty($_POST['email']) && !empty($_POST['password'])) {
    $email = $_POST['email'];
    $mdp = $_POST['password'];

    if (obtenir_joueur($email, $mdp)){
         $_SESSION["connexion"] = true;
         $_SESSION["id"] = obtenir_id($email)["JoueursJeu_idJoueur"];
        header('Location:index.php');
         exit;
    }
    else{
        $erreur = true;
    }
 }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header><?php include "includes/header.php" ?></header>
    <nav><?php include "includes/nav.php" ?></nav>
    <main>
    <form action="connexion.php" method="POST" onsubmit="return connexionValidation()">
        <fieldset  style="width : 40%">
            <label for="email">Adresse courriel : </label>
            <input type="email" name="email" id="email"><br>
            <label for="password">Mot de passe : </label>
            <input type="password" name="password" id="password"><br>
            <input type="submit" value="Se connecter">
            <span id="erreur" style="color: red;"></span>

        </fieldset>


    </form>
    <?php if (isset($erreur))  if ($erreur == true) echo "<p style= 'color: red'>Courriel et/ou mot de passe incorrect </p>"; ?>
    <p>Vous n'avez pas de compte ?</p>
    <a href="inscription.php">S'inscrire</a>
    </main>
    <footer><?php include "includes/footer.php" ?></footer>
    <script src="scripts/connexionValidation"></script>
</body>
</html>