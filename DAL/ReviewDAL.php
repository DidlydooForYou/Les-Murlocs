<?php
class ReviewDAL{
    public static function selectAllReviews(PDO $connexion, int $id){
        $sql = "SELECT e.*, jj.alias, jj.photoProfil FROM evaluations e INNER JOIN joueursjeu jj on e.JoueursJeu_idJoueur = jj.idJoueur WHERE Item_idItem = :id";

        $statement = $connexion->prepare($sql);

        $statement->bindValue('id', $id, PDO::PARAM_STR);

        $statement->execute();

        $result = $statement->fetchAll();

        return $result;
    }

    public static function insertReview(PDO $connexion, int $idItem, int $idJoueur, string $commentaire, int $etoiles){
        $sql = "INSERT INTO evaluations (commentaire, etoiles, JoueursJeu_idJoueur, Item_idItem) VALUES (:commentaire, :etoiles, :idJoueur, :idItem)";

        $statement = $connexion -> prepare($sql);

        $statement->bindValue(':commentaire', $commentaire);
        $statement->bindValue(':idJoueur', $idJoueur);
        $statement->bindValue(':idItem', $idItem);
        $statement->bindValue(':etoiles', $etoiles);

        $statement->execute();

        $result = $statement->fetchAll();

        return $result;
    }

    
}