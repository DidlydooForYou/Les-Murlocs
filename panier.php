<?php include 'include/html_setup.php' ?>
<link rel="stylesheet" href="css/panier.css">

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
                <span> + </span><span> 2 </span><span> - </span><span> x </span>
            </div>
            <div class="panier-content panier-prix">
                {nb * prix unitaire}
            </div>
        </div>
    </div>

</main>

<?php include 'include/footer.php' ?>