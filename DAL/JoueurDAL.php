<?php
class JoueurDAL{
    public static function selectPdv(PDO $connexion, int $id){
        $sql = "SELECT PointsDeVie from joueursjeu where idJoueur = :id";

        $statement = $connexion->prepare($sql);

        $statement->bindValue('id', $id, PDO::PARAM_STR);

        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }  
    public static function getInfos(PDO $connexion, int $id){
        $sql = "SELECT nom,prenom,email from joueursinfo where JoueursJeu_idJoueur = :id";
        $statement = $connexion->prepare($sql);

                $statement->bindValue('id', $id, PDO::PARAM_STR);

        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);

    }
    
}