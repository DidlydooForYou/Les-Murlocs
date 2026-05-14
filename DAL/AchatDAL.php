<?php
class AchatDAL{
    public static function selectIfBought(PDO $connexion, string $idItem, string $idJoueur) : bool {
        $sql = "SELECT achat from achat WHERE idJoueur = :idJoueur AND idItem = :idItem;";

        $statement = $connexion->prepare($sql);

        $statement->bindValue('idJoueur', $idJoueur, PDO::PARAM_STR);
        $statement->bindValue('idItem', $idItem, PDO::PARAM_STR);
        
        $statement->execute();

        return $statement->fetch() !== false;
    }

    public static function insertPurchase(PDO $connexion, int $idItem, int $idJoueur) {
    $sql = "INSERT INTO achat (idItem, achat, idJoueur) VALUES (:idItem, :achat, :idJoueur)";

    $statement = $connexion->prepare($sql);

    $statement->bindValue(':idItem', $idItem, PDO::PARAM_INT);
    $statement->bindValue(':achat', true, PDO::PARAM_BOOL); 
    $statement->bindValue(':idJoueur', $idJoueur, PDO::PARAM_INT);

    return $statement->execute();
}

}