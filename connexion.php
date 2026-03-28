<?php
require "sql/bd.php";
require "source/initialization.php";
doitEtreDeco();
$erreur = false;
 if (!empty($_POST['email']) && !empty($_POST['password'])) {
    $email = $_POST['email'];
    $mdp = $_POST['password'];

    if (obtenir_joueur($email, $mdp)){
         $_SESSION["connexion"] = true;
         $_SESSION["id"] = obtenir_id($email)["JoueursJeu_idJoueur"];
         $_SESSION['role'] = administrateur($_SESSION["id"])["administrateur"];
        header('Location:index.php');
         exit;
    }
    else{
        $erreur = true;
    }
 }
?>
<?php include 'include/html_setup.php' ?>

<title>DarQuest - Connexion</title>

<?php 
    include 'include/header.php';
    include 'include/nav.php'; 
?>
    <main class="main" style="padding-left: 4px;">
        <h3>Se connecter</h3>
    <form action="connexion.php" method="POST" onsubmit="return connexionValidation()">
    
            <label for="email">Adresse courriel : </label>
            <input type="email" name="email" id="email"><br>
            <label for="password">Mot de passe : </label>
            <input type="password" name="password" id="password"><br>
            <input type="submit" value="Se connecter">
            <span id="erreur" style="color: red;"></span>


    </form>
    <?php if (isset($erreur))  if ($erreur == true) echo "<p style= 'color: red'>Courriel et/ou mot de passe incorrect </p>"; ?>
    <p>Vous n'avez pas de compte ?</p>
    <a href="inscription.php">S'inscrire</a>
    </main>
   <?php include 'include/footer.php' ?>
    <script src="scripts/connexionValidation"></script>

</html>