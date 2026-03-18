<?php
require_once 'source/initialization.php';
require_once 'core/Database.php';
require_once 'source/InventoryDAL.php';

$connexion = Database::getConnexion($dbConfig);

if(!empty($_GET['research'])){
    $search = "%" .strtolower($_GET['research']). "%";
    $products = InventoryDAL::selectByTitle($coonnexion, $search);
}
else{
    $products = InventoryDAL::selectAll($connexion);
}

?>

<div class="row">

    <?php foreach($products as $product) : ?>

    <div class="col-lg-4 d-flex align-items-stretch">
        <div class="card mt-4">
            <div class="card-body d-flex flex-column">
                <!--Image de l'item-->
                <img src="<?= INVENTAIRE_IMG . '/' . $product['photoItem'] ?>" class="card-img-top" alt="<?= $product['alt']?>">

                <!--Nom de l'item-->
                <h5 class="card-title"><?= $product['nomItem']?></h5>

                <!--Prix de l'item-->
                <p class="card-text"><?= $product['prix']?></p>

                <div class="card-body d-flex flex-column">
                    <a href="" class="btn btn-primary mt-auto align-self-start">Ajouter au panier</a>
                </div>
            </div>
        </div>
    </div>

    <? endforeach; ?>
</div>
