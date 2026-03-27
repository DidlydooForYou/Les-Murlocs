<?php 
    include 'include/html_setup.php';

    require_once 'source/initialization.php';
    require_once 'core/Database.php';
    require_once 'source/PanierDAL.php';

    $connexion = Database::getConnexion($dbConfig);

    if(isset ($_SESSION["connexion"])){
        if(!$_SESSION["connexion"]){
            header('Location:accesRefuse.php');
            exit;
        }
    } else{
        header('Location:accesRefuse.php');
        exit;
    }

    $products = PanierDAL::selectByUser($connexion, 1 /*$_SESSION["id"]*/);


?>
<link rel="stylesheet" href="public/css/panier.css">
<script src="scripts/fonctionsPanier.js"></script>

<title>DarQuest - Panier</title>

<?php 
    include 'include/header.php';
    include 'include/nav.php'; 
?>

<main class="main">
    <h1> Panier </h1>

    <?php if($products == null) : ?>
    <div> Vous n'avez pas d'item dans votre panier </div>

    <?php else : ?>
    <div class="panier-Container">
        <?php foreach($products as $product) : ?>
            <div class="panier-row">
                <div class="panier-image-box"> 
                    <img class="panier-image" src="<?=$product['photoItem']?>" alt="<?=$product['photoItem']?>"> 
                </div>

                <div class="panier-content panier-nom">
                    <?=$product['nomItem']?> 
                </div>

                <div class="panier-content panier-quantite">
                    <button class="qte-element btn-circular" onclick="addingItemQuantite(1, <?=$product['idItem']?>, 1,'<?=$product['nomItem']?>')">+</button>
                    
                    <input id="<?=$product['nomItem']?>PanierQte" class="qte-element qte-amount" type="number" value="<?=$product['qtPanier']?>" onblur="changeItemQuantite(1, <?=$product['idItem']?>, this.value,'<?=$product['nomItem']?>')">
                    
                    <button class="qte-element btn-circular" onclick="addingItemQuantite(1, <?=$product['idItem']?>, -1,'<?=$product['nomItem']?>')">-</button>
                    
                    <button class="qte-element btn-circular">×</button>
                </div>
                
                <?php $prixCalcule = PanierDAL::multiplierCoins($product['prixOr'], $product['prixArgent'],$product['prixBronze'],$product['qtPanier']) ?>
                <div class="panier-content panier-prix">
                    
                    <div class="coins-container">
                        <img class="coin-image" src="public/images/LogoDarQuest.png" alt="LogoDarQuest.png">
                        <span class="coin-amount"><?=$prixCalcule['Or']?></span>

                        <img class="coin-image" src="public/images/LogoDarQuest.png" alt="LogoDarQuest.png">
                        <span class="coin-amount"><?=$prixCalcule['Argent']?></span>

                        <img class="coin-image" src="public/images/LogoDarQuest.png" alt="LogoDarQuest.png">
                        <span class="coin-amount"><?=$prixCalcule['Bronze']?></span>
                    </div>
                </div>

            </div>
        <?php endforeach ?>
    </div>
    <div style="display: flex; justify-content: flex-end;">
        <div class="confirm-container">
            <h3 style="text-align:right">Total : </h3>

            <div class="coins-container">
                <img class="coin-image" src="public/images/LogoDarQuest.png" alt="LogoDarQuest.png">
                <span class="coin-amount">3</span>

                <img class="coin-image" src="public/images/LogoDarQuest.png" alt="LogoDarQuest.png">
                <span class="coin-amount">2</span>

                <img class="coin-image" src="public/images/LogoDarQuest.png" alt="LogoDarQuest.png">
                <span class="coin-amount">1</span>
            </div>

            <div></div>
            <button class="button" onclick="openPanel()"> Acheter </button>
        </div>
    </div>

    <div id="confirmation-panel" class="confirmation-panel">
        <h2 style="text-align: center;">Confirmation d'achats</h2>
        <div class="panel-list-container">
            <?php foreach($products as $product) : ?>
                <div>
                    <span><?=$product['nomItem']?></span> ×<span id="<?=$product['nomItem']?>OverviewQte"><?=$product['qtPanier']?></span>
                </div>
                <hr>
            <?php endforeach ?>
        </div>

        <div class="panel-bottom">

            <div class="coins-container" style="margin:auto;">
                <img class="coin-image" src="public/images/LogoDarQuest.png" alt="LogoDarQuest.png">
                <span class="coin-amount">3</span>

                <img class="coin-image" src="public/images/LogoDarQuest.png" alt="LogoDarQuest.png">
                <span class="coin-amount">2</span>

                <img class="coin-image" src="public/images/LogoDarQuest.png" alt="LogoDarQuest.png">
                <span class="coin-amount">1</span>
            </div>

            <div class="panel-button">
                <button class="button btn-cancel" onclick="closePanel()">Annuler</button>
            </div>

            <div class="panel-button">
                <button class="button">Confirmer</button>
            </div>
        </div>
    </div>

    <?php endif ?>
</main>

<?php include 'include/footer.php' ?>


            <!--
Warning: Undefined array key "p.Item_idItem" in C:\wamp64\www\Les-Murlocs\panier.php on line 52
Call Stack #TimeMemoryFunctionLocation 10.0012462160{main}( )...\panier.php
:
0 , 1, 
            -->