INSERT INTO `Uzytkownik` (`Nick`, `Haslo`, `e-mail`)
    VALUES ('nickPawel', 'hasloPawel', 'pawel@poczta.pl'),
    ('Cwiek', 'Jakub', 'klamca@poczta.pl'),
    ('Piekara', 'Jacek', 'inkwizytor@watykan.pl'),
    ('Pawel', 'jakiesdziwnehaslo', 'pawel@gmail.com');

INSERT INTO `Wydawnictwo` (`Nazwa`)
    VALUES ('Cool Mini or Not'), 
    ('Lacerta'),
    ('MindOK');

INSERT INTO `Gra` (`Nazwa`)
    VALUES ('blood rage'),
    ('Pandemic Legacy'),
    ('Terra Mistica');

INSERT INTO `WydaloDetal` (`g_id`, `w_id`)
    VALUES (1,1),
    (2,2),
    (3,3);

INSERT INTO `OcenaWydawnictwa` (`Ocena`, `w_id`, `u_id`)
    VALUES (5.0, 1, 1),
    (2.0, 1, 2),
    (3.5, 1, 3),
    (3.5, 2, 1),
    (4.0, 2, 2),
    (5.0, 2, 3),
    (4.5, 3, 1),
    (3.5, 3, 2),
    (1.0, 3, 3);

INSERT INTO `OcenaGry` (`Ocena`, `g_id`, `u_id`)
    VALUES (5, 1, 1),
    (3, 1, 2),
    (3, 1, 3),
    (2, 2, 1),
    (4, 2, 2),
    (5, 2, 3),
    (2, 3, 1),
    (4, 3, 2),
    (1, 3, 3);

/* SPRAWDZANIE REKORDÓW */
SELECT * FROM Uzytkownik;
SELECT * FROM Wydawnictwo;
SELECT * FROM Gra;

UPDATE OcenaGry
    SET Ocena = Ocena+0.1;

DELETE FROM OcenaGry
    WHERE u_id=1;
    
DELETE FROM `Uzytkownik`
WHERE idu = 1;