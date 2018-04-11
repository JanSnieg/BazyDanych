--Zadanie 1
SELECT imie, nazwisko
FROM czytelnik
WHERE adres NOT LIKE "%Wroc%";

--Zadanie 2
SELECT * 
FROM rezerwacja
WHERE WEEKDAY(datazamow) = 1;

--Zadanie 3
SELECT tytul,  autor
FROM dzielo JOIN egzemplarz ON(idd=d_id)
WHERE wydawnictwo LIKE "%PWN%";

--Zadanie 4
SELECT imie, nazwisko 
FROM czytelnik JOIN rezerwacja ON (idc=c_id) 
WHERE datawypoz > datazamow;

--Zadanie 5
SELECT * 
FROM czytelnik LEFT JOIN rezerwacja ON(c_id=idc)
WHERE c_id IS NULL;

--Zadanie 6
SELECT count(ide)
FROM egzemplarz JOIN rezerwacja ON(ide=e_id) LEFT JOIN czytelnik ON(idc=c_id)
WHERE ((datazwrot IS NULL) AND (adres NOT LIKE "%Wroc%"));

--Zadanie 7
SELECT a, t FROM
    (SELECT idd, MAX(ilosc), alias.a, alias.t FROM
        (SELECT idd, COUNT(idd) AS ilosc, tytul as t, autor as a
        FROM dzielo JOIN egzemplarz ON (idd=d_id) JOIN rezerwacja ON (ide=e_id)
        GROUP BY idd) AS alias) AS alias2;

--Zadanie 8
SELECT idd, tytul, COUNT(idd)
FROM dzielo LEFT JOIN egzemplarz ON(d_id=idd)
GROUP BY idd;

--Zadanie 9
SELECT imie, nazwisko, kategoria 
FROM (dzielo JOIN egzemplarz ON (idd=d_id)
    JOIN rezerwacja ON(ide=e_id) 
    JOIN czytelnik ON (idc=c_id)) 
WHERE kategoria LIKE "%fizyka kwantowa%" 
OR kategoria LIKE "%poezja%";

--Zadanie 10
