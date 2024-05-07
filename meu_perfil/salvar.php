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

        // verifica se existe um foto a ser salva
        if ($foto["error"] != 4) {
            $ext_permitidas = array(
                "bmp",
                "jpeg",
                "jpg",
                "png",
                "jfif",
                "tiff"
            );
            $extensao = pathinfo($foto["name"], PATHINFO_EXTENSION);
            // verifica se a extensão é permitida
            if (in_array($extensao, $ext_permitidas)) {
                // gerar nome unico para o arquivo
                $novo_nome = hash("sha256", uniqid() . rand() . $foto["tmp_name"]. ".". $extensao);

                $_SESSION["foto"] = $novo_nome;

                // mover o arquivo para pasta 
                move_uploaded_file($foto["tmp_name"], "fotos/$novo_nome");
                $update_foto = "foto ='$novo_nome'";
            }else{
                $_SESSION["tipo"] = "error";
                $_SESSION["title"] = "OPS!";
                $_SESSION["msg"] = "Extensão de arquivo não permitida";
                header("location: ./");
                exit;
            }
        }else{
            $update_foto = "foto=foto";
        }



        try {
            if (empty($senha)) {
                $sql = "
                UPDATE usuarios SET 
                nome = :nome,
                email = :email,
                $update_foto
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
                senha = :senha,
                $update_foto
                WHERE pk_usuario = :pk_usuario
            ";

                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':nome', $nome);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':senha', $senha);
                $stmt->bindParam(':pk_usuario', $pk_usuario);
            }
            $stmt->execute();

             // transforma string em array, onde tiver " "
             $nome_usuario = explode(" ", $nome);

             // concatena primeiro nome com ultimo nome
             $_SESSION["nome_usuario"] = $nome_usuario[0]. " ". end($nome_usuario);


            $_SESSION["tipo"] = 'success';
            $_SESSION["title"] = 'Oba!';
            $_SESSION["msg"] = 'Registro salvo';
            header("location: ./");
            exit;
        } catch (PDOException $ex) {
            $_SESSION["tipo"] = 'error';
            $_SESSION["title"] = 'OPS!';
            $_SESSION["msg"] = $ex->getMessage();
            header("location: ./");
            exit;
        }
    }
}
