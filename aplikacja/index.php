<?php 
    session_start();
    if(isset($_SESSION['zalogowany']) && $_SESSION['zalogowany'])
    {
        header("Location: strona_glowna.php");
        exit();
    }
?>

<!DOCTYPE HTML>
<html>

<meta charset="utf8">

<head>
    <link rel="stylesheet" type="text/css" href="style/mystyle.css">
    <title>Logowanie</title>
</head>

<body>
    <div class="container">
        <form action="logowanie.php" method="POST">
            <div class="row">
                <div class="col-25">
                    <label for="nick">Nick/Email</label>
                </div>
                <div class="col-75">
                    <input type="text" name="nick" placeholder="Nick/E-mail" required maxlength="50">
                </div>
            </div>
            <div class="row">
                <div class="col-25">
                    <label for="haslo">Hasło</label>
                </div>
                <div class="col-75">
                    <input type="password" name="haslo" placeholder="Hasło" required maxlength="30">
                </div>
            </div>
            <div class="row">
                <input type="submit" name="submit" value="Zaloguj">
            </div>
        </form>
        <form action="rejestracja.php" method="POST">
            <div class="row">
                <input type="submit" name="rejestracja" value="Zarejestruj się">
            </div>
        </form>
        <?php
        if(isset($_SESSION['blad']))
            echo $_SESSION['blad'];

        ?>
    </div>

</body>

</html>