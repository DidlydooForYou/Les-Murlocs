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
<link rel="stylesheet" href="public/css/enigma.css">
<main class="main">
    <div class="profilMain">
     <?php include_once "DAL/JoueurDAL.php";
     $connexion = Database::getConnexion();
     $infos = JoueurDAL::getInfos($connexion,$_SESSION['id']);
     $alias = Database::obtenir_alias($_SESSION['id']);
     echo "Nom : ". $infos['nom']. "<br>";
     echo  "Prenom : " . $infos['prenom']. "<br>";
     echo "Email : " . $infos['email']. "<br>";
     echo "Alias : " . $alias;
     ?>
     </div>
</main>

<?php include 'include/footer.php' ?>
