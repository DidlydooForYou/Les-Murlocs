<nav class="navContainer">

    <span class="navLinkContainer">
        <a class="navElement navLink" href="index.php">Vitrine</a>
    </span>

    <?php if (IS_AUTH): ?>
        <?php if (!IS_ADMIN): ?>



            <span class="navLinkContainer">
                <a class="navElement navLink" href="enigma.php">Énigma</a>
            </span>

        <?php else: ?>

            <!--
            <div class="navLinkContainer" onclick="window.location='enigma.php'">
                <div class="dropdown navElement navLink">
                    Énigma
                    <div class="dropdown-content-container">
                        <a href='ajoutEnigma.php' class='dropdown-element navLink'> Ajout </a>
                    </div>
                </div>
            </div>
            -->

            <div class="navLinkContainer dropdown navElement navLink">

                <a href="enigma.php" style="text-decoration: none; color:black;">
                    Énigma
                </a>
                <button id="enigmaDropdown" class="dropdownToggle">
                    ▼
                </button>

                <div id="enigmaDropdownContent" class="dropdown-content-container">
                        <a href='ajoutEnigma.php' class='dropdown-element navLink'> Ajout </a>
                </div>

            </div>

            <script>
                let enigmaDropdown = document.getElementById("enigmaDropdown");
                let enigmaDropdownContent = document.getElementById("enigmaDropdownContent");
                enigmaDropdown.addEventListener("click", (e) => {
                    e.preventDefault();
                    enigmaDropdownContent.classList.toggle("open");
                });
            </script>

        <!---->

        <?php endif; ?>

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

    <?php else: ?>

        <span class='navLinkContainer'>
            <a class='navElement navLink' href='connexion.php'>Connexion</a>
        </span>

        <span class='navLinkContainer'>
            <a class='navElement navLink' href='inscription.php'>S'inscrire</a>
        </span>

    <?php endif; ?>


    <div class="navLinkContainer dropdown navElement navLink">

        <div style="text-decoration: none; color:black;">
            Paramètres
        </div>

        <button id="paramDropdown" class="dropdownToggle">
            ▼
        </button>

        <div id="paramDropdownContent" class="dropdown-content-container">

            <?php if (IS_ADMIN): ?>
                <a href='ajout.php' class='dropdown-element navLink'> Ajout </a>
            <?php endif; ?>

            <?php if (IS_AUTH): ?>
                <a href="profil.php" class="dropdown-element navLink"> Profil </a>
            <?php endif; ?>

            <a href="aide.php" class="dropdown-element navLink dropdown-bottom"> Aide </a>

        </div>

    </div>

    <script>
        let paramDropdown = document.getElementById("paramDropdown");
        let paramDropdownContent = document.getElementById("paramDropdownContent");
        paramDropdown.addEventListener("click", (e) => {
            e.preventDefault();
            paramDropdownContent.classList.toggle("open");
        });
    </script>

</nav>

