<?php
    session_start();
    if(!isset($_POST['nick']) || !isset($_POST['haslo']))
    {
        header("Location: index.php");
        exit();
    }
    if($_SESSION['nick'] =! "admin")
    {
        header("Location: strona_glowna.php");
        exit();
    }
    if(isset($link))
    {
        $link->close();
    }
?>
<!DOCTYPE HTML>
<html>

<meta charset="utf8">

<head>
    <link rel="stylesheet" type="text/css" href="style/mystyle.css">
    <link rel="stylesheet" type="text/css" href="style/tables.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
    <script src="resize.js"></script>
    <title>Admin</title>
</head>

<body>
    <?php
        echo "<p>Witaj ".$_SESSION['nick'].'! [ <a href="wyloguj.php">Wyloguj się!</a> ]</p>';
        require_once "connection.php";
        mysqli_report(MYSQLI_REPORT_STRICT);
        try
        {
            $link = new mysqli($host, $user, $pass, $data_base);
            if($link->connect_errno!=0)
                throw new Exception(mysqli_connect_errno());
            else
            {
                if($result = @$link->query(
                    sprintf("SELECT Gra.Nazwa as 'Gra.Nazwa', CzasTwrania, MinOsob, MaxOsob, Gra.SredniaOcen as 'Gra.SredniaOcen', DataWydania, Wydawnictwo.Nazwa as 'Wydawnictwo.Nazwa', Wydawnictwo.SredniaOcen as 'Wydawnictwo.SredniaOcen' FROM Gra JOIN Wydawnictwo ON(idw=w_id)")))
                    {
                        echo '<div class="tbl-header">
                        <table cellpadding="0" cellspacing="0" border="0">
                          <thead>
                            <tr>
                              <th>Nazwa Gry</th>
                              <th>Czas Trwania Gry</th>
                              <th>Na ilu graczy</th>
                              <th>Średnia ocena Gry</th>
                              <th>Data wydania Gry</th>
                              <th>Nazwa Wydawnictwa</th>
                              <th>Średnia ocana Wydawnictwa</th>
                            </tr>
                          </thead>
                        </table>
                      </div>';
                      echo '<div class="tbl-content">
                      <table cellpadding="0" cellspacing="0" border="0">
                        <tbody>';
                      while($row = $result->fetch_assoc())
                      {
                        echo '<tr><td>'.$row['Gra.Nazwa'].'</td>
                        <td>'.$row['CzasTwrania'].'</td>
                        <td>'.$row['MinOsob'].'-'.$row['MaxOsob'].'</td>
                        <td>'.$row['Gra.SredniaOcen'].'</td>
                        <td>'.$row['DataWydania'].'</td>
                        <td>'.$row['Wydawnictwo.Nazwa'].'</td>
                        <td>'.$row['Wydawnictwo.SredniaOcen'].'</td>
                        </tr>';
                      }
                      echo '</tbody>
                      </table>
                    </div>';
                    }
                else
                    throw new Exception($link->error);
            }
            $link->close();
        }
        catch(Exception $e)
        {
            echo '<span stype="color:red;"Błąd serwera, przepraszam za niedogodności i proszę spróbować sie zalogować w innym czasie!</span>';
            echo '<br />INFORMACJA DEVELOPERSKA: '.$e;
        }
    ?>

    <div class="container">
    <form action="dodajGre.php">
            <div class="row">
                <input type="submit" name="dodajGre" value="Dodaj Grę">
            </div>
    </form>
    <form action="dodajWydawnictwo.php">
            <div class="row">
                <input type="submit" name="dodajWydawnictwo" value="Dodaj Wydawnictwo">
            </div>
    </form>
    </div>
</body>
</html>