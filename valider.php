


<?php

require_once 'core/Database.php';
?>
<?php include 'include/php_setup.php' ?>

<title>DarQuest - Confirmation</title>

<?php 
    include 'include/html_setup.php';
    include 'include/header.php';
    include 'include/nav.php'; 
?>

<main class="main">
    <?
if (!empty($_GET['email'])) {
    $email = $_GET['email'];

    Database::confirmer_joueur($email);

    echo "Votre courriel a été confirmé. Vous pouvez maintenant vous connecter.";
}
?>

</main>

<?php include 'include/footer.php' ?>
