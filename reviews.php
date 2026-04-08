<?php
require_once 'core/error-exception.php';
require_once 'source/initialization.php';
require_once 'source/ReviewDAL.php';
require_once 'source/Page.php';
require_once 'core/Database.php';

const ACTIVE_PAGE = Page::Reviews;

include "include/header.php";
include "include/nav.php";
include "include/html_setup.php";

$connexion = Database::getConnexion($dbConfig);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['comment'])) {
    $comment = $_POST['comment'];
    $stars = $_POST['stars'];
    $idItem = $_GET['id'];
    $idJoueur = $_SESSION['id'];

    ReviewDAL::insertReview($connexion, $idItem, $idJoueur, $comment, $stars);

    header("Location: reviews.php?id=" . $idItem);
    exit;
}


?>

<link rel="stylesheet" href="public/css/reviews.css">
<Title>DarQuest - Reviews</Title>

<main class="main">
    <div class="container">
        <div class="reviews-wrapper">
            <br>
            <form class="commentBarContainer" method="POST" action="reviews.php?id=<?= $_GET['id'] ?>">

                <div class="comment-top">
                    <input name="comment" class="comment-input" type="text" placeholder="Entrer un commentaire"
                        required>

                    <div class="star-rating">
                        <input type="radio" name="stars" id="star5" value="5"><label for="star5">★</label>
                        <input type="radio" name="stars" id="star4" value="4"><label for="star4">★</label>
                        <input type="radio" name="stars" id="star3" value="3"><label for="star3">★</label>
                        <input type="radio" name="stars" id="star2" value="2"><label for="star2">★</label>
                        <input type="radio" name="stars" id="star1" value="1"><label for="star1">★</label>
                        <input type="radio" name="stars" id="star0" value="0" checked><label for="star0" hidden>☆</label>
                    </div>
                </div>

                <button type="submit" class="btn btn-boot send-btn">Envoyer</button>

            </form>




            <?php include_once INCLUDE_FILE . '/review.php'; ?>

        </div>
    </div>
</main>


<?php include_once INCLUDE_FILE . '/footer.php'; ?>