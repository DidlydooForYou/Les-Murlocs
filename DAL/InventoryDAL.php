<?php
class InventoryDAL
{
    public static function selectAll(PDO $connexion): array
    {

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

    public static function utiliserPotion(PDO $connexion, $idItem, $idJoueur) {

        $sql = "CALL UtiliserPotionProcedure(:idItem, :idJoueur)";
    }

    public static function selectById(PDO $connexion, int $idItem, int $idJoueur)
    {
        $sql = "
        SELECT 
            inv.*,
            i.*,
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
        LEFT JOIN armes arme ON arme.Item_idItem = i.idItem
        LEFT JOIN armure armure ON armure.Item_idItem = i.idItem
        LEFT JOIN potions potion ON potion.Item_idItem = i.idItem
        LEFT JOIN sorts sort ON sort.Item_idItem = i.idItem
        WHERE inv.Item_idItem = :idItem
        AND inv.JoueursJeu_idJoueur = :idJoueur
        LIMIT 1
    ";

        $stmt = $connexion->prepare($sql);
        $stmt->bindValue(':idItem', $idItem, PDO::PARAM_INT);
        $stmt->bindValue(':idJoueur', $idJoueur, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch();
    }


    public static function vendreItem(PDO $connexion, $idItem, $idJoueur)
    {

        $sql = "CALL procedureVendreItem(:idItem, :idJoueur)";

        $stmt = $connexion->prepare($sql);

        $stmt->bindValue(':idItem', $idItem, PDO::PARAM_INT);

        $stmt->bindValue(':idJoueur', $idJoueur, PDO::PARAM_INT);

        $stmt->execute();
    }

    public static function decreaseInventory(PDO $connexion, int $idJoueur, int $idItem, int $amount)
    {
        $sql = "
        UPDATE inventaire
        SET qttItem = qttItem - :amount
        WHERE JoueursJeu_idJoueur = :idJoueur
        AND Item_idItem = :idItem
        AND qttItem >= :amount
    ";

        $stmt = $connexion->prepare($sql);
        $stmt->bindValue(':amount', $amount, PDO::PARAM_INT);
        $stmt->bindValue(':idJoueur', $idJoueur, PDO::PARAM_INT);
        $stmt->bindValue(':idItem', $idItem, PDO::PARAM_INT);

        $stmt->execute();
    }

    public static function increaseInventory(PDO $connexion, int $idJoueur, int $idItem, int $amount)
    {
        $sql = "
        UPDATE inventaire
        SET qttItem = qttItem + :amount
        WHERE JoueursJeu_idJoueur = :idJoueur
        AND Item_idItem = :idItem
    ";

        $stmt = $connexion->prepare($sql);
        $stmt->bindValue(':amount', $amount, PDO::PARAM_INT);
        $stmt->bindValue(':idJoueur', $idJoueur, PDO::PARAM_INT);
        $stmt->bindValue(':idItem', $idItem, PDO::PARAM_INT);

        $stmt->execute();
    }

    public static function removeItem(PDO $connexion, int $idItem): bool
    {
        $sql = "DELETE FROM inventaire WHERE Item_idItem = :idItem";
        $stmt = $connexion->prepare($sql);
        $stmt->bindValue(':idItem', $idItem, PDO::PARAM_INT);
        return $stmt->execute();
    }
}


?>