<?php
    require_once 'source/initialization.php';
    require_once 'core/Database.php';
    require_once 'source/PanierDAL.php';

    $connexion = Database::getConnexion($dbConfig);

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $idItem = (int)$_POST['idItem'];
        $idJoueur = (int)$_POST['idJoueur'];
        $qtItem = (int)$_POST['qtItem'];

        $result = PanierDAL::changeItemQuantite($connexion,$idJoueur, $idItem, $qtItem);

        echo json_encode([
            "success" => $result
        ]);
    }
?>