<?php
include 'include/php_setup.php';

if (!IS_ADMIN) {
    header('Location:accesRefuse.php');
    exit;
}
function conversion($prix)
{
    $conversion = array();
    if (strlen($prix) == 4) {
        $conversion[0] = (int) substr($prix, 0, 2);
        $conversion[1] = (int) substr($prix, 2, 1);
        $conversion[2] = (int) substr($prix, 3, 1);
    } elseif (strlen($prix) == 3) {
        $conversion[0] = (int) substr($prix, 0, 1);
        $conversion[1] = (int) substr($prix, 1, 1);
        $conversion[2] = (int) substr($prix, 2, 1);

    } elseif (strlen($prix) == 2) {
        $conversion[0] = 0;
        $conversion[1] = (int) substr($prix, 0, 1);
        $conversion[2] = (int) substr($prix, 1, 1);
    } elseif (strlen($prix) == 1) {
        $conversion[0] = 0;
        $conversion[1] = 0;
        $conversion[2] = $prix;
    }
    return $conversion;
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $validite = true;
    if (
        isset($_POST['nom']) &&
        isset($_POST['prix']) &&
        isset($_POST['description']) &&
        isset($_POST['quantite']) &&
        isset($_POST['type'])
    ) {
        if (isset($_FILES['url'])) {
            if ($_FILES['url']['error'] === UPLOAD_ERR_NO_FILE) {
                $chemin = "public/images/profilBase.webp";
            } else {

                $repertoire = 'public/images/';
                $extension = strtolower(pathinfo($_FILES['url']['name'], PATHINFO_EXTENSION));
                if ($extension != "avif") {
                    $chemin = "public/images/profilBase.webp";
                } else {
                    $chemin = $repertoire . $_FILES['url']['name'];
                    if (move_uploaded_file($_FILES['url']['tmp_name'], $chemin)) {
                    } else {
                        $validite = false;
                    }


                }


            }

        }


        if (
            strlen($_POST['nom']) <= 80 && strlen($_POST['nom']) >= 1 &&
            $_POST['prix'] <= 5000 && $_POST['prix'] >= 1 &&
            strlen($_POST['description']) <= 80 && strlen($_POST['description']) >= 1 &&
            $_POST['quantite'] <= 20 && $_POST['quantite'] >= 1
        ) {
            $nom = $_POST['nom'];
            $prix = $_POST['prix'];
            $prixSc = conversion($prix);
            $prixOr = $prixSc[0];
            $prixArgent = $prixSc[1];
            $prixBronze = $prixSc[2];
            $description = $_POST['description'];
            $quantite = (int) $_POST['quantite'];
        } else {
            $validite = false;
        }

        switch ($_POST['type']) {
            case "formArme":
                if (
                    isset($_POST['efficacite']) &&
                    isset($_POST['genre'])
                ) {
                    if ($_POST['efficacite'] <= 10 && $_POST['efficacite'] >= 1) {
                        $efficacite = (int) $_POST['efficacite'];
                    } else {
                        $validite = false;
                    }
                    if ($validite) {
                        $genre = $_POST['genre'];
                        $erreur = Database::ajouter_arme($nom, $prixOr, $prixArgent, $prixBronze, $description, $efficacite, $genre, $quantite, $chemin);
                        if ($erreur) {
                            header('Location:index.php');
                            exit;
                        } 
                    }
                }
                break;
            case "formArmure":
                if (
                    isset($_POST['matiere']) &&
                    isset($_POST['taille'])
                ) {
                    if (
                        strlen($_POST['matiere']) <= 40 && strlen($_POST['matiere']) >= 1 &&
                        $_POST['taille'] <= 60 && $_POST['taille'] >= 1
                    ) {
                        $matiere = $_POST['matiere'];
                        $taille = $_POST['taille'];
                    } else {
                        $validite = false;
                    }
                    if ($validite) {
                        $erreur = Database::ajouter_armure($nom, $prixOr, $prixArgent, $prixBronze, $description, $matiere, $taille, $quantite, $chemin);
                        if ($erreur) {
                            header('Location:index.php');
                            exit;
                        } 
                    }
                }
                break;
            case "formPotion":
                if (
                    isset($_POST['effet']) &&
                    isset($_POST['duree'])
                ) {
                    if (
                        strlen($_POST['effet']) <= 60 && strlen($_POST['effet']) >= 1 &&
                        $_POST['duree'] <= 600 && $_POST['duree'] >= 1
                    ) {
                        $effet = $_POST['effet'];
                        $duree = $_POST['duree'];

                    } else {
                        $validite = false;
                    }
                    if ($validite) {
                        $erreur = Database::ajouter_potion($nom, $prixOr, $prixArgent, $prixBronze, $description, $effet, $duree, $quantite, $chemin);
                        if ($erreur) {
                            header('Location:index.php');
                            exit;
                        }
                    }

                } else {
                    $validite = false;
                }
                break;
            case "formSort":
                if (
                    isset($_POST['instantane']) &&
                    isset($_POST['dommage'])
                ) {
                    if (
                        $_POST['dommage'] >= 1 && $_POST['dommage'] <= 100
                    ) {
                        $dommage = $_POST['dommage'];
                        $instantane = $_POST['instantane'];
                    } else {
                        $validite = false;
                    }
                    if ($validite) {
                        $erreur = Database::ajouter_sort($nom, $prixOr, $prixArgent, $prixBronze, $description, $instantane, $dommage, $quantite, $chemin);
                        if ($erreur) {
                            header('Location:index.php');
                            exit;
                        }
                    }
                } else {
                    $validite = false;
                }
                break;
        }

    } else {
        $validite = false;
    }

}
?>


