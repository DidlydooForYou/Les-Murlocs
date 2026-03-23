DELIMITER $$

CREATE PROCEDURE Ajouter_Item_Arme(
    IN p_nomItem VARCHAR(80),
    IN p_photoItem VARCHAR(80),
    IN p_photoAlt VARCHAR(80),
    IN p_prixOr INT,
    IN p_prixArgent INT,
    IN p_prixBronze INT,
    IN p_qttItem INT,
    IN p_description VARCHAR(80),
    IN p_efficacite INT,
    IN p_genreArme VARCHAR(40)
)
BEGIN
    DECLARE v_idItem INT;

    INSERT INTO Item(nomItem, photoItem, photoAlt, prixOr, prixArgent, prixBronze, qttItem, description)
    VALUES(p_nomItem, p_photoItem, p_photoAlt, p_prixOr, p_prixArgent, p_prixBronze, p_qttItem, p_description);

    SET v_idItem = LAST_INSERT_ID();

    INSERT INTO Armes(efficacite, genreArme, Item_idItem)
    VALUES(p_efficacite, p_genreArme, v_idItem);
END $$


DELIMITER $$
CREATE PROCEDURE Ajouter_Item_Armure(
    IN p_nomItem VARCHAR(80),
    IN p_photoItem VARCHAR(80),
    IN p_photoAlt VARCHAR(80),
    IN p_prixOr INT,
    IN p_prixArgent INT,
    IN p_prixBronze INT,
    IN p_qttItem INT,
    IN p_description VARCHAR(80),
    IN p_matiere VARCHAR(40),
    IN p_taille INT
)
BEGIN
    DECLARE v_idItem INT;

    INSERT INTO Item(nomItem, photoItem, photoAlt, prixOr, prixArgent, prixBronze, qttItem, description)
    VALUES(p_nomItem, p_photoItem, p_photoAlt, p_prixOr, p_prixArgent, p_prixBronze, p_qttItem, p_description);

    SET v_idItem = LAST_INSERT_ID();

    INSERT INTO Armure(matiere, taille, Item_idItem)
    VALUES(p_matiere, p_taille, v_idItem);
END $$

-- potion
DELIMITER $$
CREATE PROCEDURE Ajouter_Item_Potion(
    IN p_nomItem VARCHAR(80),
    IN p_photoItem VARCHAR(80),
    IN p_photoAlt VARCHAR(80),
    IN p_prixOr INT,
    IN p_prixArgent INT,
    IN p_prixBronze INT,
    IN p_qttItem INT,
    IN p_description VARCHAR(80),
    IN p_effet VARCHAR(60),
    IN p_duree INT
)
BEGIN
    DECLARE v_idItem INT;

    INSERT INTO Item(nomItem, photoItem, photoAlt, prixOr, prixArgent, prixBronze, qttItem, description)
    VALUES(p_nomItem, p_photoItem, p_photoAlt, p_prixOr, p_prixArgent, p_prixBronze, p_qttItem, p_description);

    SET v_idItem = LAST_INSERT_ID();

    INSERT INTO Potions(effet, duree, Item_idItem)
    VALUES(p_effet, p_duree, v_idItem);
END $$


-- sort
DELIMITER $$

CREATE PROCEDURE Ajouter_Item_Sort(
    IN p_nomItem VARCHAR(80),
    IN p_photoItem VARCHAR(80),
    IN p_photoAlt VARCHAR(80),
    IN p_prixOr INT,
    IN p_prixArgent INT,
    IN p_prixBronze INT,
    IN p_qttItem INT,
    IN p_description VARCHAR(80),
    IN p_instantane TINYINT,
    IN p_dommage INT
)
BEGIN
    DECLARE v_idItem INT;

    INSERT INTO Item(nomItem, photoItem, photoAlt, prixOr, prixArgent, prixBronze, qttItem, description)
    VALUES(p_nomItem, p_photoItem, p_photoAlt, p_prixOr, p_prixArgent, p_prixBronze, p_qttItem, p_description);

    SET v_idItem = LAST_INSERT_ID();

    INSERT INTO Sorts(instantane, dommage, Item_idItem)
    VALUES(p_instantane, p_dommage, v_idItem);
END $$

DELIMITER ;