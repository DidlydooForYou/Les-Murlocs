DELIMITER $$
CREATE PROCEDURE bonne_reponse(in p_idJoueur int , in p_difficulte varchar(1))
BEGIN 
declare p_bonneReponseDifficile int default 0;
    START TRANSACTION;
    IF NOT EXISTS (SELECT 1 FROM statistiques where JoueursJeu_idJoueur = p_idJoueur) THEN
            Insert into statistiques (bonneReponse,mauvaiseReponse,JoueursJeu_idJoueur,	bonneReponseDifficile,questionsDifficile,questionsMoyenne,questionsFacile,reponsesDifficiles,reponsesMoyenne,reponsesFacile) VALUES (1,0,p_idJoueur,0,0,0,0,0,0,0);
    ELSE

    UPDATE statistiques set bonneReponse = bonneReponse + 1 where JoueursJeu_idJoueur = p_idJoueur;
    END IF;
        if p_difficulte = 'f'
            then
              UPDATE joueursJeu set pieceBronze = pieceBronze + 10 where idJoueur = p_idJoueur;
              UPDATE statistiques set questionsFacile = questionsFacile + 1 where JoueursJeu_idJoueur = p_idJoueur;
              UPDATE statistiques set reponsesFacile = reponsesFacile + 1 where JoueursJeu_idJoueur = p_idJoueur;
        elseif p_difficulte = 'm'
            then
            UPDATE joueursJeu set pieceArgent = pieceArgent + 10 where idJoueur = p_idJoueur;
            UPDATE statistiques set questionsMoyenne = questionsMoyenne + 1 where JoueursJeu_idJoueur = p_idJoueur;
            UPDATE statistiques set reponsesMoyenne = reponsesMoyenne + 1 where JoueursJeu_idJoueur = p_idJoueur;
        elseif p_difficulte = 'd'
            then
            UPDATE joueursJeu set pieceOr = pieceOr + 10 where idJoueur = p_idJoueur;
            UPDATE statistiques set questionsDifficile = questionsDifficile + 1 where JoueursJeu_idJoueur = p_idJoueur;
            UPDATE statistiques set reponsesDifficiles = reponsesDifficiles + 1 where JoueursJeu_idJoueur = p_idJoueur;
            UPDATE statistiques set bonneReponseDifficile = bonneReponseDifficile + 1 where JoueursJeu_idJoueur = p_idJoueur;
            SELECT bonneReponseDifficile into p_bonneReponseDifficile from statistiques where JoueursJeu_idJoueur = p_idJoueur;
            if (p_bonneReponseDifficile >= 3) then 
            UPDATE joueursJeu set pieceOr = pieceOr + 100 where idJoueur = p_idJoueur;
            Update statistiques set bonneReponseDifficile = 0 where JoueursJeu_idJoueur = p_idJoueur;
            end if;
        end if;

    commit;
END$$

DELIMITER ;