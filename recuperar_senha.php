<?php
session_start();
include('./conexao.php');

// Arquivos para recuperar senha
require('dist/plugins/php-mailer/src/PHPMailer.php');
require('dist/plugins/php-mailer/src/SMTP.php');
require('dist/plugins/php-mailer/src/Exception.php');

// Bibliotecas para recuperar senha
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if ($_POST) {
    $email = trim($_POST["email"]);
    $sql = "
    SELECT pk_usuario, nome
    FROM usuarios 
    WHERE email LIKE :email
    ";

    try {
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $dados = $stmt->fetch(PDO::FETCH_OBJ);

            $nome = $dados->nome;
            $pk_usuario = $dados->pk_usuario;

            // Gerar senha aleatória
            $senha_nova = substr(hash('sha256', uniqid()), 6, 6);

            // Configuração de servidor de email
            $mail = new PHPMailer(true);

            $mail->isSMTP();
            $mail->Host         = "mail.g1a.com.br";
            $mail->Username     = "alunos@g1a.com.br";
            $mail->Password     = "Senac@2024";
            $mail->SMTPSecure   = PHPMailer::ENCRYPTION_SMTPS;
            $mail->SMTPAuth     = true;
            $mail->Port         = 465;

            // Remetente
            $mail->setFrom("alunos@g1a.com.br", "Ordem de Servac");
            // Destinatario
            $mail->addAddress($email, $nome);
            // Destinatario em copia
            //? $mail->addCC("email", "nome");
            // Destinatario em copia oculta
            //? $mail->addBCC("email","nome");
            // Anexar arquivo
            //? $mail->addAttachment("caminho do arquivo");

            // Corpo do email
            $mail->isHTML(true);
            // Assunto
            $mail->Subject      = "Recuperação de senha";
            $mail->CharSet      = "UTF-8";
            // Corpo do email
            $mail->Body         = "
                <h2>Recuperação de senha</h2>
                <p>Olá, $nome.</p>
                <p>
                    Segue abaixo dados do seu novo acesso: <br>
                    <strong>URL:</strong>http://localhost/giovanni/dashboard/<br>
                    <strong>Email:</strong> $email<br>
                    <strong>Senha:</strong> $senha_nova
                </p>
                <p>Enviado em " . date("d/m/Y - H:i") . "</p> 
                ";
            $mail->send();

            $sql = "
            UPDATE usuarios SET 
            senha = :senha
            WHERE pk_usuario = :pk_usuario
            ";

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":senha", $senha_nova);
            $stmt->bindParam(":pk_usuario", $pk_usuario);
            $stmt->execute();

            $_SESSION["tipo"] = "success";
            $_SESSION["title"] = "OBA";
            $_SESSION["msg"] = "Nova senha enviada no email";

        } else {
            $_SESSION["tipo"] = "warning";
            $_SESSION["title"] = "OPS!";
            $_SESSION["msg"] = "Este email não consta na base de dados";
        }
    } catch (PDOException $ex) {
        $_SESSION["tipo"] = "error";
        $_SESSION["msg"] = $ex->getMessage();
    }
}

header("location: ./login.php");
exit;
