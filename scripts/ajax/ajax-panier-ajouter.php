<?php
require_once '../../core/initialization.php';
require_once '../../core/Database.php';
require_once '../../DAL/PanierDAL.php';

$connexion = Database::getConnexion();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $idItem  = $_POST['idItem']  ?? null;
    $idVente = $_POST['idVente'] ?? null;
    $idJoueur = (int) $_POST['idJoueur'];
    $fromRevente = isset($_POST['fromRevente']) ? (int) $_POST['fromRevente'] : 0;

    if ($fromRevente === 1 && $idVente !== null) {
        $result = PanierDAL::ajouterPanierRevente($connexion, $idJoueur, $idVente);
    } 
    else if ($fromRevente === 0 && $idItem !== null) {
        $result = PanierDAL::ajouterPanierVitrine($connexion, $idJoueur, $idItem);
    } 

    echo json_encode(["success" => $result]);
}
?>
