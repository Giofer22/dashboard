<?php

session_start();
// verifica se o usuario não está conectado
if ($_SESSION["autenticado"] != true) {
    session_destroy();
    header("Location: ./login.php");
    exit;
    // verifica se está conectado
} else {

    // segundos
    $tempo_limite = 5000;
    $tempo_atual = time();

    // verifica tempo inativo 
    if ($tempo_atual - $_SESSION["tempo_login"] > $tempo_limite) {
        
        $_SESSION["title"] = "OPS!!";
        $_SESSION["msg"] = "Tempo de login esgotado";
        $_SESSION["tipo"] = "warning";

        header("Location: ./login.php");
        exit;
    }else{
        $_SESSION["tempo_login"] = time();
    }
}
