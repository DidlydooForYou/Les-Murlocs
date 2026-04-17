<?php

class Database
{
    public static function getConnexion(): PDO {
        $dbConfig = [
            "dbHost" => "127.0.0.1",
            "dbName" => "DbDarquest",
            "dbUser" => "root",
            "dbPass" => "",
            "dbPort" => 3306,
            "dbParams" => [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_CASE => PDO::CASE_NATURAL,
                PDO::ATTR_ORACLE_NULLS => PDO::NULL_EMPTY_STRING,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ],
        ];

        try {
            return new PDO("mysql:host=".$dbConfig["dbHost"].";port=".$dbConfig["dbPort"].";dbname=".$dbConfig["dbName"], $dbConfig["dbUser"], $dbConfig["dbPass"], $dbConfig["dbParams"]);
        } catch(PDOException $e) {
            throw new PDOException($e->getMessage(), $e->getCode());
        }        
    }

    public static function obtenir_id($email){
        if (Database::email_pris($email)) {
            try {
                $pdo = Database::getConnexion();
                $sql = "select JoueursJeu_idJoueur from joueursinfo where email = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$email]);
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } catch (Exception $e) {
                return false;
            }
        }
    }

    public static function obtenir_joueur($email, $mdp){
        if (Database::email_pris($email)) {
            try {
                $pdo = Database::getConnexion();
                $sql = "select motDePasse from joueursinfo where email = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$email]);
                $rangee = $stmt->fetch(PDO::FETCH_ASSOC);
                if (!$rangee) {
                    return false;
                }
                $mdp_hasher = $rangee['motDePasse'];

                if (password_verify($mdp, $mdp_hasher)) {
                    return true;
                } else {
                    return false;
                }

            } catch (Exception $e) {
                //echo $e->getMessage();
                //exit;
            }
        }
    }

    public static function obtenir_alias($idJoueur){
        $sql = "SELECT alias FROM joueursjeu WHERE idJoueur = ?";    
        try{    
            $pdo = Database::getConnexion();
            $stmt = $pdo->prepare($sql);

            //$stmt->bindValue('idJoueur', $idJoueur, PDO::PARAM_INT);

            $stmt->execute([$idJoueur]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if(!$result){
                return false;
            } else {
                $result = $result['alias'];
            }

            return $result;
        }
        catch (Exception $e)
        {
            //exit;
        }
    }

    public static function obtenir_capital(int $idJoueur): array {
        $sql = "SELECT pieceOr, pieceArgent, pieceBronze
                FROM joueursjeu
                WHERE idJoueur = :idJoueur";

        $pdo = Database::getConnexion();

        $stmt = $pdo->prepare($sql);

        $stmt->bindValue('idJoueur', $idJoueur, PDO::PARAM_INT);

        $stmt->execute();

        $result = $stmt->fetch();

        return $result;
    }

    public static function alias_pris($alias){
        $sql = "select alias from joueursjeu where alias = ?";
        try {
            $pdo = Database::getConnexion();
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

    public static function email_pris($email){
        $sql = "select email from joueursinfo where email = ?";
        try {
            $pdo = Database::getConnexion();
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

    public static function nom_pris($nom){
        $sql = "select nomItem from item where nomItem =?";
        try {
            $pdo = Database::getConnexion();
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$nom]);

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

    public static function item_deja_panier($idItem){
        $sql = "select 1 from panier where JoueursJeu_idJoueur = ? and Item_idItem = ?";
        try {
            $pdo = Database::getConnexion();
            if (!isset($_SESSION['id'])) {
                return false;
            }
            $idJoueur = $_SESSION['id'];
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$idJoueur,$idItem]);
            if ($stmt->fetch(PDO::FETCH_ASSOC)) {
                return true;
            } else {
                return false;
            }
        }
        catch (Exception $e) {
            //echo $e->getMessage();
            //exit;
        }
    }

    public static function ajouter_joueur($nom, $prenom, $email, $mdp, $photoProfil, $alias){
        if (!Database::alias_pris($alias) && !Database::email_pris($email)) {
            $retour = true;
            try {
                $pdo = Database::getConnexion();
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

    public static function administrateur($id){
        $sql = "select administrateur from joueursinfo where JoueursJeu_idJoueur = ?";
        try {
            $pdo = Database::getConnexion();
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return false;
        }
    }

    public static function ajouter_armure($nom, $prixOr, $prixArgent, $prixBronze, $description, $matiere, $taille, $quantite, $chemin){
        if (!Database::nom_pris($nom)) {
            $retour = true;

            try {
                $pdo = Database::getConnexion();
                $stmt = $pdo->prepare("CALL Ajouter_Item_Armure(?, ?, ?, ?, ?, ?, ?, ?,?,?)");
                $stmt->execute([$nom, $chemin, $nom, $prixOr, $prixArgent, $prixBronze, $quantite, $description, $matiere, $taille]);
                $stmt->closeCursor();
            } catch (Exception $e) {
                echo $e->getMessage();
                $retour = false;
            }
            return $retour;
        }
        return false;
    }

    public static function ajouter_potion($nom, $prixOr, $prixArgent, $prixBronze, $description, $effet, $duree, $quantite, $chemin){
        if (!Database::nom_pris($nom)) {
            $retour = true;

            try {
                $pdo = Database::getConnexion();
                $stmt = $pdo->prepare("CALL Ajouter_Item_Potion(?, ?, ?, ?, ?, ?, ?, ?,?,?)");
                $stmt->execute([$nom, $chemin, $nom, $prixOr, $prixArgent, $prixBronze, $quantite, $description, $effet, $duree]);
                $stmt->closeCursor();
            } catch (Exception $e) {
                echo $e->getMessage();
                $retour = false;
            }
            return $retour;
        }
        return false;
    }

    public static function ajouter_sort($nom, $prixOr, $prixArgent, $prixBronze, $description, $instantane, $dommage, $quantite, $chemin){
    if (!Database::nom_pris($nom)) {
        $retour = true;

        try {
            $pdo = Database::getConnexion();
            $stmt = $pdo->prepare("CALL Ajouter_Item_Sort(?, ?, ?, ?, ?, ?, ?, ?,?,?)");
            $stmt->execute([$nom, $chemin, $nom, $prixOr, $prixArgent, $prixBronze, $quantite, $description, $instantane, $dommage]);
            $stmt->closeCursor();
        } catch (Exception $e) {
            echo $e->getMessage();
            $retour = false;
        }
        return $retour;
    }
    return false;

}
    public static function ajouter_arme($nom, $prixOr, $prixArgent, $prixBronze, $description, $efficacite, $genre, $quantite, $chemin)
    {
    if (!Database::nom_pris($nom)) {
        $retour = true;

        try {
            $pdo = Database::getConnexion();
            $stmt = $pdo->prepare("CALL Ajouter_Item_Arme(?, ?, ?, ?, ?, ?, ?, ?,?,?)");
            $stmt->execute([$nom, $chemin, $nom, $prixOr, $prixArgent, $prixBronze, $quantite, $description, $efficacite, $genre]);
            $stmt->closeCursor();
        } catch (Exception $e) {
            echo $e->getMessage();
            $retour = false;
        }
        return $retour;
    }
    return false;

        }
}