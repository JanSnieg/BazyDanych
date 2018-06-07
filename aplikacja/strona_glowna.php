<?php 
    session_start();
    require_once "connection.php";
    if(!isset($_SESSION['zalogowany']))
    {
        header("Location: index.php");
        exit();
    }
    if(isset($_SESSION['nick']) && ($_SESSION['nick'] == "admin" || $_SESSION['email'] == 'admin@admin.pl'))
    {
        header("Location: admin.php");
        exit();
    }
    if(isset($link))
    {
        $link->close();
    }
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
?>

<!DOCTYPE HTML>
<html lang="pl">

<meta charset="utf8">

<head>
    <link rel="stylesheet" type="text/css" href="style/mystyle.css">
    <link rel="stylesheet" type="text/css" href="style/tables.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
    <script src="resize.js"></script>
    <title>Strona Główna</title>
</head>

    <body>
    <div class="container">
        <form action="usunKonto.php" method="POST">
            <div class="row">
                <input type="submit" name="usunKonto" value="USUŃ KONTO">
            </div>
        </form>
        <form action="ocenGre.php" method="POST">
            <div class="row">
                <input type="submit" name="ocenGre" value="Oceń Grę">
            </div>
        </form>
        <form action="usunOceneGry.php" method="POST">
            <div class="row">
                <input type="submit" name="usunOcene" value="Usuń ocenę Gry">
            </div>
        </form>
        <form action="ocenWydawnictwo.php" method="POST">
            <div class="row">
                <input type="submit" name="ocenWydawnictwo" value="Oceń Wydawnictwo">
            </div>
        </form>
        <form action="usunOceneWydawnictwa.php" method="POST">
            <div class="row">
                <input type="submit" name="usunOcene" value="Usuń ocenę Wydawnictwa">
            </div>
        </form>
    </div>
    <!-- <h1>Strona główna</h1> -->
    <?php
        echo "<h1>Witaj ".$_SESSION['nick'].'! [ <a href="wyloguj.php">Wyloguj się!</a> ]</h1>';
        mysqli_report(MYSQLI_REPORT_STRICT);
        try
        {
            $link = new mysqli($host, $user, $pass, $data_base);
            if($link->connect_errno!=0)
                throw new Exception(mysqli_connect_errno());
            else
            {
                $idu = $_SESSION['idu'];
                if($result = $link->query(
                    sprintf("SELECT DISTINCT
                    * FROM Uzytkownik LEFT JOIN OcenaGry ON(idu=u_id) JOIN Gra ON(idg=g_id) WHERE idu='$idu' ORDER BY Ocena DESC")))
                    {
                        echo '<h1>Twoje Oceny Gier</h1>
                        <div class="tbl-header">
                        <table cellpadding="0" cellspacing="0" border="0">
                          <thead>
                            <tr>
                              <th>Nazwa Gry</th>
                              <th>Czas Trwania Gry</th>
                              <th>Na ilu graczy</th>
                              <th>Średnia ocena Gry</th>
                              <th>Data wydania Gry</th>
                              <th>Twoja ocena Gry</th>
                            </tr>
                          </thead>
                        </table>
                      </div>';
                      echo '<div class="tbl-content">
                      <table cellpadding="0" cellspacing="0" border="0">
                        <tbody>';
                      while($row = $result->fetch_assoc())
                      {
                        echo '<tr>
                        <td>'.$row['Nazwa'].'</td>
                        <td>'.$row['CzasTwrania'].'</td>
                        <td>'.$row['MinOsob'].'-'.$row['MaxOsob'].'</td>
                        <td>'.$row['SredniaOcen'].'</td>
                        <td>'.$row['DataWydania'].'</td>
                        <td>'.$row['Ocena'].'</td>
                        </tr>';
                      }
                      echo ' </tbody>
                      </table>
                    </div>';
                    }
                else
                    throw new Exception($link->error);

                $idu = $_SESSION['idu'];
                if($result = $link->query(
                    sprintf("SELECT DISTINCT
                    * FROM Uzytkownik LEFT JOIN OcenaWydawnictwa ON(idu=u_id) JOIN Wydawnictwo ON(idw=w_id) WHERE idu='$idu' ORDER BY Ocena DESC")))
                    {
                        echo '<h1>Twoje Oceny Wydawnictw</h1>
                        <div class="tbl-header">
                        <table cellpadding="0" cellspacing="0" border="0">
                            <thead>
                            <tr>
                                <th>Nazwa</th>
                                <th>Średnia ocena Wydawnictwa</th>
                                <th>Twoja ocena Wydawnictwa</th>
                            </tr>
                            </thead>
                        </table>
                        </div>';
                        echo '<div class="tbl-content">
                        <table cellpadding="0" cellspacing="0" border="0">
                        <tbody>';
                        while($row = $result->fetch_assoc())
                        {
                        echo '<tr>
                        <td>'.$row['Nazwa'].'</td>
                        <td>'.$row['SredniaOcen'].'</td>
                        <td>'.$row['Ocena'].'</td>
                        </tr>';
                        }
                        echo ' </tbody>
                        </table>
                    </div>';
                    }
                else
                    throw new Exception($link->error);
                if($result = $link->query(
                    sprintf("SELECT DISTINCT
                    * FROM Gra JOIN Wydawnictwo ON(w_id=idw)
                    ORDER BY Gra.SredniaOcen DESC")))
                    {
                        echo '<h1>Najlepsze gry</h1>
                        <div class="tbl-header">
                        <table cellpadding="0" cellspacing="0" border="0">
                          <thead>
                            <tr>
                              <th>Nazwa Gry</th>
                              <th>Czas Trwania Gry</th>
                              <th>Na ilu graczy</th>
                              <th>Średnia ocena Gry</th>
                              <th>Data wydania Gry</th>
                              <th>Wydawnictwo</th>
                            </tr>
                          </thead>
                        </table>
                      </div>';
                      echo '<div class="tbl-content">
                      <table cellpadding="0" cellspacing="0" border="0">
                        <tbody>';
                      while($row = $result->fetch_row())
                      {
                        echo '<tr>
                        <td>'.$row[1].'</td>
                        <td>'.$row[2].'</td>
                        <td>'.$row[3].'-'.$row[4].'</td>
                        <td>'.$row[5].'</td>
                        <td>'.$row[7].'</td>
                        <td>'.$row[9].'</td>
                        </tr>';
                      }
                      echo ' </tbody>
                      </table>
                    </div>';
                    }
                    else
                    throw new Exception($link->error);
            }

            if($result = $link->query(
                sprintf("SELECT DISTINCT
                * FROM Wydawnictwo 
                ORDER BY SredniaOcen DESC")))
                {
                    echo '<h1>Najlepsze wydawnictwa</h1>
                    <div class="tbl-header">
                    <table cellpadding="0" cellspacing="0" border="0">
                      <thead>
                        <tr>
                          <th>Nazwa Wydawnictwa</th>
                          <th>Średnia ocena</th>
                        </tr>
                      </thead>
                    </table>
                  </div>';
                  echo '<div class="tbl-content">
                  <table cellpadding="0" cellspacing="0" border="0">
                    <tbody>';
                  while($row = $result->fetch_row())
                  {
                    echo '<tr>
                    <td>'.$row[1].'</td>
                    <td>'.$row[2].'</td>
                    </tr>';
                  }
                  echo ' </tbody>
                  </table>
                </div>';
                }
                else
                throw new Exception($link->error);
            $link->close();
        }
        catch(Exception $e)
        {
            echo '<span stype="color:red;"Błąd serwera, przepraszam za niedogodności i proszę spróbować sie zalogować w innym czasie!</span>';
            echo '<br />INFORMACJA DEVELOPERSKA: '.$e;
        }
    ?>
    </body>
</html>