<?php
class JoueurDAL{
    public static function selectPdv(PDO $connexion, int $id){
        $sql = "SELECT PointsDeVie from joueursjeu where idJoueur = :id";

        $statement = $connexion->prepare($sql);

        $statement->bindValue('id', $id, PDO::PARAM_STR);

        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }  
    public static function getInfos(PDO $connexion, int $id){
        $sql = "Select nom,prenom,email,photoProfil from joueursinfo join joueursjeu on joueursjeu.idJoueur = joueursinfo.JoueursJeu_idJoueur where joueursjeu.idJoueur = :id";
        $statement = $connexion->prepare($sql);

                $statement->bindValue('id', $id, PDO::PARAM_STR);

        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public static function modifAlias(PDO $connexion, int $idJoueur, string $alias){
        $sql = "UPDATE joueursjeu set alias = :alias where idJoueur = :idJoueur";

        $stmt = $connexion->prepare($sql);
        
        $stmt->bindValue('alias', $alias, PDO::PARAM_STR);
        $stmt->bindValue('idJoueur', $idJoueur, PDO::PARAM_INT);
        
        $stmt->execute();
    }

    public static function checkPassword(PDO $connexion, int $idJoueur, string $password) : bool {
        $sql = "SELECT motDePasse FROM joueursinfo WHERE JoueursJeu_idJoueur = :idJoueur";
        $stmt = $connexion->prepare($sql);
        $stmt->bindValue('idJoueur', $idJoueur, PDO::PARAM_INT);
        $stmt->execute();
        $correctMdp = $stmt->fetch(PDO::FETCH_ASSOC);

        return password_verify($password, $correctMdp['motDePasse']);
    }

    public static function modifPasword(PDO $connexion, int $idJoueur, string $password){
        
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE joueursinfo set motDePasse = :mdp where JoueursJeu_idJoueur = :idJoueur";
        $stmt = $connexion->prepare($sql);

        $stmt->bindValue('mdp', $hashed, PDO::PARAM_STR);
        $stmt->bindValue('idJoueur', $idJoueur, PDO::PARAM_INT);
        
        $stmt->execute();
    }

    public static function modifEmail(PDO $connexion, int $idJoueur, string $email){
        $sql = "UPDATE joueursinfo set email = :email, confirmed = 0 where JoueursJeu_idJoueur = :idJoueur";

        $stmt = $connexion->prepare($sql);
        
        $stmt->bindValue('email', $email, PDO::PARAM_STR);
        $stmt->bindValue('idJoueur', $idJoueur, PDO::PARAM_INT);
        
        $stmt->execute();
    }

    public static function modifNom(PDO $connexion, int $idJoueur, string $nom){
        $sql = "UPDATE joueursinfo set nom = :nom where JoueursJeu_idJoueur = :idJoueur";

        $stmt = $connexion->prepare($sql);
        
        $stmt->bindValue('nom', $nom, PDO::PARAM_STR);
        $stmt->bindValue('idJoueur', $idJoueur, PDO::PARAM_INT);
        
        $stmt->execute();
    }

    public static function modifPrenom(PDO $connexion, int $idJoueur, string $prenom){
        $sql = "UPDATE joueursinfo set prenom = :prenom where JoueursJeu_idJoueur = :idJoueur";

        $stmt = $connexion->prepare($sql);
        
        $stmt->bindValue('prenom', $prenom, PDO::PARAM_STR);
        $stmt->bindValue('idJoueur', $idJoueur, PDO::PARAM_INT);
        
        $stmt->execute();
    }

        public static function modifPhotoProfil(PDO $connexion, int $idJoueur, $photoProfil){
        $sql = "UPDATE joueursjeu set photoProfil = :photo where idJoueur = :idJoueur";

        $stmt = $connexion->prepare($sql);
        
        $stmt->bindValue('photo', $photoProfil, PDO::PARAM_STR);
        $stmt->bindValue('idJoueur', $idJoueur, PDO::PARAM_INT);

        $stmt->execute();
    }
}