DELIMITER $$
CREATE PROCEDURE bonne_reponse(in p_idJoueur int , in p_difficulte varchar(1))
BEGIN 
    START TRANSACTION;
    IF NOT EXISTS (SELECT 1 FROM statistiques where JoueursJeu_idJoueur = p_idJoueur) THEN
            Insert into statistiques (bonneReponse,mauvaiseReponse,JoueursJeu_idJoueur,bonneReponseMagie) VALUES (1,0,p_idJoueur,0);
    ELSE

    UPDATE statistiques set bonneReponse = bonneReponse + 1 where JoueursJeu_idJoueur = p_idJoueur;
    END IF;
    case
        when p_difficulte = 'f'
            then
              UPDATE joueursJeu set pieceBronze = pieceBronze + 10 where idJoueur = p_idJoueur;
        when p_difficulte = 'm'
            then
            UPDATE joueursJeu set pieceArgent = pieceArgent + 10 where idJoueur = p_idJoueur;
        when p_difficulte = 'd'
            then
            UPDATE joueursJeu set pieceOr = pieceOr + 10 where idJoueur = p_idJoueur;
     END CASE;
    commit;
END$$

DELIMITER ;