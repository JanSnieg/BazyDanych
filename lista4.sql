ZADANIE 1
CREATE OR REPLACE VIEW calosc AS SELECT idk, klienci.nazwa imie, idp, produkty.nazwa nazwa, cena, sztuk FROM klienci LEFT JOIN (produkty JOIN detal_zamow ON(idp=p_id) JOIN zamow ON (idz=z_id)) ON (idk=k_id);

SELECT lewa.imie FROM calosc lewa JOIN calosc prawa using(idk) WHERE lewa.nazwa LIKE "%laptop%" AND prawa.nazwa LIKE "%tablet%";

ZADANIE 2
SELECT lewa.imie, lewa.nazwa, najwyzsza FROM calosc lewa JOIN (SELECT idk, MAX(cena*sztuk) AS najwyzsza FROM calosc GROUP BY idk) AS prawa USING(idk) WHERE (lewa.cena*lewa.sztuk) <=> (najwyzsza) ORDER BY najwyzsza;

ZADANIE 3
SELECT WEEKOFYEAR(data) AS tydzien, AVG(suma) FROM (SELECT z_id, SUM(cena*sztuk) AS suma, data FROM zamow JOIN detal_zamow ON (idz=z_id) JOIN produkty ON(idp=p_id) GROUP BY z_id) AS prawa GROUP BY tydzien;

