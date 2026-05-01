<?php
    require_once '../../core/Database.php';
    require_once '../../core/initialization.php';
    require_once '../../core/utilitaire.php';
    require_once '../../DAL/PanierDAL.php';

    $connexion = Database::getConnexion();

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $idJoueur = (int)$_POST['idJoueur'];
        $prixTotal = (int)$_POST['prixTotal'];



        // Verif capital
        $userBank = Database::obtenir_capital($idJoueur);
        $userTotal = multiplierCoins($userBank['pieceOr'],$userBank['pieceArgent'],$userBank['pieceBronze'],1)['SommeTotale'];
        
        $stockInsuffisant = PanierDAL::stocks_Insuffisants($connexion, $idJoueur);

        if($stockInsuffisant){
            $result= "Stocks insuffisants\n"."Vous avez ces produits en trop :\n";

            foreach($stockInsuffisant as $itemManquant){
                $result = $result.$itemManquant."\n";
            }
            
            echo json_encode([
                "success" => false,
                "error" => $result
            ]);
        }
        else if($userTotal < $prixTotal){
            $manque = $prixTotal - $userTotal;
            $result= "Il vous manque ".$manque." pièces";

            echo json_encode([
                "success" => false,
                "error" => $result
            ]);
        } else {
            $result = PanierDAL::acheterItem($connexion, $idJoueur);

            echo json_encode([
                "success" => $result,
                "error" => null
            ]);
        }
    }
?>