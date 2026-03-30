DELIMITER $$

CREATE PROCEDURE Modifier_Quantite_Panier(
    IN p_idJoueur INT,
    IN p_idItem INT,
    IN p_nouvelle_qt INT
)
BEGIN
    IF p_nouvelle_qt > 0 THEN
        UPDATE Panier
        SET qtPanier = p_nouvelle_qt
        WHERE JoueursJeu_idJoueur = p_idJoueur AND Item_idItem = p_idItem;
    END IF;
END $$

DELIMITER ;