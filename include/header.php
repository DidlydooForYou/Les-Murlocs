<header class="headerContainer" style="border:5px solid #c9a86a; border-bottom:none;">
    <a href="index.php" class="bannerLogoContainer"> <img class="bannerLogo" src="public/images/LogoDarQuest.png"
            alt="LogoDarQuest.png"> </a>

    <div id="header-coins">
        <!-- Banque totale des joueurs ? -->
        <?php if (isset($_SESSION['id'])):
            require_once 'DAL/JoueurDAL.php';

            $connexion = Database::getConnexion();
            $userBank = Database::obtenir_capital($_SESSION['id']);
            $userBank = multiplierCoins($userBank['pieceOr'], $userBank['pieceArgent'], $userBank['pieceBronze'], 1);
            $userAlias = Database::obtenir_alias($_SESSION['id']);
            $pdv = JoueurDAL::selectPdv($connexion, $_SESSION['id'])
        ?>


            <h3 class="header-alias"><?= $userAlias ?></h3>

            <div class="pdv-container">
                <?php
                $maxPdv = 10;
                $currentPdv = $pdv['PointsDeVie'] / 3;

                for ($i = 0; $i < $currentPdv; $i++) {
                    echo '<span class="heart full">❤️</span>';
                }

                for ($i = $currentPdv; $i < $maxPdv; $i++) {
                    echo '<span class="heart empty">🖤</span>';
                }
                ?>
            </div>

            <div class="coins-container" style="padding:10px; padding-right:0px">
                <img class="coin-image" src="public/images/gold-coin.png" alt="gold-coin">
                <span class="coin-amount"><?= $userBank['Or'] ?></span>

                <img class="coin-image" src="public/images/silver-coin.png" alt="silver-coin">
                <span class="coin-amount"><?= $userBank['Argent'] ?></span>

                <img class="coin-image" src="public/images/bronze-coin.png" alt="bronze-coin">
                <span class="coin-amount"><?= $userBank['Bronze'] ?></span>
            </div>

        <?php endif; ?>
    </div>


</header>