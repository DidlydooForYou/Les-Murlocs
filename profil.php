<?php
include 'include/php_setup.php';
include_once "DAL/EnigmaDAL.php";
doitEtreCo();
?>

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

<link rel="stylesheet" href="public/css/profil.css">

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

        <h2 class="section-title" style="color:#c9a86a;">Inventaire</h2>

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
</main>


<?php include 'include/footer.php' ?>