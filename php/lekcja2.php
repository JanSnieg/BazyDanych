<<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Lekcja 2</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <?php
        // mysqli modół do mysql dokumnetacj na PHP.net
        // klasy:
        // 1. mysqli- połączenia do bazy danych
        // 2. mysqli_result- wynik selecta
        // Połączenie z bazą:
        $link = mysqli_connect(); //(proceduralny) lub
        $link = new mysqli(); // obiektowy
        // argumenty: host, user, password, db, port, socket
        // "localhost", "polsozwy", "****", "polszowy_model"
        if(!$link) die("..."); // jeeli nie ma połączenia to zwroci to NULL
         // info o połączeniu
        echo mysqli_get_host_info($link); // lub
        echo $link->host_info;
        //zamykanie połczenia:
        mysql_close($link); // lub
        $link->close();

        //zmiana bazy danych
        mysqli_select_db($link, "baza danych"); // lub
        $link->select_db("baza");
        //zmiana urzytkownika
        mysqli_change_user($link, "user", "pass", "nazwabayz"); // lub
        $link->change_user("user", "pass", "nazwabayz");

        // Zapytania do bazy danych (select, insert,...)
        $result = mysqli_query($link, "SELECT..."); // lub
        $result = $link->query("SELECT...");
        //zwacane wartości:
        // false, jakis błąd po drodze
        // true, nic nie zwróciło, ale wykonało się dobrze
        // mysqi_result, wynik selecta

        // kawałek kodu do przeiterowania przez wiersze
        while($row = mysqli_fetch_row($result))
        {
            // instrukcje
            // SELECT * FROM produkty; (4 kolumny)
            array(
                [0]= 1,
                [1]= "laptop",
                [2]= 3.56, //cena
                [3]= 7);//ilosc
        }
        while($row = mysqli_fetch_assoc($result))
        {
            // zamiast indeksow nazwy kolumn takie jak w mysql
        }
        while($row = mysql_fetch_array($result)) // drugi argument, ale to sie stanie jednym z powyszych
        {
            // oba powyzsze, zawiera indeksy ale i rowniez nazwy w innych kolumnach
        }
        while($row = mysql_fetch_object($result, "nazwa klasy(zdefiniowana)", array("nazwy argumentów, mapowania pomiedzy jednym a drugim")))
        {

        }
        // wrzucenie do tablicy tablic całego wyniku zapytania. (taka jak fetch array)
        $tbl = mysqli_fetch_all($result, MYSQLI_NUM);
    ?>
</body>
</html>