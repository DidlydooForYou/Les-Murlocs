<?php
require_once 'core/error-exception.php';
require_once 'source/initialization.php';
require_once 'source/Page.php';

const ACTIVE_PAGE = Page::Vitrine;

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