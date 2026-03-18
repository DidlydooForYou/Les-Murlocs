<?php
session_start();
require "sql/bd.php";
if (!$_SESSION["connexion"]){
    header('Location:accesRefuse.php');
    exit;
}
if (!isset($_SESSION["admin"])){
    $admin = administrateur($_SESSION["id"])["administrateur"];
    if ($admin == 0){
        header('Location:accesRefuse.php');
        exit;
    }
}
?>