<?php 
    echo "costam ";
    $zmienna = ""; 
    // albo cokolwiek takiego
    $tabela = array(); //pod tabela bedzie pusta tabela 
    $tebela = []; //to samo co wyzej
    $tabela = array(1, 'znak', true, 3.14); // tak samo mozna [...]
    $tabela = array("a"=>"5", 2=>true, "foo"=> 3.4); //slownik
    $tabela[0] = "beee";
    unset($tabela["a"]); // podajemy klucz
    $tabela[] = array(); //push nowej tabeli do tabeli
    for ($i=0; $i<count($tabela); $i++) { 
        
    }
    foreach ($variable as $key => $value) {
        # code...
    }
    foreach ($variable as $value) {
        # code...
    }
    implode("separator", $tabela);
    array_map(funkcja, $tabela); // mapuje tabele przez funkcje

    // Dane z FORMULARZA
    $_GET //zmianne z zewnątrz, array()
    $_POST["login"];
    $_POST["plec"][0];
    if (!$_POST) //wykona sie jezeli nie ma posta
    <pre>print_r($_POST); </pre> //goly tekst z wciaciami itd i to w html
    //get wypisuje a adresie kazda zmienna, wszystko widac
    //post jest bezpieczniejszy
    
?>