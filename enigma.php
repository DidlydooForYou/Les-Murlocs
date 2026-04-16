
<?php
require_once 'core/error-exception.php';
require_once 'source/initialization.php';
require_once 'source/Page.php';
doitEtreCo();
?>
<?php include 'include/html_setup.php' ?>

<title>DarQuest - Énigma</title>

<?php 
    include 'include/header.php';
    include 'include/nav.php'; 
?>

<main class="main" style="padding-left : 4px">
   <h3>Bienvenue à Énigma ! </h3>  
   <div>
    <div>
    <button class="buttonEnigma" onclick="afficherMage()" style="background-color: lightblue;">Devenir mage</button>
    <button class="buttonEnigma" onclick="afficherDifficulté()" style="background-color: lightblue;">Répondre pour gagner de l'argent</button>
    </div>
    <div id="questionMage" style="display: none;">
        <h3>Veuillez répondre à 3 questions pour devenir mage</h3>

    </div>
   </div>
</main>

<?php include 'include/footer.php' ?>
<script src="scripts/enigma.js"></script>
