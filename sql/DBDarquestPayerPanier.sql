DELIMITER $$

CREATE PROCEDURE Payer_panier(
    IN p_idJoueur INT
)
BEGIN
  declare v_nbBronzeJoueur int; -- nombre de pieces du joueur
  declare v_nbArgentJoueur int;
  declare v_nbOrJoueur int;

  declare v_nbBronzePanier int default 0; -- total a payer
  declare v_nbArgentPanier int default 0;
  declare v_nbOrPanier int default 0;

  declare v_prixBronzeItem int; -- prix individuel de chaque item, change avec le curseur
  declare v_prixArgentItem int;
  declare v_prixOrItem int;

  declare v_idItem int;
  declare v_qttItem int;
  declare v_qtPanier int;

  declare v_fromRevente int;

  -- curseur sur le panier
  declare done int default 0; -- condition du curseur
  declare v_erreur int default 0;
  declare cur_items cursor for 
    select Item_idItem, qtPanier, fromRevente
    from Panier
    where JoueursJeu_idJoueur = p_idJoueur;


  declare continue handler for not found set done = 1; 

  -- début transaction
  START TRANSACTION;

  -- pieces du joueur
  SET v_nbBronzeJoueur = (SELECT pieceBronze FROM JoueursJeu WHERE idJoueur = p_idJoueur);
  SET v_nbArgentJoueur = (SELECT pieceArgent FROM JoueursJeu WHERE idJoueur = p_idJoueur);
  SET v_nbOrJoueur = (SELECT pieceOr FROM JoueursJeu WHERE idJoueur = p_idJoueur);

  open cur_items;

  read_loop: loop
    fetch cur_items into v_idItem, v_qtPanier, v_fromRevente;

    if done then
      leave read_loop;
    end if;

    SELECT prixBronze, prixArgent, prixOr
    INTO v_prixBronzeItem, v_prixArgentItem, v_prixOrItem
    FROM Item
    WHERE idItem = v_idItem;

    SET v_nbBronzePanier = v_nbBronzePanier + (v_prixBronzeItem * v_qtPanier);
    SET v_nbArgentPanier = v_nbArgentPanier + (v_prixArgentItem * v_qtPanier);
    SET v_nbOrPanier = v_nbOrPanier + (v_prixOrItem * v_qtPanier);

  end loop;

  close cur_items;

  -- maintenant comparer les totaux
  IF v_nbBronzeJoueur < v_nbBronzePanier 
  OR v_nbArgentJoueur < v_nbArgentPanier 
  OR v_nbOrJoueur < v_nbOrPanier THEN

      ROLLBACK;

  ELSE

      -- remettre done a 0 pour reutiliser le curseur
      SET done = 0;

      open cur_items;

      read_loop2: loop
        fetch cur_items into v_idItem, v_qtPanier, v_fromRevente;

        if done then
          leave read_loop2;
        end if;

        IF v_fromRevente = 1 THEN
        -- check le stock revente
        SELECT qttItem INTO v_qttItem
        FROM revente
        WHERE idItem = v_idItem;

        IF v_qttItem < v_qtPanier THEN
          SET v_erreur = 1;
          LEAVE read_loop2;
        END IF;

        -- reduire le stock dans revente
        UPDATE revente
        SET qttItem = qttItem - v_qtPanier
        WHERE idItem = v_idItem;

        -- delete si empty
        DELETE FROM revente
        WHERE idItem = v_idItem AND qttItem <= 0;

        ELSE
          -- check le stock items
          SELECT qttItem INTO v_qttItem
          FROM Item
        WHERE idItem = v_idItem;

        IF v_qttItem < v_qtPanier THEN
          SET v_erreur = 1;
          LEAVE read_loop2;
        END IF;

          -- reduire stock items
          UPDATE Item
          SET qttItem = qttItem - v_qtPanier
          WHERE idItem = v_idItem;
        END IF;


        -- ajouter l'item dans inventaire
        INSERT INTO Inventaire(JoueursJeu_idJoueur, Item_idItem, qtInventaire)
        VALUES(p_idJoueur, v_idItem, v_qtPanier)
        ON DUPLICATE KEY UPDATE qtInventaire = qtInventaire + v_qtPanier;

      end loop;

      close cur_items;

      IF v_erreur = 1 THEN
        ROLLBACK;
      ELSE

        -- si tout est correct, reduire les pieces du joueur
        UPDATE JoueursJeu
        SET pieceBronze = pieceBronze - v_nbBronzePanier,
            pieceArgent = pieceArgent - v_nbArgentPanier,
            pieceOr = pieceOr - v_nbOrPanier
        WHERE idJoueur = p_idJoueur;

        -- vider le panier
        DELETE FROM Panier
        WHERE JoueursJeu_idJoueur = p_idJoueur;

        -- commit si tout est correct
        COMMIT;

      END IF;

  END IF;

END$$

DELIMITER ;
