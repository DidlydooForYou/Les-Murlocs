<?php 
    include 'include/php_setup.php';
    include_once "DAL/EnigmaDAL.php";
    include_once "DAL/JoueurDAL.php";
    doitEtreCo();

    $connexion = Database::getConnexion();
    $infos = JoueurDAL::getInfos($connexion,$_SESSION['id']);
    $alias = Database::obtenir_alias($_SESSION['id']);

    if(IS_POST){
        // Init
        $erreurAlias = "";
        $erreurMdp = "";
        $erreurCourriel = "";
        $erreurNom = "";
        $erreurPrenom = "";

        #region Alias Checks
        if(isset($_POST['alias']) && $_POST['alias'] != ""){
            if(strlen($_POST['alias']) < 2 || strlen($_POST['alias']) > 40){
                $erreurAlias = $erreurAlias."L'alias doit contenir entre 2 et 40 charactères <br>";
            }
            if(Database::alias_pris($_POST['alias'])){
                $erreurAlias = $erreurAlias."Cet alias est déjà pris";
            }
            if($erreurAlias === ""){
                JoueurDAL::modifAlias($connexion,$_SESSION['id'], $_POST['alias']);
            }
        }
        #endregion

        #region MDP Checks
        $mdpAllParamsSet = 0;
        $mdpCorrect;

        if(isset($_POST['current-mdp']) && $_POST['current-mdp'] != "") {
            $mdpAllParamsSet++;

            // Verif
            

            $mdpCorrect = JoueurDAL::checkPassword($connexion, $_SESSION['id'], $_POST['current-mdp']);


            if(!$mdpCorrect) { 
                $erreurMdp = $erreurMdp."Le mot de passe saisi est incorrect <br>";
            }  
        }

        if(isset($_POST['nouv-mdp']) && $_POST['nouv-mdp'] != "") {
            $mdpAllParamsSet++;

            // Verif
            if (strlen($_POST['nouv-mdp']) < 8 || strlen($_POST['nouv-mdp']) > 50){
                $erreurMdp = $erreurMdp."Votre nouveau mot de passe doit contenir entre 8 et 50 charactères <br>";
            }
        }

        if(isset($_POST['nouv-mdp-con']) && $_POST['nouv-mdp-con'] != "") {
            $mdpAllParamsSet++;

            // Verif
            if($_POST['nouv-mdp-con'] != $_POST['nouv-mdp']){
                $erreurMdp = $erreurMdp."Les nouveaux mots de passe doivent être identiques <br>";
            }
        }
        
        if($mdpAllParamsSet > 0 && $mdpAllParamsSet < 3){
            $erreurMdp = "Veuillez compléter tous les champs <br>".$erreurMdp;
        }
        elseif($mdpAllParamsSet == 3 && $erreurMdp === ""){
            JoueurDAL::modifPasword($connexion, $_SESSION['id'], $_POST['nouv-mdp']);
        }
        #endregion

        #region Checks Adresse Courriel
        if(isset($_POST['email']) && $_POST['email'] != ""){
            if(strlen($_POST['email']) < 6 || strlen($_POST['email']) > 60){
                $erreurCourriel = $erreurCourriel."L'adresse courriel devrait être entre 6 et 60 charactères<br>";
            }
            if(Database::email_pris($_POST['email'])){
                $erreurCourriel = $erreurCourriel."Cette adresse courriel possède déjà un compte";
            }
            if($erreurCourriel === ""){
                JoueurDAL::modifEmail($connexion, $_SESSION['id'], $_POST['email']);
            }
        }
        #endregion
        
        #region Checks Nom
        if(isset($_POST['nom']) && $_POST['nom'] != ""){
            if(strlen($_POST['nom']) < 2 || strlen($_POST['nom']) > 40){
                $erreurNom = $erreurNom."Votre nom devrait être entre 2 et 40 charactères<br>";
            }
            if($erreurCourriel === ""){
                JoueurDAL::modifNom($connexion, $_SESSION['id'], $_POST['nom']);
            }
        }
        #endregion

        #region Checks Prenom
        if(isset($_POST['prenom']) && $_POST['prenom'] != ""){
            if(strlen($_POST['prenom']) < 2 || strlen($_POST['prenom']) > 40){
                $erreurPrenom = $erreurPrenom."Votre prénom devrait être entre 2 et 40 charactères<br>";
            }
            if($erreurCourriel === ""){
                JoueurDAL::modifPrenom($connexion, $_SESSION['id'], $_POST['prenom']);
            }
        }
        #endregion

        #region Checks Images
        if (isset($_FILES['url']) && $_FILES['url']['name'] != '') {

            if ($_FILES['url']['error'] === UPLOAD_ERR_NO_FILE) {
                $chemin = "public/images/profilBase.webp";
            } else {
                $repertoire = 'public/images/';
                $extension = strtolower(pathinfo($_FILES['url']['name'], PATHINFO_EXTENSION));
                if ($extension != "avif") {
                    $chemin = "public/images/profilBase.webp";
                } else {
                    $chemin = $repertoire . $_FILES['url']['name'];
                    if (move_uploaded_file($_FILES['url']['tmp_name'], $chemin)) {
                    } else {
                        $validite = false;
                    }
                }
            }
            JoueurDAL::modifPhotoProfil($connexion,$_SESSION['id'], $chemin);
        }
        #endregion
    }
