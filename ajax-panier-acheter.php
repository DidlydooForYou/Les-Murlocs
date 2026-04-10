<?php
    require_once 'source/initialization.php';
    require_once 'core/Database.php';
    require_once 'source/PanierDAL.php';

    $connexion = Database::getConnexion($dbConfig);

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $idJoueur = (int)$_POST['idJoueur'];
        $prixTotal = (int)$_POST['prixTotal'];

        $userBank = PanierDAL::getUserBank($connexion, $idJoueur);

        $userTotal = PanierDAL::multiplierCoins($userBank['pieceOr'],$userBank['pieceArgent'],$userBank['pieceBronze'],1)['SommeTotale'];

        if($userTotal >= $prixTotal){
            $result = PanierDAL::acheterItem($connexion, $idJoueur);

            echo json_encode([
                "success" => $result,
                "error" => null
            ]);
        } else {
            $result = $prixTotal - $userTotal;

            echo json_encode([
                "success" => false,
                "error" => $result
            ]);
        }
    }
?>