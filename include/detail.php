<?php
require_once 'source/initialization.php';
require_once 'core/Database.php';
require_once 'source/VitrineDAL.php';
require_once 'source/PanierDAL.php';
require_once 'sql/bd.php';

$connexion = DataBase::getConnexion($dbConfig);
$products = [];

if(!empty($_GET['id'])){
    $id = $_GET['id'];
    $products = VitrineDAL::SelectById($connexion, $id);
}else {
    echo "<h3>Aucun produit trouvé.</h3>";
}

if(isset($_SESSION['id']))
    $idJoueur = $_SESSION["id"];

$cartItems = array();

if (isset($idJoueur)) {

    $panier = PanierDAL::selectByUser($connexion, $idJoueur);

    foreach ($panier as $item) {
        $cartItems[$item['idItem']] = $item['qtPanier'];
    }
}
?>

<div class="container text-center">
    <div class="row justify-content-center">

    <?php foreach($products as $product) : 
    if(isset($cartItems[$product['idItem']])){
                $isInCart = true;
                $itemQuantite = $cartItems[$product['idItem']];
            }
            else{
                $isInCart = false;
            }
        ?>

    <div class="col-lg-3 d-flex align-items-stretch">

            <div class="card mt-4 w-100 d-flex flex-column backgroundDetails">
                <!--Image de l'item-->
                <img src="<?=$product['photoItem'] ?>" class="card-img-top image-wrapper" alt="<?= $product['nomItem']?>">

                <div class="card-body d-flex flex-column text-center">
                    <!--Nom de l'item-->
                <h5 class="card-title"><?= $product['nomItem']?></h5>

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
                        if($product['nb_reviews'] == 0){
                            $color = "rating";
                        }
                    ?>
                    <div class="stars">
                        <div class="stars-inner" style="width: <?= $starPercentage ?>%;"></div>
                    </div>
                    <p class="rating-number <?= $color ?>"><?= $avg ?>/5</p>
                    

                <!--Nombre de review de l'item-->
                <!--<a href="" class="reviews">--><p class="card-text"><?= $product['nb_reviews'] ?? 0 ?> reviews</p><!--</a>-->

                <!--Prix de l'item-->
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

                <!--Description de l'item-->
                <p class="card-text"><?= $product['description']?></p>

                <div class="mt-auto">
                     <?php if(IS_AUTH) : //  Si connecté?>

                        <?php if($isInCart) :// Si item est dans le cart?>
                            <div class="btn btn-boot mt-auto" style="background-color: #b3b3b3; display: flex; justify-content: center;">
                                <div class="quantity-container">
                                    <button class="quantity-element quantity-button" onclick="addingItemQuantite(<?=$idJoueur?>, <?=$product['idItem']?>, 1)">+</button>
                                    <input id="input_<?=$product['idItem']?>" class="quantity-element quantity-input" type="number" value="<?=$itemQuantite?>" onblur="changeItemQuantite(<?=$idJoueur?>, <?=$product['idItem']?>, this.value)">
                                    <button class="quantity-element quantity-button" onclick="addingItemQuantite(<?=$idJoueur?>, <?=$product['idItem']?>, -1)">-</button>
                                </div>
                            </div>


                        <?php else :         // Si item est pas dans le cart?>
                            <button onclick="ajouter_panierAJAX(<?=$idJoueur?>,<?= $product['idItem'] ?>)" class="btn btn-boot mt-auto">Ajouter au panier</button>
                        <?php endif;?>

                    <?php else :        //  Si pas connecté?>
                        <a href="connexion.php" class="btn btn-boot mt-auto" style="background-color: #b3b3b3; display: flex; justify-content: center;">
                            Connectez-vous pour ajouter au panier
                        </a>
                    <?php endif;?>
                </div>
                </div>
            </div>
        </div>

    <?php endforeach; ?>
</div>
<script src="scripts/fonctionsPanier.js"> </script>
