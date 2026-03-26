<?php
class PanierDAL{
    public static function selectByUser(PDO $connexion/*, int $idJoueur*/): array {
        $sql = "SELECT photoItem, nomItem, qtPanier, prixOr, prixArgent, prixBronze
                FROM Panier p INNER JOIN Item i ON p.Item_idItem = i.idItem
                WHERE p.JoueursJeu_idJoueur = :idJoueur
                ORDER BY nomItem";

        $stmt = $connexion->prepare($sql);

        $stmt->bindValue('idJoueur', 1/*$idJoueur*/, PDO::PARAM_INT);

        $stmt->execute();

        $result = $stmt->fetchAll();

        return $result;
    }
}
?>