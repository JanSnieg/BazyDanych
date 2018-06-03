<?php 
    session_start();
    error_reporting(E_ALL);
    ini_set('display_errors', 1);


    if(isset($_POST['email']))// mogłoby być cokolwiek, bo po kliknięciu submit przesyłane są dane, a nie wcześniej
    {
        // udana walidacja
        $wszystko_ok = true;

        $nick = $_POST['nick'];
        // sprawdzenie długości nicka
        if ((strlen($nick)<3) || (strlen($nick)>30))
        {
            $wszystko_ok = false;
            $_SESSION['e_nick']="Nick musi posiadać od 3 do 50 znaków";
        }
        // sprawdznie czy znaki sa alfanumeryczne
        if(!ctype_alnum($nick))
        {
            $wszystko_ok = false;
            $_SESSION['e_nick'] = "Nick moze składać sie tylko z liter i cyfr(bez polskich znakow)";
        }
        //WALIDACJA E-MAILA
        $email = $_POST['email'];
        $email_after = filter_var($email, FILTER_SANITIZE_EMAIL);
        if(!(filter_var($email_after, FILTER_VALIDATE_EMAIL)) || $email_after != $email)
        {
            $wszystko_ok = false;
            $_SESSION['e_email'] = "Podaj poprawy adres e-mail";
        }
        //WALIDACJA HASŁA
        $haslo1 = $_POST['haslo1'];
        $haslo2 = $_POST['haslo2'];
        if ((strlen($haslo1)<8) || (strlen($haslo1)>30))
        {
            $wszystko_ok = false;
            $_SESSION['e_haslo'] = "Haslo musi posiadać od 8 do 30 znaków";
        }
        if($haslo1 != $haslo2)
        {
            $wszystko_ok = false;
            $_SESSION['e_haslo'] = "Podane hasła nie są identyczne";
        }
        // haszowanie hasła
        $haslo_hash = password_hash($haslo1, PASSWORD_DEFAULT);

        /* 
        EWENTUALNY REGULAMIN (CHECKBOX)
        if(!isses($_POST['regulami]))
        {
            $wszystko_ok = false;
            $_SESSION['e_regulamin'] = "Potwierdź regulamin";
        }
        */

        //BOT OR NOT?
        $sekret = "6Ld0PVsUAAAAAAhWrar5_guTTtC9wvWKChc5eI8e";
        $response = json_decode(file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$sekret.'&response='.$_POST['g-recaptcha-response']));

        if(!($response->success))
        {
            $wszystko_ok = false;
            $_SESSION['e_bot'] = "Potwierdź ze jesteś człowiekiem";
        }
        //Trzymanie wprowadzonych dancyh
        $_SESSION['fr_nick'] = $nick;
        $_SESSION['fr_email'] = $email;
        $_SESSION['fr_haslo1'] = $haslo1;
        $_SESSION['fr_haslo2'] = $haslo2;

        // Łączenie sie z bazą danych
        require_once "connection.php";
        mysqli_report(MYSQLI_REPORT_STRICT);
        try
        {
            $link = new mysqli($host, $user, $pass, $data_base);
            if($link->connect_errno!=0)
                throw new Exception(mysqli_connect_errno());
            else
            {
                // Sprawdzenie czy istnieje w bazie e-mail
                $result = $link->query("SELECT idu FROM Uzytkownik WHERE `e-mail`='$email'");
                if(!$result)
                    throw new Exception($link->error);
                // czy mail juz istnieje
                if($result->num_rows > 0)
                {
                    $wszystko_ok = false;
                    $_SESSION['e_email'] = "Istnieje juz konto o takim adresie E-mail";
                }

                // Sprawdzenie czy istnieje w bazie Nick
                $result = $link->query("SELECT idu FROM Uzytkownik WHERE Nick = '$nick'");
                if(!$result)
                    throw new Exception($link->error);
                
                if($result->num_rows > 0)
                {
                    $wszystko_ok = false;
                    $_SESSION['e_nick'] = "Istnieje juz konto o takim Nicku";
                }
                // ZAPYTANIE INSERT!!!
                if($wszystko_ok)
                {
                    //mozna dodac uzytkownika
                    if($link->query("INSERT INTO Uzytkownik VALUES(NULL, '$nick', '$haslo_hash', '$email')"))
                    {
                        $_SESSION['udana_rejestracja'] = true;
                        header('Location: witamy.php');
                    }
                    else
                        throw new Exception($link->error);
                }
                $link->close();
            }
        }
        catch(Exeption $e)
        {
            echo '<span stype="color:red;"Błąd serwera, przepraszam za niedogodności i proszę o rejestracje w innym czasie!</span>';
            echo '<br />INFORMACJA DEVELOPERSKA: '.$e;
        }
    }

