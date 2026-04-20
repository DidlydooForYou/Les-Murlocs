<?php
require_once 'core/error-exception.php';
require_once 'core/initialization.php';
require_once 'DAL/Page.php';
require_once 'core/Database.php';

const ACTIVE_PAGE = Page::Inventaire;
doitEtreCo();
?>

<?php 
    include "include/html_setup.php";
?>

<link rel="stylesheet" href="public/css/inventaire.css">

<?php 
    include "include/header.php"; 
    include "include/nav.php";
?>

<?php
$inventaire = [];

if (isset($_SESSION['id'])) {
    $inventaire = Database::obtenir_inventaire_joueur($_SESSION['id']);
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