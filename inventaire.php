<?php
require_once 'core/error-exception.php';
require_once 'source/initialization.php';
require_once 'source/Page.php';
require_once 'sql/bd.php';

const ACTIVE_PAGE = Page::Inventaire;
doitEtreCo();
?>

<?php 
    include "include/html_setup.php";
?>

<?php 
    include "include/header.php"; 
    include "include/nav.php";
?>

<style>
body {
    margin: 0;
    background-color: #f7f8f0;
}

.vitrine {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 25px;
    margin-bottom: 40px;
}

.main {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
    background-color: transparent;
}

.main h1,
.section-title {
    text-align: center;
}

.carte-item {
    width: 260px;
    background: #355c7d;
    border: 2px solid #1f3f59;
    color: white;
    padding: 14px;
    box-sizing: border-box;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    text-align: left;
    border-radius: 12px;
}
.carte-item p {
    word-wrap: break-word;
    overflow-wrap: break-word;
}

.carte-header {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
}

.quantite {
    font-weight: bold;
    color: #dcdcdc;
}

.carte-item img {
    width: 100%;
    height: 140px;
    object-fit: contain;
    background: #e5e5e5;
    margin-bottom: 10px;
}

.label {
    font-weight: bold;
    margin-top: 8px;
}

.btn-vendre {
    margin-top: 12px;
    padding: 8px;
    background: #6c94b3;
    border: 1px solid #1f3f59;
    color: white;
    border-radius: 8px;
    text-align: center;
    cursor: pointer;
}

.btn-vendre:hover {
    background: #5a819e;
}

.section-title {
    margin-top: 30px;
    margin-bottom: 10px;
}
</style>

<?php
$inventaire = [];

if (isset($_SESSION['id'])) {
    $inventaire = obtenir_inventaire_joueur($_SESSION['id']);
}





$groupes = [];
foreach ($inventaire as $item) {
    $groupes[$item['type']][] = $item;
}
?>

<main class="main">
    <h1 class="py-3 mt-3">Inventaire</h1>

    <?php if (!empty($inventaire)) { ?>

        <?php foreach ($groupes as $type => $items) { ?>

            <h2 class="section-title"><?= ucfirst($type) ?></h2>

            <div class="vitrine">

                <?php foreach ($items as $item) { ?>

                    <div class="carte-item">

                        <div>
                            <div class="carte-header">
                                <strong><?= htmlspecialchars($item['nomItem']) ?></strong>
                                <div class="quantite">x<?= $item['qtInventaire'] ?></div>
                            </div>

                            <img src="<?= htmlspecialchars($item['photoItem']) ?>">

                            <p><?= htmlspecialchars($item['description']) ?></p>

                            <?php if ($type === 'arme') { ?>
                                <div class="label">Efficacité</div>
                                <div><?= $item['efficacite'] ?? '' ?></div>

                                <div class="label">Type</div>
                                <div><?= $item['genreArme'] ?? '' ?></div>

                            <?php } elseif ($type === 'armure') { ?>
                                <div class="label">Matière</div>
                                <div><?= $item['matiere'] ?? '' ?></div>

                                <div class="label">Taille</div>
                                <div><?= $item['taille'] ?? '' ?></div>

                            <?php } elseif ($type === 'potion') { ?>
                                <div class="label">Effet</div>
                                <div><?= $item['effet'] ?? '' ?></div>

                                <div class="label">Durée</div>
                                <div><?= $item['duree'] ?? '' ?></div>

                            <?php } elseif ($type === 'sort') { ?>
                                <div class="label">Instantané</div>
                                <div><?= ($item['instantane'] ?? 0) ? 'Oui' : 'Non' ?></div>

                                <div class="label">Dommage</div>
                                <div><?= $item['dommage'] ?? '' ?></div>
                            <?php } ?>
                        </div>

                        <div class="btn-vendre">Vendre</div>

                    </div>

                <?php } ?>

            </div>

        <?php } ?>

    <?php } else { ?>

        <h3 style="text-align:center;">Votre inventaire est vide.</h3>
        <div style="text-align:center;">
            <a class="btn btn-boot mt-auto" href="index.php">Revenir</a>
        </div>

    <?php } ?>

</main>

<?php include_once INCLUDE_FILE . '/footer.php'; ?>