?>

<!DOCTYPE HTML>
<html lang="pl">

<meta charset="utf8">

<head>
    <link rel="stylesheet" type="text/css" href="style/mystyle.css">
    <title>Rejestracja</title>
    <script src='https://www.google.com/recaptcha/api.js'></script>
</head>

<body>
    <div class="container">
        <form method="POST">
            <div class="row">
                <div class="col-25">
                    <label for="nick">Nick</label>
                </div>
                <div class="col-75">
                    <input type="text" name="nick" value="<?php
                    if(isset($_SESSION['fr_nick']))
                    {
                        echo $_SESSION['fr_nick'];
                        unset($_SESSION['fr_nick']);
                    }
                    ?>" placeholder="Nick" required maxlength="50" minlength="3">

                    <?php
                    if(isset($_SESSION['e_nick']))
                    {
                        echo '<div class = "error">'.$_SESSION['e_nick'].'</div>';
                        unset($_SESSION['e_nick']);
                    }
                    ?>

                </div>
            </div>
            <div class="row">
                <div class="col-25">
                    <label for="nick">E-mail</label>
                </div>
                <div class="col-75">
                    <input type="text" name="email" value="<?php
			        if (isset($_SESSION['fr_email']))
                    {
                        echo $_SESSION['fr_email'];
                        unset($_SESSION['fr_email']);
                    }
		            ?>" placeholder="E-mail" required maxlength="50">

                    <?php
                    if(isset($_SESSION['e_email']))
                    {
                        echo '<div class = "error">'.$_SESSION['e_email'].'</div>';
                        unset($_SESSION['e_email']);
                    }
                    ?>

                </div>
            </div>
            <div class="row">
                <div class="col-25">
                    <label for="haslo">Hasło</label>
                </div>
                <div class="col-75">
                    <input type="password" name="haslo1" value="<?php
                    if(isset($_SESSION['fr_haslo1']))
                    {
                        echo $_SESSION['fr_haslo1'];
                        unset($_SESSION['fr_haslo1']);
                    }
                    ?>" placeholder="Hasło" required maxlength="30" minlength="8">

                    <?php
                    if(isset($_SESSION['e_haslo']))
                    {
                        echo '<div class = "error">'.$_SESSION['e_haslo'].'</div>';
                        unset($_SESSION['e_haslo']);
                    }
                    ?>

                </div>
            </div>
            <div class="row">
                <div class="col-25">
                    <label for="haslo">Powtórz hasło</label>
                </div>
                <div class="col-75">
                    <input type="password" name="haslo2" value="<?php
                    if(isset($_SESSION['fr_haslo2']))
                    {
                        echo $_SESSION['fr_haslo2'];
                        unset($_SESSION['fr_haslo2']);
                    }
                    ?>" placeholder="Powtórz Hasło" required maxlength="30">
                </div>
            </div>
            <div class="g-recaptcha" data-sitekey="6Ld0PVsUAAAAAD-ZTd3aph5zHGs7JoqWGA0V0EBW"></div>
            <?php
                    if(isset($_SESSION['e_bot']))
                    {
                        echo '<div class = "error">'.$_SESSION['e_bot'].'</div>';
                        unset($_SESSION['e_bot']);
                    }
                    ?>
            <div class="row">
                <input type="submit" name="submit" value="Zarejestruj">
            </div>
        </form>
    </div>
</body>
</html>