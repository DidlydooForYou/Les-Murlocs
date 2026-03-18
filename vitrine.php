<?php
require_once 'core/error-exception.php';
require_once 'source/initialization.php';
require_once 'source/Page.php';

const ACTIVE_PAGE = Page::Vitrine;

?>

<!DOCTYPE html>
<html lang="fr">

<?php include_once TEMPLATE . '/head.php'; ?>

    <body>
        <div class="container">
            <?php include_once TEMPLATE . '/header.php'; ?>

            <main>
                <h1 class="py-3 mt-3">Inventaire</h1>
                <?php include_once TEMPLATE . '/showcase.php'; ?>
            </main>

            <?php include_once TEMPLATE . '/footer.php'; ?>

        </div>
    </body>
</html>