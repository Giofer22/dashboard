<?php
include("../verificar_aut.php");
include("../conexao.php");


if ($_POST) {
    if (empty($_POST["nome"]) || empty($_POST["email"])) {
        $_SESSION["tipo"] = 'warning';
        $_SESSION["title"] = 'OPS!';
        $_SESSION["msg"] = 'Por favor, preencha os campos obrigatórios';

        header("location: ./");
        exit;
    } else {
        $pk_usuario = $_SESSION["pk_usuario"];
        $nome = trim($_POST["nome"]);
        $email = trim($_POST["email"]);
        $senha = trim($_POST["senha"]);
        $foto = $_FILES["foto"];

        try {
            if (empty($senha)) {
                $sql = "
                UPDATE usuarios SET 
                nome = :nome,
                email = :email
                WHERE pk_usuario = :pk_usuario
            ";

                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':nome', $nome);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':pk_usuario', $pk_usuario);

            } else {
                $sql = "
                UPDATE usuarios SET 
                nome = :nome,
                email = :email,
                senha = :senha
                WHERE pk_usuario = :pk_usuario
            ";

                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':nome', $nome);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':senha', $senha);
                $stmt->bindParam(':pk_usuario', $pk_usuario);
            }
            $stmt->execute();

            $_SESSION["tipo"] = 'success';
            $_SESSION["title"] = 'Oba!';
            $_SESSION["msg"] = 'Registro salvo';
            header("location: ../");
            exit;
        } catch (PDOException $ex) {
            $_SESSION["tipo"] = 'error';
            $_SESSION["title"] = 'OPS!';
            $_SESSION["msg"] = $ex->getMessage();
            header("location: ../");
            exit;
        }
    }
}
