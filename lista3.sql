--ZADANIE 1
SELECT GROUP_CONCAT(nazwa
ORDER BY nazwa SEPARATOR ", ") FROM klienci;
--ZADANIE 2
SELECT nazwa, SUM(sztuk)
FROM produkty JOIN detal_zamow ON(p_id=idp)
GROUP BY nazwa;
--ZADANIE 3
SELECT klienci.nazwa, IFNULL(SUM(cena*sztuk),0) AS "Cena"
FROM klienci LEFT JOIN (produkty JOIN detal_zamow ON(idp=p_id) JOIN zamow ON(idz=z_id)) ON(idk=k_id)
GROUP BY klienci.nazwa;
--ZADANIE 4
SELECT SUM(sztuk*cena) AS "Cena_calosci", MONTH(data)
FROM zamow LEFT JOIN detal_zamow ON (idz = z_id) JOIN produkty ON(idp=p_id)
GROUP BY MONTH(data);
--ZADANIE 5
SELECT produkty.nazwa, MAX(sztuk*cena) AS "MAX", MONTH(data)
FROM zamow RIGHT JOIN detal_zamow ON (idz = z_id) RIGHT JOIN produkty ON(idp=p_id)
GROUP BY produkty.nazwa, MONTH(data)
ORDER BY produkty.nazwa;
