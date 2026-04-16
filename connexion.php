<?php 
include 'include/html_setup.php';

require_once 'source/EnigmaDAL.php';

doitEtreDeco();
$erreur = false;

if (!empty($_POST['email']) && !empty($_POST['password'])) {
    $email = $_POST['email'];
    $mdp = $_POST['password'];

    if (Database::obtenir_joueur($email, $mdp)){
         $_SESSION["connexion"] = true;
         $_SESSION["id"] = Database::obtenir_id($email)["JoueursJeu_idJoueur"];
         $_SESSION['role'] = Database::administrateur($_SESSION["id"])["administrateur"];
        $connexion = Database::getConnexion();
        $mage = EnigmaDAL::estMage($connexion, $_SESSION["id"]);
        if ($mage['mage'] == 1){
            $_SESSION["mage"] = true;
        }
        else{
            $_SESSION["mage"] = false;
        }
        
        header('Location:index.php');
        
         exit;
    }
    else{
        $erreur = true;
    }
}
?>


<link rel="stylesheet" href="public/css/connexion.css">
<title>DarQuest - Connexion</title>
<?php include 'include/header.php'; ?>
<?php include 'include/nav.php'; ?>

<main class="main">
    <div class="container">
        <div class="connexion-wrapper">

            <h3>Se connecter</h3>

            <form action="connexion.php" method="POST" onsubmit="return connexionValidation()">

                <label for="email">Adresse courriel :</label>
                <input type="email" name="email" id="email">

                <label for="password">Mot de passe :</label>
                <input type="password" name="password" id="password">

                <br>
                <br>
                <input type="submit" value="Se connecter">

                <?php if ($erreur) : ?>
                    <p class="error">Courriel et/ou mot de passe incorrect</p>
                <?php endif; ?>

            </form>

            <a href="inscription.php">Créer un compte</a>

        </div>
    </div>
</main>
<?php include 'include/footer.php' ?>
<script src="scripts/connexionValidation"></script>

</html>