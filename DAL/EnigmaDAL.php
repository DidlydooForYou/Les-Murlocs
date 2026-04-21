<?php
class EnigmaDAL{

    public static function selectAll(PDO $connexion) : array {

        $sql = "SELECT * from questions except select * from questions where categorie = 'magie'";

        $statement = $connexion->prepare($sql); 
             
        $statement->execute();

        return $statement->fetchAll();
    }
    public static function selectAllMageQuestion(PDO $connexion) : array {
        $sql = "SELECT * from questions where categorie = 'magie'";
        $statement = $connexion->prepare($sql);
        $statement->execute();
        return $statement->fetchAll();
    }

    public static function selectResponses(PDO $connexion, $idQuestion){

    $sql = "select * from reponses join questions_has_reponses on questions_has_reponses.Reponses_idReponse= reponses.idReponse where questions_has_reponses.Questions_idQuestion = :idQuestion";
    $stmt = $connexion->prepare($sql);
    $stmt->bindValue('idQuestion',$idQuestion,PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
   
    }
    public static function estMage(PDO $connexion, $idJoueur){
        $sql = "SELECT mage from joueursjeu where idJoueur = :idJoueur";
        $stmt = $connexion->prepare($sql);
        $stmt->bindValue('idJoueur',$idJoueur,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
            
    }
    public static function devenirMage(PDO $connexion, $idJoueur){
        $sql = "UPDATE joueursJeu set mage = 1 where idJoueur = :idJoueur";
        $stmt = $connexion->prepare($sql);
        $stmt->bindValue('idJoueur',$idJoueur,PDO::PARAM_INT);
        $stmt->execute();
    }
    public static function bonneReponse(PDO $connexion, $idJoueur, $difficulte){
        $sql = "CALL bonne_reponse(:idJoueur, :difficulte)";
        $stmt = $connexion->prepare($sql);
        $stmt->bindValue('idJoueur',$idJoueur,PDO::PARAM_INT);
        $stmt->bindValue('difficulte', $difficulte, PDO::PARAM_STR);
        $stmt->execute();
    }
    public static function mauvaiseReponse(PDO $connexion, $idJoueur, $difficulte){
        $sql = "CALL mauvaise_reponse(:idJoueur, :difficulte)";
        $stmt = $connexion->prepare($sql);
        $stmt->bindValue('idJoueur',$idJoueur,PDO::PARAM_INT);
        $stmt->bindValue('difficulte', $difficulte, PDO::PARAM_STR);
        $stmt->execute();
    }
    public static function nbrQuestionDifficile(PDO $connexion, $JoueursJeu_idJoueur){
        $sql = "SELECT bonneReponseDifficile from statistiques where JoueursJeu_idJoueur = :JoueursJeu_idJoueur";
        $stmt = $connexion->prepare($sql);
        $stmt->bindValue('JoueursJeu_idJoueur', $JoueursJeu_idJoueur, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }
    public static function getStats(PDO $connexion, $JoueursJeu_idJoueur){
        $sql = "SELECT * FROM statistiques where JoueursJeu_idJoueur = :JoueursJeu_idJoueur";
        $stmt = $connexion->prepare($sql);
        $stmt->bindValue('JoueursJeu_idJoueur', $JoueursJeu_idJoueur, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }
}
    
?>