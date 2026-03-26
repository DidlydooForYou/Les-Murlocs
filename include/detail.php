<?php
require_once 'source/initialization.php';
require_once 'core/Database.php';
require_once 'source/VitrineDAL.php';

$connexion = DataBase::getConnexion($dbConfig);
$products = [];

if(!empty($_GET['id'])){
    $id = $_GET['id'];
    $products = VitrineDAL::SelectById($connexion, $id);
}else {
    echo "<h3>Aucun produit trouvé.</h3>";
}

?>

<div class="container text-center">
    <div class="row justify-content-center">

    <?php foreach($products as $product) : ?>

    <div class="col-lg-3 d-flex align-items-stretch">

            <div class="card mt-4 w-100 d-flex flex-column backgroundDetails">
                <!--Image de l'item-->
                <img src="<?=$product['photoItem'] ?>" class="card-img-top" alt="<?= $product['photoAlt']?>">

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
                <p class="card-text"><?= $product['prix']?>$</p>

                <!--Description de l'item-->
                <p class="card-text"><?= $product['description']?></p>

                <div class="mt-auto">
                    <?php if(!IS_ADMIN) : ?>
                        <a href="" class="btn btn-boot mt-auto">Ajouter au panier</a>
                    <?php endif; ?>
                </div>
                </div>
            </div>
        </div>
    </div>

    <?php endforeach; ?>
</div>
