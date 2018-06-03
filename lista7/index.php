<<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Lista nr6</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <form action="dodawanie.php" method="POST">
        <input type="text" name="nazwa" placeholder="Nazwa produktu"/>
        Cena: <input type="number" name="cena" value="0"/>
        Ilość: <input type="number" name="ilosc" value="0.0" size="12" />
        <input type="submit" value ="Potwierdź" />
    </form>
    <?
        $link = mysqli_connect("localhost", "polszowy", "aK2zoweimoo6", "polszowy_test");
        if(!$link) 
            die("Brak połączenia z bazą danych");
        else
        {
            echo mysqli_get_host_info($link);
            $select = mysql_query($link, "INSERT INTO TABLE produkty (nazwa, cena, ilosc) VALUES $nazwa, $cena, $ilosc");
            echo "INSERT zadziałał";
            mysql_close($link);
        }
    ?>
</body>
</html>