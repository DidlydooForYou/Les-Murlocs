<?php

class aideDAL {

    public static function obtenirJoueur(PDO $connexion, $idJoueur) {

        $sql = "
            SELECT nbrDemande, administrateur
            FROM joueursinfo
            JOIN joueursjeu 
            ON joueursinfo.JoueursJeu_idJoueur = joueursjeu.idJoueur
            WHERE joueursjeu.idJoueur = :idJoueur
        ";

        $stmt = $connexion->prepare($sql);
        $stmt->bindValue(':idJoueur', $idJoueur);
        $stmt->execute();

        return $stmt->fetch();
    }

    public static function ajouterDemande(PDO $connexion, $idJoueur) {

        $sql = "
            UPDATE joueursjeu
            SET nbrDemande = nbrDemande + 1
            WHERE idJoueur = :idJoueur
        ";

        $stmt = $connexion->prepare($sql);
        $stmt->bindValue(':idJoueur', $idJoueur);
        $stmt->execute();
    }

    public static function obtenirDemandes(PDO $connexion) {

        $sql = "
            SELECT alias, nbrDemande
            FROM joueursjeu
            WHERE nbrDemande > 0
        ";

        $stmt = $connexion->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public static function accepterDemande(PDO $connexion, $idJoueur) {


    }

    public static function vendreItem(PDO $connexion, $idItem, $idJoueur) {

        $sql = "CALL procedureVendreItem(:idItem, :idJoueur)";

        $stmt = $connexion->prepare($sql);

        $stmt->bindValue(':idItem', $idItem, PDO::PARAM_INT);

        $stmt->bindValue(':idJoueur', $idJoueur, PDO::PARAM_INT);

        $stmt->execute();
    }
}