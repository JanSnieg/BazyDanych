<?php
    session_start();
    require_once "connection.php";
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    if(!isset($_SESSION['nick']))
    {
        header("Location: index.php");
        exit();
    }
    if(isset($_SESSION['nick']))
    {
        if($_SESSION['nick'] == "admin" || $_SESSION['email'] == 'admin@admin.pl')
        {
            header("Location: admin.php");
            exit();
        }
        else
            $nazwa = $_SESSION['nick'];
    }

    if(isset($_POST['Potwierdzenie']))
    {
        $wszystko_ok = true;
        
        $potw = $_POST['Potwierdzenie'];
        if($potw != "Potwierdzam")
        {
            $wszystko_ok = false;
            $_SESSION['e_potw'] = "Wpisz poprawnie";
        }
        mysqli_report(MYSQLI_REPORT_STRICT);
        try
        {
            $link = new mysqli($host, $user, $pass, $data_base);
            if($link->connect_errno!=0)
                throw new Exception(mysqli_connect_errno());
            else
            {
                //sprawdzanie czy nie istnieje takie konto
                $result = $link->query("SELECT idu FROM Uzytkownik WHERE Nick = '$nazwa' OR `e-mail` = '$nazwa'");
                if(!$result)
                    throw new Exception($link->error);
                if($result->num_rows > 0)
                {
                    $idu = $_SESSION['idu'];
                    if($link->query("DELETE FROM Uzytkownik WHERE idu = $idu"))
                    {
                        header("Location: wyloguj.php");
                        exit();
                    }
                    else
                    {
                        $wszystko_ok = false;
                        $_SESSION['e_potw'] = "Nie istnieje takie konto, wyloguj sie i zaloguj ponownie, aby usunąć konto";
                    }
                }
                $link->close();
                echo "zamknięte połączenie";
            }
        }
        catch(Exception $e)
        {
            echo '<span stype="color:red;"Błąd serwera, przepraszam za niedogodności i proszę spróbować dodać Wydawnictwo w innym czasie!</span>';
            echo '<br />INFORMACJA DEVELOPERSKA: '.$e;
        }
    }
?>

<!DOCTYPE HTML>
<html>

    <meta charset="utf8">
    <head>
        <link rel="stylesheet" type="text/css" href="style/mystyle.css">
    </head>
    <body>
    <h1>
        Potwierdź, ze na pewno chcesz usunąć swoje kotno
    </h1>
        <div class="container">
            <form method="POST">
                <div class="row">
                    <div class="col-25">
                        <label for="Nazwa">Wpisz "Potwierdzam"</label>
                    </div>
                    <div class="col-75">
                        <input type="text" name="Potwierdzenie" placeholder="Potwierdzam" required maxlength="50">
                        <?php
                            if (isset($_SESSION['e_potw']))
                            {
                                echo '<div class="error">'.$_SESSION['e_potw'].'</div>';
                                unset($_SESSION['e_potw']);
                            }
                        ?>
                    </div>
                </div>
                <div class="row">
                    <input type="submit" name="submit" value="USUŃ">
                </div>
            </form>
            <form action="strona_glowna.php">
                <div class="row">
                    <input type="submit" name="submit" value="Powrót">
                </div>
            </form>
        </div>

    </body>

</html>