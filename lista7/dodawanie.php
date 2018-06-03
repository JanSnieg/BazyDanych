<<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <?php
        $link = mysqli_connect("localhost", "polszowy", "aK2zoweimoo6", "polszowy_test");
        if(!$link) 
            die("Brak połączenia z bazą danych");
        else
        {
            echo mysqli_get_host_info($link);
            $nazwa = $_POST['nazwa'];
            $cena = $_POST['cena'];
            $ilosc = $_POST['ilosc'];
            $insert = mysql_query($link, "INSERT INTO TABLE produkty (nazwa, cena, ilosc) VALUES $nazwa, $cena, $ilosc");
            echo "INSERT zadziałał";
            mysql_close($link);
        }
    ?>
    
</body>
</html>