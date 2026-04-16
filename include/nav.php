<nav class="navContainer">

    <span class="navLinkContainer">
        <a class="navElement navLink" href="index.php">Vitrine</a>
    </span>


    <span class="navLinkContainer">
        <a class="navElement navLink" href="enigma.php">Énigmes</a>
    </span>

   

    <?php if (IS_AUTH) : ?>

    <span class="navLinkContainer">
        <a class="navElement navLink" href="panier.php">Panier</a>
    </span>

    <span class="navLinkContainer">
        <a class="navElement navLink" href="inventaire.php">Inventaire</a>
    </span>
    
     <span class="navLinkContainer">
        <a class="navElement navLink" href="revente.php">Revente</a>
    </span>
    
    <span class='navLinkContainer'>
        <a class='navElement navLink' href='deco.php'>Déconnexion</a> 
    </span>
    
    <?php else : ?>
    
    <span class='navLinkContainer'>
        <a class='navElement navLink' href='connexion.php'>Connexion</a>
    </span>

    <span class='navLinkContainer'>
        <a class='navElement navLink' href='inscription.php'>S'inscrire</a>
    </span>
    <?php endif; ?>

    <div class="navLinkContainer">
        <div class="dropdown navElement navLink">
            Paramètres
            <div class="dropdown-content-container">

                <?php if (IS_ADMIN) : ?>
                    <a href='ajout.php' class='dropdown-element navLink'> Ajout </a>    
                <?php endif; ?>

                <a href="aide.php" class="dropdown-element navLink"> Aide </a>
                
                <?php if (IS_AUTH) : ?>
                    <a href="profil.php" class="dropdown-element navLink"> Profil </a>
                <?php endif; ?>
                
            </div>
        </div>
    </div>

</nav>