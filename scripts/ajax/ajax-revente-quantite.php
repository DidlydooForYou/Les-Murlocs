<?php
require_once '../../core/Database.php';
require_once '../../DAL/PanierDAL.php';
require_once '../../DAL/ReventeDAL.php';
require_once '../../DAL/InventoryDAL.php';

header('Content-Type: application/json');

if (!isset($_POST['idItem'], $_POST['idJoueur'], $_POST['qtItem'])) {
    echo json_encode(['success' => false, 'message' => 'Missing parameters']);
    exit;
}

$conn      = Database::getConnexion();
$idItem    = (int)$_POST['idItem'];
$idJoueur  = (int)$_POST['idJoueur']; // BUYER
$newQt     = (int)$_POST['qtItem'];

if ($newQt < 1)  $newQt = 1;
if ($newQt > 99) $newQt = 99;

$diff = $newQt - $currentQt;
$seller = ReventeDAL::selectByUserAndItem($conn, $idJoueur, $idItem);
$sellerId = $seller['idJoueur'];

if ($diff > 0) {
    InventoryDAL::decreaseInventory($conn, $sellerId, $idItem, $diff);
} elseif ($diff < 0) {
    InventoryDAL::increaseInventory($conn, $sellerId, $idItem, abs($diff));
}

echo json_encode(['success' => true, 'newQt' => $newQt]);
exit;
