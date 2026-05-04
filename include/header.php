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


            <h3 class="header-alias" style="color: #c9a86a;"><?= $userAlias ?></h3>

            <div class="pdv-container">
                <?php
                $maxPdv = 10;
                $coeurPlein = intdiv($pdv['PointsDeVie'], 3);
                $coeurNoir = $maxPdv - $coeurPlein;

                for ($i = 0; $i < $coeurPlein; $i++) {
                    echo "<span title='Il vous reste " . $pdv['PointsDeVie']. " points de vie' class='heart full'>❤️</span>";
                }

                for ($i = 0; $i < $coeurNoir; $i++) {
                    echo "<span title='Il vous reste " . $pdv['PointsDeVie']. " points de vie' class='heart empty'>🖤</span>";
                }
                ?>
            </div>

            <div class="coins-container" style="padding:10px; padding-right:0px">
                <img class="coin-image" src="public/images/gold-coin.png" alt="gold-coin">
                <span class="coin-amount" style="color: #FFD700"><?= $userBank['Or'] ?></span>

                <img class="coin-image" src="public/images/silver-coin.png" alt="silver-coin">
                <span class="coin-amount" style="color: #d7e2eb"><?= $userBank['Argent'] ?></span>

                <img class="coin-image" src="public/images/bronze-coin.png" alt="bronze-coin">
                <span class="coin-amount" style="color: #cb823a"><?= $userBank['Bronze'] ?></span>
            </div>

        <?php endif; ?>
    </div>


</header>