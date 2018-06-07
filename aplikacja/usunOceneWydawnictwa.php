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
    if(isset($_SESSION['nick']) && ($_SESSION['nick'] == "admin" || $_SESSION['email'] == 'admin@admin.pl'))
    {
        header("Location: admin.php");
        exit();
    }

    if(isset($_POST['Nazwa']))
    {
        $wszystko_ok = true;
        
        $nazwa = $_POST['Nazwa'];
        mysqli_report(MYSQLI_REPORT_STRICT);
        try
        {
            $link = new mysqli($host, $user, $pass, $data_base);
            if($link->connect_errno!=0)
                throw new Exception(mysqli_connect_errno());
            else
            {
                if($link->query("DELETE FROM OcenaWydawnictwa WHERE iduw = '$nazwa'"))
                {
                    header("Location: strona_glowna.php");
                    exit();
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
        Wybierz Wydawnictwo, którego ocenę chcesz usunąć
    </h1>
        <div class="container">
            <form method="POST">
                <div class="row">
                    <div class="col-25">
                        <label for="Nazwa">Nazwa</label>
                    </div>
                    <div class="col-75">
                        <select name="Nazwa">
                        <?php
                        require_once "connection.php";
                        mysqli_report(MYSQLI_REPORT_STRICT);
                        try
                        {
                            $link = new mysqli($host, $user, $pass, $data_base);
                            if($link->connect_errno != 0)
                                throw new Exception(mysqli_connect_errno());
                            else
                            {
                                $u_id = $_SESSION['idu'];
                                if($result = $link->query("SELECT Nazwa, iduw FROM Wydawnictwo JOIN OcenaWydawnictwa ON(idw = w_id) WHERE u_id = '$u_id' ORDER BY Nazwa"))
                                {
                                    while($row = $result->fetch_assoc())
                                    {
                                        echo '<option value="'.$row['iduw'].'">'.$row['Nazwa'].'</option>';
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
                    <input type="submit" name="submit" value="USUŃ">
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