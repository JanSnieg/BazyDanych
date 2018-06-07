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

    if(isset($_SESSION['nick']) && ($_SESSION['nick'] != "admin" && $_SESSION['email'] != "admin@admin.pl"))
    {
        header("Location: strona_glowna.php");
        exit();
    }
    if(isset($_POST['Nazwa']))
    {
        $wszystko_ok = true;
        
        $nazwa = $_POST['Nazwa'];
        if(isset($_POST['Wydawnictwo']))
            $idw = $_POST['Wydawnictwo'];
        if(strlen($nazwa) < 1 || ctype_alnum($nazwa)==false)
        {
            $wszystko_ok = false;
            $_SESSION['e_nazwa'] = "Wprowadź prawidłową nazwę";
        }
        $czas = $_POST['CzasTrwania'];
        if($czas < 1)
        {
            $wszystko_ok = false;
            $_SESSION['e_czas'] = "Wprowadź prawidłowy czas trwania rozgrywki";
        }
        $od = $_POST['MinOsob'];
        $do = $_POST['MaxOsob'];
        if($od < 1 || $do<$od)
        {
            $wszystko_ok = false;
            $_SESSION['e_od'] = "Wprowadź poprawną liczbę mozliwych graczy";
        }
        //Trzymanie wprowadzonych dancyh
        $_SESSION['fr_nazwa'] = $nazwa;
        $_SESSION['fr_czas'] = $czas;
        $_SESSION['fr_od'] = $od;
        $_SESSION['fr_do'] = $do;
    
        mysqli_report(MYSQLI_REPORT_STRICT);
        try
        {
            $link = new mysqli($host, $user, $pass, $data_base);
            if($link->connect_errno!=0)
                throw new Exception(mysqli_connect_errno());
            else
            {
                //sprawdzanie czy nie istnieje juz gra o takiej nazwie
                $result = $link->query("SELECT idg FROM Gra WHERE Nazwa = '$nazwa'");
                if(!$result)
                    throw new Exception($link->error);
                if($result->num_rows > 0)
                {
                    $wszystko_ok = false;
                    $_SESSION['e_nazwa'] = "Istnieje juz Gra o takiej nazwie w bazie danych";
                }
                if($wszystko_ok)
                {
                    if(isset($_POST['data']) && $_POST['data'] == NULL)
                        $data = "NULL";
                    else
                        $data = "'".(string)$_POST['data']."'";
                    if($link->query("INSERT INTO Gra VALUES (NULL, '$nazwa', '$czas', '$od', '$do', NULL, '$idw', $data)"))
                    {
                        $_SESSION['udane_dodanie'] = true;
                        header("Location: dodane.php");
                    }
                    else
                        throw new Exception($link->error);
                }
                $link->close();
            }
        }
        catch(Exception $e)
        {
            echo '<span stype="color:red;"Błąd serwera, przepraszam za niedogodności i proszę spróbować dodać grę w innym czasie!</span>';
            echo '<br />INFORMACJA DEVELOPERSKA: '.$e;
        }
    }
?>

<!DOCTYPE HTML>
<html lang="pl">
</style>
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
                    <input type="text" name="Nazwa" placeholder="Nazwa" required maxlength="50" value="<?php
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
            </div>
            <div class="row">
                <div class="col-25">
                    <label for="CzasTrwania">Czas Trwania (min)</label>
                </div>
                <div class="col-75">
                    <input type="number" name="CzasTrwania" placeholder="Czas Trwania" value="<?php
                    if(isset($_SESSION['fr_czas']))
                    {
                        echo $_SESSION['fr_czas'];
                        unset($_SESSION['fr_czas']);
                    }
                    ?>">
                    <?php
                        if (isset($_SESSION['e_czas']))
                        {
                            echo '<div class="error">'.$_SESSION['e_czas'].'</div>';
                            unset($_SESSION['e_czas']);
                        }
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-25">
                    <label for="MinOsob">Liczba graczy</label>
                </div>
                <div class="col-75">
                    <input type="number" name="MinOsob" placeholder="Od" value="<?php
                    if(isset($_SESSION['fr_od']))
                    {
                        echo $_SESSION['fr_od'];
                        unset($_SESSION['fr_od']);
                    }
                    ?>">
                    <?php
                        if (isset($_SESSION['e_od']))
                        {
                            echo '<div class="error">'.$_SESSION['e_od'].'</div>';
                            unset($_SESSION['e_od']);
                        }
                    ?>
                    <input type="number" name="MaxOsob" placeholder="Do" value="<?php
                    if(isset($_SESSION['fr_do']))
                    {
                        echo $_SESSION['fr_do'];
                        unset($_SESSION['fr_do']);
                    }
                    ?>">
                </div>
            </div>
            <div class="row">
                <div class="col-25">
                    <label for="Wydawnictwo">Wydawnictwo</label>
                </div>
                <div class="col-75">
                    <select name="Wydawnictwo">
                        <?php
                            require_once "connection.php";
                            mysqli_report(MYSQLI_REPORT_STRICT);
                            try
                            {
                                $link = new mysqli($host, $user, $pass, $data_base);
                                if($link->connect_errno!=0)
                                    throw new Exception(mysqli_connect_errno());
                                else
                                {
                                    if($result = $link->query("SELECT idw, Nazwa FROM Wydawnictwo ORDER BY Nazwa"))
                                    {
                                        while($row = $result->fetch_assoc())
                                        {
                                            echo '<option value="'.$row['idw'].'">'.$row['Nazwa'].'</option>';
                                        }
                                    }
                                    else
                                        throw new Exception($link->error);
                                }
                                $link->close();
                            }
                            catch(Exception $e)
                            {
                                echo '<span stype="color:red;"Błąd serwera, przepraszam za niedogodności.</span>';
                                echo '<br />INFORMACJA DEVELOPERSKA: '.$e;
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-25">
                    <label for="DataWydania">Data Wydania (yyyy-mm-dd)</label>
                </div>
                <div class="col-75">
                    <input type="date" name="data" placeholer="yyyy-mm-dd">
                </div>
            </div>
            <div class="row">
                <input type="submit" name="submit" value="Dodaj">
            </div>
        </form>
        <form action="admin.php" method="POST">
            <div class="row">
                <input type="submit" name="submit" value="Powrót">
            </div>
        </form>
    </div>

</body>

</html>