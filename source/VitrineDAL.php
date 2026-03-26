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
    public static function selectById(PDO $connexion, int $id): false|array{
        $sql = "SELECT * from item where idItem = :id";

        $statement = $connexion->prepare($sql);
        
        $statement->bindValue('id', $id, PDO::PARAM_STR);

        $statement->execute();

        $result = $statement->fetchAll();

        return $result;
    }
    public static function selectByPrice(PDO $connexion, string $sortWay){
        if($sortWay === "price_asc"){
            $sql = "SELECT * from item ORDER BY prix";
        }else if($sortWay === "price_desc"){
            $sql = "SELECT * from item ORDER BY prix DESC";
        }

        $statement = $connexion->prepare($sql);

        $statement->execute();

        $result = $statement->fetchAll();

        return $result;
    }

    public static function selectByAlphabete(PDO $connexion, string $alphab){
        if($alphab === "alpha_asc"){
            $sql = "SELECT * from item ORDER BY nomItem";
        }else if($alphab === "alpha_desc"){
            $sql = "SELECT * from item ORDER BY nomItem DESC";
        }

        $statement = $connexion->prepare($sql);

        $statement->execute();

        $result = $statement->fetchAll();

        return $result;
    }
    public static function selectByCategory(PDO $connexion, string $type){
        if($type === "armors"){
            $sql = "SELECT * from item i INNER JOIN armure a ON i.idItem = a.Item_idItem";
        }else if($type === "weapons"){
            $sql = "SELECT * from item i INNER JOIN armes ar ON i.idItem = ar.Item_idItem";
        }else if($type === "potions"){
            $sql = "SELECT * from item i INNER JOIN potions p ON i.idItem = p.Item_idItem";
        }else if($type === "sorts"){
            $sql = "SELECT * from item i INNER JOIN sorts s ON i.idItem = s.Item_idItem";
        }

        $statement = $connexion->prepare($sql);

        $statement->execute();

        $result = $statement->fetchAll();

        return $result;
    }

    public static function selectByFilters(PDO $connexion, string $type, string $alphab, string $sortPrix){
        if($type != null){
            if($type === "armors"){
                $sql = "SELECT * from item i INNER JOIN armure a ON i.idItem = a.Item_idItem";
            }else if($type === "weapons"){
                $sql = "SELECT * from item i INNER JOIN armes ar ON i.idItem = ar.Item_idItem";
            }else if($type === "potions"){
                $sql = "SELECT * from item i INNER JOIN potions p ON i.idItem = p.Item_idItem";
            }else if($type === "sorts"){
                $sql = "SELECT * from item i INNER JOIN sorts s ON i.idItem = s.Item_idItem";
            }
        }
    }
}
?>