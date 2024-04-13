<?php

// criar sessão para variavel global
session_start();



if ($_POST) {
    if (empty($_POST['email']) || empty($_POST['senha'])) {

        $_SESSION["title"] = "Erro!";
        $_SESSION["msg"] = "Por favor, preencha os campos obrigatorios";
        $_SESSION["tipo"] = "warning";

        header("location: login.php");
        exit;
    } else {
        $email = trim($_POST['email']);
        $senha = trim($_POST['senha']);

        include('conexao.php');

        // stmt = statement 
        $stmt = $conn->prepare("
            SELECT pk_usuario, nome FROM usuarios WHERE email LIKE :email AND senha LIKE :senha
        ");

        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // organizar dados do banco como objetos
            $row = $stmt->fetch(PDO::FETCH_OBJ);

            // declara variavel informando se o usuario está autenticado
            $_SESSION["autenticado"] = true;
            $_SESSION["pk_usuario"] = $row->pk_usuario;
            $_SESSION["nome_usuario"] = $row->nome;
            $_SESSION["tempo_login"] = time();

            // transforma string em array, onde tiver " "
            $nome_usuario = explode(" ", $row->nome);

            // concatena primeiro nome com ultimo nome
            $_SESSION["nome_usuario"] = $nome_usuario[0]. " ". end($nome_usuario);


            header('location: ./');
            exit;
        } else {
            $_SESSION["title"] = "OPS!";
            $_SESSION["msg"] = "E-mail e/ou senha invalidos";
            $_SESSION["tipo"] = "error";

            header('Location: ./login.php');
            exit;
        }
    }
} else {
    header('Location: ./login.php');
    exit;
}