<link rel="stylesheet" href="public/css/enigma.css">
<title>DarQuest - Ajout</title>

<?php
include 'include/html_setup.php';
include 'include/header.php';
include 'include/nav.php';
?>

<main class="main">
    <div class="enigmaAjout-container">
        <select name="type" id="type" onchange="Form()" style="margin-top : 4px; margin-left:4px;">
            <option value="" selected>Choisir un type d'objet : </option>
            <option value="arme">Armes</option>
            <option value="armure">Armure</option>
            <option value="potion">Potion</option>
            <option value="sort">Sort</option>
        </select>
        <form action="ajout.php" method="POST" id="formArme" enctype="multipart/form-data"
            style="display: none; padding: 4px;">
            <input type="hidden" name="type" value="formArme">
            <h2>Ajouter une arme</h2>
            <label for="nom">Nom : </label>
            <input type="text" name="nom" id="nom" minlength="1" maxlength="80" required><br>
            <label for="prix">Prix : </label> en bronze
            <input type="number" id="prix" name="prix" required min="1" max="5000" value="1"> <br>
            <label for="description">Description : </label> <br>
            <textarea name="description" id="description" autofocus cols="40" rows="10" style="resize : none;" required
                minlength="1" maxlength="80"></textarea><br>
            <label for="efficacite">Efficacité : </label>
            <input type="number" id="efficacite" name="efficacite" min="1" max="10" value="1" required> <br>
            <p>Quel est le genre de l'arme ?</p>
            <input type="radio" id="uneMain" name="genre" value="une main" checked>
            <label for="uneMain"> Une main</label>
            <input type="radio" id="deuxMains" name="genre" value="deux mains">
            <label for="deuxMains">Deux mains</label> <br>
            <label for="quantite">Quantité à ajouter : </label>
            <input type="number" min="1" max="20" value="1" name="quantite" id="quantite" required> <br>
            <label for="image">Image :</label><br>
            <input type="hidden" name="MAX_FILE_SIZE" value="50000000">
            <input type="file" id="image" name="url" accept=".avif,image/avif"><br>
            <input type="submit" value="Ajouter">

        </form>
        <form action="ajout.php" method="POST" id="formArmure" style="display: none;padding: 4px;"
            enctype="multipart/form-data">
            <input type="hidden" name="type" value="formArmure">
            <h2>Ajouter une armure</h2>
            <label for="nom">Nom : </label>
            <input type="text" name="nom" id="nom" minlength="1" maxlength="80" required><br>
            <label for="prix">Prix : </label> en bronze
            <input type="number" id="prix" name="prix" required min="1" max="5000" value="1"> <br>
            <label for="description">Description : </label> <br>
            <textarea name="description" id="description" autofocus cols="40" rows="10" style="resize : none;" required
                minlength="1" maxlength="80"></textarea><br>
            <label for="matiere">Matière de l'armure : </label>
            <input type="text" name="matiere" id="matiere" required minlength="1" maxlength="40"> <br>
            <label for="taille">Taille en cm :</label>
            <input type="number" name="taille" id="taille" required min="1" max="60"> cm <br>
            <label for="quantite">Quantité à ajouter : </label>
            <input type="number" min="1" max="20" value="1" name="quantite" id="quantite" required> <br>
            <label for="image">Image :</label><br>
            <input type="hidden" name="MAX_FILE_SIZE" value="50000000" required>
            <input type="file" id="image" name="url" accept=".avif,image/avif" required><br>
            <input type="submit" value="Ajouter">
        </form>
        <form action="ajout.php" method="POST" id="formPotion" style="display: none;padding: 4px;"
            enctype="multipart/form-data">
            <input type="hidden" name="type" value="formPotion">
            <h2>Ajouter une potion</h2>
            <label for="nom">Nom : </label>
            <input type="text" name="nom" id="nom" required><br>
            <label for="prix">Prix : </label>
            <input type="number" id="prix" name="prix" required min="1" max="5000" value="1"> <br>
            <label for="description">Description : </label> <br>
            <textarea name="description" id="description" autofocus cols="40" rows="10" style="resize : none;" required
                minlength="1" maxlength="80"></textarea><br>
            <label for="effet">Effet : </label>
            <input type="text" name="effet" id="effet" required minlength="1" maxlength="60"> <br>
            <label for="duree">Durée en secondes : </label>
            <input type="number" id="duree" name="duree" required min="1" max="600"> secondes <br>
            <label for="quantite">Quantité à ajouter : </label>
            <input type="number" min="1" max="20" value="1" name="quantite" id="quantite" required> <br>
            <label for="image">Image :</label><br>
            <input type="hidden" name="MAX_FILE_SIZE" value="50000000" required>
            <input type="file" id="image" name="url" accept=".avif,image/avif" required><br>
            <input type="submit" value="Ajouter">
        </form>
        <form action="ajout.php" method="POST" id="formSort" style="display: none; padding: 4px;"
            enctype="multipart/form-data">
            <input type="hidden" name="type" value="formSort">
            <h2>Ajouter un sort</h2>
            <label for="nom">Nom : </label>
            <input type="text" name="nom" id="nom" required><br>
            <label for="prix">Prix : </label>
            <input type="number" id="prix" name="prix" required min="1" max="5000" value="1"> <br>
            <label for="description">Description : </label> <br>
            <textarea name="description" id="description" autofocus cols="40" rows="10" style="resize : none;" required
                minlength="1" maxlength="80"></textarea><br>
            <p>Est-ce que le sort est instantané ?</p>
            <input type="radio" id="oui" name="instantane" value="1" checked>
            <label for="oui"> Oui</label>
            <input type="radio" id="non" name="instantane" value="0">
            <label for="non">Non</label> <br>
            <label for="dommage">Dommage du sort : </label>
            <input type="number" id="dommage" name="dommage" required min="1" max="100"> points de vie<br>
            <label for="quantite">Quantité à ajouter : </label>
            <input type="number" min="1" max="20" value="1" name="quantite" id="quantite" required> <br>
            <label for="image">Image :</label><br>
            <input type="hidden" name="MAX_FILE_SIZE" value="50000000" required>
            <input type="file" id="image" name="url" accept=".avif,image/avif" required><br>
            <input type="submit" value="Ajouter">
        </form>
        <?php
        if (isset($erreur)) {
            if (!$erreur) {
                echo "<span style='color:red'> Erreur dans les données </span>";
            }
        }
        ?>
    </div>
</main>

<?php include 'include/footer.php' ?>
<script src="scripts/ajout.js">

</script>