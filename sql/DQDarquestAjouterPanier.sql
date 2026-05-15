DELIMITER $$

CREATE PROCEDURE Ajouter_au_panier(
    IN p_quantite INT,
    IN p_idJoueur INT,
    IN p_idItem INT,
    IN p_fromRevente TINYINT
)
BEGIN
    DECLARE v_count INT;

    SELECT COUNT(*) INTO v_count
    FROM Panier
    WHERE JoueursJeu_idJoueur = p_idJoueur
      AND Item_idItem = p_idItem;

    IF v_count > 0 THEN
        UPDATE Panier
        SET qtPanier = qtPanier + p_quantite,
            fromRevente = p_fromRevente
        WHERE JoueursJeu_idJoueur = p_idJoueur
          AND Item_idItem = p_idItem;
    ELSE
        INSERT INTO Panier(qtPanier, JoueursJeu_idJoueur, Item_idItem, fromRevente)
        VALUES(p_quantite, p_idJoueur, p_idItem, p_fromRevente);
    END IF;
END $$

DELIMITER ;
