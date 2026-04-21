<?php
class PanierDAL{
    public static function selectByUser(PDO $connexion, int $idJoueur): array {
        $sql = "SELECT photoItem, nomItem, i.description, p.Item_idItem as idItem, qtPanier, prixOr, prixArgent, prixBronze
                FROM Panier p INNER JOIN Item i ON p.Item_idItem = i.idItem
                WHERE p.JoueursJeu_idJoueur = :idJoueur
                ORDER BY nomItem";

        $stmt = $connexion->prepare($sql);

        $stmt->bindValue('idJoueur', $idJoueur, PDO::PARAM_INT);

        $stmt->execute();

        $result = $stmt->fetchAll();

        return $result;
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

    public static function effacerItem(PDO $connexion, int $idJoueur, int $idItem): bool{
        $sql = "CALL Enlever_Item_Panier(:idJoueur,:idItem)";

        $stmt = $connexion->prepare($sql);

        $stmt->bindValue('idJoueur', $idJoueur, PDO::PARAM_INT);
        $stmt->bindValue('idItem', $idItem, PDO::PARAM_INT);

        $result = $stmt->execute();

        return $result;
    }

    public static function acheterItem(PDO $connexion, int $idJoueur): bool{
        $sql = "CALL Payer_panier(:idJoueur)";

        $stmt = $connexion->prepare($sql);

        $stmt->bindValue('idJoueur', $idJoueur, PDO::PARAM_INT);

        $result = $stmt->execute();

        return $result;
    }

    public static function stocks_Insuffisants(PDO $connexion, int $idJoueur): bool|array{
        $panier= PanierDAL::selectByUser($connexion, $idJoueur);

        $tooMany = array();

        foreach($panier as $itemPanier){
            $itemData = Database::obtenir_item($itemPanier['idItem']);

            if($itemData['qttItem'] < $itemPanier['qtPanier']){
                $manqueItem = $itemPanier['qtPanier'] - $itemData['qttItem'];
                $tooMany[] = $manqueItem." × ".$itemData['nomItem'];
            }
        }

        if(count($tooMany) > 0){
            return $tooMany;
        } else {
            return false;
        }
    }
}
?>