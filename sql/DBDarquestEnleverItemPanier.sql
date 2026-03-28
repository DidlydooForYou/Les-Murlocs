DELIMITER $$

CREATE PROCEDURE Enlever_Item_Panier(
    IN p_idJoueur INT,
    IN p_idItem INT
)
BEGIN
    DELETE FROM Panier
    WHERE JoueursJeu_idJoueur = p_idJoueur AND Item_idItem = p_idItem;
END $$

DELIMITER ;