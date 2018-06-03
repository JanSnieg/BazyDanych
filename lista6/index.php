<!DOCTYPE HTML>
<html lang="pl">
<head>
    <meta charset="utf-8" />
    <title>Lista 1</title>
</head>
<body>
    <h1>Zadanie 1</h1>
    <h2>Ile liczb wypisać?</h2>
    <form action="tablica.php" method="POST">
        <input type="number" name="n" value="1" min="1" step="1"/>
        <br/>
        <input type="submit" value="Potwierdź"/>
    </form>
    <h1>Zadanie 2</h1>
    <?php
        $tablica = [[1,2,3,4,5,6,7],
            ["a","b","c","d","e","f","g"],
            [7,6,5,4,3,2,1],
            [1.0,1.1,1.2,1.3,1.4,1.5,1.6],
            ["mam","na","imie","Paweł","i mam",23, "lata"]];
            $result = "";
            foreach ($tablica as $wiersz) 
            {
                $result .= "<tr><td>".implode("</td><td>", $wiersz)."</tr>";
            }
            echo '<table border = "1" cellpadding="10" cellspacing="0">'.$result."</table>";
    ?>

    <h1>Zadanie 3</h1>
    <h2>Wypełnij formularz</h2>
    <form action="student.php" method="POST">
            <input type="text" name="imie" placeholder="Imię"/>
            <input type="text" name="nazwisko" placeholder="Nazwisko"/>
            <h3>Ulubione zajęcia:</h3>
            <input type="checkbox" name="zajecia[]" value="Bazy Danych"/> Bazy danuch<br>
            <input type="checkbox" name="zajecia[]" value="Algorytmy i Struktury Danych"/> Algorytmy i Struktury Danych<br>
            <input type="checkbox" name="zajecia[]" value="Modelowanie Komputerowe"/> Modelowanie Komputerowe<br>
            <input type="checkbox" name="zajecia[]" value="Matematyka"/> Matematyka<br>
            <input type="checkbox" name="zajecia[]" value="Fizyka"/> Fizyka<br>
            <h3>Hobby:</h3>
            <input type="checkbox" name="hobby[]" value="Nauka"/> Nauka<br>
            <input type="checkbox" name="hobby[]" value="Rower"/> Jazda na Rowerze<br>
            <input type="checkbox" name="hobby[]" value="Snowboard"/> Snowboard<br>
            <input type="checkbox" name="hobby[]" value="Gry elektroniczne"/> Gry elektroniczne<br>
            <input type="checkbox" name="hobby[]" value="Gry papierowe"/> Gry papierowe<br>
            <br><br>
            <input type="submit" name="submit" value="Potwierdź"/>

    </form>
</body>
</html>