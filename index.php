<?php
session_start();
require_once 'core/error-exception.php';
require_once 'source/initialization.php';
require_once 'source/Page.php';

const ACTIVE_PAGE = Page::Menu;

include "include/html_setup.php";
?>

<title>DarQuest - Vitrine</title>

<?php 
    include 'include/header.php';
    include 'include/nav.php'; 
?>

<main class="main">
    <h1 class="py-3 mt-3">Vitrine</h1>
    <?php include_once INCLUDE_FILE . '/showcase.php'; ?>
</main>

<?php include 'include/footer.php' ?>
