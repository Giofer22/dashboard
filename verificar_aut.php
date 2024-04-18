<?php



session_start();

// caminho fixo do software web
define("caminhoURL", "http://localhost/giovanni/dashboard/");

// verifica se o usuario não está conectado
if ($_SESSION["autenticado"] != true) {
    session_destroy();
    header("Location: ".caminhoURL."login.php");
    exit;
    // verifica se está conectado
} else {

    // segundos
    $tempo_limite = 300;
    $tempo_atual = time();

    // verifica tempo inativo 
    if ($tempo_atual - $_SESSION["tempo_login"] > $tempo_limite) {
        
        $_SESSION["title"] = "OPS!!";
        $_SESSION["msg"] = "Tempo de login esgotado";
        $_SESSION["tipo"] = "warning";

        header("Location:".caminhoURL."login.php");
        exit;
    }else{
        $_SESSION["tempo_login"] = time();
    }
}
