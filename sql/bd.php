<?php
function get_pdo()
{
    $pdo = new PDO("mysql:host=localhost;dbname=dbdarquest", "root", "");
    return $pdo;
}
function obtenir_id($email){
    if (email_pris($email)){
        try{
            $pdo = get_pdo();
            $sql = "select JoueursJeu_idJoueur from joueursinfo where email = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$email]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        catch(Exception $e){
        return false;
    }

    }
}

function obtenir_joueur($email, $mdp)
{
    if (email_pris($email)){
        try{
            $pdo = get_pdo();
            $sql = "select motDePasse from joueursinfo where email = ?";
            $stmt = $pdo->prepare($sql);
            $stmt ->execute([$email]);
            $rangee = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$rangee){
            return false;
        }
        $mdp_hasher = $rangee['motDePasse'];

        if (password_verify($mdp,$mdp_hasher)){
            return true;
        }
        else{
            return false;
        }

    } catch (Exception $e) {
        //echo $e->getMessage();
        //exit;
    }
    }
    
}
function alias_pris($alias)
{
    $sql = "select alias from joueursjeu where alias = ?";
    try {
        $pdo = get_pdo();
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$alias]);

        if ($stmt->fetch(PDO::FETCH_ASSOC)) {
            return true;
        } else {
            return false;
        }
    } catch (Exception $e) {
        //echo $e->getMessage();
        //exit;
    }
}
function email_pris($email)
{
    $sql = "select email from joueursinfo where email = ?";
    try {
        $pdo = get_pdo();
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email]);

        if ($stmt->fetch(PDO::FETCH_ASSOC)) {
            return true;
        } else {
            return false;
        }
    } catch (Exception $e) {
        //echo $e->getMessage();
        //exit;
    }
}


function ajouter_joueur($nom, $prenom, $email, $mdp, $photoProfil, $alias)
{
    if (!alias_pris($alias) && !email_pris($email)) {
        $retour = true;
        try {
            $pdo = get_pdo();
            $stmt = $pdo->prepare("CALL Ajouter_joueur(?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$nom, $prenom, $email, $mdp, 0, $photoProfil, $alias]);
            $stmt->closeCursor();
        } catch (Exception $e) {
            $retour = false;
        }
        return $retour;
    }
    return false;

}

function obtenir_panier($idJoueur): bool|PDOStatement {
    $sql = "SELECT photoItem, nomItem, qtPanier, prixOr, prixArgent, prixBronze
    FROM Panier p INNER JOIN Item i ON p.Item_idItem = i.idItem 
    WHERE p.JoueursJeu_idJoueur = ?' 
    ORDER BY nomItem";

    try{
        $pdo = get_pdo();
        $stmt = $pdo->query($sql);
        $stmt -> execute([$idJoueur]);
        $retour = $stmt;
    } catch(Exception $e){
        $retour = false;
    }
    
    return $retour;
}

?>