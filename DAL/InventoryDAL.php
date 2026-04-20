<?php
class InventoryDAL{
public static function selectAll(PDO $connexion): array {

    $sql = "
        SELECT 
            inv.,
            i.,
            arme.efficacite,
            arme.genreArme,
            armure.matiere,
            armure.taille,
            potion.effet,
            potion.duree,
            sort.instantane,
            sort.dommage
        FROM inventaire inv
        JOIN item i ON inv.Item_idItem = i.idItem
        LEFT JOIN armes ON arme.Item_idItem = i.idItem
        LEFT JOIN armure ON armure.Item_idItem = i.idItem
        LEFT JOIN potions ON potion.Item_idItem = i.idItem
        LEFT JOIN sorts ON sort.Item_idItem = i.idItem
    ";

    $statement = $connexion->prepare($sql); 

    $statement->execute();

    return $statement->fetchAll();

}

    public static function vendreItem(PDO $connexion, $idItem, $idJoueur) {

        $sql = "CALL procedureVendreItem(:idItem, :idJoueur)";

        $stmt = $connexion->prepare($sql);

        $stmt->bindValue(':idItem', $idItem, PDO::PARAM_INT);

        $stmt->bindValue(':idJoueur', $idJoueur, PDO::PARAM_INT);

        $stmt->execute();
    }

}


?>