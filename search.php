<?php
require "core/Database.php";
require_once 'DAL/VitrineDAL.php';
require_once 'DAL/PanierDAL.php';

$pdo = Database::getConnexion();

define("IS_AUTH", isset($_SESSION['id']));

$search = "%" . strtolower($_GET['search'] ?? '') . "%";

$results = VitrineDAL::selectByLike($pdo, $search);

if (empty($results)) {
    echo "<p>No results found</p>";
    exit;
}

$cartItems = [];

if (IS_AUTH) {
    $idJoueur = $_SESSION['id'];
    $panier = PanierDAL::selectByUser($pdo, $idJoueur);

    foreach ($panier as $item) {
        $cartItems[$item['idItem']] = $item['qtPanier'];
    }
}
?>


<div class="row justify-content-center">
    <?php foreach ($results as $product):
        if (isset($cartItems[$product['idItem']])) {
            $isInCart = true;
            $itemQuantite = $cartItems[$product['idItem']];
        } else {
            $isInCart = false;
        }

        ?>
        <div id="card_<?= $product['idItem'] ?>" class="col-6 col-lg-4 d-flex align-items-stretch">
            <div class="card mt-4 w-100 backgroundImage">
                <a href="details.php?id=<?= $product['idItem'] ?>" class="image-wrapper">
                    <img src="<?= $product['photoItem'] ?>" class="card-img-top img-fluid" alt="<?= $product['nomItem'] ?>">
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
                    <?php if (IS_AUTH):  //  Si connecté ?>

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