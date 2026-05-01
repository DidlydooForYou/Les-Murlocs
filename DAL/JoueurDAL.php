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
        $sql = "Select nom,prenom,email,photoProfil from joueursinfo join joueursjeu on joueursjeu.idJoueur = joueursinfo.JoueursJeu_idJoueur where joueursjeu.idJoueur = :id";
        $statement = $connexion->prepare($sql);

                $statement->bindValue('id', $id, PDO::PARAM_STR);

        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);

    }

    
}