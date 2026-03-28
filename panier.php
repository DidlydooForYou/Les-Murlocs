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

    $userId = 1;    // Either renameAll $userId pour $_SESSION["id"] or change 1 pour $_SESSION["id"]

    $products = PanierDAL::selectByUser($connexion, $userId);

    $totalOr = 0;
    $totalArgent = 0;
    $totalBronze = 0;
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
    <div id="panier" class="panier-Container">
        <?php foreach($products as $product) : ?>

            <div id="Tableau_<?=$product['idItem']?>" class="panier-row">
                <div class="panier-image-box"> 
                    <img class="panier-image" src="<?=$product['photoItem']?>" alt="<?=$product['nomItem']?>"> 
                </div>

                <div class="panier-content panier-nom">
                    <?=$product['nomItem']?> 
                </div>

                <div class="panier-content panier-quantite">
                    <button class="qte-element btn-circular" onclick="addingItemQuantite(<?=$userId?>, <?=$product['idItem']?>, 1)">+</button>
                    
                    <input class="qte-element qte-amount" id="InputQte<?=$product['idItem']?>" type="number" value="<?=$product['qtPanier']?>" onblur="changeItemQuantite(<?=$userId?>, <?=$product['idItem']?>, this.value)">
                    
                    <button class="qte-element btn-circular" onclick="addingItemQuantite(<?=$userId?>, <?=$product['idItem']?>, -1)">-</button>
                    
                    <button class="qte-element btn-circular" onclick="deleteItem(<?=$userId?>, <?=$product['idItem']?>)">×</button>
                </div>
                
                <?php 
                    $prixCalcule = PanierDAL::multiplierCoins($product['prixOr'], $product['prixArgent'],$product['prixBronze'],$product['qtPanier']);
                    $totalOr += $prixCalcule['Or'];
                    $totalArgent += $prixCalcule['Argent'];
                    $totalBronze += $prixCalcule['Bronze'];
                ?>
                <div class="panier-content panier-prix">
                    
                    <div class="coins-container">
                        <img class="coin-image" src="public/images/gold-coin.png" alt="gold-coin">
                        <span class="coin-amount"><?=$prixCalcule['Or']?></span>

                        <img class="coin-image" src="public/images/silver-coin.png" alt="silver-coin">
                        <span class="coin-amount"><?=$prixCalcule['Argent']?></span>

                        <img class="coin-image" src="public/images/bronze-coin.png" alt="bronze-coin">
                        <span class="coin-amount"><?=$prixCalcule['Bronze']?></span>
                    </div>
                </div>

            </div>
        <?php 
            endforeach;
            
            $totalSplit = PanierDAL::multiplierCoins($totalOr, $totalArgent, $totalBronze, 1);
        ?>
    </div>
    <div style="display: flex; justify-content: flex-end;">
        <div class="confirm-container">
            <h3 style="text-align:right">Total : </h3>

            <div id="tableau-total" class="coins-container">
                <img class="coin-image" src="public/images/gold-coin.png" alt="gold-coin">
                <span class="coin-amount"><?=$totalSplit['Or']?></span>

                <img class="coin-image" src="public/images/silver-coin.png" alt="silver-coin">
                <span class="coin-amount"><?=$totalSplit['Argent']?></span>

                <img class="coin-image" src="public/images/bronze-coin.png" alt="bronze-coin">
                <span class="coin-amount"><?=$totalSplit['Bronze']?></span>
            </div>

            <div></div>
            <button class="button" onclick="openPanel()"> Acheter </button>
        </div>
    </div>

    <div id="confirmation-panel" class="confirmation-panel">
        <h2 style="text-align: center;">Confirmation d'achats</h2>
        <div class="panel-list-container">
            <?php foreach($products as $product) : ?>
                <div id="Panel_<?=$product['idItem']?>">
                    <span><?=$product['nomItem']?> </span><span> ×<?=$product['qtPanier']?></span>
                </div>
                <hr>
            <?php endforeach ?>
        </div>

        <div class="panel-bottom">

            <div id="panel-total" class="coins-container" style="margin:auto;">
                <img class="coin-image" src="public/images/gold-coin.png" alt="gold-coin">
                <span class="coin-amount"><?=$totalSplit['Or']?></span>

                <img class="coin-image" src="public/images/silver-coin.png" alt="silver-coin">
                <span class="coin-amount"><?=$totalSplit['Argent']?></span>

                <img class="coin-image" src="public/images/bronze-coin.png" alt="bronze-coin">
                <span class="coin-amount"><?=$totalSplit['Bronze']?></span>
            </div>

            <div class="panel-button">
                <button class="button btn-cancel" onclick="closePanel()">Annuler</button>
            </div>

            <div class="panel-button">
                <button class="button" onclick="acheterPanier(<?=$userId?>,<?=$totalSplit['SommeTotale']?>)">Confirmer</button>
            </div>
        </div>
    </div>

    <?php endif ?>
</main>

<?php include 'include/footer.php' ?>