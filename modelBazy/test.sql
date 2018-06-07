SELECT DISTINCT
* FROM Gra JOIN Wydawnictwo as GW ON (w_id= idw)
LEFT JOIN OcenaGry ON(idg=g_id) LEFT JOIN Uzytkownik ON(u_id=idu);

/* Poprawne złączenie oceny i uzytkowników */
SELECT *  FROM Uzytkownik LEFT JOIN OcenaGry ON(idu=u_id);

SELECT Gra LEFT JOIN 
    (SELECT DISTINCT * FROM OcenaGry WHERE u_id = ...) as alias;
    -- POPRAWIONE


-- JOIN Gra ON(idg=g_id)