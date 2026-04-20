<?php
include 'include/html_setup.php';
require_once 'DAL/EnigmaDAL.php';
require_once 'DAL/JoueurDAL.php';
doitEtreCo();
doitEtreEnVie();

$connexion = Database::getConnexion();


if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $erreur = false;
    if (!isset($_POST['reponse']) && !isset($_POST['reponseMagie'])) {
        $erreur = true;
    } else {
        if ($erreur) {

        } else {

            if ($_POST['formType'] === "mage") {
                $reponse = $_POST['reponseMagie'];
                if ($reponse == $_SESSION['ReponseCorrectMagie']) {
                    if (!isset($_SESSION['bonneMage'])) {
                        $_SESSION['bonneMage'] = 1;
                    } else {
                        $_SESSION['bonneMage']++;
                    }

                    $message = "Félicitations, c'est une bonne réponse, vous êtes à " . $_SESSION['bonneMage'] . " sur 3 pour devenir mage !";
                    $continuation = true;
                    $nbrDifficile = EnigmaDAL::nbrQuestionDifficile($connexion, $_SESSION['id']);
                    if ($nbrDifficile['bonneReponseDifficile'] == 2) {
                        $messageBonus = "Félicitations, vous avez répondu à trois questions difficiles d'affilées, vous gagnez 100 pièces d'or en plus !";
                    }
                    EnigmaDAL::bonneReponse($connexion, $_SESSION['id'], 'd');

                } else {
                    $_SESSION['bonneMage'] = 0;
                    $message = "Échec ! Veuillez recommencer le questionnaire pour devenir mage";
                    $continuation = false;
                    EnigmaDAL::mauvaiseReponse($connexion, $_SESSION['id'], 'd');
                }

                if ($_SESSION['bonneMage'] >= 3) {
                    EnigmaDAL::bonneReponse($connexion, $_SESSION['id'], 'd');
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
                    if ($difficulte === 'd') {
                        $nbrDifficile = EnigmaDAL::nbrQuestionDifficile($connexion, $_SESSION['id']);
                        if ($nbrDifficile['bonneReponseDifficile'] == 2) {
                            $messageBonus = "Félicitations, vous avez répondu à trois questions difficiles d'affilées, vous gagnez 100 pièces d'or en plus !";
                        }
                    }
                    EnigmaDAL::bonneReponse($connexion, $_SESSION['id'], $difficulte);
                } else {
                    $message = "Malheureusement, c'est une mauvaise réponse, vous avez perdu " . $perteVieString;
                    EnigmaDAL::mauvaiseReponse($connexion, $_SESSION['id'], $difficulte);
                }
            }
        }
    }


}


?>


<title>DarQuest - Énigma</title>

<?php
include 'include/header.php';
include 'include/nav.php';
?>
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

        ?>
        <div>
            <div>
                <?php
                if (!IS_MAGE) {
        
                    echo "<button class='buttonEnigma' onclick='afficherMage()'>Devenir mage</button>";
                }

                ?>
                <button class="buttonEnigma" onclick="afficherDifficulté()">Répondre
                    pour gagner de l'argent</button>
            </div>
            <div id="questionMage" style="<?php if (isset($continuation) && $continuation) {
                echo "display : block;";
            } else {
                echo "display : none;";
            }

            ?>">
                <h3>Veuillez répondre à 3 questions pour devenir mage</h3>
                <form action="enigma.php" onsubmit="return submitEnigma()" method="POST">
                    <input type="hidden" name="formType" value="mage">
                    <?php

                    $questions = EnigmaDAL::selectAllMageQuestion($connexion);
                    shuffle($questions);
                    $questionRandom = array_pop($questions);
                    $id = $questionRandom['idQuestion'];
                    $_SESSION['idQuestion'] = $id;
                    $reponses = EnigmaDAL::selectResponses($connexion, $id);
                    $enonce = $questionRandom['enonce'];
                    $difficulte = "difficile";
                    $categorie = $questionRandom['categorie'];
                    echo "<p style='font-weight : bold;'> Difficulté de la question : <span style='font-weight : normal;'>$difficulte</span> </p>";
                    echo "<p style='font-weight : bold;'> Catégorie : <span style='font-weight : normal;'>$categorie</span></p>";
                    echo "<p>$enonce</p>";
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
                    if (isset($attentionVie)) {
                        if ($attentionVie) {
                            echo "<p><span class='attentionVie'> ATTENTION RÉPONDRE MAL À CETTE QUESTION MET VOS P.V À 0 </span></p>";
                        }
                    }

                    ?>
                    <input class="buttonEnvoyer" type="submit">
                </form>

            </div>
            <div id="questionArgent" style="display: none;">
                <h3>Répondre à la question pour gagner de l'argent</h3>
                <form action="enigma.php" method="POST" onsubmit="return submitEnigma()">
                    <input type="hidden" name="formType" value="argent">

                    <?php
                    $connexion = Database::getConnexion();
                    $questions = EnigmaDAL::selectAll($connexion);
                    shuffle($questions);
                    //var_dump($pdv);
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
                            $pdv <=3 ? $attentionVie = true : $attentionVie = false;
                            break;
                        case 'm':
                            $difficulte = 'moyenne';
                           $pdv <=6 ? $attentionVie = true : $attentionVie = false;
                            break;
                        case 'd':
                            $difficulte = 'difficile';
                            $pdv <=10 ? $attentionVie = true : $attentionVie = false;
                            break;

                    }
                    $categorie = $questionRandom['categorie'];
                    echo "<p style='font-weight : bold;'> Difficulté de la question : <span style='font-weight : normal;'>$difficulte</span> </p>";
                    echo "<p style='font-weight : bold;'> Catégorie : <span style='font-weight : normal;'>$categorie</span></p>";
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
                    if (isset($attentionVie)) {
                        if ($attentionVie) {
                            echo "<p><span class='attentionVie'> ATTENTION RÉPONDRE MAL À CETTE QUESTION MET VOS P.V À 0 </span></p>";
                        }
                    }
                    ?>
                    <input class="buttonEnvoyer" type="submit">
                </form>
            </div>
        </div>
        <?php
        if (isset($erreur)) {
            if ($erreur) {
                echo "<p style='color:red'> Erreur, vous n'avez pas choisi une réponse, veuillez recommencer </p>";
            }
        }
        if (isset($message)) {
            echo "<p> $message </p>";
        }
        if (isset($messageBonus)) {
            echo "<p> $messageBonus </p>";
        }
        


        ?>
        <p id="remplir" style="color : red;"></p>
    </div>
</main>

<?php include 'include/footer.php' ?>
<script src="scripts/enigma.js"></script>