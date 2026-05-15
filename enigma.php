<?php 
    include 'include/html_setup.php';
    require_once 'DAL/EnigmaDAL.php';
    doitEtreCo();


    $connexion = Database::getConnexion();

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $erreur = false;
    if (!isset($_POST['reponse']) && !isset($_POST['reponseMagie'])) {
        $erreur = true;
    } else {
        if ($erreur) {
           
        }
        else {
        if ($_POST['formType'] === "mage") {
            $reponse = $_POST['reponseMagie'];
            var_dump($reponse, $_SESSION['ReponseCorrectMagie']);
            if ($reponse == $_SESSION['ReponseCorrectMagie']) {
                if (!isset($_SESSION['bonneMage'])) {
                    $_SESSION['bonneMage'] = 1;
                } else {
                    $_SESSION['bonneMage']++;
                }

                $message = "Félicitation, c'est une bonne réponse, vous êtes à " . $_SESSION['bonneMage'] . " sur 3 pour devenir mage !";
                $continuation = true;
                EnigmaDAL::bonneReponse($connexion, $_SESSION['id'], $_SESSION['difficulte']);
            } else {
                $_SESSION['bonneMage'] = 0;
                $message = "Échec ! Veuillez recommencer le questionnaire pour devenir mage";
                $continuation = false;
                EnigmaDAL::mauvaiseReponse($connexion, $_SESSION['id'], $_SESSION['difficulte']);
            }

            if ($_SESSION['bonneMage'] >= 3) {
                EnigmaDAL::devenirMage($connexion, $_SESSION['id']);
                $_SESSION['mage'] = true;
                header("Location:" . $_SERVER['PHP_SELF']);
                exit;
            }

        } else if ($_POST['formType'] === "argent") {
            $difficulte = $_SESSION['difficulte'];
             $reponse = $_POST['reponse'];
            switch ($difficulte) {
                case "f":
                    $difficulteString = "10 pièces de bronze";
                    $perteVieString = "3 points de vie";
                    break;
                case 'm':
                    $difficulteString = "10 pièces d'argent";
                    $perteVieString = "6 points de vie";
                    break;
                case 'd':
                    $difficulteString = "10 pièces d'or";
                    $perteVieString = "10 points de vie";

                    break;
            }
            if ($reponse == $_SESSION['ReponseCorrect']) {


                $message = "Félications ! C'est une bonne réponse, vous recevez " . $difficulteString;
                EnigmaDAL::bonneReponse($connexion, $_SESSION['id'], $difficulte);
            } else {
                $message = "Malheureusement, c'est une mauvaise réponses, vous avez perdu " . $perteVieString;
                EnigmaDAL::mauvaiseReponse($connexion, $_SESSION['id'], $difficulte);
            }
        }
    }
    }


}
 $pdv = JoueurDAL::selectPdv($connexion, $_SESSION['id']);
        $pdv = $pdv['PointsDeVie'];
  if ($pdv == 0) {
            header('Location:mort.php');
            exit;
        }

?>


<title>DarQuest - Énigma</title>

<?php
include 'include/header.php';
include 'include/nav.php';
?>
<<<<<<< Updated upstream
=======
<script src="scripts/enigma.js"></script>
<link rel="stylesheet" href="public/css/enigma.css">
<main class="main">
    <div class="enigma-container">
        <div class="enigma-title">Bienvenue sur Énigma !</div>
        <?php
        $pdv = JoueurDAL::selectPdv($connexion, $_SESSION['id']);
        $pdv = $pdv['PointsDeVie'];
        if (isset($_SESSION['bonneMage']) && $_SESSION['bonneMage'] >= 3) {
            echo "<p>Félicitations, vous avez répondu à 3 bonnes réponses de mage, vous devenez mage !";
            $_SESSION['bonneMage'] = 0;
        }
>>>>>>> Stashed changes

