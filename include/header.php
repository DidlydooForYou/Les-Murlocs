<header class="headerContainer">
    <a href="index.php" class="bannerLogoContainer" > <img class="bannerLogo" src="public/images/LogoDarQuest.png" alt="LogoDarQuest.png"> </a>

    <div id="header-coins">
        <!-- Banque totale des joueurs ? -->
        <?php if(isset($_SESSION['id'])) : 
            require_once 'source/initialization.php';
            require_once 'core/Database.php';
            require_once 'source/CoinManagement.php';
            require_once 'sql/bd.php';

            $connexion = Database::getConnexion($dbConfig);
            $userBank = Coins::getUserBank($connexion, $_SESSION['id']);
            $userBank = Coins::multiplierCoins($userBank['pieceOr'], $userBank['pieceArgent'], $userBank['pieceBronze'],1);
            $userAlias = obtenir_alias($_SESSION['id']);
        ?>
            <span style="text-align: right;"><?= $userAlias ?></span>

            <div class="coins-container">
                <img class="coin-image" src="public/images/gold-coin.png" alt="gold-coin">
                <span class="coin-amount"><?=$userBank['Or']?></span>

                <img class="coin-image" src="public/images/silver-coin.png" alt="silver-coin">
                <span class="coin-amount"><?=$userBank['Argent']?></span>

                <img class="coin-image" src="public/images/bronze-coin.png" alt="bronze-coin">
                <span class="coin-amount"><?=$userBank['Bronze']?></span>
            </div>
        <?php endif;?>
    </div>


</header>