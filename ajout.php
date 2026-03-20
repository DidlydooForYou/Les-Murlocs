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
?>

<?php include 'include/html_setup.php' ?>

<title>Vitrine</title>

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
    <form action="" method="POST" id="formArme" enctype="multipart/form-data" style="display: none; padding: 4px;">
        <h2>Ajouter une arme</h2>
        <label for="nom">Nom : </label>
        <input type="text" name="nom" id="nom" minlength="1" maxlength="80" required><br>
        <label for="prix">Prix : </label>
        <input type="number" id="prix" required min="1" max="5000" value="1"> <br>
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
        <input type="hidden" name="MAX_FILE_SIZE" value="50000000">
        <input type="file" id="image" name="imgage" accept="image/*"><br>
        <input type="submit" value="Ajouter">

    </form>
    <form action="" method="POST" id="formArmure" style="display: none;padding: 4px;">
        <h2>Ajouter une armure</h2>
        <label for="nom">Nom : </label>
        <input type="text" name="nom" id="nom" minlength="1" maxlength="80" required><br>
        <label for="prix">Prix : </label>
        <input type="number" id="prix" required min="1" max="5000" value="1"> <br>
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
        <input type="hidden" name="MAX_FILE_SIZE" value="50000000">
        <input type="file" id="image" name="imgage" accept="image/*"><br>
    </form>
    <form action="" method="POST" id="formPotion" style="display: none;padding: 4px;">
        <h2>Ajouter une potion</h2>
        <label for="nom">Nom : </label>
        <input type="text" name="nom" id="nom" required><br>
        <label for="prix">Prix : </label>
        <input type="number" id="prix" required min="1" max="5000" value="1"> <br>
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
        <input type="hidden" name="MAX_FILE_SIZE" value="50000000">
        <input type="file" id="image" name="imgage" accept="image/*"><br>
    </form>
    <form action="" method="POST" id="formSort" style="display: none; padding: 4px;" ;>
        <h2>Ajouter un sort</h2>
        <label for="nom">Nom : </label>
        <input type="text" name="nom" id="nom" required><br>
        <label for="prix">Prix : </label>
        <input type="number" id="prix" required min="1" max="5000" value="1"> <br>
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
        <input type="hidden" name="MAX_FILE_SIZE" value="50000000">
        <input type="file" id="image" name="imgage" accept="image/*"><br>
    </form>


</main>

<?php include 'include/footer.php' ?>
<script src="scripts/ajout.js">

</script>