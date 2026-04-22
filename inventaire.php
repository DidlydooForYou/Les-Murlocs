<?php
require_once 'core/error-exception.php';
require_once 'core/initialization.php';
require_once 'DAL/Page.php';
require_once 'core/Database.php';
require_once 'DAL/InventoryDAL.php';

const ACTIVE_PAGE = Page::Inventaire;
doitEtreCo();

if (isset($_POST['vendre']) && isset($_POST['idItem'])) {
    $connexion = Database::getConnexion();
    InventoryDAL::vendreItem($connexion, $_POST['idItem'], $_SESSION['id']);
    header("Location: inventaire.php");
    exit;
}
?>

<?php 
    include "include/php_setup.php";
?>

<link rel="stylesheet" href="public/css/inventaire.css">

<?php 
    include "include/html_setup.php";
    include "include/header.php"; 
    include "include/nav.php";
?>

<?php
$inventaire = [];
$groupes = [];

if (isset($_SESSION['id'])) {
    $inventaire = Database::obtenir_inventaire_joueur($_SESSION['id']);
}

foreach ($inventaire as $item) {
    if ($item['qtInventaire'] > 0) {
        $groupes[$item['type']][] = $item;
    }
}
?>

<main class="main">
    <h1 class="py-3 mt-3">Inventaire</h1>

    <?php if (!empty($groupes)) { ?>

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

                            <p class="description"><?= htmlspecialchars($item['description']) ?></p>

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

                        <form method="post">
                            <input type="hidden" name="idItem" value="<?= $item['idItem'] ?>">
                            <button type="submit" name="vendre" class="btn btn-boot mt-auto">Vendre</button>
                        </form>

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