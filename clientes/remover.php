<?php
include("../verificar_aut.php");
include("../conexao.php");

if(empty($_GET["ref"])){
    header("location: ./");
    exit;
} else{
    $pk_cliente = base64_decode($_GET["ref"]);

    $sql = "
        DELETE FROM clientes
        WHERE pk_cliente = :pk_cliente
    ";

    try{
        $stmt = $conn ->prepare($sql);
        $stmt ->bindParam(':pk_cliente', $pk_cliente);
        $stmt ->execute();

        $_SESSION["tipo"] = 'success';
        $_SESSION["title"] = 'Oba!';
        $_SESSION["msg"] = 'Registro removido';

        header("location: ./");
        exit;
    }catch(PDOException $ex){
        $_SESSION["tipo"] = 'error';
        $_SESSION["title"] = 'eita!';

        if($ex->getCode() == 23000){
        $_SESSION["msg"] = "Não foi possivel remover, pois ele está sendo utilizado em outro local";

        } else{
        $_SESSION["msg"] = $ex->getMessage();
        }
        header("location: ./");
        exit;
    }
}