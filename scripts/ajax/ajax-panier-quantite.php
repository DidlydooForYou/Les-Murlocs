<?php
    require_once '../../DAL/initialization.php';
    require_once '../../core/Database.php';
    require_once '../../DAL/PanierDAL.php';

    $connexion = Database::getConnexion();

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