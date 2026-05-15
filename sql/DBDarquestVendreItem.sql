DELIMITER $$

CREATE PROCEDURE procedureVendreItem(
    IN p_idItem INT,
    IN p_idJoueur INT
)
BEGIN
    DECLARE v_valeurOr INT;
    DECLARE v_valeurArgent INT;
    DECLARE v_valeurBronze INT;
  
    DECLARE v_Type VARCHAR(30);
    DECLARE v_rarete INT;

    START TRANSACTION;

    -- reduire la qtt en inventaire du joueur
    UPDATE inventaire 
    SET qtInventaire = qtInventaire - 1 
    WHERE Item_idItem = p_idItem 
      AND JoueursJeu_idJoueur = p_idJoueur 
      AND qtInventaire > 0;
    
    -- augmenter la qtt en inventaire du magasin
    UPDATE item 
    SET qttItem = qttItem + 1
    WHERE idItem = p_idItem;
    
    -- trouver le type et les prix de l'item
    SET v_Type = (SELECT type FROM item WHERE idItem = p_idItem);
    SET v_valeurOr = (SELECT prixOr FROM item WHERE idItem = p_idItem);
    SET v_valeurArgent = (SELECT prixArgent FROM item WHERE idItem = p_idItem);
    SET v_valeurBronze = (SELECT prixBronze FROM item WHERE idItem = p_idItem);

    -- aller chercher la rarete si c'est un sort
    IF v_Type = 'sort' THEN
        SET v_rarete = (
            SELECT rarete
            FROM sort
            WHERE Item_idItem = p_idItem
        );

        IF v_rarete = 1 THEN -- 100%
            UPDATE joueursjeu SET pieceOr = pieceOr + FLOOR(v_valeurOr * 1.0)WHERE idJoueur = p_idJoueur;
            UPDATE joueursjeu SET pieceArgent = pieceArgent + FLOOR(v_valeurArgent * 1.0) WHERE idJoueur = p_idJoueur;
            UPDATE joueursjeu SET pieceBronze = pieceBronze + FLOOR(v_valeurBronze * 1.0) WHERE idJoueur = p_idJoueur;

        ELSEIF v_rarete = 2 THEN -- 95%
            UPDATE joueursjeu SET pieceOr = pieceOr + FLOOR(v_valeurOr * 0.95) WHERE idJoueur = p_idJoueur;
            UPDATE joueursjeu SET pieceArgent = pieceArgent + FLOOR(v_valeurArgent * 0.95) WHERE idJoueur = p_idJoueur;
            UPDATE joueursjeu SET pieceBronze = pieceBronze + FLOOR(v_valeurBronze * 0.95) WHERE idJoueur = p_idJoueur;

        ELSEIF v_rarete = 3 THEN -- 90%
            UPDATE joueursjeu SET pieceOr = pieceOr + FLOOR(v_valeurOr * 0.90) WHERE idJoueur = p_idJoueur;
            UPDATE joueursjeu SET pieceArgent = pieceArgent + FLOOR(v_valeurArgent * 0.90) WHERE idJoueur = p_idJoueur;
            UPDATE joueursjeu SET pieceBronze = pieceBronze + FLOOR(v_valeurBronze * 0.90) WHERE idJoueur = p_idJoueur;
        END IF;

    ELSE
        -- 60% pour tout sauf sort
        UPDATE joueursjeu SET pieceOr = pieceOr + FLOOR(v_valeurOr * 0.6) WHERE idJoueur = p_idJoueur;
        UPDATE joueursjeu SET pieceArgent = pieceArgent + FLOOR(v_valeurArgent * 0.6) WHERE idJoueur = p_idJoueur;
        UPDATE joueursjeu SET pieceBronze = pieceBronze + FLOOR(v_valeurBronze * 0.6) WHERE idJoueur = p_idJoueur;
    END IF;
    
    COMMIT;

END $$

DELIMITER ;