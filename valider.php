<?php
require_once 'core/Database.php';

if (!empty($_GET['email'])) {
    $email = $_GET['email'];

    Database::confirmer_joueur($email);

    echo "Votre courriel a été confirmé. Vous pouvez maintenant vous connecter.";
}
?>
