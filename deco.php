<?php
session_start();
unset($_SESSION["id"]);
unset($_SESSION["connexion"]);
session_destroy();
setcookie("PHPSESSID", null, -1);
header('Location: index.php');
exit;
?>