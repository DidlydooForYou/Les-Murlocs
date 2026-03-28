<?php
require_once 'source/initialization.php';
require_once 'core/Database.php';
require_once 'source/VitrineDAL.php';

$connexion = Database::getConnexion($dbConfig);

if (!empty($_GET['sortAlphabete'])) {
    $sort = $_GET['sortAlphabete'];
    $products = VitrineDAL::selectByAlphabete($connexion, $sort);
}
else if (!empty($_GET['sortCatego'])){
    $sort = $_GET['sortCatego'];
    $products = VitrineDAL::selectByCategory($connexion, $sort);
}
else if (!empty($_GET['sortPrice'])) {
    $sort = $_GET['sortPrice'];
    $products = VitrineDAL::selectByPrice($connexion, $sort);
}
else if (!empty($_GET['research'])) {
    $search = "%" . strtolower($_GET['research']) . "%";
    $products = VitrineDAL::selectByTitle($connexion, $search);
}
else {
    $products = VitrineDAL::selectAll($connexion);
}
?>

<div class="container text-center">
    <div class="row justify-content-center">

        <?php foreach($products as $product) : ?>

        <div class="col-lg-3 d-flex align-items-stretch">
            <div class="card mt-4 w-100 backgroundImage">
                <a href="details.php?id=<?= $product['idItem'] ?>">
                    <img src="<?= $product['photoItem'] ?>" class="card-img-top img-fluid image-wrapper" alt="<?= $product['photoAlt'] ?>">
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

                    <p class="card-text"><?= $product['prix'] ?>$</p>
                    <a href="" class="btn btn-boot mt-auto">Ajouter au panier</a>
                </div>
            </div>
        </div>

        <?php endforeach; ?>

    </div>

    <div id="hand-zone"></div>

</div>