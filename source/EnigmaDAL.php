<?php
    class EnigmaDAL{

    public static function selectAll(PDO $connexion) : array {

        $sql = "SELECT * from questions";

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

    }
?>