<main class="main" style="padding-left : 4px">
    <h3>Bienvenue à Énigma ! </h3>

    <?php
    if (isset($_SESSION['bonneMage']) && $_SESSION['bonneMage'] >= 3) {
        echo "<p>Félicitations, vous avez répondu à 3 bonnes réponses de mage, vous devenez mage !";
        $_SESSION['bonneMage'] = 0;
    }

    ?>
    <div>
        <div>
            <?php
            if (!IS_MAGE) {
                echo "<button class='buttonEnigma' onclick='afficherMage()' style='background-color: lightblue;'>Devenir mage</button>";
            }

            ?>
            <button class="buttonEnigma" onclick="afficherDifficulté()" style="background-color: lightblue;">Répondre
                pour gagner de l'argent</button>
        </div>
        <div id="questionMage" style="<?php if (isset($continuation) && $continuation) {
            echo "display : block;";
        } else {
            echo "display : none;";
        }

        ?>">
            <h3>Veuillez répondre à 3 questions pour devenir mage</h3>
            <form action="enigma.php" method="POST">
                <input type="hidden" name="formType" value="mage">
                <?php

                $questions = EnigmaDAL::selectAllMageQuestion($connexion);
                shuffle($questions);
                $questionRandom = array_pop($questions);
                $id = $questionRandom['idQuestion'];
                $_SESSION['idQuestion'] = $id;
                $reponses = EnigmaDAL::selectResponses($connexion, $id);
                $enonce = $questionRandom['enonce'];
                $difficulte = $questionRandom['difficulte'];
                $_SESSION['difficulte'] = $difficulte;
                switch ($difficulte) {
                    case 'f':
                        $difficulte = 'facile';
                        break;
                    case 'm':
                        $difficulte = 'moyenne';
                        break;
                    case 'd':
                        $difficulte = 'difficile';
                        break;

                }
                $categorie = $questionRandom['categorie'];
                echo "<p> Difficulté de la question : $difficulte </p>";
                echo "<p> Catégorie : $categorie </p>";
                echo "<p>$enonce</p>";
                //  var_dump($enonce,$difficulte,$categorie);
                shuffle($reponses);
                foreach ($reponses as $reponse) {
                    $enonceQuestion = $reponse['reponse'];
                    $idReponse = $reponse['idReponse'];
                    if ($reponse['correct'] === 1) {
                        $_SESSION['ReponseCorrectMagie'] = $idReponse;
                    }
                    echo "<input type='radio' value='$idReponse' name='reponseMagie'>";
                    echo "<label style='padding-left : 8px;' for='$idReponse'> $enonceQuestion </label> <br>";
                }

                ?>
                <input type="submit">
            </form>

        </div>
        <div id="questionArgent" style="display: none;">
            <h3>Répondre à la question pour gagner de l'argent</h3>
            <form action="enigma.php" method="POST">
                <input type="hidden" name="formType" value="argent">
                <?php
                $connexion = Database::getConnexion();
                $questions = EnigmaDAL::selectAll($connexion);
                shuffle($questions);
                $questionRandom = array_pop($questions);
                $id = $questionRandom['idQuestion'];
                $_SESSION['idQuestion'] = $id;
                $reponses = EnigmaDAL::selectResponses($connexion, $id);
                $enonce = $questionRandom['enonce'];
                $difficulte = $questionRandom['difficulte'];
                $_SESSION['difficulte'] = $difficulte;
                switch ($difficulte) {
                    case 'f':
                        $difficulte = 'facile';
                        break;
                    case 'm':
                        $difficulte = 'moyenne';
                        break;
                    case 'd':
                        $difficulte = 'difficile';
                        break;

                }
                $categorie = $questionRandom['categorie'];
                echo "<p> Difficulté de la question : $difficulte </p>";
                echo "<p> Catégorie : $categorie </p>";
                echo "<p>$enonce</p>";
                shuffle($reponses);
                foreach ($reponses as $reponse) {
                    $enonceQuestion = $reponse['reponse'];
                    $idReponse = $reponse['idReponse'];
                    if ($reponse['correct'] === 1) {
                        $_SESSION['ReponseCorrect'] = $idReponse;
                    }
                    echo "<input type='radio' value='$idReponse' name='reponse'>";
                    echo "<label style='padding-left : 8px;' for='$idReponse'> $enonceQuestion </label> <br>";
                }
                ?>
                <input type="submit">
            </form>
        </div>
    </div>
    <?php
    if (isset($erreur)) {
        if ($erreur) {
            echo "<p style='color:red'> Erreur </p>";
        }
    }
    if (isset($message)) {
        echo "<p> $message </p>";
    }

    ?>
</main>

<?php include 'include/footer.php' ?>
<script src="scripts/enigma.js"></script>