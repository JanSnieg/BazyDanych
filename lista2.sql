Zad1
SELECT nazwa FROM klienci WHERE miasto != 'Wrocław';

Zad2
SELECT nazwa, (cena*ilosc) FROM produkty;

Zad3
SELECT * FROM zamow WHERE WEEKDAY(data) = 0 OR WEEKDAY(data) = 4;

Zad4
SELECT nazwa FROM produkty WHERE nazwa LIKE '%Apple%';

Zad5
SELECT nazwa FROM klienci WHERE adres LIKE '%Marszałkowska%';

Zad6
SELECT [DISTINCT nazwa], ilosc FROM produkty JOIN detal_zamow ON (idp=p_id);

Zad7
SELECT nazwa FROM produkty LEFT JOIN detal_zamow ON(idp = p_id) WHERE idd IS NULL;

Zad8
SELECT nazwa FROM klienci LEFT JOIN zamow ON(idk = k_id) WHERE idz IS NULL;
