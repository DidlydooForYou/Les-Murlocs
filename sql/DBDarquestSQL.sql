create database DBDarquest;
use DBDarquest;

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema DbDarquest
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema DbDarquest
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `DbDarquest` DEFAULT CHARACTER SET utf8mb4 ;
USE `DbDarquest` ;

-- -----------------------------------------------------
-- Table `DbDarquest`.`JoueursJeu`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `DbDarquest`.`JoueursJeu` (
  `photoProfil` VARCHAR(100) NOT NULL,
  `alias` VARCHAR(40) NOT NULL,
  `pieceOr` INT NULL DEFAULT 1,
  `pieceArgent` INT NULL DEFAULT 10,
  `pieceBronze` INT NULL DEFAULT 100,
  `mage` TINYINT NULL DEFAULT 0,
  `idJoueur` INT NOT NULL AUTO_INCREMENT,
  `nbrDemande` INT NULL DEFAULT 0,
  `PointsDeVie` INT NULL DEFAULT 10,
  UNIQUE INDEX `alias_UNIQUE` (`alias` ASC) ,
  PRIMARY KEY (`idJoueur`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `DbDarquest`.`JoueursInfo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `DbDarquest`.`JoueursInfo` (
  `nom` VARCHAR(40) NOT NULL,
  `prenom` VARCHAR(40) NOT NULL,
  `email` VARCHAR(60) NOT NULL,
  `motDePasse` VARBINARY(128) NOT NULL,
  `JoueursJeu_idJoueur` INT NOT NULL,
  `administrateur` TINYINT NULL DEFAULT 0,
  UNIQUE INDEX `email_UNIQUE` (`email` ASC) ,
  PRIMARY KEY (`JoueursJeu_idJoueur`),
  CONSTRAINT `fk_JoueursInfo_JoueursJeu1`
    FOREIGN KEY (`JoueursJeu_idJoueur`)
    REFERENCES `DbDarquest`.`JoueursJeu` (`idJoueur`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `DbDarquest`.`Item`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `DbDarquest`.`Item` (
  `nomItem` VARCHAR(80) NOT NULL,
  `photoItem` VARCHAR(255) NOT NULL,
  `prixOr` INT NOT NULL ,
  `prixArgent` INT NOT NULL,
  `prixBronze` INT NOT NULL,
  `description` VARCHAR(80) NOT NULL,
  `qttItem` INT NOT NULL,
  `idItem` INT NOT NULL AUTO_INCREMENT,
  `type` type VARCHAR(20) NOT NULL, 
  ADD CONSTRAINT chk_item_type CHECK (type IN ('arme', 'armure', 'potion', 'sort'));
  UNIQUE INDEX `nomItem_UNIQUE` (`nomItem` ASC) ,
  PRIMARY KEY (`idItem`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `DbDarquest`.`Armes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `DbDarquest`.`Armes` (
  `efficacite` INT NOT NULL,
  `genreArme` VARCHAR(40) NOT NULL,
  `Item_idItem` INT NOT NULL,
  PRIMARY KEY (`Item_idItem`),
  CONSTRAINT `fk_Armes_Item`
    FOREIGN KEY (`Item_idItem`)
    REFERENCES `DbDarquest`.`Item` (`idItem`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `DbDarquest`.`Armure`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `DbDarquest`.`Armure` (
  `matiere` VARCHAR(40) NOT NULL,
  `taille` INT NOT NULL,
  `Item_idItem` INT NOT NULL,
  PRIMARY KEY (`Item_idItem`),
  CONSTRAINT `fk_Armure_Item1`
    FOREIGN KEY (`Item_idItem`)
    REFERENCES `DbDarquest`.`Item` (`idItem`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `DbDarquest`.`Potions`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `DbDarquest`.`Potions` (
  `effet` VARCHAR(60) NOT NULL,
  `duree` INT NOT NULL,
  `Item_idItem` INT NOT NULL,
  PRIMARY KEY (`Item_idItem`),
  CONSTRAINT `fk_Potions_Item1`
    FOREIGN KEY (`Item_idItem`)
    REFERENCES `DbDarquest`.`Item` (`idItem`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `DbDarquest`.`Sorts`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `DbDarquest`.`Sorts` (
  `instantane` TINYINT NOT NULL,
  `dommage` INT NOT NULL,
  `Item_idItem` INT NOT NULL,
  PRIMARY KEY (`Item_idItem`),
  CONSTRAINT `fk_Sorts_Item1`
    FOREIGN KEY (`Item_idItem`)
    REFERENCES `DbDarquest`.`Item` (`idItem`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `DbDarquest`.`Inventaire`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `DbDarquest`.`Inventaire` (
  `qtInventaire` INT NULL,
  `JoueursJeu_idJoueur` INT NOT NULL,
  `Item_idItem` INT NOT NULL,
  PRIMARY KEY (`JoueursJeu_idJoueur`, `Item_idItem`),
  INDEX `fk_Inventaire_Item1_idx` (`Item_idItem` ASC) ,
  CONSTRAINT `fk_Inventaire_JoueursJeu1`
    FOREIGN KEY (`JoueursJeu_idJoueur`)
    REFERENCES `DbDarquest`.`JoueursJeu` (`idJoueur`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Inventaire_Item1`
    FOREIGN KEY (`Item_idItem`)
    REFERENCES `DbDarquest`.`Item` (`idItem`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `DbDarquest`.`Panier`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `DbDarquest`.`Panier` (
  `qtPanier` INT NULL,
  `JoueursJeu_idJoueur` INT NOT NULL,
  `Item_idItem` INT NOT NULL,
  PRIMARY KEY (`JoueursJeu_idJoueur`, `Item_idItem`),
  INDEX `fk_Panier_Item1_idx` (`Item_idItem` ASC) ,
  CONSTRAINT `fk_Panier_JoueursJeu1`
    FOREIGN KEY (`JoueursJeu_idJoueur`)
    REFERENCES `DbDarquest`.`JoueursJeu` (`idJoueur`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Panier_Item1`
    FOREIGN KEY (`Item_idItem`)
    REFERENCES `DbDarquest`.`Item` (`idItem`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `DbDarquest`.`Evaluations`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `DbDarquest`.`Evaluations` (
  `commentaire` VARCHAR(60) NOT NULL,
  `etoiles` INT NOT NULL,
  `JoueursJeu_idJoueur` INT NOT NULL,
  `Item_idItem` INT NOT NULL,
  PRIMARY KEY (`JoueursJeu_idJoueur`, `Item_idItem`),
  INDEX `fk_Évaluations_Item1_idx` (`Item_idItem` ASC) ,
  CONSTRAINT `fk_Évaluations_JoueursJeu1`
    FOREIGN KEY (`JoueursJeu_idJoueur`)
    REFERENCES `DbDarquest`.`JoueursJeu` (`idJoueur`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Évaluations_Item1`
    FOREIGN KEY (`Item_idItem`)
    REFERENCES `DbDarquest`.`Item` (`idItem`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `DbDarquest`.`Questions`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `DbDarquest`.`Questions` (
  `enonce` VARCHAR(60) NOT NULL,
  `categorie` VARCHAR(30) NOT NULL,
  `idQuestion` INT NOT NULL AUTO_INCREMENT,
  `difficulte` VARCHAR(1) NOT NULL,
  UNIQUE INDEX `enonce_UNIQUE` (`enonce` ASC) ,
  PRIMARY KEY (`idQuestion`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `DbDarquest`.`Reponses`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `DbDarquest`.`Reponses` (
  `idReponse` INT NOT NULL AUTO_INCREMENT,
  `reponse` VARCHAR(60) NOT NULL,
  `correct` TINYINT NOT NULL,
  PRIMARY KEY (`idReponse`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `DbDarquest`.`Statistiques`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `DbDarquest`.`Statistiques` (
  `bonneReponse` INT NOT NULL,
  `mauvaiseReponse` INT NOT NULL,
  `JoueursJeu_idJoueur` INT NOT NULL,
  `bonneReponseMagie` INT NOT NULL DEFAULT 0,
  PRIMARY KEY (`JoueursJeu_idJoueur`),
  CONSTRAINT `fk_Statistiques_JoueursJeu1`
    FOREIGN KEY (`JoueursJeu_idJoueur`)
    REFERENCES `DbDarquest`.`JoueursJeu` (`idJoueur`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `DbDarquest`.`Questions_has_Reponses`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `DbDarquest`.`Questions_has_Reponses` (
  `Questions_idQuestion` INT NOT NULL,
  `Reponses_idReponse` INT NOT NULL,
  PRIMARY KEY (`Questions_idQuestion`, `Reponses_idReponse`),
  INDEX `fk_Questions_has_Reponses_Reponses1_idx` (`Reponses_idReponse` ASC) ,
  INDEX `fk_Questions_has_Reponses_Questions1_idx` (`Questions_idQuestion` ASC) ,
  CONSTRAINT `fk_Questions_has_Reponses_Questions1`
    FOREIGN KEY (`Questions_idQuestion`)
    REFERENCES `DbDarquest`.`Questions` (`idQuestion`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Questions_has_Reponses_Reponses1`
    FOREIGN KEY (`Reponses_idReponse`)
    REFERENCES `DbDarquest`.`Reponses` (`idReponse`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `DbDarquest`.`marche`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `DbDarquest`.`marche` (
  `qtItem` INT NOT NULL DEFAULT 0,
  `Item_idItem` INT NOT NULL,
  PRIMARY KEY (`Item_idItem`),
  CONSTRAINT `fk_marche_Item1`
    FOREIGN KEY (`Item_idItem`)
    REFERENCES `DbDarquest`.`Item` (`idItem`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

ALTER TABLE sorts
ADD COLUMN rarete TINYINT,
ADD COLUMN soins TINYINT;

ALTER TABLE potions
ADD COLUMN soins TINYINT;

