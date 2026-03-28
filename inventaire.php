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
        <?php include_once INCLUDE_FILE . '/inventory.php'; ?>
    <br>
</main>

<?php include_once INCLUDE_FILE . '/footer.php'; ?>