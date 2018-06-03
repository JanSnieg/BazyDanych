<?php 
    session_start();
    if(!isset($_SESSION['udana_rejestracja'])) 
    {
        header("Location: index.php");
        exit();
    }
    else
    {
        unset($_SESSION['udana_rejestracja']);
    }
    //usuwanie zmiennych pamietanych przy rejestracji
    if(isset($_SESSION['fr_nick']))
        unset($_SESSION['fr_nick']);
    if(isset($_SESSION['fr_email']))
        unset($_SESSION['fr_email']);
    if(isset($_SESSION['fr_haslo1']))
        unset($_SESSION['fr_haslo1']);
    if(isset($_SESSION['fr_haslo2']))
        unset($_SESSION['fr_haslo2']);

    // usuwanie errorów
    if(isset($_SESSION['e_nick']))
        unset($_SESSION['e_nick']);
    if(isset($_SESSION['e_email']))
        unset($_SESSION['e_email']);
    if(isset($_SESSION['e_haslo']))
        unset($_SESSION['e_haslo']);
    if(isset($_SESSION['e_bot']))
        unset($_SESSION['e_bot']);
?>

<!DOCTYPE HTML>
<html lang="pl">

<meta charset="utf8">

<head>
    <title>Dzięki</title>
</head>

<body>
    <h1>Dziękujemy za rejestracje</h1>
    <h2>Mozesz juz <a href="index.php">zalogować</a> się na swoje konto</h2>
</body>

</html>