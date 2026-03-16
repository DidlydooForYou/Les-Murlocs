<?php
class InventoryDAL{
    public static function selectAll(PDO $connexion): array {

        $sql = "SELECT * from product";

        $statement = $connexion->prepare($sql); 
             
        $statement->execute();

        return $statement->fetchAll();

    }
}
?>