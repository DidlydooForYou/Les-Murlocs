<?php
require_once 'core/error-exception.php';
require_once 'core/initialization.php';
require_once 'DAL/Page.php';
require_once 'core/Database.php';
require_once 'DAL/InventoryDAL.php';
require_once 'DAL/ReventeDAL.php';

const ACTIVE_PAGE = Page::Inventaire;
doitEtreCo();
?>
function headerInventaire(){
     header("Location: inventaire.php");
    exit;
}

if (isset($_POST['vendre']) && isset($_POST['idItem'])) {
    $connexion = Database::getConnexion();
    InventoryDAL::vendreItem($connexion, $_POST['idItem'], $_SESSION['id']);
   headerInventaire();
}

include "include/php_setup.php";
?>

<link rel="stylesheet" href="public/css/inventaire.css">
<link rel="stylesheet" href="public/css/panier.css">
<title>DarQuest - Inventaire</title>

<?php
include "include/html_setup.php";
include "include/header.php";
include "include/nav.php";

$inventaire = [];
$groupes = [];

if (isset($_SESSION['id'])) {
    $inventaire = Database::obtenir_inventaire_joueur($_SESSION['id']);
}

if (isset($_POST['vendreMarket']) && isset($_POST['idItem']) && isset($_SESSION['id'])) {

    $connexion = Database::getConnexion();
    $idItem = $_POST['idItem'];
    $idJoueur = $_SESSION['id'];

    $item = InventoryDAL::selectById($connexion, $idItem, $_SESSION['id']);

    $joueur = JoueurDAL::getInfos($connexion, $idJoueur);
    $alias = Database::obtenir_alias($idJoueur);
    $photoProfil = $joueur['photoProfil'];

    ReventeDAL::ajouterRevente(
        $connexion,
        $idJoueur,
        $idItem,
        $item['nomItem'],
        $item['prixOr'],
        $item['prixArgent'],
        $item['prixBronze'],
        $item['photoItem'],
        1,
        $item['type'],
        $photoProfil,
        $alias
    );

    InventoryDAL::vendreItem($connexion, $idItem, $idJoueur);

   headerInventaire();
}

$idJoueur = $_SESSION["id"] ?? null;

$cartItems = [];

if ($idJoueur) {
    $connexion = Database::getConnexion();
    $revente = ReventeDAL::selectByUser($connexion, $idJoueur);

    foreach ($revente as $item) {
        $cartItems[$item['idItem']] = $item['qttItem'];
    }
}

foreach ($inventaire as $item) {
    if ($item['qtInventaire'] > 0) {
        $groupes[$item['type']][] = $item;
    }
}
?>

<main class="main">
    <h1 class="py-3 mt-3">Inventaire</h1>

    <?php if (!empty($groupes)): ?>

        <?php foreach ($groupes as $type => $items): ?>

            <h2 class="section-title"><?= ucfirst($type) ?></h2>

            <div class="vitrine">

                <?php foreach ($items as $item):

                    $isInCart = isset($cartItems[$item['idItem']]);
                    $itemQuantite = $isInCart ? $cartItems[$item['idItem']] : 0;
                    ?>

                    <div class="carte-item">

                        <div>
                            <div class="carte-header">
                                <strong><?= htmlspecialchars($item['nomItem']) ?></strong>
                                <div class="quantite">x<?= $item['qtInventaire'] ?></div>
                            </div>

                            <img src="<?= htmlspecialchars($item['photoItem']) ?>">

                            <p class="description"><?= htmlspecialchars($item['description']) ?></p>

                            <?php if ($type === 'arme'): ?>
                                <div class="label">Efficacité</div>
                                <div><?= $item['efficacite'] ?? '' ?></div>

                                <div class="label">Type</div>
                                <div><?= $item['genreArme'] ?? '' ?></div>

                            <?php elseif ($type === 'armure'): ?>
                                <div class="label">Matière</div>
                                <div><?= $item['matiere'] ?? '' ?></div>

                                <div class="label">Taille</div>
                                <div><?= $item['taille'] ?? '' ?></div>

                            <?php elseif ($type === 'potion'): ?>
                                <div class="label">Effet</div>
                                <div><?= $item['effet'] ?? '' ?></div>

                                <div class="label">Durée</div>
                                <div><?= $item['duree'] ?? '' ?></div>

                            <?php elseif ($type === 'sort'): ?>
                                <div class="label">Instantané</div>
                                <div><?= ($item['instantane'] ?? 0) ? 'Oui' : 'Non' ?></div>

                                <div class="label">Dommage</div>
                                <div><?= $item['dommage'] ?? '' ?></div>
                            <?php endif; ?>
                        </div>

                        <div style="display:flex; gap:10px;">

                            <form method="post">
                                <input type="hidden" name="idItem" value="<?= $item['idItem'] ?>">
                                <button type="submit" name="vendre" class="btn btn-boot mt-auto">Vendre</button>
                            </form>

                            <?php if ($type === 'potion' || $type === 'sort') { ?>
                                <form method="post">
                                    <input type="hidden" name="idItem" value="<?= $item['idItem'] ?>">
                                    <button type="submit" name="utiliser" class="btn btn-boot mt-auto">Utiliser</button>
                                </form>
                            <?php } ?>

                        </div>
                        <?php if ($isInCart): ?>

                            <div class="btn btn-boot mt-auto"
                                style="background-color: #b3b3b3; display: flex; justify-content: center;">
                                <div class="quantity-container">
                                    <button type="button"
                                        onclick="console.log('CLICK -'); addingReventeQuantite(<?= $idJoueur ?>, <?= $item['idItem'] ?>, -1)">
                                        -
                                    </button>

                                    <input id="InputQte<?= $item['idItem'] ?>" value="<?= $itemQuantite ?>" type="number" data-max="<?= $item['qtInventaire'] ?>"
                                        onblur="changeReventeQuantite(<?= $idJoueur ?>, <?= $item['idItem'] ?>, this.value)">

                                    <button type="button" onclick="addingReventeQuantite(<?= $idJoueur ?>, <?= $item['idItem'] ?>, 1)">
                                        +
                                    </button>

                                </div>
                            </div>

                        <?php else: ?>
                            <form method="post">
                                <input type="hidden" name="idItem" value="<?= $item['idItem'] ?>">
                                <button type="submit" name="vendre" class="btn btn-boot mt-auto">Vendre</button>
                                <button type="submit" name="vendreMarket" class="btn btn-boot mt-auto">Revendre sur marketplace</button>
                            </form>

                        <?php endif; ?>

                    </div>

                <?php endforeach; ?>

            </div>

        <?php endforeach; ?>

    <?php else: ?>

        <h3 style="text-align:center;">Votre inventaire est vide.</h3>
        <div style="text-align:center;">
            <a class="btn btn-boot mt-auto" href="index.php">Revenir</a>
        </div>

    <?php endif; ?>

</main>

<script src="scripts/fonctions_Revente.js"></script>

<?php include_once INCLUDE_FILE . '/footer.php'; ?>