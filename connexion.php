<?php
require_once 'DAL/EnigmaDAL.php';
require_once 'core/initialization.php';
require_once 'core/Email.php';
require_once 'core/Database.php';
include 'include/php_setup.php';

@session_start();
doitEtreDeco();
$erreur = false;

if (!empty($_POST['email']) && !empty($_POST['password'])) {
    $email = $_POST['email'];
    $mdp = $_POST['password'];

    $joueur = Database::obtenir_joueur($email, $mdp);

    if (!is_array($joueur)) {
        $erreur = "Courriel ou mot de passe incorrect.";
    } else if ((int) $joueur["confirmed"] === 0) {
        $erreur = "Veuillez confirmer votre courriel avant de vous connecter.";
    } else {
        $_SESSION["connexion"] = true;
        $_SESSION["id"] = $joueur["JoueursJeu_idJoueur"];
        $_SESSION["role"] = Database::administrateur($_SESSION["id"])["administrateur"];

        $connexion = Database::getConnexion();
        $mage = EnigmaDAL::estMage($connexion, $_SESSION["id"]);
        $_SESSION["mage"] = ($mage["mage"] == 1);

        header('Location:index.php');
        exit;
    }
}
?>


<link rel="stylesheet" href="public/css/connexion.css">
<title>DarQuest - Connexion</title>
<?php
include 'include/html_setup.php';
include 'include/header.php';
include 'include/nav.php';
?>

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

                <?php if ($erreur): ?>
                    <p class="error"><?= $erreur ?></p>
                <?php endif; ?>
                <?php
                    if (isset($_SESSION['confirEmail'] )){
                        if ($_SESSION['confirEmail'] ){
                            echo "<p>Veuillez confirmer votre email pour vous connecter";
                            $_SESSION['confirEmail'] = false;
                        }
                    }
                ?>


            </form>

            <a href="inscription.php">Créer un compte</a>

        </div>
    </div>
</main>
<?php include 'include/footer.php' ?>
<script src="scripts/connexionValidation"></script>

</html>