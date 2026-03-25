<nav class="navContainer">
    <span class="navLinkContainer">
        <a class="navElement navLink" href="index.php">Vitrine</a>
    </span>

    <span class="navLinkContainer">
        <a class="navElement navLink" href="panier.php">Panier</a>
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
        } else {
            echo "<span class='navLinkContainer'>
        <a class='navElement navLink' href='connexion.php'>Connexion</a>
    </span>";
        }
    } else {
        echo "<span class='navLinkContainer'>
        <a class='navElement navLink' href='connexion.php'>Connexion</a>
    </span>";
    }

    ?>

    <div class="navLinkContainer">
        <div class="dropdown navElement navLink">
            Paramètres
            <div class="dropdown-content-container">
                <?php
                
                if (!isset($_SESSION["admin"]) && isset($_SESSION["id"])) {
                    require_once "sql/bd.php";
                    $admin1 = administrateur($_SESSION["id"])["administrateur"];
                    if ($admin1 == 1) {
                        echo "<a href='ajout.php' class='dropdown-element navLink'> Ajout </a>";
                    }
                }
                ?>
                <a href="aide.php" class="dropdown-element navLink"> Aide </a>
                <a href="profil.php" class="dropdown-element navLink"> Profil </a>
            </div>
        </div>
    </div>

</nav>