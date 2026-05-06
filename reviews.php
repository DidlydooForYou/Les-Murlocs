<?php
include "include/php_setup.php";
require_once 'DAL/VitrineDAL.php';
require_once 'DAL/ReviewDAL.php';
require_once 'DAL/AchatDAL.php';
require_once 'core/initialization.php';

if (!IS_AUTH) {
    include "include/html_setup.php";
    include "include/header.php";
    include "include/nav.php";
    ?>
    <main class="main" style="border:5px solid #c9a86a; border-top:none; border-bottom:none;">
        <div class="container" style="display:flex; justify-content:center; padding:60px 0;">

            <div class="connexion-wrapper" style="
                    width:350px;
                    background:#517189;
                    border:3px solid #c9a86a;
                    border-radius:12px;
                    padding:30px;
                    text-align:center;
                    box-shadow:0 0 6px rgba(0,0,0,0.4);
                 ">

                <h2 style="color:#c9a86a; margin-bottom:15px; font-size:22px;">
                    Accès restreint
                </h2>

                <p style="color:white; font-size:16px; margin-bottom:25px;">
                    Vous devez être connecté pour voir les avis.
                </p>

                <a href="connexion.php" class="btn btn-boot" style="width:100%; display:block; padding:10px 0;">
                    Se connecter
                </a>

            </div>

        </div>
    </main>
    <?php
    include_once INCLUDE_FILE . '/footer.php';
    exit;
}




$connexion = Database::getConnexion();

$idItem = $_GET['id'];
$idJoueur = $_SESSION['id'];



if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['comment'])) {
    $comment = $_POST['comment'];
    $stars = $_POST['stars'];

    ReviewDAL::insertReview($connexion, $idItem, $idJoueur, $comment, $stars);
    header("Location: reviews.php?id=" . $idItem);
    exit;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = (int) $_GET['id'];
$details = VitrineDAL::selectById($connexion, $id);
$textNoReviews = '';

if (!$details) {
    header("Location: index.php");
    exit;
}


include "include/html_setup.php";
include "include/header.php";
include "include/nav.php";

$reviews = ReviewDAL::selectAllReviews($connexion, $id);

$totalReviews = count($reviews);
$sumStars = 0;

$starsCount = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0];

foreach ($reviews as $r) {
    $sumStars += $r['etoiles'];
    $starsCount[$r['etoiles']]++;
}

$average = $totalReviews > 0 ? round($sumStars / $totalReviews, 1) : 0;

$percentages = [];
foreach ($starsCount as $star => $count) {
    $percentages[$star] = $totalReviews > 0
        ? round(($count / $totalReviews) * 100)
        : 0;
}
?>

<link rel="stylesheet" href="public/css/reviews.css">
<Title>DarQuest - Reviews</Title>

