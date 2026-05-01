<?php 
    include 'include/php_setup.php';
    include_once "DAL/EnigmaDAL.php";
    doitEtreCo();
?>

<title>DarQuest - Profil</title>

<?php 
    include 'include/html_setup.php';
    include 'include/header.php';
    include 'include/nav.php'; 
?>
<link rel="stylesheet" href="public/css/profil.css">
<main class="main">
    <div class="profilMain">
        <div class="donnees">
     <?php include_once "DAL/JoueurDAL.php";
     $connexion = Database::getConnexion();
     $infos = JoueurDAL::getInfos($connexion,$_SESSION['id']);
     $alias = Database::obtenir_alias($_SESSION['id']);
     echo '<img class ="imageProfil"src="' . $infos["photoProfil"] . '" alt="' . $alias . '">';
    echo "<div class='donnee'><span class='label'>Nom :</span> <span>".$infos['nom']."</span></div>";
    echo "<div class='donnee'><span class='label'>Prenom :</span> <span>".$infos['prenom']."</span></div>";
    echo "<div class='donnee'><span class='label'>Email :</span> <span>".$infos['email']."</span></div>";
    echo "<div class='donnee'><span class='label'>Alias :</span> <span>".$alias."</span></div>";
    
     ?>
     </div>
     </div>
     </main>
</main>

<?php include 'include/footer.php' ?>
