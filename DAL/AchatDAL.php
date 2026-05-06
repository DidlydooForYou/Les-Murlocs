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
}