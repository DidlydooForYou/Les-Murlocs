<?php
require "sql/bd.php";
require "source/initialization.php";
doitEtreDeco();
if (isset($_SESSION["connexion"])){
if ($_SESSION["connexion"]){
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
            $mdp = password_hash($_POST['mdp'],PASSWORD_DEFAULT);
           
        } else {
            $validite = false;
        }
    }
    if (isset($_FILES['url'])) {
        if ($_FILES['url']['error'] === UPLOAD_ERR_NO_FILE) {
            $chemin = "public/images/profilBase.webp";
        } else if (
            $_FILES['url']['type'] == "image/jpeg" ||
            $_FILES['url']['type'] == "image/png" ||
            $_FILES['url']['type'] == "image/jpg" ||
            $_FILES['url']['type'] == "image/webp"
        ) {

            $repertoire = 'public/images/';
            $chemin = $repertoire . $_FILES['url']['name'];
            $extension = $_FILES['url']['type'];

            if (move_uploaded_file($_FILES['url']['tmp_name'], $chemin)) {

                switch ($extension) {
                    case 'image/jpeg':
                    case 'image/jpg':
                        $image = imagecreatefromjpeg($chemin);
                        break;
                    case 'image/png':
                        $image = imagecreatefrompng($chemin);
                        break;
                    case 'image/webp':
                        $image = imagecreatefromwebp($chemin);
                        break;
                }
                
               $image = imagescale($image, 640);
               $cheminAvif = pathinfo($chemin,PATHINFO_DIRNAME) . "/" . pathinfo($chemin,PATHINFO_FILENAME) . ".avif";
               imageavif($image,$cheminAvif,90);
               unlink($chemin);
               $chemin = $cheminAvif;
                
            } else {
                $validite = false;
            }
        } else {
            $validite = false;
        }

    }
}
if (isset($validite)){
    if ($validite){
       $erreur = ajouter_joueur($nom,$prenom,$email,$mdp,$chemin,$alias);
       if ($erreur){
        header('Location:connexion.php');
        exit;
       }
       else{
        if ($_FILES['url']['error'] === UPLOAD_ERR_NO_FILE){
        
        }
        else{
            unlink($chemin);
        }
       }
    }
}
?>
<?php include 'include/html_setup.php' ?>
<title>DarQuest - Inscription</title>
<?php 
    include 'include/header.php';
    include 'include/nav.php'; 
?>
    <main class="main" style="padding-left: 4px; ">
        <h3>S'inscrire à Darquest</h3>
        <form action="inscription.php" enctype="multipart/form-data" method="POST"
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
                <label for="alias">Alias :</label>
                <input type="text" name="alias" id="alias" required minlength="2" maxlength="50">
                <br>
                <label for="mdp">Mot de passe : </label>
                <input type="password" name="mdp" id="mdp" required minlength="8" maxlength="50">
                <br>
                <label for="mdpConfirm">Confirmer le mot de passe :</label>
                <input type="password" name="mdpConfirm" id="mdpConfirm" required minlength="8" maxlength="50">
                <br>
                <label for="url">Image :</label>
                <br>
                <input type="hidden" name="MAX_FILE_SIZE" value="50000000">
                <input type="file" id="url" name="url" accept="image/*">
                <br>
                <input type="submit" value="S'inscrire">
                <span id="erreur" style="color: red;"></span>
        </form>
        <p>Déjà membre de Darquest ?</p>
        <a href="connexion.php">Se connecter</a>
        <?php
    if (isset($erreur)) {
        if (!$erreur) {
            echo "<span style='color:red'> Erreur dans les données </span>";
        }
    }
    ?>
    </main>
   <?php include 'include/footer.php' ?>

<script src="scripts/inscriptionValidation.js"></script>

</html>