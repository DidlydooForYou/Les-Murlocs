<?php 
<<<<<<< Updated upstream
include 'include/html_setup.php';
=======
include 'include/php_setup.php'; 
require_once 'core/Database.php';
require_once 'DAL/aideDAL.php';

>>>>>>> Stashed changes
doitEtreCo();

$connexion = Database::getConnexion();

$idJoueur = $_SESSION['id'];

$message = "";

$joueur = aideDAL::obtenirJoueur($connexion, $idJoueur);

$nbrDemande = $joueur['nbrDemande'];
$admin = $joueur['administrateur'];

if (isset($_POST['demanderCapital']) && !$admin) {

    if ($nbrDemande < 3) {

        aideDAL::ajouterDemande($connexion, $idJoueur);

        $nbrDemande++;

        $message = "Votre demande de capital a été envoyée !";

    } else {

        $message = "Vous avez atteint le maximum de demandes.";
    }
}


if (isset($_POST['accepter'])) {

    $idJoueur = $_POST['idJoueur'];

    aideDAL::accepterDemande($connexion, $idJoueur);
}

?>

<title>DarQuest - Aide</title>

<?php 
    include 'include/header.php';
    include 'include/nav.php'; 
?>

<main class="main" 
      style="
        display:flex;
        flex-direction:column;
        align-items:center;
        justify-content:center;
        text-align:center;
        gap:15px;
        padding:40px;
      ">

    <?php if (!$admin) { ?>

        <?php if ($nbrDemande < 3) { ?>

            <form method="post">

                <button type="submit"
                        name="demanderCapital"
                        class="btn btn-success">
                    Demande de capital
                </button>

            </form>

            <p style="font-size:20px;">
                Nombre de demandes :
                <?= $nbrDemande ?>/3
            </p>


        <?php } else { ?>

            <p style="color:red; font-weight:bold; font-size:22px;">
                Vous avez atteint le maximum de demandes.
            </p>

        <?php } ?>





    <?php } else { ?>

        <h2>Demandes de capital</h2>

        <?php
            $demandes = aideDAL::obtenirDemandes($connexion);
        ?>

<?php if (count($demandes) > 0) { ?>

    <table border="1" cellpadding="15"
           style="background:white;
                color:black;
                border-collapse:collapse;
                text-align:center;
                width:600px;
           ">

        <tr>
            <th>Joueur</th>
            <th>Demandes</th>
            <th>Action</th>
        </tr>

        <?php foreach ($demandes as $demande) { ?>

            <tr>
                <td>
                    <?= $demande['alias'] ?>
                </td>
                <td>
                    <?= $demande['nbrDemande'] ?>
                </td>
                <td>
                    <form method="post">

                       

                        <button type="submit"
                                name="accepter">
                            Accepter
                        </button>

                    </form>
                </td>
            </tr>

        <?php } ?>

    </table>

<?php } else { ?>

    <p>Aucune demande en cours.</p>

<?php } ?>

    <?php } ?>

    <?php if ($message != "") { ?>
        <p><?= $message ?></p>
    <?php } ?>

    <a class="btn btn-boot mt-auto" href="index.php">
        Revenir
    </a>

</main>

<?php include 'include/footer.php' ?>