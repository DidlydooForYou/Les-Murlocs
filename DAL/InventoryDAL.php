<?php
class InventoryDAL{
    public static function selectAll(PDO $connexion): array {

        $sql = "SELECT * from inventaire";

        $statement = $connexion->prepare($sql); 
             
        $statement->execute();

        return $statement->fetchAll();

    }
<<<<<<< Updated upstream
=======

    public static function utiliserPotion(PDO $connexion, $idItem, $idJoueur) {

        $sql = "CALL UtiliserPotionProcedure(:idItem, :idJoueur)";

        $stmt = $connexion->prepare($sql);

        $stmt->bindValue(':idItem', $idItem, PDO::PARAM_INT);

        $stmt->bindValue(':idJoueur', $idJoueur, PDO::PARAM_INT);

        $stmt->execute();
    }


>>>>>>> Stashed changes
}
?>