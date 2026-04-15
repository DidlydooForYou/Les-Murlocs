<?php
require_once 'core/error-exception.php';
require_once 'source/initialization.php';

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

    <?php include_once INCLUDE_FILE . '/detail.php'; ?>
    <br>
</main>

<?php include_once INCLUDE_FILE . '/footer.php'; ?>