<?php
require_once 'core/Email.php';

include 'include/php_setup.php';

require_once 'upload/PHPMailer/src/Exception.php';
require_once 'upload/PHPMailer/src/PHPMailer.php';
require_once 'upload/PHPMailer/src/SMTP.php';

doitEtreDeco();


if (isset($_SESSION["connexion"])) {
    if ($_SESSION["connexion"]) {
        header('Location:accesRefuse.php');
        exit;
    }
}
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $validite = true;
    if (
        isset($_POST['alias']) &&
        isset($_POST['nom']) &&
        isset($_POST['prenom']) &&
        isset($_POST['email']) &&
        isset($_POST['mdp'])
    ) {
        if (strlen($_POST['alias']) >= 2 && strlen($_POST['alias']) <= 50) {
            $alias = $_POST['alias'];
        } else {
            $validite = false;
        }
        if (strlen($_POST['nom']) >= 2 && strlen($_POST['nom']) <= 25) {
            $nom = $_POST['nom'];
        } else {
            $validite = false;
        }
        if (strlen($_POST['prenom']) >= 2 && strlen($_POST['prenom']) <= 25) {
            $prenom = $_POST['prenom'];
        } else {
            $validite = false;
        }
        if (strlen($_POST['email']) >= 6 && strlen($_POST['email']) <= 254) {
            $email = $_POST['email'];
        } else {
            $validite = false;
        }
        if (strlen($_POST['mdp']) >= 8 && strlen($_POST['mdp']) <= 50) {
            $mdp = password_hash($_POST['mdp'], PASSWORD_DEFAULT);

        } else {
            $validite = false;
        }
    }
    if (isset($_FILES['url'])) {
        if ($_FILES['url']['error'] === UPLOAD_ERR_NO_FILE) {
            $chemin = "public/images/profilBase.webp";
        }
        else {

            $repertoire = 'public/images/';
            $extension = strtolower(pathinfo($_FILES['url']['name'], PATHINFO_EXTENSION));
            if ($extension != "avif"){
                $chemin = "public/images/profilBase.webp";
            }
            else{
            $chemin = $repertoire . $_FILES['url']['name'];
            if (move_uploaded_file($_FILES['url']['tmp_name'], $chemin)) {
            } else {
                $validite = false;
            }


            }
         
        
        }

    }
}
if (isset($validite)) {
    if ($validite) {
        $erreur = Database::ajouter_joueur($nom, $prenom, $email, $mdp, $chemin, $alias);
        if ($erreur) {

            Email::readConfig(__DIR__ . '/gmail.ini');
           

            $subject = "Bienvenue sur DarQuest!";
            $message = "<h1>Merci d'avoir créé un compte, $prenom!</h1>
            <p>Veuillez confirmer votre adresse courriel :</p>
            <p><a href='http://158.69.48.57/~darquest13/valider.php?email=$email'>Cliquez ici pour valider</a></p>";

            Email::send($email, $subject, $message);
            $_SESSION['confirEmail'] = true;
            header('Location:connexion.php');
            exit;
        }
    }
}
?>

<link rel="stylesheet" href="public/css/connexion.css">
<title>DarQuest - Inscription</title>

<?php
include 'include/html_setup.php';
include 'include/header.php';
include 'include/nav.php';
?>
<main class="main">
    <div class="container">
        <div class="connexion-wrapper">
            <h3>S'inscrire à Darquest</h3>
            <form action="inscription.php" style="padding-left: 4px;" enctype="multipart/form-data" method="POST"
                onsubmit="return validationInscription()">
                <label for="prenom"> Prénom :</label>
                <input type="text" id="prenom" name="prenom" required minlength="2" maxlength="25">
                <br>
                <label for="nom"> Nom :</label>
                <input type="text" id="nom" name="nom" required minlength="2" maxlength="25">
                <br>
                <label for="email">Adresse courriel : </label>
                <input type="email" id="email" name="email" required minlength="6" maxlength="254">
                <br>
                <label for="alias">Alias : </label>
                <input type="text" name="alias" id="alias" required minlength="2" maxlength="50">
                <br>
                <label for="mdp">Mot de passe : </label>
                <input type="password" name="mdp" id="mdp" required minlength="8" maxlength="50">
                <br>
                <label for="mdpConfirm">Confirmer le mot de passe : </label>
                <input type="password" name="mdpConfirm" id="mdpConfirm" required minlength="8" maxlength="50">
                <br>
                <label for="url">Image : </label>

                <label for="url" class="upload-btn">Choisir une image</label>
                <input type="file" id="url" name="url" accept=".avif,image/avif">

                <div class="file-name" id="file-name">Aucune image sélectionnée</div>
                <div class="image-section">
                    <img id="pfp-preview" class="pfp-preview" style="display:none;">
                </div>

                <input type="submit" value="S'inscrire">
                <span id="erreur" style="color: red;"></span>
            </form>
            <div class="login-links">
                <p>Déjà membre de Darquest ?</p>
                <a href="connexion.php">Se connecter</a>
            </div>

            <?php
            if (isset($erreur)) {
                if (!$erreur) {
                    echo "<span style='color:red'> Erreur dans les données </span>";
                }
            }
            ?>
        </div>
    </div>
</main>
<?php include 'include/footer.php' ?>

<script src="scripts/inscriptionValidation.js"></script>
<script>
    document.getElementById("url").addEventListener("change", function (event) {
        const file = event.target.files[0];
        const preview = document.getElementById("pfp-preview");
        const fileName = document.getElementById("file-name");

        if (!file) return;

        fileName.textContent = "";
        preview.src = URL.createObjectURL(file);
        preview.style.display = "block";
    });
</script>

</html>