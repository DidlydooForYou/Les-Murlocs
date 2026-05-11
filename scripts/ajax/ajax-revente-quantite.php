<?php
require_once '../../core/Database.php';
require_once '../../DAL/ReventeDAL.php';

header('Content-Type: application/json');

if (!isset($_POST['idItem'], $_POST['idJoueur'], $_POST['qtItem'])) {
    echo json_encode(['success' => false, 'message' => 'Missing parameters']);
    exit;
}

$conn      = Database::getConnexion();
$idItem    = (int)$_POST['idItem'];
$idJoueur  = (int)$_POST['idJoueur'];
$qt        = (int)$_POST['qtItem'];

if ($qt < 1)  $qt = 1;
if ($qt > 99) $qt = 99;

ReventeDAL::updateQuantite($conn, $idJoueur, $idItem, $qt);

echo json_encode(['success' => true, 'newQt' => $qt]);
exit;
