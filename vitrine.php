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
<<<<<<< HEAD
                <h1 class="py-3 mt-3">Inventaire</h1>
                <?php include_once TEMPLATE . '/showcase.php'; ?>
=======
                <h1 class="py-3 mt-3">Vitrine</h1>
                <?php include_once TEMPLATE . '/vitrine.php'; ?>
>>>>>>> 4ba2b35801dba318d7416390b35c195522f26297
            </main>

            <?php include_once TEMPLATE . '/footer.php'; ?>

        </div>
    </body>
</html>