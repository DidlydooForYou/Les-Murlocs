<?php
include 'include/php_setup.php';
require_once 'DAL/EnigmaDAL.php';

if (!IS_ADMIN) {
    header('Location:accesRefuse.php');
    exit;
}

$connexion = Database::getConnexion();

if ($_SERVER['REQUEST_METHOD'] === "POST" && $_POST['type'] === "formEnigme") {

    if(isset($_POST['typeResponse']) && $_POST['typeResponse'] == "vraiFaux"){
        if(isset($_POST['correct']) && $_POST['correct'] == "Vrai"){
            $vraiFauxInverse = "Faux";
        } else {
            $vraiFauxInverse = "Vrai";
        }
    }

    if (
        isset($_POST['enonce']) &&
        isset($_POST['categorie']) &&
        isset($_POST['correct']) &&
        (isset($_POST['faux']) || isset($vraiFauxInverse) ) &&
        isset($_POST['difficulte'])
    ) {

        $reponses = [];
        $reponses[] = $_POST['correct'];

        if(isset($_POST['faux'])){
            foreach ($_POST['faux'] as $f) {
                $reponses[] = $f;
            }
        } else {
            $reponses[] = $vraiFauxInverse;
        }


        $correctIndex = 1;
        if ($_POST['categorie'] == "magie") {
            $difficulte = 'd';
        } else {
            $difficulte = $_POST['difficulte'];
        }

        EnigmaDAL::ajouterEnigme(
            $connexion,
            $_POST['enonce'],
            $_POST['categorie'],
            $difficulte,
            $reponses,
            $correctIndex
        );

        $successMessage = "Énigme ajoutée avec succès!";
    }
}

?>

<link rel="stylesheet" href="public/css/enigma.css">
<title>DarQuest - Ajout Énigma</title>

<?php
include 'include/html_setup.php';
include 'include/header.php';
include 'include/nav.php';
?>

<main class="main">
    <div class="enigmaAjout-container">
        <div class="type-buttons">
            <button class="btn btn-boot mt-auto" type="button" onclick="Form()">Ajouter une énigme</button>
        </div>

        <form action="ajoutEnigma.php" method="POST" id="formEnigme" enctype="multipart/form-data" style="display: none; padding: 4px;">
            
            <input type="hidden" name="type" value="formEnigme">
            
            <h2>Ajouter une énigme</h2>
            
            <label for="enonce">Énoncé : </label>
            
            <textarea name="enonce" id="enonce" autofocus cols="40" rows="10" style="resize : none;"required></textarea>
            <br>
            
            <label for="categorie">Catégorie :</label>
            
            <select id="categorie" name="categorie" required>
                <option value="" disabled selected>Choisir une catégorie</option>
                <option value="armure">Armure</option>
                <option value="arme">Arme</option>
                <option value="potion">Potion</option>
                <option value="sort">Sort</option>
                <option value="magie">Magie</option>
                <option value="monde">Monde</option>
            </select>
            <br>

            <label for="type">Type :</label>
            
            <select id="type" name="typeResponse" required onchange="ChangerType(this.value)">
                <option value="" disabled>Choisir un type de réponse</option>
                <option value="choix" selected>Choix de réponse</option>
                <option value="vraiFaux">Vrai / Faux</option>
            </select>
            <br>
            
            
            <div id="anwsers">
            <?php if(isset($_GET['typeResponse']) && $_GET['typeResponse'] == "vraiFaux") :?>
                <label>Réponse :</label>

                <select name="correct" required>
                    <option value="Vrai">Vrai</option>
                    <option value="Faux">Faux</option>
                </select>
            </div>

            <?php else : ?>
                <label>Réponses :</label>
                <div class="reponse-block">
                    <input type="text" name="correct" placeholder="Bonne réponse" required>
                </div>

                <div id="mauvaise-reponses">

                </div>

            <!---->
                <div class="reponse-block">
                    <input id="addReponse" type="text" onfocus="AjouterReponse()" placeholder="Ajouter une mauvaise réponse" required>
                </div>
            <!---->

                

                <!--
                <div class="reponse-block">
                    <input type="text" name="faux[]" placeholder="Mauvaise réponse 2" required>
                </div> 

                <div class="reponse-block">
                    <input type="text" name="faux[]" placeholder="Mauvaise réponse 3" required>
                </div>
                -->

            </div>
            <?php endif; ?>
            


            <label>Difficulté : </label>
            <label for="facile"> Facile </label>
            <input type="radio" id="facile" name="difficulte" value="f" checked>
            <label for="moyenne">Moyenne </label>
            <input type="radio" id="moyenne" name="difficulte" value="m">
            <label for="difficile">Difficile </label>
            <input type="radio" id="difficile" name="difficulte" value="d"><br><br>
            <input type="submit" value="Ajouter">
        </form>
    </div>
    <?php if (!empty($successMessage)): ?>
        <p class="success-message">
            <?= $successMessage ?>
        </p>
    <?php endif; ?>
</main>

<script>
    let ajoutReponse = document.getElementById("mauvais-rep-input");
    ajoutReponse.addEventListener('blur');


    function ChangerType(type) {
        $.ajax({
            url: "ajoutEnigma.php?typeResponse="+type,
            success: function(response) {
                console.log('refresh success');

                let html = $("<div>").html(response);

                $('#anwsers').html(html.find('#anwsers').html());
            }
        });
    }

    function AjouterReponse() {
        // Prends le input value -> Ajoute un nouvel input avec la bonne valeur
        /**/
        input = document.getElementById("addReponse");
        if(input.hasAttribute("required"))
            input.removeAttribute("required");

        /*
        if(input.value != null && input.value != ""){
            container.innerHTML += `
                <div class="reponse-block">
                    <input type="text" name="faux[]" placeholder="Mauvaise réponse" required value="${input.value}">
                </div>`;

            input.value = "";
        }
        /**/
        $('#mauvaise-reponses').append(`
                <div class="reponse-block">
                    <input type="text" name="faux[]" placeholder="Mauvaise réponse" required>
                </div>`);
        
        newElement = document.querySelector('#mauvaise-reponses > div:last-child > input');

        setTimeout(() => {
            newElement.focus();
        }, 0);

        
        
        //container.lastElementChild.value = "Here";
    }

    function Form() {
        const form = document.getElementById("formEnigme");

        form.style.display = "block";
    }
</script>

<?php include 'include/footer.php' ?>