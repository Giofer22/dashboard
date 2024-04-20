<?php

@session_start();

// isset verifica se a variavel foi criada
if (isset($_SESSION["tipo"]) && isset($_SESSION["msg"]) && isset($_SESSION["title"])) {
    echo "
    <script>
    $(function() {
        var Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 5000
        });
    
          Toast.fire({
            icon: '".$_SESSION["tipo"]."',
            title: '".$_SESSION["title"]."',
            text: '".$_SESSION["msg"]."'
          });
    });
    </script>
    ";

    // Após exibir a mensagem, limpa as variaveis de sessã 
    unset($_SESSION["tipo"]);
    unset($_SESSION["msg"]);
    unset($_SESSION["title"]);
}
