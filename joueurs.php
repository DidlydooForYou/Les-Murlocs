<?php 
    include 'include/php_setup.php';
    include_once "DAL/EnigmaDAL.php";
    doitEtreCo();
?>

<title>DarQuest - Profil</title>

<?php 
    include 'include/html_setup.php';
    include 'include/header.php';
    include 'include/nav.php'; 
?>

<link rel="stylesheet" href="public/css/enigma.css">

<main class="main">
    <div class="profilMain">

        <?php
        $connexion = Database::getConnexion();

        $sql = "
            SELECT idJoueur, alias
            FROM joueursjeu
            ORDER BY alias
        ";

        $statement = $connexion->prepare($sql);
        $statement->execute();

        $joueurs = $statement->fetchAll();
        ?>


        <h2 style="color:black; text-align:center;">Liste des joueurs</h2>

        
        <div style="
            display:grid;
            grid-template-columns:repeat(3, 1fr);
            gap:25px;
            margin-top:25px;
            padding:20px;
        ">

            <?php foreach ($joueurs as $joueur): ?>

                <a href="joueursinventaire.php?id=<?= $joueur['idJoueur'] ?>"
                   style="text-decoration:none;">

                    <div style="
                        border:2px solid #d4a84f;
                        border-radius:10px;
                        padding:25px;
                        text-align:center;
                        background-color:#547b95;
                        color:white;
                        font-weight:bold;
                        font-size:24px;
                        box-shadow:0 0 12px rgba(0,0,0,0.35);
                    ">
                        <?= $joueur['alias'] ?>
                    </div>

                </a>

            <?php endforeach; ?>

        </div>

    </div>
</main>

<?php include 'include/footer.php' ?>