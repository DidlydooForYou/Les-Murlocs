DELIMITER $$

CREATE PROCEDURE UtiliserPotionProcedure(
    IN p_idItem INT,
    IN p_idJoueur INT
)
BEGIN
    DECLARE v_qt INT;
    DECLARE v_soins INT;
    DECLARE v_type VARCHAR(30);

    START TRANSACTION;

    SELECT qtInventaire INTO v_qt
    FROM inventaire
    WHERE Item_idItem = p_idItem
      AND JoueursJeu_idJoueur = p_idJoueur;

    IF v_qt IS NOT NULL AND v_qt > 0 THEN

        SET v_type = (SELECT type FROM item WHERE idItem = p_idItem);

        IF v_type = 'sort' THEN
            SELECT soins INTO v_soins
            FROM sorts
            WHERE Item_idItem = p_idItem;

        ELSEIF v_type = 'potion' THEN
            SELECT soins INTO v_soins
            FROM potions
            WHERE Item_idItem = p_idItem;
        END IF;

        UPDATE inventaire
        SET qtInventaire = qtInventaire - 1
        WHERE Item_idItem = p_idItem
          AND JoueursJeu_idJoueur = p_idJoueur;

        UPDATE joueursjeu
        SET PointsDeVie = PointsDeVie + v_soins
        WHERE idJoueur = p_idJoueur;

        COMMIT;

    ELSE
        ROLLBACK;
    END IF;

END$$

DELIMITER ;