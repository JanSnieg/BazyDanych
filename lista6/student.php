<!DOCTYPE HTML>
<html lang="pl">
<head>
    <meta charset="utf-8" />
    <title>Zadanie 1</title>
</head>
<body>

<?php
    $imie = $_POST['imie'];
    $nazwisko = $_POST['nazwisko'];
    $zajecia = "<ul><li>".implode("</li><li>", $_POST['zajecia'])."</li></ul>";
    $hobby = "<ul><li>".implode("</li><li>", $_POST['hobby'])."</li></ul>";

echo<<<END
    Student $imie $nazwisko lubi zajecia z:
    $zajecia. <br>A w wolnym czasie najbardziej interesuje go:
    $hobby

    <br/><a href="index.php">Powrót</a>
END;
?>
</body>
</html>