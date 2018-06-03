<?php 
    session_start();
    if(!isset($_SESSION['udana_ocena']) || $_SESSION['udana_ocena'] = false) 
    {
        header("Location: index.php");
        exit();
    }
    else
    {
        unset($_SESSION['udana_ocena']);
    }
    if(isset($_SESSION['Nazwa']))
        unset($_SESSION['Nazwa']);
    if(isset($_SESSION['Ocena']))
        unset($_SESSION['Ocena']);
    // usuwanie errorów
    if(isset($_SESSION['e_ocena']))
        unset($_SESSION['e_ocena']);
?>

<!DOCTYPE HTML>
<html lang="pl">

<meta charset="utf8">

<head>
    <title>Dzięki</title>
</head>

<body>
    <h1>Dziękujemy za ocenę gry/wydawnictwa</h1>
    <h2>Mozesz <a href="strona_glowna.php">wrócić</a> na strone główną</h2>
</body>

</html>