<?php
    //passo 1
    $servidor = "localhost";
    $user = "projeotSD";
    $senha = "projetoSD2021";
    $banco = "andes";
    $connect = mysqli_connect($servidor, $user, $senha, $banco);

    //passo 2
    if (mysqli_connect_errno()) {
        die("Conexão falhou: " . mysqli_connect_errno());
    }
?>
