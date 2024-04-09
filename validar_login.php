<?php

// criar sessão para variavel global
session_start();



if ($_POST) {
    if (empty($_POST['email']) || empty($_POST['senha'])) {

        $_SESSION["msg"] = "por favor preencha os campos obrigatorios";
        $_SESSION["tipo"] = "warning";

        header("location: login.php");
        exit;
    } else {
        $email = trim($_POST['email']);
        $senha = trim($_POST['senha']);

        include('./funcao_conexao_msqli.php');

        $sql = "
            SELECT pk_usuario, nome FROM usuarios WHERE email LIKE '$email' AND senha LIKE '$senha'
        ";

        $query = mysqli_query($conn, $sql);

        if (mysqli_num_rows($query) > 0) {

            // organizar dados do banco como objetos
            $row = mysqli_fetch_object($querry);





            // declara variavel informando se o usuario está autenticado
            $_SESSION["autenticado"] = true;
            $_SESSION["pk_usuario"] = $row->pk_usuario;
            $_SESSION["nome_usuario"] = $row->nome;
            $_SESSION["tempo_login"] = time();

            header('location: ./crud_mysqli');
            exit;
        } else {
            echo "
            <script>
                alert('email e/ou senha inválida');
                window.location='./tela_login.php';
            </script>
            ";
            exit;
        }
    }
} else {
    header('Location: ./tela_login.php');
    exit;
}
