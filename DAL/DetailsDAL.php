<?php
class DetailsDAL{
    public static function selectByType(PDO $connexion, int $id, string $type){
        if($type === "arme"){
            $sql = "SELECT efficacite, genreArme, Item_idItem from armes where Item_idItem = :id";
        }
        else if($type === "potion"){
            $sql = "SELECT effet, duree, Item_idItem from potions where Item_idItem = :id";
        }
        else if($type === "sort"){
            $sql = "SELECT instantane, dommage, Item_idItem from sorts where Item_idItem = :id";
        }
        else if($type === "armure"){
            $sql = "SELECT matiere, taille, Item_idItem from armure where Item_idItem = :id";
        }

        $statement = $connexion->prepare($sql);

        $statement->bindValue('id', $id, PDO::PARAM_STR);

        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }    
}