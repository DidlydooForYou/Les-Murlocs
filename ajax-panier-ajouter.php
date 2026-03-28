<?php 
session_start();
require_once "sql/bd.php";
isset($_POST['idItem']) ? $idItem = $_POST['idItem'] : exit("id manquant");
function ajouter_panier($idItem){
     if (!isset($_SESSION['id'])) {
            return false;
        }
        $idJoueur = $_SESSION['id'];
    if (item_deja_panier($idItem)){

        $sql = "update panier set qtPanier = qtPanier + 1 where JoueursJeu_idJoueur = ? and Item_idItem = ?";
        try {
            $pdo = get_pdo();
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$idJoueur, $idItem]);
            return true;

        }
        catch (Exception $e){
            return false;
        }
    }else{
        $sql = "insert into panier (qtPanier, JoueursJeu_idJoueur, Item_idItem) values (?, ?, ?) ";
        try{
            $pdo = get_pdo();
            $stmt = $pdo->prepare($sql);
            $stmt->execute([1,$idJoueur,$idItem]);
            return true;

        }
        catch (Exception $e){
            return false;
        }
    }

}
if (ajouter_panier($idItem)){
    echo "oui";

}
else{
    echo "non";
}
?>