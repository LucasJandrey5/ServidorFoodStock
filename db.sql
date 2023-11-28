SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

CREATE SCHEMA IF NOT EXISTS `marcosvir_lucasj` DEFAULT CHARACTER SET utf8 ;
USE `marcosvir_lucasj` ;

-- -----------------------------------------------------
-- Table `marcosvir_lucasj`.`restaurante`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `marcosvir_lucasj`.`restaurante` (
  `idrestaurante` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NOT NULL,
  `descricao` VARCHAR(45) NOT NULL,
  `endereco` VARCHAR(256) NOT NULL,
  `horario` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idrestaurante`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `marcosvir_lucasj`.`lanche`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `marcosvir_lucasj`.`lanche` (
  `idlanche` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NOT NULL,
  `descricao` VARCHAR(512) NOT NULL,
  `preco` FLOAT NOT NULL,
  `freteGratis` TINYINT NOT NULL,
  `combo` TINYINT NOT NULL,
  `restaurante_idrestaurante` INT NOT NULL,
  PRIMARY KEY (`idlanche`),
  INDEX `fk_lanche_restaurante_idx` (`restaurante_idrestaurante` ASC) VISIBLE,
  CONSTRAINT `fk_lanche_restaurante`
    FOREIGN KEY (`restaurante_idrestaurante`)
    REFERENCES `marcosvir_lucasj`.`restaurante` (`idrestaurante`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


