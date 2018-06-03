<?php 
    session_start();
    if(!isset($_SESSION['udane_dodanie'])) 
    {
        header("Location: index.php");
        exit();
    }
    else
    {
        unset($_SESSION['udane_dodanie']);
    }
    if(isset($_SESSION['idw']))
        unset($_SESSION['idw']);
    //usuwanie zmiennych pamietanych przy rejestracji
    if(isset($_SESSION['fr_nazwa']))
        unset($_SESSION['fr_nazwa']);
    if(isset($_SESSION['fr_czas']))
        unset($_SESSION['fr_czas']);
    if(isset($_SESSION['fr_od']))
        unset($_SESSION['fr_od']);
    if(isset($_SESSION['fr_do']))
        unset($_SESSION['fr_do']);

    // usuwanie errorów
    if(isset($_SESSION['e_nazwa']))
        unset($_SESSION['e_nazwa']);
    if(isset($_SESSION['e_czas']))
        unset($_SESSION['e_czas']);
    if(isset($_SESSION['e_od']))
        unset($_SESSION['e_od']);
?>

<!DOCTYPE HTML>
<html lang="pl">

<meta charset="utf8">

<head>
    <title>Dzięki</title>
</head>

<body>
    <h1>Dziękujemy za dodanie gry/wydawnictwa</h1>
    <h2>Mozesz <a href="admin.php">wrócić</a> na strone główną admina</h2>
</body>

</html>