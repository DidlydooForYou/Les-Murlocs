<?php
require_once 'core/error-exception.php';
require_once 'source/initialization.php';
require_once 'source/Page.php';

const ACTIVE_PAGE = Page::Inventaire;
doitEtreCo();
?>

<?php 
    include "include/html_setup.php";
?>

<?php 
    include "include/header.php"; 
    include "include/nav.php";
?>
<main class="main">
    <br>
        <h1 class="py-3 mt-3">Inventaire</h1>
<h3>Cette partie du site est en cours de construction, revenez dans pas longtemps ! </h3>
     <img src="public/images/construction.gif" alt="en construction">
        <a class="btn btn-boot mt-auto" href="index.php">Revenir</a>
    <br>
</main>

<?php include_once INCLUDE_FILE . '/footer.php'; ?>