<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('ROOT', dirname(__DIR__));

const INCLUDE_FILE = ROOT . '/include';
const CORE = ROOT . '/core';
const SOURCE = ROOT . '/source';

const URL_ROOT = '/';

const CSS = URL_ROOT . 'css';
const VITRINE_IMG = URL_ROOT . 'upload';

define('IS_POST', $_SERVER['REQUEST_METHOD'] === 'POST');
define('IS_AUTH', isset($_SESSION['id']));
define('IS_ADMIN', IS_AUTH && $_SESSION['role'] === 1);
define('IS_MAGE',IS_AUTH && $_SESSION["mage"] );

function doitEtreDeco(){
    if (IS_AUTH){
        header('Location:accesRefuse.php');
        exit;
    }
}

function doitEtreCo(){
    if (!IS_AUTH){
        header('Location:connexion.php');
        exit;
    }
}
function doitEtreEnVie(){
    if (IS_AUTH){
        require_once "core/Database.php";
        $connexion = Database::getConnexion();
        require_once "DAL/JoueurDAL.php";
        $point = JoueurDAL::selectPdv($connexion, $_SESSION['id']);
        $point = $point['PointsDeVie'];
        if ($point == 0){
            header('Location:mort.php');
            exit;
        }
    }
}

const PASSWORD_SIZE = 8;
const MATCH_PATTERN ='/^(?=.*\d)(?=.*[@#\-_$%^&+=§!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z@#\-_$%^&+=§!\?]{8,20}$/';
?>