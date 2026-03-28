<?php
class PanierDAL{
    public static function selectByUser(PDO $connexion, int $idJoueur): array {
        $sql = "SELECT photoItem, nomItem, p.Item_idItem as idItem, qtPanier, prixOr, prixArgent, prixBronze
                FROM Panier p INNER JOIN Item i ON p.Item_idItem = i.idItem
                WHERE p.JoueursJeu_idJoueur = :idJoueur
                ORDER BY nomItem";

        $stmt = $connexion->prepare($sql);

        $stmt->bindValue('idJoueur', $idJoueur, PDO::PARAM_INT);

        $stmt->execute();

        $result = $stmt->fetchAll();

        return $result;
    }

    public static function selectByUserItem(PDO $connexion, int $idJoueur, int $idItem): array {

        $sql = "SELECT photoItem, nomItem, p.Item_idItem as idItem, qtPanier, prixOr, prixArgent, prixBronze
                FROM Panier p INNER JOIN Item i ON p.Item_idItem = i.idItem
                WHERE p.JoueursJeu_idJoueur = :idJoueur AND p.Item_idItem = :idItem";

        $stmt = $connexion->prepare($sql);
        
        $stmt->bindValue('idJoueur', $idJoueur, PDO::PARAM_INT);
        $stmt->bindValue('idItem', $idItem, PDO::PARAM_INT);
        
        $stmt->execute();

        $result = $stmt->fetch();

        return $result;
    }

    public static function multiplierCoins(int $prixOr, int $prixArgent, int $prixBronze, int $amount): array {
        $prixUnitaireBronze = ($prixOr * 100) + ($prixArgent * 10) + $prixBronze;
        $prixTotal = $prixUnitaireBronze * $amount;

        $prixBronzeFinal = $prixTotal % 10;             // Enlève les unités
        $prixArgentFinal = intdiv($prixTotal,10) % 10;  // Met les dizaines aux unités puis les enlèves
        $prixOrFinal = intdiv($prixTotal,100);          // Transfert le reste aux unités

        return [
            "Or" => $prixOrFinal,
            "Argent" => $prixArgentFinal,
            "Bronze" => $prixBronzeFinal
        ];
    }

    public static function changeItemQuantite(PDO $connexion, int $idJoueur, int $idItem, int $nouvelleQuantite): bool{
        $sql = "CALL Modifier_Quantite_Panier(:idJoueur,:idItem,:qtItem)";

        $stmt = $connexion->prepare($sql);

        $stmt->bindValue('idJoueur', $idJoueur, PDO::PARAM_INT);
        $stmt->bindValue('idItem', $idItem, PDO::PARAM_INT);
        $stmt->bindValue('qtItem', $nouvelleQuantite, PDO::PARAM_INT);

        $result = $stmt->execute();

        return $result;
    }
}
?>