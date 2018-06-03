<?php 
    session_start();
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    if(!isset($_SESSION['zalogowany']) || $_SESSION['zalogowany'] == false)
    {
        header("Location: index.php");
        exit();
    }
    else
    {
        $wszystko_ok = true;
        //sprawdzie poprawności nazwy
        $nazwa = $_POST['nazwa'];
        if((strlen($nazwa)<1) || (strlen($nazwa)>50))
        {
            $wszystko_ok = false;
        }
        //sprawdzanie poprawności oceny
        if($_SESSION['Ocena'] < 1 || $_SESSION['Ocena'] > 5)
        {
            $wszystko_ok = false;
            $_SESSION['e_ocena'] = "Wprowadź ocenę od 1 do 5";
        }
        require_once "connection.php";
        mysqli_report(MYSQLI_REPORT_STRICT);
        try
        {
            $link = new mysqli($host, $user, $pass, $data_base);
            if($link->connect_errno!=0)
                throw new Exception(mysqli_connect_errno());
            else
            {
                if($wszystko_ok)
                {
                    $ocena = $_SESSION['Ocena'];
                    $g_id = $_SESSION['Nazwa'];
                    $u_id = $_SESSION['idu'];
                    if($link->query("INSERT INTO OcenaGry VALUES (NULL, '$ocena', NULL, '$g_id', '$u_id', NULL) ON DUPLICATE KEY UPDATE Ocena = '$ocena"))
                    {
                        $_SESSION['udana_ocena'] = true;
                        header('Location: ocana.php');
                    }
                    else
                        throw new Exception($link->error);
                }
            $link->close();
            }
        }
        catch(Exeption $e)
        {
            echo '<span stype="color:red;"Błąd serwera, przepraszam za niedogodności i proszę spróbować w innym czasie!</span>';
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
                            if($result = $link->query("SELECT idg, Nazwa FROM Gra ORDER BY Nazwa"))
                            {
                                while($row = $result->fetch_assoc())
                                {
                                    echo '<option value="'.$row['idg'].'">'.$row['Nazwa'].'</option>';
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
                    <label for="Ocena">Ocena</label>
                </div>
                <div class="col-75">
                    <input type="number" name="Ocena" value="1" min="0" max="5" step="0.5">
                    <?php
                    if(isset($_SESSION['e_ocena']))
                    {
                        echo '<div class = "error">'.$_SESSION['e_ocena'].'</div>';
                        unset($_SESSION['e_ocena']);
                    }
                    ?>
                </div>
            </div>
            <div class="row">
                <input type="submit" name="submit" value="Dodaj">
            </div>

        </form>

</body>
</html>