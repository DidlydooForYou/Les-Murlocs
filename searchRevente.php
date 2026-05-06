<?php
require "core/Database.php";
require_once 'DAL/PanierDAL.php';
require_once 'DAL/ReventeDAL.php';
require_once 'core/initialization.php';

$connexion = Database::getConnexion();

$search = "%" . strtolower($_GET['search'] ?? '') . "%";

$results = ReventeDAL::selectByTitle($connexion, $search);


if (empty($results)) {
    echo "<p>No results found</p>";
    exit;
}

if (!empty($_GET['sortPrice'])) {
    $sort = $_GET['sortPrice'];
    $products = ReventeDAL::selectByPrice($connexion, $sort);

} else if (!empty($_GET['sortAlphabete'])) {
    $sort = $_GET['sortAlphabete'];
    $products = ReventeDAL::selectByAlphabete($connexion, $sort);

} else if (!empty($_GET['sortCatego'])) {
    $sort = $_GET['sortCatego'];
    $products = ReventeDAL::selectByCategory($connexion, $sort);

} else if (!empty($_GET['research'])) {
    $search = "%" . strtolower($_GET['research']) . "%";
    $products = ReventeDAL::selectByTitle($connexion, $search);

} else {
    $products = ReventeDAL::selectAll($connexion);
}


if (isset($_SESSION['id']))
    $idJoueur = $_SESSION["id"];

$cartItems = array();

if (isset($idJoueur)) {

    $panier = PanierDAL::selectByUser($connexion, $idJoueur);

    foreach ($panier as $item) {
        $cartItems[$item['idItem']] = $item['qtPanier'];
    }
}
doitEtreCo();
?>


<div class="container text-center">
    <div id="allItemsContainer" class="row justify-content-center" style="padding: 0 20px;">
        <?php foreach ($products as $product):
            if (isset($cartItems[$product['idItem']])) {
                $isInCart = true;
                $itemQuantite = $cartItems[$product['idItem']];
            } else {
                $isInCart = false;
            }

            ?>

            <div id="card_<?= $product['idItem'] ?>" class="col-10 col-lg-3 d-flex align-items-stretch"
                style="flex-driection: row;">
                <div class="card mt-4 w-100 backgroundImage">
                    <a href="details.php?id=<?= $product['idItem'] ?>" class="image-wrapper">
                        <img src="<?= $product['photoItem'] ?>" class="card-img-top img-fluid"
                            alt="<?= $product['nomItem'] ?>">
                    </a>

                    <div class="card-body d-flex flex-column text-center backgroundColor">
                        <h3 class="card-title"><?= $product['nomItem'] ?></h3>

                        <div class="card-text" style="display: flex; justify-content: center;">
                            <div id="tableau-total" class="coins-container">
                                <img class="coin-image" src="public/images/gold-coin.png" alt="gold-coin.png">
                                <span class="coin-amount"><?= $product['prixOr'] ?></span>

                                <img class="coin-image" src="public/images/silver-coin.png" alt="silver-coin.png">
                                <span class="coin-amount"><?= $product['prixArgent'] ?></span>

                                <img class="coin-image" src="public/images/bronze-coin.png" alt="bronze-coin.png">
                                <span class="coin-amount"><?= $product['prixBronze'] ?></span>
                            </div>
                        </div>

                        <?php if ($product['qttItem'] > 10): ?>
                            <p></p>
                        <?php elseif ($product['qttItem'] > 0): ?>
                            <p class="almost-out-of-stock">Il n'en reste que <?= $product['qttItem'] ?></p>
                        <?php else: ?>
                            <p class="out-of-stock">Rupture de stock</p>
                        <?php endif; ?>

                        <p style="font-weight:bold;">Revendu par :</p>

                        <a href="profil.php?id=<?= $product['idJoueur'] ?>" style="text-decoration:none; color:inherit;">
                            <div style="display:flex; align-items:center; justify-content:center; gap:8px;">
                                <img src="<?= htmlspecialchars($product['vendeur_photo']) ?>" alt="photoProfil"
                                    style="width:40px; height:40px; border-radius:50%; object-fit:cover;">
                                <span><?= htmlspecialchars($product['vendeur_alias']) ?></span>
                            </div>
                        </a>


                        <br>
                        <!-- Button Section -->
                        <?php if (IS_AUTH):  //  Si connecté ?>
                            <?php if ($product['type'] == 'sort' && !IS_MAGE): ?>
                                <a href="enigma.php" class="btn btn-boot mt-auto"
                                    style="background-color: #b3b3b3; display: flex; justify-content: center;">
                                    Devenez mage pour acheter le sort
                                </a>
                            <?php else: ?>

                                <?php if ($isInCart): // Si item est dans le cart ?>
                                    <div class="btn btn-boot mt-auto"
                                        style="background-color: #b3b3b3; display: flex; justify-content: center;">
                                        <div class="quantity-container">
                                            <button class="quantity-element quantity-button"
                                                onclick="addingItemQuantite(<?= $idJoueur ?>, <?= $product['idItem'] ?>, -1)">-</button>
                                            <input id="input_<?= $product['idItem'] ?>" class="quantity-element quantity-input"
                                                type="number" value="<?= $itemQuantite ?>"
                                                onblur="changeItemQuantite(<?= $idJoueur ?>, <?= $product['idItem'] ?>, this.value)">
                                            <button class="quantity-element quantity-button"
                                                onclick="addingItemQuantite(<?= $idJoueur ?>, <?= $product['idItem'] ?>, 1)">+</button>
                                        </div>
                                    </div>


                                <?php else:          // Si item est pas dans le cart ?>
                                    <button onclick="ajouter_panierAJAX(<?= $idJoueur ?>,<?= $product['idItem'] ?>)"
                                        class="btn btn-boot mt-auto">Ajouter au panier</button>
                                <?php endif; ?>
                            <?php endif; ?>


                        <?php else:         //  Si pas connecté ?>
                            <a href="connexion.php" class="btn btn-boot mt-auto"
                                style="background-color: #b3b3b3; display: flex; justify-content: center;">
                                Connectez-vous pour ajouter au panier
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        <?php endforeach; ?>
    </div>

    <div id="resultsContainer"></div>
</div>