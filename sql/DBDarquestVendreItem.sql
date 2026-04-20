DELIMITER $$

CREATE PROCEDURE procedureVendreItem(
    IN p_idItem INT,
    IN p_idJoueur INT
)
BEGIN
  declare v_valeurOr int; -- nombre de pieces du joueur
  declare v_valeurArgent int;
  declare v_valeurBronze int;

  declare v_Type varchar(30);

  START TRANSACTION;

    -- reduire la qtt en inventaire du joueur
    UPDATE inventaire SET qtInventaire = qtInventaire - 1 
    WHERE Item_idItem = p_idItem AND JoueursJeu_idJoueur = p_idJoueur AND qtInventaire > 0;

    -- augmenter la qtt en inventaire du magasin
    UPDATE item set qttItem = qttItem + 1
    WHERE idItem = p_idItem;

    -- trouver le type de l'item
    SET v_Type =  (SELECT type FROM item WHERE idItem = p_idItem);
    SET v_valeurOr = (SELECT prixOr FROM item WHERE idItem = p_idItem);
    SET v_valeurArgent= (SELECT prixArgent FROM item WHERE idItem = p_idItem);
    SET v_valeurBronze = (SELECT prixBronze FROM item WHERE idItem = p_idItem);

-- condition selon le type
IF v_Type = 'sort' THEN

        -- ajouter les pieces dans le compte du joueur (110% SORT)
    UPDATE joueursjeu set pieceOr = pieceOr + FLOOR(v_valeurOr * 1.1) WHERE idJoueur = p_idJoueur;
    UPDATE joueursjeu set pieceArgent = pieceArgent + FLOOR(v_valeurArgent * 1.1) WHERE idJoueur = p_idJoueur;
    UPDATE joueursjeu set pieceBronze = pieceBronze + FLOOR(v_valeurBronze * 1.1) WHERE idJoueur = p_idJoueur;

ELSE
    -- ajouter les pieces dans le compte du joueur (60% TOUT SAUF SORT)
    UPDATE joueursjeu set pieceOr = pieceOr + FLOOR(v_valeurOr * 0.6) WHERE idJoueur = p_idJoueur;
    UPDATE joueursjeu set pieceArgent = pieceArgent + FLOOR(v_valeurArgent * 0.6) WHERE idJoueur = p_idJoueur;
    UPDATE joueursjeu set pieceBronze = pieceBronze + FLOOR(v_valeurBronze * 0.6) WHERE idJoueur = p_idJoueur;

END IF;

 COMMIT;

END $$

DELIMITER ;