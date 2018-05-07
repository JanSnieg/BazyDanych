/* USUWANIE TABEL JEZELI ISTNIEJA */
DROP TABLE IF EXISTS `Uzytkownik`;
DROP TABLE IF EXISTS `Wydawnictwo`;
DROP TABLE IF EXISTS `Gra`;
DROP TABLE IF EXISTS `OcenaWydawnictwa`;
DROP TABLE IF EXISTS `OcenaGry`;
DROP TABLE IF EXISTS `WydaloDetal`;


/* TWORZENIE TABEL */
CREATE TABLE `Uzytkownik`
(
  `idu` INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `Nick` VARCHAR(30) NOT NULL UNIQUE,
  `Haslo` VARCHAR(30) NOT NULL,
  `e-mail` VARCHAR(50) NOT NULL UNIQUE);

CREATE TABLE `Wydawnictwo`
(
  `idw` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `Nazwa` VARCHAR(50) NOT NULL,
  `SredniaOcen` DECIMAL(4,2));

CREATE TABLE `Gra`
(
  `idg` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `Nazwa` VARCHAR(20) NOT NULL,
  `SredniaOcen` DECIMAL(4,2));

CREATE TABLE `OcenaWydawnictwa`
(
  `iduw` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `Ocena` DECIMAL(3,1) NOT NULL DEFAULT 0,
  `Data` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `u_id` INT NOT NULL REFERENCES `Uzytkownik` (`idu`)
    ON UPDATE CASCADE ON DELETE CASCADE,
  `w_id` INT NOT NULL REFERENCES `Wydawnictwo` (`idw`)
    ON UPDATE CASCADE ON DELETE CASCADE);

CREATE TABLE `OcenaGry`
(
  `idug` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `Ocena` DECIMAL(3,1) NOT NULL DEFAULT 0,
  `Data` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `g_id` INT NOT NULL REFERENCES `Gra`(`idg`)
    ON UPDATE CASCADE ON DELETE CASCADE,
  `u_id` INT NOT NULL REFERENCES `Uzytkownik`(`idu`)
    ON UPDATE CASCADE ON DELETE CASCADE);

CREATE TABLE `WydaloDetal`
(
  `idd` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `Data` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `g_id` INT NOT NULL REFERENCES `Gra` (`idg`)
    ON UPDATE CASCADE ON DELETE CASCADE,
  `w_id` INT NOT NULL REFERENCES `Wydawnictwo` (`idw`)
    ON UPDATE CASCADE ON DELETE CASCADE);

/* USUWANIE TRIGGEROW JEZELI ISTNIEJA */

DROP TRIGGER IF EXISTS `sredniaWydawnictwaInsert`;
DROP TRIGGER IF EXISTS `sredniaWydawnictwaUpdate`;
DROP TRIGGER IF EXISTS `sredniaWydawnictwaDelete`;
DROP TRIGGER IF EXISTS `sredniaGryInsert`;
DROP TRIGGER IF EXISTS `sredniaGryUpdate`;
DROP TRIGGER IF EXISTS `sredniaGryDelete`;


/* TRIGGERY NA SREDNIA OCENE WYDAWNICTWA*/

CREATE TRIGGER `sredniaWydawnictwaInsert`
  AFTER INSERT ON `OcenaWydawnictwa`
  FOR EACH ROW
    UPDATE `Wydawnictwo`
    SET `SredniaOcen` = (SELECT AVG(`Ocena`) FROM `OcenaWydawnictwa`
      WHERE `idw` = `w_id`)
    WHERE `idw` = NEW.w_id;


CREATE TRIGGER `sredniaWydawnictwaUpdate`
  AFTER UPDATE ON `OcenaWydawnictwa`
  FOR EACH ROW
    UPDATE `Wydawnictwo`
    SET `SredniaOcen` = (SELECT AVG(`Ocena`) FROM `OcenaWydawnictwa`
      WHERE `idw` = `w_id`)
    WHERE `idw` = NEW.w_id;

CREATE TRIGGER `sredniaWydawnictwaDelete`
  AFTER DELETE ON `OcenaWydawnictwa`
  FOR EACH ROW
    UPDATE `Wydawnictwo`
    SET `SredniaOcen` = (SELECT AVG(`Ocena`) FROM `OcenaWydawnictwa`
      WHERE `idw` = `w_id`);

/* TRIGGERY NA SREDNIOA OCENE GIER */

CREATE TRIGGER `sredniaGryInsert` 
  AFTER INSERT ON `OcenaGry`
  FOR EACH ROW
    UPDATE `Gra`
    SET SredniaOcen = (SELECT AVG(Ocena) FROM OcenaGry
      WHERE `g_id` = `idg`)
    WHERE `idg` = NEW.g_id;
  
CREATE TRIGGER `sredniaGryUpdate` 
  AFTER UPDATE ON `OcenaGry`
  FOR EACH ROW
    UPDATE `Gra`
    SET SredniaOcen = (SELECT AVG(Ocena) FROM OcenaGry
      WHERE `g_id` = `idg`)
    WHERE `idg` = NEW.g_id;
  
CREATE TRIGGER `sredniaGryDelete` 
  AFTER DELETE ON `OcenaGry`
  FOR EACH ROW
    UPDATE `Gra`
    SET SredniaOcen = (SELECT AVG(Ocena) FROM OcenaGry
      WHERE `g_id` = `idg`);