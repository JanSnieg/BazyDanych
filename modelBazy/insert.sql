INSERT INTO `Uzytkownik` (`Nick`, `Haslo`, `e-mail`)
    VALUES ('nickPawel', 'hasloPawel', 'pawel@poczta.pl'),
    ('Cwiek', 'Jakub', 'klamca@poczta.pl'),
    ('Piekara', 'Jacek', 'inkwizytor@watykan.pl'),
    ('Pawel', 'jakiesdziwnehaslo', 'pawel@gmail.com'),
    ('Tobiasz', 'Dobrowolski', 'mail@op.pl');

INSERT INTO `Wydawnictwo` (`Nazwa`)
    VALUES ('Cool Mini or Not'), 
    ('Lacerta'),
    ('MindOK'),
    ('Portal'),
    ('Rebel');

INSERT INTO `Gra` (`Nazwa`, `CzasTwrania`, `MinOsob`, `MaxOsob`, `w_id`)
    VALUES ('blood rage', 80, 2, 4, 1),
    ('Pandemic Legacy', 120, 1, 5, 2),
    ('Terra Mistica', 120, 2, 4, 3),
    ('Neuroshima Hex', 30, 2, 2, 4),
    ('Smallworld', 90, 2, 4, 5);

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

INSERT INTO `OcenaWydawnictwa` (`Ocena`, `w_id`, `u_id`, `Komentarz`)
    VALUES (1.0, 4, 4, "słabe nie polecam"),
    (1.5, 5, 5, "Wszystko sie łamie, słabe materiały");

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

INSERT INTO `OcenaGry` (`Ocena`, `g_id`, `u_id`, `Komentarz`)
    VALUES (1, 4, 4, "Nie da sie grać"),
    (5, 5, 5, "Najlepsza w jaką kiedykolwiek grałem");

/* SPRAWDZANIE REKORDÓW */
SELECT * FROM Uzytkownik;
SELECT * FROM Wydawnictwo;
SELECT * FROM Gra;
SELECT * FROM WydaloDetal;
SELECT * FROM OcenaGry;
SELECT * FROM OcenaWydawnictwa;

UPDATE OcenaGry
    SET Ocena = Ocena+0.1;

DELETE FROM OcenaGry
    WHERE u_id=1;
    
DELETE FROM `Uzytkownik`
WHERE idu = 1;