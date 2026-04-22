<?php

require_once "core/initialization.php";
require_once 'DAL/VitrineDAL.php';
require_once 'DAL/PanierDAL.php';
require_once 'core/Database.php';
include_once 'include/php_setup.php';
$connexion = Database::getConnexion();

if (!empty($_GET['sortPrice'])) {
    $sort = $_GET['sortPrice'];
    $products = VitrineDAL::selectByPrice($connexion, $sort);
} else if (!empty($_GET['sortAlphabete'])) {
    $sort = $_GET['sortAlphabete'];
    $products = VitrineDAL::selectByAlphabete($connexion, $sort);
} else if (!empty($_GET['sortCatego'])) {
    $sort = $_GET['sortCatego'];
    $products = VitrineDAL::selectByCategory($connexion, $sort);
} else if (!empty($_GET['research'])) {
    $search = "%" . strtolower($_GET['research']) . "%";
    $products = VitrineDAL::selectByTitle($connexion, $search);
} else {
    $products = VitrineDAL::selectAll($connexion);
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
?>
<?php include "include/html_setup.php"; ?>
<link rel="stylesheet" href="public/css/vitrine.css">
<title>DarQuest - Vitrine</title>

<?php
include 'include/header.php';
include 'include/nav.php';
?>

<main class="main" style="border:5px solid #c9a86a; border-top:none; border-bottom:none;">
    <form class="search-sort-container searchBarContainer" role="search" action="index.php">
        <input name="research" id="liveSearch" class="search-sort-element form-control search-bar" type="search"
            placeholder="Recherche sur DarQuest">

        <select name="sortPrice" id="sortPrice" class="search-sort-element form-select sort-element">
            <option value="" hidden>Trier par prix</option>
            <option value="price_asc">Prix ↑</option>
            <option value="price_desc">Prix ↓</option>
        </select>

        <select id="sortCatego" name="sortCatego" class="search-sort-element form-select sort-element">
            <option value="" hidden>Filtrer par catégorie</option>
            <option value="sorts">Sorts</option>
            <option value="armors">Armures</option>
            <option value="weapons">Armes</option>
            <option value="potions">Potions</option>
        </select>

        <select id="sortAlphabete" name="sortAlphabete" class="search-sort-element form-select sort-element">
            <option value="" hidden>Trier par ordre alphabétique</option>
            <option value="alpha_asc">A à Z</option>
            <option value="alpha_desc">Z à A</option>
        </select>
    </form>

    <div class="container text-center">
        <div id="allItemsContainer" class="row justify-content-center">
            <?php foreach ($products as $product):
                if (isset($cartItems[$product['idItem']])) {
                    $isInCart = true;
                    $itemQuantite = $cartItems[$product['idItem']];
                } else {
                    $isInCart = false;
                }

                ?>

                <div id="card_<?= $product['idItem'] ?>" class="col-6 col-lg-3 d-flex align-items-stretch"
                    style="flex-driection: row;">
                    <div class="card mt-4 w-100 backgroundImage">
                        <a href="details.php?id=<?= $product['idItem'] ?>" class="image-wrapper">
                            <img src="<?= $product['photoItem'] ?>" class="card-img-top img-fluid"
                                alt="<?= $product['nomItem'] ?>">
                        </a>

                        <div class="card-body d-flex flex-column text-center backgroundColor">
                            <h3 class="card-title"><?= $product['nomItem'] ?></h3>
                            <?php
                            $avg = number_format($product['moyenne_etoiles'] ?? 0, 1);
                            $starPercentage = ($avg / 5) * 100;

                            if ($avg >= 4) {
                                $color = "rating-good";
                            } elseif ($avg >= 2) {
                                $color = "rating-average";
                            } else {
                                $color = "rating-bad";
                            }
                            if ($product['nb_reviews'] == 0) {
                                $color = "rating";
                            }
                            ?>
                            <div class="stars">
                                <div class="stars-inner" style="width: <?= $starPercentage ?>%;"></div>
                            </div>
                            <p class="rating-number <?= $color ?>"><?= $avg ?>/5</p>

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

                            <br>
                            <!-- Button Section -->
                            <?php if(IS_AUTH) : //  Si connecté?>
                               <?php if ($product['type'] == 'sort' && !IS_MAGE) :?>
                                    <a href="enigma.php" class="btn btn-boot mt-auto" style="background-color: #b3b3b3; display: flex; justify-content: center;">
                                    Devenez mage pour acheter le sort
                                </a>
                                <?php else : ?>
                                
                                <?php if($isInCart) :// Si item est dans le cart?>
                                    <div class="btn btn-boot mt-auto" style="background-color: #b3b3b3; display: flex; justify-content: center;">
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


                                <?php else :         // Si item est pas dans le cart?>
                                    <button onclick="ajouter_panierAJAX(<?=$idJoueur?>,<?= $product['idItem'] ?>)" class="btn btn-boot mt-auto">Ajouter au panier</button>
                                <?php endif;?>
                                <?php endif;?>
                                 

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

    <script src="scripts/fonctions_Index.js"> </script>

    <div id="hand-zone"></div>
    <!---->
    <br>
</main>

<script>
    const searchInput = document.getElementById("liveSearch");
    const allItems = document.getElementById("allItemsContainer");
    const results = document.getElementById("resultsContainer");

    searchInput.addEventListener("input", function () {
        const query = this.value.trim();

        if (query === "") {
            allItems.style.display = "";
            results.innerHTML = "";
            return;
        }

        allItems.style.display = "none";

        fetch("search.php?search=" + encodeURIComponent(query))
            .then(r => r.text())
            .then(html => {
                results.innerHTML = html;
            });
    });
</script>



<?php include 'include/footer.php' ?>