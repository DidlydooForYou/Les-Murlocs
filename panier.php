<?php 
    include 'include/html_setup.php';

    require_once 'source/initialization.php';
    require_once 'core/Database.php';
    require_once 'source/PanierDAL.php';

    $connexion = Database::getConnexion($dbConfig);

    if(!isset ($_SESSION["connexion"])){
        if($_SESSION["connexion"]){
            header('Location:accesRefuse.php');
            exit;
        }
    }

    $products = PanierDAL::selectByUser($connexion, $_SESSION["id"]);

?>
<link rel="stylesheet" href="public/css/panier.css">

<title>DarQuest - Panier</title>

<?php 
    include 'include/header.php';
    include 'include/nav.php'; 
?>

<main class="main">
    <h1> Panier </h1>

    <div class="panier-Container">

    <?php foreach($products as $product) : ?>
        <div class="panier-row">
            <div class="panier-image-box"> 
                <img class="panier-image" src="<?$product['photoItem']?>" alt="<?$product['photoItem']?>"> 
            </div>
            <div class="panier-content panier-nom">
                <?$product['nomItem']?> 
                </div>
            <div class="panier-content panier-quantite">
                <div></div>
                <button class="qte-element btn-circular"> + </button>
                <input type="text" class="qte-element" value="<?$product['qtPanier']?> ">
                <button class="qte-element btn-circular"> - </button>
                <div></div>
                <button class="qte-element btn-circular">×</button>
            </div>
                
            <div class="panier-content panier-prix">
                
            </div>
        </div>
        <?php endforeach ?>
    </div>

</main>

<?php include 'include/footer.php' ?>