<main class="main" style="border:5px solid #c9a86a; border-top:none; border-bottom:none;">
    <div class="reviews-layout">

        <div class="reviews-summary">
            <h4>Commentaires des clients</h4>

            <div class="total">
                <?= $totalReviews ?> évaluations
            </div>

            <?php for ($i = 5; $i >= 1; $i--): ?>
                <a href="reviews.php?id=<?= $id ?>&stars=<?= $i ?>" class="bar-row">
                    <span><?= $i ?> étoiles</span>

                    <div class="bar">
                        <div class="fill" style="width: <?= $percentages[$i] ?>%"></div>
                    </div>

                    <span><?= $percentages[$i] ?>%</span>
                </a>
            <?php endfor; ?>
            <a href="reviews.php?id=<?= $id ?>" class="show-all">Tous les avis</a>
        </div>

        <!-- RIGHT PANEL -->
        <div class="reviews-list">
            <div class="container">
                <div class="reviews-wrapper">
                    <br>
                    <?php if (!ReviewDAL::userHasReview($connexion, $idItem, $idJoueur) && AchatDAL::selectIfBought($connexion, $idItem, $idJoueur)): ?>
                        <form class="commentBarContainer" method="POST" action="reviews.php?id=<?= $id ?>">

                            <?php if (IS_AUTH): ?>
                                <div class="comment-top">
                                    <input name="comment" class="comment-input" type="text" placeholder="Entrer un commentaire"
                                        required>

                                    <div class="star-rating">
                                        <input type="radio" name="stars" id="star5" value="5"><label for="star5">★</label>
                                        <input type="radio" name="stars" id="star4" value="4"><label for="star4">★</label>
                                        <input type="radio" name="stars" id="star3" value="3"><label for="star3">★</label>
                                        <input type="radio" name="stars" id="star2" value="2"><label for="star2">★</label>
                                        <input type="radio" name="stars" id="star1" value="1"><label for="star1">★</label>
                                        <input type="radio" name="stars" id="star0" value="0" checked><label for="star0"
                                            hidden>☆</label>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-boot send-btn">Envoyer</button>
                            <?php else: ?>
                                <a href="connexion.php" class="btn btn-boot mt-auto"
                                    style="background-color: #b3b3b3; display: flex; justify-content: center;">Connectez-vous
                                    pour
                                    envoyer un message</a>
                            <?php endif; ?>

                        </form>
                    <?php endif ?>

                    <?php
                    $products = [];

                    if (!empty($_GET['id'])) {
                        $id = $_GET['id'];
                        $products = [];

                        if (isset($_GET['stars']) && is_numeric($_GET['stars'])) {
                            $stars = (int) $_GET['stars'];
                            $products = ReviewDAL::selectByNumber($connexion, $id, $stars);
                        } else {
                            $products = $reviews;
                        }
                    }

                    if (empty($products)) {
                        $textNoReviews = "Pas de commentaires pour le moment";
                    }
                    ?>

                    <h2 style="text-align:center;"><?= $textNoReviews ?></h2>

                    <div class="container">
                        <div class="reviews-wrapper">
                            <?php foreach ($products as $product): ?>
                                <div class="review-card">
                                    <div class="review-header">

                                        <div class="user-info">
                                            <img src="<?= $product['photoProfil'] ?>" class="profile"
                                                alt="<?= $product['alias'] ?>">
                                            <div class="alias"><?= $product['alias'] ?></div>
                                        </div>

                                        <div class="stars-reviews">
                                            <span class="star-number"><?= $product['etoiles'] ?></span>

                                            <span class="star-icons">
                                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                                    <span class="star"><?= $i <= $product['etoiles'] ? "★" : "☆" ?></span>
                                                <?php endfor; ?>
                                            </span>
                                        </div>

                                    </div>


                                    <div class="comment"><?= $product['commentaire'] ?></div>

                                    <div class="modification-comments">
                                        <?php if (IS_AUTH && $product['JoueursJeu_idJoueur'] == $_SESSION['id'] || IS_ADMIN): ?>
                                            <a href="editReview.php?idItem=<?= $id ?>&idJoueur=<?= $_SESSION['id'] ?>"
                                                class="edit-btn">✎ Modifier</a>
                                        <?php endif; ?>
                                        <?php if (IS_AUTH && $product['JoueursJeu_idJoueur'] == $_SESSION['id'] || IS_ADMIN): ?>
                                            <a class="edit-btn"
                                                onclick="confirmDelete(<?= $product['Item_idItem'] ?>, <?= $product['JoueursJeu_idJoueur'] ?>)">⛔
                                                Retirer</a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</main>

<script>
    function confirmDelete(idItem, idJoueur) {
        if (confirm("Voulez-vous vraiment retirer votre évaluation ?")) {
            window.location.href = "deleteReview.php?idItem=" + idItem + "&idJoueur=" + idJoueur;
        }
    }
</script>


<?php include_once INCLUDE_FILE . '/footer.php'; ?>