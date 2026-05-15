<?php
include "include/html_setup.php";
require_once "DAL/ReviewDAL.php";
require_once "core/initialization.php";
require_once "core/Database.php";
if (!IS_AUTH) {
    header("Location: connexion.php");
    exit;
}

$connexion = Database::getConnexion();

$idItem = $_GET['idItem'];
$idJoueur = $_GET['idJoueur'];
if (IS_ADMIN){
    ReviewDAL::deleteReview($connexion, $idItem, $idJoueur);

header("Location: reviews.php?id=$idItem");
exit;
}

if ($idJoueur != $_SESSION['id'] ) {
    header("Location: reviews.php?id=$idItem");
    exit;
}

ReviewDAL::deleteReview($connexion, $idItem, $idJoueur);

header("Location: reviews.php?id=$idItem");
exit;
