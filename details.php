<?php
include "include/html_setup.php";

require_once 'DAL/VitrineDAL.php';
require_once 'DAL/PanierDAL.php';
require_once 'DAL/DetailsDAL.php';

$connexion = DataBase::getConnexion();
$products = [];
$details = [];
?>

<link rel="stylesheet" href="public/css/vitrine.css">
<link rel="stylesheet" href="public/css/details.css">
<Title>DarQuest - Détails</Title>



<?php
include "include/header.php";
include "include/nav.php";
?>
<main class="main">
    <br>

    <?php
    if (!empty($_GET['id'])) {
        $id = $_GET['id'];
        $products = VitrineDAL::SelectById($connexion, $id);
    } else {
        echo "<h3>Aucun produit trouvé.</h3>";
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

    $id = (int) $_GET['id'];
    $details = VitrineDAL::selectById($connexion, $id);

    if (!$details) {
        header("Location: index.php");
        exit;
    }
    ?>

    <div class="container text-center">
        <div class="row justify-content-center">

            <?php foreach ($products as $product):
                if (isset($cartItems[$product['idItem']])) {
                    $isInCart = true;
                    $itemQuantite = $cartItems[$product['idItem']];
                } else {
                    $isInCart = false;
                }
                ?>

                <div class="col-lg-11 d-flex align-items-stretch">

                    <div class="card mt-4 w-100 d-flex flex-column backgroundDetails">

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-5 d-flex align-items-start">
                                    <img src="<?= $product['photoItem'] ?>" class="img-fluid product-image mx-auto d-block"
                                        alt="<?= $product['nomItem'] ?>">
                                </div>

                                <div class="col-md-5 d-flex flex-column text-start product-details">
                                    <!--Nom de l'item-->
                                    <h2 class="card-title"><?= $product['nomItem'] ?></h2>

                                    <!--Moyenne des reviews de l'item-->
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
                                    <div class="rating-row">
                                        <a href="reviews.php?id=<?= $product['idItem'] ?>" class="reviews">
                                            <!-- Average number -->
                                            <p class="rating-number <?= $color ?> mb-0"><?= $avg ?></p>

                                            <!-- Stars -->
                                            <div class="stars-details">
                                                <div class="stars-inner" style="width: <?= $starPercentage ?>%;"></div>
                                            </div>

                                            <!-- Review count -->
                                            <p class="card-text mb-0">(<?= $product['nb_reviews'] ?? 0 ?>)</p>
                                        </a>

                                    </div>

                                    <!--Prix de l'item-->
                                    <div class="card-text price-outside coins-container-details">
                                        <div id="tableau-total" class="coins-container">
                                            <img class="coin-image" src="public/images/gold-coin.png" alt="gold-coin.png">
                                            <span class="coin-amount"><?= $product['prixOr'] ?></span>

                                            <img class="coin-image" src="public/images/silver-coin.png"
                                                alt="silver-coin.png">
                                            <span class="coin-amount"><?= $product['prixArgent'] ?></span>

                                            <img class="coin-image" src="public/images/bronze-coin.png"
                                                alt="bronze-coin.png">
                                            <span class="coin-amount"><?= $product['prixBronze'] ?></span>
                                        </div>
                                    </div>

                                    <!--Description de l'item-->
                                    <p class="card-text"><strong>Description : </strong><br><?= $product['description'] ?></p>

                                    <!-- Type de l'item -->
                                    <p class="card-text"><strong>Type : </strong><br> <?= $product['type'] ?></p>

                                    <?php
                                    if (!empty($_GET['id'])) {
                                        $id = $_GET['id'];
                                        $details = DetailsDAL::selectByType($connexion, $id, $product['type']);
                                    } else {
                                        echo "<h3>Aucun produit trouvé.</h3>";
                                    }
                                    ?>

                                
                                    <?php if ($product['type'] == "arme"): ?>
                                        <p class="card-text"><strong>Efficacite : </strong><br> <?= $details['efficacite'] ?></p>
                                        <p class="card-text"><strong>Genre arme : </strong><br> <?= $details['genreArme'] ?></p>
                                    <?php elseif ($product['type'] == "potion"): ?>
                                        <p class="card-text"><strong>Effet : </strong><br> <?= $details['effet'] ?></p>
                                        <p class="card-text"><strong>Durée : </strong><br> <?= $details['duree'] ?></p>
                                    <?php elseif ($product['type'] == "armure"): ?>
                                        <p class="card-text"><strong>Matière : </strong><br> <?= $details['matiere'] ?></p>
                                        <p class="card-text"><strong>Taille : </strong><br> <?= $details['taille'] ?></p>
                                    <?php elseif ($product['type'] == "sort"): ?>
                                        <p class="card-text"><strong>Instantanée : </strong><br> <?= $details['instantane'] ?></p>
                                        <p class="card-text"><strong>Dommages : </strong><br> <?= $details['dommage'] ?></p>

                                    <?php endif ?>

                                </div>

                                <div class="col-md-2">
                                    <div id="purchase-box" class="purchase-box p-3">
                                        <p class="price-title">Achat unique</p>

                                        <div class="coins-container mb-3">
                                            <img class="coin-image" src="public/images/gold-coin.png">
                                            <span><?= $product['prixOr'] ?></span>

                                            <img class="coin-image" src="public/images/silver-coin.png">
                                            <span><?= $product['prixArgent'] ?></span>

                                            <img class="coin-image" src="public/images/bronze-coin.png">
                                            <span><?= $product['prixBronze'] ?></span>
                                        </div>

                                        <?php if ($product['qttItem'] > 10): ?>
                                            <p class="in-stock">En stock</p>
                                        <?php elseif ($product['qttItem'] > 0 ): ?>
                                            <p class="almost-out-of-stock">Il n'en reste que <?=$product['qttItem']?></p>
                                        <?php else: ?>
                                            <p class="out-of-stock">Rupture de stock</p>
                                        <?php endif; ?>

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

                                                            <button 
                                                                class="quantity-element quantity-button"
                                                                onclick="addingItemQuantite(<?= $idJoueur ?>, <?= $product['idItem'] ?>, -1)"
                                                            >
                                                                -
                                                            </button>
                                                            <input id="input_<?= $product['idItem'] ?>"
                                                                class="quantity-element quantity-input" 
                                                                type="number"
                                                                value="<?= $itemQuantite ?>"
                                                                onblur="changeItemQuantite(<?= $idJoueur ?>, <?= $product['idItem'] ?>, this.value)"
                                                            >
                                                            <button 
                                                                class="quantity-element quantity-button"
                                                                onclick="addingItemQuantite(<?= $idJoueur ?>, <?= $product['idItem'] ?>, 1)"
                                                            >
                                                                +
                                                            </button>
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

                        </div>
                    </div>
                </div>

            <?php endforeach; ?>
        </div>
        <script src="scripts/fonctions_Details.js"> </script>
        <br>
</main>

<?php include_once INCLUDE_FILE . '/footer.php'; ?>