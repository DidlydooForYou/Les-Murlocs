<?php
include 'include/html_setup.php';
require_once 'DAL/EnigmaDAL.php';

if (!IS_ADMIN) {
    header('Location:accesRefuse.php');
    exit;
}

$connexion = Database::getConnexion();

if ($_SERVER['REQUEST_METHOD'] === "POST" && $_POST['type'] === "formEnigme") {

    if (
        isset($_POST['enonce']) &&
        isset($_POST['categorie']) &&
        isset($_POST['correct']) &&
        isset($_POST['faux']) &&
        isset($_POST['difficulte'])
    ) {

        $reponses = [];
        $reponses[] = $_POST['correct']; 

        foreach ($_POST['faux'] as $f) {
            $reponses[] = $f;
        }

        $correctIndex = 1;

        EnigmaDAL::ajouterEnigme(
            $connexion,
            $_POST['enonce'],
            $_POST['categorie'],
            $_POST['difficulte'],
            $reponses,
            $correctIndex
        );

        echo "<p style='color:green;'>Énigme ajoutée avec succès!</p>";
    }
}

?>
<title>DarQuest - Ajout Énigma</title>

<?php
include 'include/header.php';
include 'include/nav.php';
?>

<main class="main">
    <div class="type-buttons">
        <button type="button" onclick="Form()">Ajouter une énigme</button>
    </div>

    <form action="ajoutEnigma.php" method="POST" id="formEnigme" enctype="multipart/form-data"
        style="display: none; padding: 4px;">
        <input type="hidden" name="type" value="formEnigme">
        <h2>Ajouter une énigme</h2>
        <label for="enonce">Énoncé : </label> <br>
        <textarea name="enonce" id="enonce" autofocus cols="40" rows="10" style="resize : none;"
            required></textarea><br>
        <label for="categorie">Catégorie :</label>
        <select id="categorie" name="categorie" required>
            <option value="" disabled selected>Choisir une catégorie</option>
            <option value="armure">Armure</option>
            <option value="arme">Arme</option>
            <option value="potion">Potion</option>
            <option value="sort">Sort</option>
            <option value="magie">Magie</option>
            <option value="monde">Monde</option>
        </select><br>
        <label>Réponses :</label><br>

        <div class="reponse-block">
            <input type="text" name="correct" placeholder="Bonne réponse" required>
        </div><br>

        <div class="reponse-block">
            <input type="text" name="faux[]" placeholder="Mauvaise réponse 1" required>
        </div><br>

        <div class="reponse-block">
            <input type="text" name="faux[]" placeholder="Mauvaise réponse 2" required>
        </div> <br>

        <div class="reponse-block">
            <input type="text" name="faux[]" placeholder="Mauvaise réponse 3" required>
        </div><br>

        <p>Difficulté ?</p>
        <input type="radio" id="facile" name="difficulte" value="f" checked>
        <label for="facile"> Facile </label> <br>
        <input type="radio" id="moyenne" name="difficulte" value="m">
        <label for="moyenne">Moyenne </label> <br>
        <input type="radio" id="difficile" name="difficulte" value="d">
        <label for="difficile">Difficile </label> <br>
        <input type="submit" value="Ajouter">
    </form>
</main>

<script>
    function Form() {
        const form = document.getElementById("formEnigme");

        form.style.display = "block";
    }
</script>

<?php include 'include/footer.php' ?>