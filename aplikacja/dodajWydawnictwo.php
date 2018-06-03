<?php
    session_start();
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    if(!isset($_SESSION['user']))
    {
        header("Location: index.php");
        exit();
    }

    if(isset($_SESSION['user']) && ($_SESSION['user'] == "admin" || $_SESSION['email'] == 'admin@admin.pl'))
    {
        header("Location: admin.php");
        exit();
    }
    if(isset($_SESSION['nazwa']))
    {
        $wszystko_ok = true;
        
        $nazwa = $_POST['nazwa'];
        if(strlen($nazwa) < 1 || ctype_alnum($nazwa)==false)
        {
            $wszystko_ok = false;
            $_SESSION['e_nazwa'] = "Wprowadź prawidłową nazwę";
        }
        //Trzymanie wprowadzonych dancyh
        $_SESSION['fr_nazwa'] = $nazwa;

        require_once "connection.php";
        mysqli_report(MYSQLI_REPORT_STRICT);
        echo "poczatek try";
        try
        {
            $link = new mysqli($host, $user, $pass, $data_base);
            if($link->connect_errno!=0)
                throw new Exception(mysqli_connect_errno());
            else
            {
                echo "połączone";
                //sprawdzanie czy nie istnieje juz wydawnictwo o takiej nazwie
                $result = $link->query("SELECT idw FROM Wydawnictwo WHERE Nazwa='$nazwa'");
                if(!$result)
                    throw new Exception($link->error);
                if($result->num_rows > 0)
                {
                    $wszystko_ok = false;
                    $_SESSION['e_nazwa'] = "Istnieje juz Gra o takiej nazwie w bazie danych";
                }
                if($wszystko_ok)
                {
                    if($link->query("INSERT INTO Wydawnictwo VALUES(NULL, '$nazwa', NULL)"))
                    {
                        echo "Błąd inserta";
                        $_SESSION['udane_dodanie'] = true;
                        header("Location: dodane.php");
                    }
                    else
                        throw new Exception($link->error);
                }
                $link->close();
                echo "zamknięte połączenie";
            }
        }
        catch(Exeption $e)
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
    <div class="container">
        <form method="POST">
            <div class="row">
                <div class="col-25">
                    <label for="Nazwa">Nazwa</label>
                </div>
                <div class="col-75">
                    <input type="text" name="nazwa" placeholder="Nazwa" required maxlength="50" value="<?php
                    if(isset($_SESSION['fr_nazwa']))
                    {
                        echo $_SESSION['fr_nazwa'];
                        unset($_SESSION['fr_nazwa']);
                    }
                    ?>">
                    <?php
                        if (isset($_SESSION['e_nazwa']))
                        {
                            echo '<div class="error">'.$_SESSION['e_nazwa'].'</div>';
                            unset($_SESSION['e_nazwa']);
                        }
                    ?>
                </div>
            <div class="row">
                <input type="submit" name="submit" value="Dodaj">
            </div>
        </form>
        <form action="admin.php">
            <div class="row">
                <input type="submit" name="submit" value="Powrót">
            </div>
        </form>
    </div>

</body>

</html>