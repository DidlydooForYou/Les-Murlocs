<?php 
    include 'include/html_setup.php';

    $pdo = get_pdo();
    
    if($pdo === false){
        $erreur = "<p>Erreur : impossible d'ouvrir <strong> la base de données </strong></p>"; 
    } else {
        $tableau = array();

        $donnees = obtenir_panier($_SESSION['idJoueur']);

        if($donnees){
            foreach ($donnees as $itemPanier) {
                if(!empty($itemPanier)){
                    $ligne = array(
                        "Image" => ($itemPanier['photoItem']),
                        "Nom" => ($itemPanier['nomItem']),
                        "Quantite" => ($itemPanier['qtPanier']),
                        "Or" => ($itemPanier['prixOr']),
                        "Argent" => $itemPanier(['prixArgent']),
                        "Bronze" => $itemPanier(['prixBronze'])
                    );
                    $tableau[] = $ligne;
                }
            }
        }
    }

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

        <div class="panier-row">
            <div class="panier-image-box"> 
                <img class="panier-image" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRZMA41rkfY1mp-2Mrv3kNtSvP4kBIaMCIu0A&s" alt="mama mia"> 
            </div>
            <div class="panier-content panier-nom">
                 Épée fuckall :speaking_head: 
                </div>
            <div class="panier-content panier-quantite">
                <div></div>
                <button class="qte-element btn-circular"> + </button>
                <input type="text" class="qte-element" value="2">
                <button class="qte-element btn-circular"> - </button>
                <div></div>
                <button class="qte-element btn-circular">×</button>
            </div>
                
            <div class="panier-content panier-prix">
                {nb * prix unitaire}
            </div>
        </div>
    </div>

</main>

<?php include 'include/footer.php' ?>