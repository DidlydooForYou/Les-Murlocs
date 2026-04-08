<?php
class VitrineDAL{
    public static function selectAll(PDO $connexion): array {

        $sql = "SELECT i.idItem, i.nomItem, i.prixOr, i.prixArgent, i.prixBronze, i.description, i.photoItem, AVG(etoiles) as moyenne_etoiles, COUNT(etoiles) as nb_reviews from item i LEFT JOIN evaluations e ON i.idItem = e.Item_idItem GROUP BY i.idItem, i.nomItem, i.description, i.photoItem";

        $statement = $connexion->prepare($sql); 
             
        $statement->execute();

        return $statement->fetchAll();

    }
    public static function selectByTitle(PDO $connexion, string $search): array{
        $sql = "SELECT i.idItem, i.nomItem, i.prixOr, i.prixArgent, i.prixBronze, i.description, i.photoItem, AVG(etoiles) as moyenne_etoiles, COUNT(etoiles) as nb_reviews from item i LEFT JOIN evaluations e ON i.idItem = e.Item_idItem where nomItem like :search GROUP BY i.idItem, i.nomItem, i.description, i.photoItem";

        $statement = $connexion->prepare($sql);

        $statement->bindValue('search', $search, PDO::PARAM_STR);

        $statement->execute();

        $result = $statement->fetchAll();

        return $result;
    }
    public static function selectById(PDO $connexion, int $id): false|array{
        $sql = "SELECT i.qttItem, i.idItem, i.nomItem, i.prixOr, i.prixArgent, i.prixBronze, i.description, i.photoItem, AVG(etoiles) as moyenne_etoiles, COUNT(etoiles) as nb_reviews from item i LEFT JOIN evaluations e ON i.idItem = e.Item_idItem where idItem = :id GROUP BY i.idItem, i.nomItem, i.prixOr, i.prixArgent, i.prixBronze, i.description, i.photoItem, i.qttItem";

        $statement = $connexion->prepare($sql);
        
        $statement->bindValue('id', $id, PDO::PARAM_STR);

        $statement->execute();

        $result = $statement->fetchAll();

        return $result;
    }
    public static function selectByPrice(PDO $connexion, string $sortWay){
    if($sortWay === "price_asc"){
        $sql = "SELECT i.idItem, i.nomItem, i.prixOr, i.prixArgent, i.prixBronze, 
                       i.description, i.photoItem, 
                       AVG(etoiles) as moyenne_etoiles, COUNT(etoiles) as nb_reviews
                FROM item i 
                LEFT JOIN evaluations e ON i.idItem = e.Item_idItem
                GROUP BY i.idItem, i.nomItem, i.description, i.photoItem, i.prixOr, i.prixArgent, i.prixBronze
                ORDER BY i.prixOr ASC, i.prixArgent ASC, i.prixBronze ASC";
    } else if($sortWay === "price_desc"){
        $sql = "SELECT i.idItem, i.nomItem, i.prixOr, i.prixArgent, i.prixBronze, 
                       i.description, i.photoItem, 
                       AVG(etoiles) as moyenne_etoiles, COUNT(etoiles) as nb_reviews
                FROM item i 
                LEFT JOIN evaluations e ON i.idItem = e.Item_idItem
                GROUP BY i.idItem, i.nomItem, i.description, i.photoItem, i.prixOr, i.prixArgent, i.prixBronze
                ORDER BY i.prixOr DESC, i.prixArgent DESC, i.prixBronze DESC";
    }

    $statement = $connexion->prepare($sql);
    $statement->execute();
    return $statement->fetchAll();
}

    public static function selectByAlphabete(PDO $connexion, string $alphab){
        if($alphab === "alpha_asc"){
            $sql = "SELECT i.idItem, i.nomItem, i.prixOr, i.prixArgent, i.prixBronze, i.description, i.photoItem, AVG(etoiles) as moyenne_etoiles, COUNT(etoiles) as nb_reviews from item i LEFT JOIN evaluations e ON i.idItem = e.Item_idItem GROUP BY i.idItem, i.nomItem, i.description, i.photoItem ORDER BY nomItem";
        }else if($alphab === "alpha_desc"){
            $sql = "SELECT i.idItem, i.nomItem, i.prixOr, i.prixArgent, i.prixBronze, i.description, i.photoItem, AVG(etoiles) as moyenne_etoiles, COUNT(etoiles) as nb_reviews from item i LEFT JOIN evaluations e ON i.idItem = e.Item_idItem GROUP BY i.idItem, i.nomItem, i.description, i.photoItem ORDER BY nomItem DESC";
        }

        $statement = $connexion->prepare($sql);

        $statement->execute();

        $result = $statement->fetchAll();

        return $result;
    }
    public static function selectByCategory(PDO $connexion, string $type){
        if($type === "armors"){
            $sql = "SELECT i.idItem, i.nomItem, i.prixOr, i.prixArgent, i.prixBronze, i.description, i.photoItem, AVG(etoiles) as moyenne_etoiles, COUNT(etoiles) as nb_reviews from item i INNER JOIN armure a ON i.idItem = a.Item_idItem LEFT JOIN evaluations e ON i.idItem = e.Item_idItem GROUP BY i.idItem, i.nomItem, i.description, i.photoItem";
        }else if($type === "weapons"){
            $sql = "SELECT i.idItem, i.nomItem, i.prixOr, i.prixArgent, i.prixBronze, i.description, i.photoItem, AVG(etoiles) as moyenne_etoiles, COUNT(etoiles) as nb_reviews from item i INNER JOIN armes ar ON i.idItem = ar.Item_idItem LEFT JOIN evaluations e ON i.idItem = e.Item_idItem GROUP BY i.idItem, i.nomItem, i.description, i.photoItem";
        }else if($type === "potions"){
            $sql = "SELECT i.idItem, i.nomItem, i.prixOr, i.prixArgent, i.prixBronze, i.description, i.photoItem, AVG(etoiles) as moyenne_etoiles, COUNT(etoiles) as nb_reviews from item i INNER JOIN potions p ON i.idItem = p.Item_idItem LEFT JOIN evaluations e ON i.idItem = e.Item_idItem GROUP BY i.idItem, i.nomItem, i.description, i.photoItem";
        }else if($type === "sorts"){
            $sql = "SELECT i.idItem, i.nomItem, i.prixOr, i.prixArgent, i.prixBronze, i.description, i.photoItem, AVG(etoiles) as moyenne_etoiles, COUNT(etoiles) as nb_reviews from item i INNER JOIN sorts s ON i.idItem = s.Item_idItem LEFT JOIN evaluations e ON i.idItem = e.Item_idItem GROUP BY i.idItem, i.nomItem, i.description, i.photoItem";
        }

        $statement = $connexion->prepare($sql);

        $statement->execute();

        $result = $statement->fetchAll();

        return $result;
    }

    public static function ajouterPanier(PDO $connexion, $idJoueur, $idItem):bool {

        $sql = "insert into panier (qtPanier, JoueursJeu_idJoueur, Item_idItem) values (:qtItem,:idJoueur,:idItem)";

        $stmt = $connexion->prepare($sql);

        $stmt->bindValue('qtItem', 1, PDO::PARAM_INT);
        $stmt->bindValue('idJoueur', $idJoueur, PDO::PARAM_INT);
        $stmt->bindValue('idItem', $idItem, PDO::PARAM_INT);

        $result = $stmt->execute();

        return $result;
    }

    
}
?>