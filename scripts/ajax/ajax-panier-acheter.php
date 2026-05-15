<?php
require_once '../../core/Database.php';
require_once '../../core/initialization.php';
require_once '../../core/utilitaire.php';
require_once '../../DAL/PanierDAL.php';
require_once '../../DAL/AchatDAL.php';

$connexion = Database::getConnexion();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idJoueur = (int) $_POST['idJoueur'];
    $prixTotal = (int) $_POST['prixTotal'];



    // Verif capital
    $userBank = Database::obtenir_capital($idJoueur);
    $userTotal = multiplierCoins($userBank['pieceOr'], $userBank['pieceArgent'], $userBank['pieceBronze'], 1)['SommeTotale'];

    $stockInsuffisant = PanierDAL::stocks_Insuffisants($connexion, $idJoueur);

    if ($stockInsuffisant) {
        $result = "Stocks insuffisants\n" . "Vous avez ces produits en trop :\n";

        foreach ($stockInsuffisant as $itemManquant) {
            $result = $result . $itemManquant . "\n";
        }

        echo json_encode([
            "success" => false,
            "error" => $result
        ]);
    } else if ($userTotal < $prixTotal) {
        $manque = $prixTotal - $userTotal;
        $result = "Il vous manque " . $manque . " pièces";

        echo json_encode([
            "success" => false,
            "error" => $result
        ]);
    } else {
        $items = PanierDAL::selectByUser($connexion, $idJoueur);
        $result = PanierDAL::acheterItem($connexion, $idJoueur);

        if ($result) {
           

            foreach ($items as $item) {
                AchatDAL::insertPurchase($connexion, $item['idItem'], $idJoueur);
            }

            echo json_encode([
                "success" => true,
                "error" => null
            ]);

        } else {

            echo json_encode([
                "success" => false,
                "error" => "Erreur lors de l'achat"
            ]);
        }
    }
}
?>