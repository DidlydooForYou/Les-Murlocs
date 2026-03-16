<?php
require_once 'core/error-exception.php';
require_once 'source/initialization.php';
require_once 'source/Page.php';

const ACTIVE_PAGE = Page::Inventaire;

?>

<!DOCTYPE html>
<html lang="fr">

<?php include_once TEMPLATE . '/head.php'; ?>

    <body>
        <div class="container">
            <?php include_once TEMPLATE . '/header.php'; ?>

            <main>
                <?php include_once TEMPLATE . '/inventory.php'; ?>
            </main>

            <?php include_once TEMPLATE . '/footer.php'; ?>

        </div>
    </body>
</html>