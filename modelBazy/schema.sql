/* USUWANIE TABEL JEZELI ISTNIEJA */
DROP TABLE IF EXISTS `OcenaWydawnictwa` CASCADE;
DROP TABLE IF EXISTS `OcenaGry` CASCADE;
DROP TABLE IF EXISTS `Uzytkownik` CASCADE;
DROP TABLE IF EXISTS `Gra` CASCADE;
DROP TABLE IF EXISTS `Wydawnictwo` CASCADE;



/* TWORZENIE TABEL */
CREATE TABLE `Uzytkownik`
(
  `idu` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `Nick` VARCHAR(30) NOT NULL UNIQUE,
  `Haslo` VARCHAR(255) NOT NULL,
  `e-mail` VARCHAR(50) NOT NULL UNIQUE);

CREATE TABLE `Wydawnictwo`
(
  `idw` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `Nazwa` VARCHAR(50) NOT NULL,
  `SredniaOcen` DECIMAL(4,2));

CREATE TABLE `Gra`
(
  `idg` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `Nazwa` VARCHAR(50) NOT NULL,
  `CzasTwrania` INT UNSIGNED,
  `MinOsob` INT DEFAULT 1,
  `MaxOsob` INT DEFAULT 2, 
  `SredniaOcen` DECIMAL(4,2),
  `w_id` INT UNSIGNED NOT NULL,
  `DataWydania` DATE,
  PRIMARY KEY (idg),
  FOREIGN KEY (w_id) REFERENCES Wydawnictwo (idw)
    ON UPDATE CASCADE ON DELETE CASCADE);

CREATE TABLE `OcenaWydawnictwa`
(
  `iduw` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `Ocena` DECIMAL(3,1) NOT NULL DEFAULT 0,
  `Data` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `w_id` INT UNSIGNED NOT NULL,
  `u_id` INT UNSIGNED NOT NULL,
  `Komentarz` VARCHAR(200),
  PRIMARY KEY (iduw),
  FOREIGN KEY (w_id) REFERENCES Wydawnictwo (idw)
    ON UPDATE CASCADE ON DELETE CASCADE,
    -- UNIQUE(g_id, u_id), << JEST W BAZIE
  FOREIGN KEY (u_id) REFERENCES Uzytkownik (idu)
    ON UPDATE CASCADE ON DELETE CASCADE);

CREATE TABLE `OcenaGry`
(
  `idog` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `Ocena` DECIMAL(3,1) NOT NULL DEFAULT 0,
  `Data` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `g_id` INT UNSIGNED NOT NULL,
  `u_id` INT UNSIGNED NOT NULL,
  `Komentarz` VARCHAR(200),
  PRIMARY KEY (idog),
  FOREIGN KEY (g_id) REFERENCES Gra (idg)
    ON UPDATE CASCADE ON DELETE CASCADE,
  -- UNIQUE(g_id, u_id), << JEST W BAZIE
  FOREIGN KEY (u_id) REFERENCES Uzytkownik (idu)
    ON UPDATE CASCADE ON DELETE CASCADE);

/* USUWANIE TRIGGEROW JEZELI ISTNIEJA */

DROP TRIGGER IF EXISTS `sredniaWydawnictwaInsert`;
DROP TRIGGER IF EXISTS `sredniaWydawnictwaUpdate`;
DROP TRIGGER IF EXISTS `sredniaWydawnictwaDelete`;
DROP TRIGGER IF EXISTS `sredniaGryInsert`;
DROP TRIGGER IF EXISTS `sredniaGryUpdate`;
DROP TRIGGER IF EXISTS `sredniaGryDelete`;
DROP TRIGGER IF EXISTS `usuwanieUzytkownika`;


/* TRIGGERY NA SREDNIA OCENE WYDAWNICTWA*/

CREATE TRIGGER `sredniaWydawnictwaInsert`
  AFTER INSERT ON `OcenaWydawnictwa`
  FOR EACH ROW
    UPDATE `Wydawnictwo`
    SET SredniaOcen = (SELECT AVG(`Ocena`) FROM `OcenaWydawnictwa`
      WHERE `idw` = `w_id`)
    WHERE `idw` = NEW.w_id;


CREATE TRIGGER `sredniaWydawnictwaUpdate`
  AFTER UPDATE ON `OcenaWydawnictwa`
  FOR EACH ROW
    UPDATE `Wydawnictwo`
    SET SredniaOcen = (SELECT AVG(`Ocena`) FROM `OcenaWydawnictwa`
      WHERE `idw` = `w_id`)
    WHERE `idw` = NEW.w_id;

CREATE TRIGGER `sredniaWydawnictwaDelete`
  AFTER DELETE ON `OcenaWydawnictwa`
  FOR EACH ROW
    UPDATE `Wydawnictwo`
    SET SredniaOcen = (SELECT AVG(`Ocena`) FROM `OcenaWydawnictwa`
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

delimiter //
CREATE TRIGGER `usuwanieUzytkownika`
  AFTER DELETE ON `Uzytkownik`
  FOR EACH ROW 
  BEGIN
    UPDATE `Gra`
    SET SredniaOcen = (SELECT AVG(Ocena) FROM OcenaGry
      WHERE `g_id` = `idg`);
    UPDATE `Wydawnictwo`
    SET SredniaOcen = (SELECT AVG(Ocena) FROM OcenaWydawnictwa
      WHERE `idw` = `w_id`);
  END
//
delimiter ;
