<?php
require_once CORE . '/Database.php';


?>

<div class="row">

    <?php foreach($products as $product) : ?>

    <div class="col-lg-4 d-flex align-items-stretch">
        <div class="card mt-4">
            <div class="card-body d-flex flex-column">
                <!--Nom de l'item-->
                <h5 class="card-title"></h5>

                <!--Nombre en inventaire-->
                <p class="card-text">x</p>

                <!--Image de l'item-->
                <img src="<?= INVENTAIRE_IMG . '/' . $product['image'] ?>" class="card-img-top" alt="<?= $product['alt']?>">

                <!--Description de l'item-->
                <p class="card-text"><?= $product['description']?></p>

                <!--Efficacité de l'item-->
                <p class="card-text"><?= $product['efficacite']?></p>

                <!--Type de l'item (une main, deux mains, ect...)-->
                <p class="card-text"><?= $product['type']?></p>

                <div class="mt-auto">
                    <?php if(!IS_ADMIN) : ?>
                        <a href="" class="btn btn-primary mt-auto align-self-start">Vendre</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <? endforeach; ?>
</div>
