<?php
require_once 'core/error-exception.php';
require_once 'source/initialization.php';
require_once 'source/Page.php';

const ACTIVE_PAGE = Page::Details;

?>

<link rel="stylesheet" href="public/css/vitrine.css">
<Title>DarQuest - Détails</Title>

<?php 
    include "include/html_setup.php";
?>

<?php 
    include "include/header.php"; 
    include "include/nav.php";
?>
<main class="main">
    <br>
    <fieldset>
        <legend><h1 class="py-3 mt-3">Détails</h1></legend>
        <?php include_once INCLUDE_FILE . '/detail.php'; ?>
    </fieldset>
    <br>
</main>

<?php include_once INCLUDE_FILE . '/footer.php'; ?>