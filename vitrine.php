<?php
require_once 'core/error-exception.php';
require_once 'source/initialization.php';

include "include/header.php"; 
include "include/nav.php";
include "include/html_setup.php";

?>

<Title>Vitrine</Title>

<main class="main">
    <br>
        <?php include_once INCLUDE_FILE . '/showcase.php'; ?>
    <br>
</main>

<?php include_once INCLUDE_FILE . '/footer.php'; ?>