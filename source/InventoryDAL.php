<?php
class InventoryDAL{
    public static function selectAll(PDO $connexion): array {

        $sql = "SELECT * from inventaire";

        $statement = $connexion->prepare($sql); 
             
        $statement->execute();

        return $statement->fetchAll();

    }

}
?>