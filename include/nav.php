<nav class="navContainer">

    <span class="navLinkContainer">
        <a class="navElement navLink" href="index.php">Vitrine</a>
    </span>


    <span class="navLinkContainer">
        <a class="navElement navLink" href="enigma.php">Énigmes</a>
    </span>

   

    <?php
    require_once "source/initialization.php";
    if (IS_AUTH) {
        echo 
        '<span class="navLinkContainer">
        <a class="navElement navLink" href="panier.php">Panier</a>
    </span>

    <span class="navLinkContainer">
        <a class="navElement navLink" href="inventaire.php">Inventaire</a>
    </span>
    
     <span class="navLinkContainer">
        <a class="navElement navLink" href="revente.php">Revente</a>
    </span>'. 
        "<span class='navLinkContainer'>
        <a class='navElement navLink' href='deco.php'>Déconnexion</a> </span>";
        } else {
            echo "<span class='navLinkContainer'>
        <a class='navElement navLink' href='connexion.php'>Connexion</a>
    </span>".
     "<span class='navLinkContainer'>
        <a class='navElement navLink' href='inscription.php'>S'inscrire</a>
    </span>";
        }
    ?>

    <div class="navLinkContainer">
        <div class="dropdown navElement navLink">
            Paramètres
            <div class="dropdown-content-container">
                <?php
                require_once "source/initialization.php";
                if (IS_ADMIN) {
                        echo "<a href='ajout.php' class='dropdown-element navLink'> Ajout </a>";
                    
                }
                ?>
                <a href="aide.php" class="dropdown-element navLink"> Aide </a>
                <?php
                if (IS_AUTH){
                    echo '<a href="profil.php" class="dropdown-element navLink"> Profil </a>';
                }
                ?>
                
            </div>
        </div>
    </div>

</nav>