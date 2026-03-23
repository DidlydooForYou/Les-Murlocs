<?php
session_start();
require "sql/bd.php";
if (!$_SESSION["connexion"]) {
    header('Location:accesRefuse.php');
    exit;
}
if (!isset($_SESSION["admin"])) {
    $admin = administrateur($_SESSION["id"])["administrateur"];
    if ($admin == 0) {
        header('Location:accesRefuse.php');
        exit;
    }
}
function conversion($prix){
    $conversion = array();
    if (strlen($prix) == 4){
        $conversion[0] = (int) substr($prix,0,2);
        $conversion[1] = (int) substr($prix,2,1); 
        $conversion[2] = (int) substr($prix,3,1);
    }
    elseif (strlen($prix) == 3){
        $conversion[0] = (int) substr($prix,0,1);
        $conversion[1] = (int) substr($prix,1,1);
        $conversion[2] = (int) substr($prix,3,1);

    }
    elseif(strlen($prix) == 2){
        $conversion[0] = 0;
        $conversion[1] = (int) substr($prix,0,1);
        $conversion[2] = (int) substr($prix,1,1);
    }
    elseif(strlen($prix) == 1){
        $conversion[0] = 0;
        $conversion[1] = 0;
        $conversion[2] = $prix;
    }
    return $conversion;
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $validite = true;
    if (
        isset($_POST['nom']) &&
        isset($_POST['prix']) &&
        isset($_POST['description']) &&
        isset($_POST['quantite']) &&
        isset($_POST['type'])
    ) {
        if (isset($_FILES['url'])) {
            if ($_FILES['url']['error'] === UPLOAD_ERR_NO_FILE) {
                $chemin = "lorem.png";
            } else if (
                $_FILES['url']['type'] == "image/jpeg" ||
                $_FILES['url']['type'] == "image/png" ||
                $_FILES['url']['type'] == "image/jpg" ||
                $_FILES['url']['type'] == "image/webp"
            ) {

                $repertoire = 'images/';
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

                    switch ($extension) {
                        case 'image/jpeg':
                        case 'image/jpg':
                            imagejpeg($image, $chemin, 90);
                            break;
                        case 'image/png':
                            imagepng($image, $chemin);
                            break;
                        case 'image/webp':
                            imagewebp($image, $chemin, 90);
                            break;
                    }
                } else {
                    $validite = false;
                }
            } else {
                $validite = false;
            }

        }
        if (strlen($_POST['nom']) <= 80 && strlen($_POST['nom']) >= 1) {
            $nom = $_POST['nom'];
        }
        if (strlen($_POST['prix']) <= 5000 && strlen($_POST['prix']) >= 1) {
            $prix = $_POST['prix'];
            $prixSc = conversion($prix);
            $prixOr = $prixSc[0];
            $prixArgent = $prixSc[1];
            $prixBronze = $prixSc[2];
        }
        if (strlen($_POST['description']) <= 80 && strlen($_POST['description']) >= 1) {
            $description = $_POST['description'];
        }
        if (strlen($_POST['quantite']) <= 20 && strlen($_POST['quantite']) >= 1) {
            $quantite = (int)$_POST['quantite'];
        }

        switch ($_POST['type']) {
            case "formArme":
                if (
                    isset($_POST['efficacite']) &&
                    isset($_POST['genre'])
                ) {
                    if (strlen($_POST['efficacite']) <= 10 && strlen($_POST['efficacite']) >= 1) {
                        $efficacite = (int)$_POST['efficacite'];
                    }
                    $genre = $_POST['genre'];
                    ajouter_arme($nom,$prixOr,$prixArgent,$prixBronze, $description,$efficacite,$genre,$quantite,$chemin);
                }
                break;
            case "fortArmure":
                break;
            case "formPotion":
                break;
            case "formSort":
                break;
        }

    }

}
?>

<?php include 'include/html_setup.php' ?>

<title>Ajout</title>

<?php
include 'include/header.php';
include 'include/nav.php';
?>

