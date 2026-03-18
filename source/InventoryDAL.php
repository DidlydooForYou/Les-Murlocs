<?php
class InventoryDAL{
    public static function selectAll(PDO $connexion): array {

        $sql = "SELECT * from DbDarquest";

        $statement = $connexion->prepare($sql); 
             
        $statement->execute();

        return $statement->fetchAll();

    }
    public static function selectByTitle(PDO $connexion, string $search): array{
        $sql = "SELECT * from DbDarquest where nomItem like :search";

        $statement = $connexion->prepare($sql);

        $statement->bindValue('search', $search, PDO::PARAM_STR);

        $statement->execute();

        $result = $statement->fetchAll();

        return $result;
    }
}
?>