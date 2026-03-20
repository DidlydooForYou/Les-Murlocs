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

<div class="row">

    <?php foreach($products as $product) : ?>

    <div class="col-lg-4 d-flex align-items-stretch">
        <div class="card mt-4">
            <div class="card-body d-flex flex-column">
                <!--Image de l'item-->
                <img src="<?=$product['photoItem'] ?>" class="card-img-top" alt="<?= $product['photoAlt']?>">

                <!--Nom de l'item-->
                <h5 class="card-title"><?= $product['nomItem']?></h5>

                <!--Prix de l'item-->
                <p class="card-text"><?= $product['prix']?></p>

                <!--Description de l'item-->
                <p class="card-text"><?= $product['description']?></p>

                <div class="mt-auto">
                    <?php if(!IS_ADMIN) : ?>
                        <a href="" class="btn btn-primary mt-auto align-self-start">Ajouter au panier</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <?php endforeach; ?>
</div>