<main class="main">

    <select name="type" id="type" onchange="Form()" style="margin-top : 4px; margin-left:4px;">
        <option value="" selected>Choisir un type d'objet : </option>
        <option value="arme">Armes</option>
        <option value="armure">Armure</option>
        <option value="potion">Potion</option>
        <option value="sort">Sort</option>
    </select>
    <form action="ajout.php" method="POST" id="formArme" enctype="multipart/form-data"
        style="display: none; padding: 4px;">
        <input type="hidden" name="type" value="formArme">
        <h2>Ajouter une arme</h2>
        <label for="nom">Nom : </label>
        <input type="text" name="nom" id="nom" minlength="1" maxlength="80" required><br>
        <label for="prix">Prix : </label> en bronze
        <input type="number" id="prix" name="prix" required min="1" max="5000" value="1"> <br>
        <label for="description">Description : </label> <br>
        <textarea name="description" id="description" autofocus cols="40" rows="10" style="resize : none;" required
            minlength="1" maxlength="80"></textarea><br>
        <label for="efficacite">Efficacité : </label>
        <input type="number" id="efficacite" name="efficacite" min="1" max="10" value="1" required> <br>
        <p>Quel est le genre de l'arme ?</p>
        <input type="radio" id="uneMain" name="genre" value="une main">
        <label for="uneMain"> Une main</label>
        <input type="radio" id="deuxMains" name="genre" value="deux mains">
        <label for="deuxMains">Deux mains</label> <br>
        <label for="quantite">Quantité à ajouter : </label>
        <input type="number" min="1" max="20" value="1" name="quantite" id="quantite" required> <br>
        <label for="image">Image :</label><br>
        <input type="hidden" name="MAX_FILE_SIZE" value="50000000" >
        <input type="file" id="image" name="url" accept="image/*" ><br>
        <input type="submit" value="Ajouter">

    </form>
    <form action="ajout.php" method="POST" id="formArmure" style="display: none;padding: 4px;">
        <input type="hidden" name="type" value="formArmure">
        <h2>Ajouter une armure</h2>
        <label for="nom">Nom : </label>
        <input type="text" name="nom" id="nom" minlength="1" maxlength="80" required><br>
        <label for="prix">Prix : </label> en bronze
        <input type="number" id="prix"name="prix" required min="1" max="5000" value="1"> <br>
        <label for="description">Description : </label> <br>
        <textarea name="description" id="description" autofocus cols="40" rows="10" style="resize : none;" required
            minlength="1" maxlength="80"></textarea><br>
        <label for="matiere">Matière de l'armure : </label>
        <input type="text" name="matiere" id="matiere" required minlength="1" maxlength="40"> <br>
        <label for="taille">Taille en cm :</label>
        <input type="number" name="taille" id="taille" required min="1" max="60"> cm <br>
        <label for="quantite">Quantité à ajouter : </label>
        <input type="number" min="1" max="20" value="1" name="quantite" id="quantite" required> <br>
        <label for="image">Image :</label><br>
        <input type="hidden" name="MAX_FILE_SIZE" value="50000000" required>
        <input type="file" id="image" name="url" accept="image/*" required><br>
    </form>
    <form action="ajout.php" method="POST" id="formPotion" style="display: none;padding: 4px;">
        <input type="hidden" name="type" value="formPotion">
        <h2>Ajouter une potion</h2>
        <label for="nom">Nom : </label>
        <input type="text" name="nom" id="nom" required><br>
        <label for="prix">Prix : </label>
        <input type="number" id="prix"name="prix" required min="1" max="5000" value="1"> <br>
        <label for="description">Description : </label> <br>
        <textarea name="description" id="description" autofocus cols="40" rows="10" style="resize : none;" required
            minlength="1" maxlength="80"></textarea><br>
        <label for="effet">Effet : </label>
        <input type="text" name="effet" id="effet" required minlength="1" maxlength="60"> <br>
        <label for="duree">Durée en secondes : </label>
        <input type="number" id="duree" name="idee" required min="1" max="600"> secondes <br>
        <label for="quantite">Quantité à ajouter : </label>
        <input type="number" min="1" max="20" value="1" name="quantite" id="quantite" required> <br>
        <label for="image">Image :</label><br>
        <input type="hidden" name="MAX_FILE_SIZE" value="50000000" required>
        <input type="file" id="image" name="url" accept="image/*" required><br>
    </form>
    <form action="ajout.php" method="POST" id="formSort" style="display: none; padding: 4px;" ;>
        <input type="hidden" name="type" value="formSort">
        <h2>Ajouter un sort</h2>
        <label for="nom">Nom : </label>
        <input type="text" name="nom" id="nom" required><br>
        <label for="prix">Prix : </label>
        <input type="number" id="prix"name="prix" required min="1" max="5000" value="1"> <br>
        <label for="description">Description : </label> <br>
        <textarea name="description" id="description" autofocus cols="40" rows="10" style="resize : none;" required
            minlength="1" maxlength="80"></textarea><br>
        <p>Est-ce que le sort est instantané ?</p>
        <input type="radio" id="oui" name="instantane" value="oui">
        <label for="oui"> Oui</label>
        <input type="radio" id="non" name="instantane" value="non">
        <label for="non">Non</label> <br>
        <label for="dommage">Dommage du sort : </label>
        <input type="number" id="dommage" name="dommage" required min="1" max="100"> points de vie<br>
        <label for="quantite">Quantité à ajouter : </label>
        <input type="number" min="1" max="20" value="1" name="quantite" id="quantite" required> <br>
        <label for="image">Image :</label><br>
        <input type="hidden" name="MAX_FILE_SIZE" value="50000000" required>
        <input type="file" id="image" name="url" accept="image/*" required><br>
    </form>


</main>

<?php include 'include/footer.php' ?>
<script src="scripts/ajout.js">

</script>