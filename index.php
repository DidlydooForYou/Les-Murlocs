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
    <br>
    <h1>Vitrine</h1>
        <form class="ms-2 d-flex align-items-center gap-2" role="search" action="index.php">
            <input name="research" class="form-control" type="search" placeholder="Recherche">

            <select name="sortPrice" id="sortPrice" class="form-select w-auto">
                <option value="" hidden>Trier par prix</option>
                <option value="price_asc">Prix ↑</option>
                <option value="price_desc">Prix ↓</option>
            </select>

            <select id="sortCatego" name="sortCatego" class="form-select w-auto">
                <option value="" hidden>Trier par catégorie</option>
                <option value="sorts">Sorts</option>
                <option value="armors">Armures</option>
                <option value="weapons">Armes</option>
                <option value="potions">Potions</option>
            </select>

            <select id="sortAlphabete" name="sortAlphabete" class="form-select w-auto">
                <option value="" hidden>Trier par ordre alphabétique</option>
                <option value="alpha_asc">A à Z</option>
                <option value="alpha_desc">Z à A</option>
            </select>
        </form>
        <?php include_once INCLUDE_FILE . '/showcase.php'; ?>
    <br>
</main>

<script>
document.getElementById("sortPrice").addEventListener("change", function () {
    const url = new URL(window.location.href);
    url.searchParams.set("sortPrice", this.value);
    window.location.href = url.toString();
});
document.getElementById("sortAlphabete").addEventListener("change", function () {
    const url = new URL(window.location.href);
    url.searchParams.set("sortAlphabete", this.value);
    window.location.href = url.toString();
});
document.getElementById("sortCatego").addEventListener("change", function () {
    const url = new URL(window.location.href);
    url.searchParams.set("sortCatego", this.value);
    window.location.href = url.toString();
});
</script>

<?php include 'include/footer.php' ?>
