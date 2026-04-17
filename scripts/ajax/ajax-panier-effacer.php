<?php

require_once '../../DAL/initialization.php';
require_once '../../core/Database.php';
require_once '../../DAL/PanierDAL.php';

/*
    require_once 'DAL/initialization.php';
    require_once 'core/Database.php';
    require_once 'DAL/PanierDAL.php';
*/
    $connexion = Database::getConnexion();
    
    error_log("AJAX-PANIER-EFFACER REACHED");

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $idItem = (int)$_POST['idItem'];
        $idJoueur = (int)$_POST['idJoueur'];

        $result = PanierDAL::effacerItem($connexion, $idJoueur, $idItem);

        echo json_encode([
            "success" => $result
        ]);
    }
?>