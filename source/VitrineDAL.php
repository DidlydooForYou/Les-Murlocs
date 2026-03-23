<?php
class VitrineDAL{
    public static function selectAll(PDO $connexion): array {

        $sql = "SELECT * from item";

        $statement = $connexion->prepare($sql); 
             
        $statement->execute();

        return $statement->fetchAll();

    }
    public static function selectByTitle(PDO $connexion, string $search): array{
        $sql = "SELECT * from item where nomItem like :search";

        $statement = $connexion->prepare($sql);

        $statement->bindValue('search', $search, PDO::PARAM_STR);

        $statement->execute();

        $result = $statement->fetchAll();

        return $result;
    }
    public static function SelectById(PDO $connexion, int $id): false|array{
        $sql = "SELECT * from item where idItem = :id";

        $statement = $connexion->prepare($sql);
        
        $statement->bindValue('id', $id, PDO::PARAM_STR);

        $statement->execute();

        $result = $statement->fetchAll();

        return $result;
    }
}
?>