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
        $nouvelAlias = $alias;
        $erreurAlias = "";

        // Checks
        if(isset($_POST['alias'])){
            if(strlen($_POST['alias']) < 2 || strlen($_POST['alias']) > 50){
                $erreurAlias = $erreurAlias."L'alias doit contenir entre 2 et 50 charactères \n";
            }
            if(Database::alias_pris($_POST['alias'])){
                $erreurAlias = $erreurAlias."Cet alias est déjà pris";
            }
            if($erreurAlias === ""){
                $nouvelAlias = $_POST['alias'];
            }
        }

        
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
                <div class='donnee'><span class='label'>Nom :</span> <span
                        class='textDonees'><?= $infos['nom'] ?></span></div>
                <div class='donnee'><span class='label'>Prenom :</span> <span
                        class='textDonees'><?= $infos['prenom'] ?></span></div>
                <div class='donnee'><span class='label'>Email :</span> <span
                        class='textDonees'><?= $infos['email'] ?></span></div>
                <div class='donnee'><span class='label'>Alias :</span> <span class='textDonees'><?= $alias ?></span>
                </div>
            </div>
        </div>

        <div class="modif">
            <button class="btn btn-boot mt-auto" onclick="toggleDisplay('modif-container')">Modifier mon profil</button>

            <form id="modif-container" action="profil.php" method="POST">

                <button type="button" class="modif-subtitle" onclick="toggleDisplay('modif-alias')">Alias</button>
                <div id="modif-alias" class="modif-subcontainer">

                    <div class="modif-data">
                        <label class="modif-label"> Alias actuel :</label>
                        <div><?=$alias?></div>
                    </div>

                    <div class="modif-data">
                        <label for="alias" class="modif-label"> Nouvel alias :</label>
                        <input name="alias" type="text" class="modif-input" placeholder="Entrez votre nouvel alias"/>
                        
                        <?php if(isset($erreurAlias)) : ?>
                            <div style="color:red;"><?=$erreurAlias?></div>
                        <?php endif;?>
                    </div>

                    <button type="submit" class="btn btn-boot mt-auto">Sauvegarder</button>
                </div>


                <button type="button" class="modif-subtitle" onclick="toggleDisplay('modif-mdp')">Mot de Passe</button>
                <div id="modif-mdp" class="modif-subcontainer">
                    
                    <div class="modif-data">
                        <label for="current-mdp" class="modif-label"> Mot de passe actuel :</label>
                        <input name="current-mdp" type="password" class="modif-input" placeholder="Entrez votre mot de passe actuel"/>
                    </div>

                    <div class="modif-data">
                        <label for="nouv-mdp" class="modif-label"> Nouveau mot de passe :</label>
                        <input name="nouv-mdp" type="password" class="modif-input" placeholder="Entrez votre nouveau mot de passe"/>
                    </div>

                    <div class="modif-data">
                        <label for="nouv-mdp-con" class="modif-label"> Confirmer nouveau mot de passe :</label>
                        <input name="nouv-mdp-con" type="password" class="modif-input" placeholder="Confirmez votre nouveau mot de passe"/>
                        
                        <?php if(isset($erreurMdp)) : ?>
                            <div style="color:red;"><?=$erreurMdp?></div>
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
                        <input name="email" type="text" class="modif-input" placeholder="Entrez votre nouvelle adresse courriel"/>
                        
                        <?php if(isset($erreurCourriel)) : ?>
                            <div style="color:red;"><?=$erreurCourriel?></div>
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
                        <input name="nom" type="text" class="modif-input" placeholder="Entrez votre nouveau nom"/>
                        
                        <?php if(isset($erreurNom)) : ?>
                            <div style="color:red;"><?=$erreurNom?></div>
                        <?php endif;?>
                    </div>


                    <div class="modif-data">
                        <label class="modif-label"> Prénom actuel :</label>
                        <div><?=$infos['prenom']?></div>
                    </div>

                    <div class="modif-data">
                        <label for="prenom" class="modif-label"> Nouveau prénom :</label>
                        <input name="prenom" type="text" class="modif-input" placeholder="Entrez votre nouveau prénom"/>
                        
                        <?php if(isset($erreurPrenom)) : ?>
                            <div style="color:red;"><?=$erreurPrenom?></div>
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
                        
                        <?php if(isset($erreurPhotos)) : ?>
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