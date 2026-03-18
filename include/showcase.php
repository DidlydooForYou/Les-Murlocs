<?php
require_once 'source/initialization.php';
require_once 'core/Database.php';
require_once 'source/VitrineDAL.php';

$connexion = Database::getConnexion($dbConfig);

if(!empty($_GET['research'])){
    $search = "%" .strtolower($_GET['research']). "%";
    $products = VitrineDAL::selectByTitle($connexion, $search);
}
else{
    $products = VitrineDAL::selectAll($connexion);
}
?>

<div class="container">
    <div class="row">

        <?php foreach($products as $product) : ?>

        <div class="col-lg-4 d-flex align-items-stretch">
            <div class="card mt-4">
                <a href="details.php?id=<?= $product['idItem'] ?>">
                    <img src="<?= $product['photoItem'] ?>" class="card-img-top img-fluid" alt="<?= $product['photoAlt'] ?>">
                </a>

                <div class="card-body d-flex flex-column text-center">
                    <h5 class="card-title mt-3"><?= $product['nomItem'] ?></h5>
                    <p class="card-text"><?= $product['prix'] ?></p>
                    <p class="card-text"><?= $product['description'] ?></p>
                    <a href="" class="btn btn-primary mt-auto">Ajouter au panier</a>
                </div>
            </div>
        </div>

        <?php endforeach; ?>

    </div>
</div>