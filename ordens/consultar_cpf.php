<?php
include("../verificar_aut.php");
include("../conexao.php");

if(isset($_GET["cpf"])){
    $cpf = trim($_GET["cpf"]);

    $sql = "
        SELECT nome FROM clientes WHERE cpf Like :cpf
    ";

    try {
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":cpf", $cpf);
        $stmt->execute();

        if($stmt->rowCount() > 0){
            $dado = $stmt->fetch(PDO::FETCH_OBJ);
            $success = true;
            
        }else{
            $dado = "Registro não encontrado";
            $success = false;
        }
    } catch (Exception $ex) {
        $dado = $ex->getMessage();
        $success = false;

    }

    echo json_encode(array(
        "success" => $success,
        "dado" => $dado
    ));
}



?>