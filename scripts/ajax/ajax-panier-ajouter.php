<?php
    require_once '../../DAL/initialization.php';
    require_once '../../core/Database.php';
    require_once '../../DAL/VitrineDAL.php';

    $connexion = Database::getConnexion();

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $idItem = (int)$_POST['idItem'];
        $idJoueur = (int)$_POST['idJoueur'];

        $result = VitrineDAL::AjouterPanier($connexion, $idJoueur, $idItem);

        echo json_encode([
            "success" => $result
        ]);
    }
?>