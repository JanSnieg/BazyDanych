<?php
    session_start();

    if(!isset($_POST['nick']) || !isset($_POST['haslo']))
    {
        header("Location: index.php");
        exit();
    }
    if(isset($link))
    {
        $link->close();
    }

    require_once "connection.php";

    $link = @new mysqli($host, $user, $pass, $data_base);
    if($link->connect_errno)
        echo "Error: ".$link->connect_errno."Explanation: ".$link->connect_error;
    else
    {
        $nick = htmlentities($_POST['nick'], ENT_QUOTES, "UTF-8");
        $haslo = $_POST['haslo'];

        if($result = @$link->query(
            sprintf("SELECT * FROM Uzytkownik WHERE (Nick='%s' OR `e-mail`='%s')",
            mysqli_real_escape_string($link,$nick),
            mysqli_real_escape_string($link,$nick))))
        {
            if($result->num_rows > 0)
            {
                $row = $result->fetch_assoc();
                if(password_verify($haslo, $row['Haslo']))
                {
                        // udało sie zalogować
                    $_SESSION['zalogowany'] = true;
                    
                    $_SESSION['idu'] = $row['idu'];
                    $_SESSION['nick'] = $row['Nick'];
                    $_SESSION['email'] = $row['e-mail'];

                    unset($_SESSION['blad']);
                    $result->close();
                    if($_SESSION['nick'] == "admin" || $_SESSION['email'] == "admin@admin.pl")
                        header('Location: admin.php');
                    else
                        header('Location: strona_glowna.php');
                }
                else
                {
                    $_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
                    header('Location: index.php');
                }
            }
            else
            {
                // nie udało sie zalogować
                $_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
				header('Location: index.php');
            }
        }
        else{
            echo "ERROR";
        }
        $link->close();
    }
?>