<?php
require_once 'source/initialization.php';
require_once 'core/Database.php';
require_once 'source/VitrineDAL.php';
<<<<<<< HEAD
require_once 'source/PanierDAL.php';
=======
require_once 'sql/bd.php';
>>>>>>> 3cfc349630eab6d1a66780805e0084cdfff816e4

$connexion = Database::getConnexion($dbConfig);

if (!empty($_GET['sortPrice'])) {
    $sort = $_GET['sortPrice'];
    $products = VitrineDAL::selectByPrice($connexion, $sort);
}
else if (!empty($_GET['sortAlphabete'])) {
    $sort = $_GET['sortAlphabete'];
    $products = VitrineDAL::selectByAlphabete($connexion, $sort);
}
else if (!empty($_GET['sortCatego'])){
    $sort = $_GET['sortCatego'];
    $products = VitrineDAL::selectByCategory($connexion, $sort);
}
else if (!empty($_GET['research'])) {
    $search = "%" . strtolower($_GET['research']) . "%";
    $products = VitrineDAL::selectByTitle($connexion, $search);
}
else {
    $products = VitrineDAL::selectAll($connexion);
}

$idJoueur = $_SESSION['idJoueur'] ?? null;

$cartItems = [];

if ($idJoueur !== null) {

    $panier = PanierDAL::selectByUser($connexion, $idJoueur);

    $bank = PanierDAL::getUserBank($connexion, $idJoueur);

    foreach ($panier as $item) {
        $cartItems[$item['idItem']] = $item['qtPanier'];
    }

} else {
    $cartItems = [];
}
?>

<div class="container text-center">
    <div class="row justify-content-center">

        <?php foreach($products as $product) : 
            
        $isInCart = isset($cartItems[$product['idItem']]);
        $quantity = $cartItems[$product['idItem']] ?? 1;
        ?>

        <div class="col-lg-3 d-flex align-items-stretch">
            <div class="card mt-4 w-100 backgroundImage">
                <a href="details.php?id=<?= $product['idItem'] ?>">
                    <img src="<?= $product['photoItem'] ?>" class="card-img-top img-fluid image-wrapper" alt="<?= $product['nomItem'] ?>">
                </a>

                <div class="card-body d-flex flex-column text-center backgroundColor">
                        <h5 class="card-title"><?= $product['nomItem'] ?></h5>
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
                        if($product['nb_reviews'] == 0){
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
                            <span class="coin-amount"><?=$product['prixOr']?></span>

                            <img class="coin-image" src="public/images/silver-coin.png" alt="silver-coin.png">
                            <span class="coin-amount"><?=$product['prixArgent']?></span>

                            <img class="coin-image" src="public/images/bronze-coin.png" alt="bronze-coin.png">
                            <span class="coin-amount"><?=$product['prixBronze']?></span>
                        </div>
                    </div>
                    <?php if (!$isInCart): ?>

    <a href="ajouter.php?id=<?= $product['idItem'] ?>" class="btn btn-boot mt-auto">
        Ajouter au panier
    </a>

<?php else: ?>

    <div class="quantity-selector mt-auto">
        <button class="btn btn-minus" onclick="addingItemQuantite(<?= $idJoueur ?>, <?= $product['idItem'] ?>, -1)">-</button>

        <input 
            type="text" 
            id="InputQte<?= $product['idItem'] ?>" 
            value="<?= $quantity ?>" 
            onchange="changeItemQuantite(<?= $idJoueur ?>, <?= $product['idItem'] ?>, this.value)"
            class="quantity-input"
        >

        <button class="btn btn-plus" onclick="addingItemQuantite(<?= $idJoueur ?>, <?= $product['idItem'] ?>, 1)">+</button>
    </div>

<?php endif; ?>
                </div>
            </div>
        </div>

        <?php endforeach; ?>

    </div>
</div>
<script src="scripts/fonctionsPanier.js"> </script>

    <div id="hand-zone"></div>

</div>
