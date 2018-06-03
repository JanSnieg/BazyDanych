<!DOCTYPE HTML>
<html lang="pl">
<head>
    <meta charset="utf-8" />
    <title>Zadanie 1</title>
</head>
<body>

<?php
    $n = $_POST['n'];
    $s = '';
    $i = $j = 1;
    for ($i; $i <=$n ; $i++) 
    { 
        $s .= "<tr>";
        for ($j = 1; $j <=$n; $j++) 
        { 
            $s .= "<td>".($i*$j)."</td>";
        }
        $s .= "</tr>";
    }

echo<<<END
    <table border = "1" cellpadding="10" cellspacing="0">
    $s
    </table>
    <br/><a href="index.php">Powrót</a>
END;

?>
</body>
</html>