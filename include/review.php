<?php
require_once 'source/initialization.php';
require_once 'core/Database.php';
require_once 'source/ReviewDAL.php';
require_once 'sql/bd.php';

$connexion = Database::getConnexion($dbConfig);

$products = [];

if (!empty($_GET['id'])) {
    $id = $_GET['id'];
    $products = ReviewDAL::selectAllReviews($connexion, $id);
}

?>

<div class="container">
    <div class="reviews-wrapper">
        <?php foreach ($products as $product): ?>
            <div class="review-card">
                <div class="review-header">

                    <div class="user-info">
                        <img src="<?= $product['photoProfil'] ?>" class="profile" alt="<?= $product['alias'] ?>">
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
            </div>
        <?php endforeach; ?>
    </div>
</div>