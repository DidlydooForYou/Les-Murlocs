<?php
include "include/php_setup.php";
require_once 'DAL/ReviewDAL.php';

if (!IS_AUTH) {
    header("Location: connexion.php");
    exit;
}

$connexion = Database::getConnexion();

$idItem = $_GET['idItem'];
$idJoueur = $_GET['idJoueur'];

$review = ReviewDAL::selectReview($connexion, $idItem, $idJoueur);
if (IS_ADMIN){

}
else if (!$review || $idJoueur != $_SESSION['id']) {
    header("Location: reviews.php?id=$idItem");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $comment = $_POST['comment'];
    $stars = $_POST['stars'];

    ReviewDAL::updateReview($connexion, $idItem, $idJoueur, $comment, $stars);

    header("Location: reviews.php?id=$idItem");
    exit;
}
include 'include/html_setup.php';
include "include/header.php";
include "include/nav.php";


$products = [];

if (!empty($_GET['id'])) {
    $id = $_GET['id'];
    $products = ReviewDAL::selectAllReviews($connexion, $id);
}

?>
<Title>DarQuest - Modifier Reviews</Title>
<link rel="stylesheet" href="public/css/reviews.css">

<main class="main" style="border:5px solid #c9a86a; border-top:none; border-bottom:none;">
    <div class="container">
        <div class="edit-review-wrapper">

            <h2>Modifier votre évaluation</h2>

            <form method="POST" class="edit-review-form">

                <label for="comment">Commentaire :</label>
                <textarea name="comment" id="comment" rows="4"
                    required><?= htmlspecialchars($review['commentaire']) ?></textarea>

                <label for="stars">Étoiles :</label>
                <div class="star-rating" name="stars" id="stars">
                    <input type="radio" name="stars" id="star5" value="5"><label for="star5">★</label>
                    <input type="radio" name="stars" id="star4" value="4"><label for="star4">★</label>
                    <input type="radio" name="stars" id="star3" value="3"><label for="star3">★</label>
                    <input type="radio" name="stars" id="star2" value="2"><label for="star2">★</label>
                    <input type="radio" name="stars" id="star1" value="1"><label for="star1">★</label>
                    <input type="radio" name="stars" id="star0" value="0" checked><label for="star0" hidden>☆</label>
                </div>

                <input type="submit" value="Mettre à jour" class="btn btn-boot send-btn">

            </form>

            <a href="reviews.php?id=<?= $idItem ?>" class="back-link">Retourner aux évaluations</a>

        </div>
    </div>
</main>

<?php include "include/footer.php"; ?>