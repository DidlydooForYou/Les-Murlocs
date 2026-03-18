<?php
session_start();
require_once 'core/error-exception.php';
require_once 'source/initialization.php';
require_once 'source/Page.php';

const ACTIVE_PAGE = Page::Menu;

include "include/html_setup.php";
?>

<title>Vitrine</title>

<?php 
    include 'include/header.php';
    include 'include/nav.php'; 
?>

<main class="main">
    <h1 class="py-3 mt-3">Vitrine</h1>
    <?php include_once INCLUDE_FILE . '/showcase.php'; ?>
    <br>
    <fieldset>
        <legend>  Vitrine goes brr  </legend>
        <br><br><br><br><br><br><br><br>
        <div>Très beau produit trust</div>
    </fieldset>
    <br>
</main>

<?php include 'include/footer.php' ?>
