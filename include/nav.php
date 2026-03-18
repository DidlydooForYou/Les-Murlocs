<nav class="navContainer">
    <span class="navLinkContainer">
        <a class="navElement navLink" href="index.php">Vitrine</a>
    </span>

    <span class="navLinkContainer">
        <a class="navElement navLink" href="connexion.php">Panier</a>
    </span>

    <span class="navLinkContainer">
        <a class="navElement navLink" href="inventaire.php">Inventaire</a>
    </span>

    <span class="navLinkContainer">
        <a class="navElement navLink" href="enigma.php">Énigmes</a>
    </span>

    <span class="navLinkContainer">
        <a class="navElement navLink" href="revente.php">Revente</a>
    </span>

    <?php
    if (isset($_SESSION["connexion"])) {
        if ($_SESSION["connexion"]) {
            echo "<span class='navLinkContainer'>
        <a class='navElement navLink' href='deco.php'>Déconnexion</a> </span>";
        }
        else{
            echo "<span class='navLinkContainer'>
        <a class='navElement navLink' href='connexion.php'>Connexion</a>
    </span>";
        }
    }
    else{
        echo "<span class='navLinkContainer'>
        <a class='navElement navLink' href='connexion.php'>Connexion</a>
    </span>";
        }
    
    ?>

  <div class="navLinkContainer">
        <div class="dropdown navElement navLink">
            Paramètres
            <div class="dropdown-content-container">
                <a href="aide.php" class="dropdown-element navLink"> Aide </a>
                <a href="profil.php" class="dropdown-element navLink"> Profil </a>
            </div>
        </div>
    </div>

</nav>