?>

<link rel="stylesheet" href="public/css/profil.css">
<title>DarQuest - Profil</title>

<?php
include 'include/html_setup.php';
include 'include/header.php';
include 'include/nav.php';

include_once "DAL/JoueurDAL.php";

$connexion = Database::getConnexion();

$idProfil = isset($_GET['id']) ? intval($_GET['id']) : $_SESSION['id'];

$infos = JoueurDAL::getInfos($connexion, $idProfil);
$alias = Database::obtenir_alias($idProfil);

$inventaire = Database::obtenir_inventaire_joueur($idProfil);
$groupes = [];

foreach ($inventaire as $item) {
    if ($item['qtInventaire'] > 0) {
        $groupes[$item['type']][] = $item;
    }
}
?>
<main class="main">
    <div class="profilMain">
        <div class="profilRow">
            <img class="imageProfil" src="<?= $infos['photoProfil'] ?>" alt="<?= $alias ?>">

            <div class="donnees">
                <div class='donnee'>
                    <span class='label'>Nom :</span> 
                    <span class='textDonees'><?= $infos['nom'] ?></span>
                </div>
                <div class='donnee'>
                    <span class='label'>Prenom :</span> 
                    <span class='textDonees'><?= $infos['prenom'] ?></span>
                </div>
                <div class='donnee'>
                    <span class='label'>Email :</span> 
                    <span class='textDonees'><?= $infos['email'] ?></span>
                </div>
                <div class='donnee'>
                    <span class='label'>Alias :</span> 
                    <span class='textDonees'><?= $alias ?></span>
                </div>
                <div class="donnee" style="border-bottom:none; justify-content: end;">
                    <button class="btn btn-boot mt-auto" onclick="toggleDisplay('modif-container')">Modifier mon profil</button>
                </div>
            </div>
        </div>

        <div class="modif">

            <form id="modif-container" action="profil.php" method="POST" enctype="multipart/form-data">

                <button type="button" class="modif-subtitle" onclick="toggleDisplay('modif-alias')">Alias</button>
                <div id="modif-alias" class="modif-subcontainer">

                    <div class="modif-data">
                        <label class="modif-label"> Alias actuel :</label>
                        <div><?=$alias?></div>
                    </div>

                    <div class="modif-data">
                        <label for="alias" class="modif-label"> Nouvel alias :</label>
                        <input name="alias" type="text" class="modif-input" placeholder="Entrez votre nouvel alias" minlength="2" maxlength="50"/>
                        
                        <?php if(isset($erreurAlias) && $erreurAlias != "") : ?>
                            <div style="color:red;"><?=$erreurAlias?></div>
                            <script>
                                document.getElementById('modif-alias').style.display = "block";
                                document.getElementById('modif-container').style.display = "block";
                            </script>
                        <?php endif;?>
                    </div>

                    <button type="submit" class="btn btn-boot mt-auto">Sauvegarder</button>
                </div>


                <button type="button" class="modif-subtitle" onclick="toggleDisplay('modif-mdp')">Mot de Passe</button>
                <div id="modif-mdp" class="modif-subcontainer">
                    
                    <div class="modif-data">
                        <label for="current-mdp" class="modif-label"> Mot de passe actuel :</label>
                        <input name="current-mdp" type="password" class="modif-input" placeholder="Entrez votre mot de passe actuel" />
                    </div>

                    <div class="modif-data">
                        <label for="nouv-mdp" class="modif-label"> Nouveau mot de passe :</label>
                        <input name="nouv-mdp" type="password" class="modif-input" placeholder="Entrez votre nouveau mot de passe" minlength="8" maxlength="50"/>
                    </div>

                    <div class="modif-data">
                        <label for="nouv-mdp-con" class="modif-label"> Confirmer nouveau mot de passe :</label>
                        <input name="nouv-mdp-con" type="password" class="modif-input" placeholder="Confirmez votre nouveau mot de passe" minlength="8" maxlength="50"/>
                        
                        <?php if(isset($erreurMdp) && $erreurMdp != "") : ?>
                            <div style="color:red;"><?=$erreurMdp?></div>
                            <script>
                                document.getElementById('modif-mdp').style.display = "block";
                                document.getElementById('modif-container').style.display = "block";
                            </script>
                        <?php endif;?>
                    </div>

                    <button type="submit" class="btn btn-boot mt-auto">Sauvegarder</button>
                </div>

                <button type="button" class="modif-subtitle" onclick="toggleDisplay('modif-courriel')">Adresse Courriel</button>
                <div id="modif-courriel" class="modif-subcontainer">

                    <div class="modif-data">
                        <label class="modif-label"> Adresse courriel actuelle :</label>
                        <div><?=$infos['email']?></div>
                    </div>

                    <div class="modif-data">
                        <label for="email" class="modif-label"> Nouvelle adresse courriel :</label>
                        <input name="email" type="email" class="modif-input" placeholder="Entrez votre nouvelle adresse courriel" minlength="6" maxlength="254"/>
                        
                        <?php if(isset($erreurCourriel) && $erreurCourriel != "") : ?>
                            <div style="color:red;"><?=$erreurCourriel?></div>
                            <script>
                                document.getElementById('modif-courriel').style.display = "block";
                                document.getElementById('modif-container').style.display = "block";
                            </script>
                        <?php endif;?>
                    </div>

                    <button type="submit" class="btn btn-boot mt-auto">Sauvegarder</button>
                </div>


                <button type="button" class="modif-subtitle" onclick="toggleDisplay('modif-nom')">Nom complet</button>
                <div id="modif-nom" class="modif-subcontainer">

                    <div class="modif-data">
                        <label class="modif-label"> Nom actuel :</label>
                        <div><?=$infos['nom']?></div>
                    </div>

                    <div class="modif-data">
                        <label for="nom" class="modif-label"> Nouveau nom :</label>
                        <input name="nom" type="text" class="modif-input" placeholder="Entrez votre nouveau nom" minlength="2" maxlength="25"/>
                        
                        <?php if(isset($erreurNom) && $erreurNom != "") : ?>
                            <div style="color:red;"><?=$erreurNom?></div>
                            <script>
                                document.getElementById('modif-nom').style.display = "block";
                                document.getElementById('modif-container').style.display = "block";
                            </script>
                        <?php endif;?>
                    </div>


                    <div class="modif-data">
                        <label class="modif-label"> Prénom actuel :</label>
                        <div><?=$infos['prenom']?></div>
                    </div>

                    <div class="modif-data">
                        <label for="prenom" class="modif-label"> Nouveau prénom :</label>
                        <input name="prenom" type="text" class="modif-input" placeholder="Entrez votre nouveau prénom" minlength="2" maxlength="25"/>
                        
                        <?php if(isset($erreurPrenom) && $erreurPrenom != "") : ?>
                            <div style="color:red;"><?=$erreurPrenom?></div>
                            <script>
                                document.getElementById('modif-nom').style.display = "block";
                                document.getElementById('modif-container').style.display = "block";
                            </script>
                        <?php endif;?>
                    </div>

                    <button type="submit" class="btn btn-boot mt-auto">Sauvegarder</button>
                </div>


                <button type="button" class="modif-subtitle" onclick="toggleDisplay('modif-pdp')">Photo de profil</button>
                <div id="modif-pdp" class="modif-subcontainer">

                    <div class="modif-data">
                        <label class="modif-label"> Photo de profil actuelle :</label><br>
                        <img class ="imageProfil" src='<?=$infos["photoProfil"]?>' alt="<?=$alias?>">
                    </div>

                    <div class="modif-data">
                        <label for="prenom" class="modif-label"> Nouvelle photo de profil :</label><br>

                        <label for="url" class="upload-btn">Choisir une image</label>
                        <input type="file" id="url" name="url" accept=".avif,image/avif">

                        <div class="file-name" id="file-name">Aucune image sélectionnée</div>
                       <div class="modif-image">
                            <img id="pfp-preview" class="pfp-preview" style="display:none;">
                        </div>
                        
                        <?php if(isset($erreurPhoto) && $erreurPhoto) : ?>
                            <div style="color:red;"><?=$erreurPhoto?></div>
                        <?php endif;?>
                    </div>

                    <button type="submit" class="btn btn-boot mt-auto">Sauvegarder</button>
                </div>
            </form>
        </div>

        <div class="vitrine-profil">
            <?php foreach ($groupes as $type => $items) { ?>
                <?php foreach ($items as $item) { ?>
                    <div class="profil-item">
                        <img src="<?= htmlspecialchars($item['photoItem']) ?>">
                        <div class="carte-header">
                            <strong><?= htmlspecialchars($item['nomItem']) ?></strong>
                            <div class="quantite">x<?= $item['qtInventaire'] ?></div>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
        </div>


    </div>

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

        function toggleDisplay(elementId){
            let element = document.getElementById(elementId);
            let elementStyle = window.getComputedStyle(element);
            
            if(elementStyle.display == "none"){
                element.style.display = "block";
            }
            else {
                element.style.display = "none";
            }
        }
    </script>
</main>


<?php include 'include/footer.php' ?>