DROP TABLE IF EXISTS `rezerwacja`;
DROP TABLE IF EXISTS `czytelnik`;
DROP TABLE IF EXISTS `egzemplarz`;
DROP TABLE IF EXISTS `dzielo`;

CREATE TABLE `dzielo` (
  `idd`          int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tytul`        varchar(100) NOT NULL,
  `autor`        varchar(100),
  `kategoria`    varchar(30),
  `rokpowstania` int(4),
  PRIMARY KEY (`idd`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `egzemplarz` (
  `ide`         int(10) unsigned NOT NULL AUTO_INCREMENT,
  `d_id`        int(10) unsigned,
  `wydawnictwo` varchar(50),
  `rokwydania`  int(4),
  PRIMARY KEY (`ide`),
  KEY `d_ind` (`d_id`),
  CONSTRAINT `fk_egzemplarz_dzielo` FOREIGN KEY (`d_id`) REFERENCES `dzielo` (`idd`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `czytelnik` (
  `idc`      int(10) unsigned NOT NULL AUTO_INCREMENT,
  `imie`     varchar(30) NOT NULL,
  `nazwisko` varchar(50) NOT NULL,
  `adres`    varchar(200) NOT NULL,
  `telefon`  varchar(20),
  `email`    varchar(30),
  PRIMARY KEY (`idc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `rezerwacja` (
  `idr`       int(10) unsigned NOT NULL AUTO_INCREMENT,
  `c_id`      int(10) unsigned,
  `e_id`      int(10) unsigned,
  `datazamow` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `datawypoz` timestamp NULL,
  `datazwrot` timestamp NULL,
  PRIMARY KEY (`idr`),
  KEY `c_ind` (`c_id`),
  KEY `e_ind` (`e_id`),
  CONSTRAINT `fk_rezerwacja_czytelnik`  FOREIGN KEY (`c_id`) REFERENCES `czytelnik`  (`idc`) ON UPDATE CASCADE,
  CONSTRAINT `fk_rezerwacja_egzemplarz` FOREIGN KEY (`e_id`) REFERENCES `egzemplarz` (`ide`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
