<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/assets/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="icon" href="public/images/logo.png">
    <link rel="stylesheet" href="public/css/style.css">
    
    <script src="public/assets/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js" defer></script>
    <script
        src="https://code.jquery.com/jquery-4.0.0.min.js"
        integrity="sha256-OaVG6prZf4v69dPg6PhVattBXkcOWQB62pdZ3ORyrao="
        crossorigin="anonymous">
    </script>
</head>
<?php
    @session_start();
    require_once 'core/Database.php';
    require_once 'core/error-exception.php';
    require_once 'core/initialization.php';
    require_once 'core/utilitaire.php';
?>