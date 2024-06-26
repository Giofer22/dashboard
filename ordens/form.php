<?php
include('../verificar_aut.php');
include('../conexao.php');

$pagina_ativa = "ordens";

$sql = "
    SELECT pk_servico, servico FROM servicos
    ORDER BY servico
";
try {
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $dados = $stmt->fetchAll(PDO::FETCH_OBJ);

    $options = '<option value "">--Selecione--</option>';
    foreach ($dados as $row) {
        $options .= '<option value="' . $row->pk_servico . '">' . $row->servico . '</option>';
    }
} catch (Exception $ex) {
    $_SESSION["tipo"] = "error";
    $_SESSION["title"] = "Ops";
    $_SESSION["msg"] = $ex->getMessage();

    header("location: ./");
    exit;
}

if (empty($_GET["ref"])) {
    $pk_ordem_servico = "";
    $cpf = "";
    $nome = "";
    $data_ordem_servico = "";
    $data_inicio = "";
    $data_fim = "";
} else {
    $pk_ordem_servico = base64_decode(trim($_GET["ref"]));

    $sql = "
    SELECT pk_ordem_servico, data_ordem_servico, data_inicio, data_fim,
    cpf, nome
    FROM ordens_servicos
    JOIN clientes ON pk_cliente = fk_cliente
    WHERE pk_ordem_servico = :pk_ordem_servico
    ";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':pk_ordem_servico', $pk_ordem_servico);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $dado = $stmt->fetch(PDO::FETCH_OBJ);
        $data_ordem_servico = $dado->data_ordem_servico;
        $data_inicio = $dado->data_inicio;
        $data_fim = $dado->data_fim;
        $cpf = $dado->cpf;
        $nome = $dado->nome;
    } else {
        $_SESSION["tipo"] = 'error';
        $_SESSION["title"] = 'OPS!';
        $_SESSION["msg"] = 'Registro não encontrado';

        header("location: ./");
        exit;
    }
}

?>


<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ordem de Servac | Cliente</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../dist/plugins/fontawesome-free/css/all.min.css">
    <!-- Boostrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="../dist/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- iCheck -->
    <link rel="stylesheet" href="../dist/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="../dist/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="../dist/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <?php include("../nav.php") ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php include("../aside.php"); ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            <!-- Main content -->
            <section class="content mt-3">
                <div class="container-fluid">
                    <!-- Small boxes (Stat box) -->
                    <div class="row">
                        <div class="col">
                            <form method="post" action="salvar.php">
                                <div class="card card-primary card-outline">
                                    <div class="card-header">
                                        <h3 class="card-title">Cadastro de OS</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label for="pk_ordem_servico" class="form-label">CÓD:</label>
                                                    <input value="<?php echo $pk_ordem_servico ?>" readonly type="number" name="pk_ordem_servico" id="pk_ordem_servico" class="form-control ">
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="cpf" class="form-label">CPF:</label>
                                                    <div class="input-group">
                                                        <input value="<?php echo $cpf ?>" type="text" name="cpf" id="cpf" class="form-control" data-mask="000.000.000-00" required minlength="14">
                                                        <span class="input-group-append">
                                                            <button class="btn btn-default btn-flat" type="button">
                                                                <i id="btn-search" class="bi bi-search-heart"></i>
                                                            </button>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-md">
                                                    <label for="nome" class="form-label">Cliente:</label>
                                                    <input readonly value="<?php echo $nome ?>" type="text" name="nome" id="nome" class="form-control">
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col">
                                                    <label for="data_ordem_servico" class="form-label">Data O.S.:</label>
                                                    <input readonly value="<?php echo $data_ordem_servico ?>" type="date" name="data_ordem_servico" id="data_ordem_servico" class="form-control">
                                                </div>
                                                <div class="col">
                                                    <label for="data_inicio" class="form-label">Data início:</label>
                                                    <input value="<?php echo $data_inicio ?>" type="date" name="data_inicio" id="data_inicio" class="form-control">
                                                </div>
                                                <div class="col">
                                                    <label for="data_fim" class="form-label">Data Fim:</label>
                                                    <input value="<?php echo $data_fim ?>" type="date" name="data_fim" id="data_fim" class="form-control">
                                                </div>
                                            </div>
                                            <div class="row mt-5">
                                                <div class="card card-warning card-outline">
                                                    <div class="card-header">
                                                        <h3 class="card-title">Lista de Ordens de Serviço</h3>
                                                        <button class="btn btn-primary float-end btn-sm" id="btn-add" type="button">
                                                            <i class="bi bi-plus"></i>
                                                        </button>
                                                    </div>
                                                    <div class="card-body">
                                                        <table class="table" id="tabela_servicos">
                                                            <thead>
                                                                <tr>
                                                                    <th>Serviço</th>
                                                                    <th class="">Valor</th>
                                                                    <th class="text-center">Opções</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="">
                                                                <?php
                                                                if (empty($pk_ordem_servico)) {
                                                                    echo '
                                                                    <tr>
                                                                        <td>
                                                                            <select required class="form-select" name="fk_servico[]" id="">
                                                                                ' . $options . '
                                                                            </select>
                                                                        </td>
                                                                        <td>
                                                                            <input required class="form-control" type="text" name="valor[]" id="">
                                                                        </td>
                                                                        <td class="text-center">
                                                                        </td>
                                                                    </tr>
                                                                    ';
                                                                } else {
                                                                    $sql = "
                                                                        SELECT s.pk_servico, s.servico, rl.valor
                                                                        FROM servicos s
                                                                        JOIN rl_servicos_os rl ON rl.fk_servico = s.pk_servico
                                                                        WHERE rl.fk_ordem_servico = :pk_ordem_servico
                                                                    ";
                                                                    try {
                                                                        $stmt = $conn->prepare($sql);
                                                                        $stmt->bindParam(':pk_ordem_servico', $pk_ordem_servico);
                                                                        $stmt->execute();

                                                                        $dados = $stmt->fetchAll(PDO::FETCH_OBJ);

                                                                        foreach ($dados as $key => $row) {
                                                                            echo '
                                                                                <tr>
                                                                                    <td>
                                                                                        <select required class="form-select" name="fk_servico[]" id="">
                                                                                            <option selected value = "' . $row->pk_servico . '">' . $row->servico . '</option>
                                                                                            ' . $options . '
                                                                                        </select>
                                                                                    </td>
                                                                                    <td>
                                                                                        <input value="' . $row->valor . '" required class="form-control" type="text" name="valor[]" id="">
                                                                                    </td>
                                                                                    <td class="text-center">
                                                                                    <button class="btn btn-danger btn-sm" onclick="RemoveRow(this)" type="button" >
                                                                                    <i class="bi bi-trash"></i>
                                                                                    </button>
                                                                                    </td>
                                                                                </tr>
                                                                            ';
                                                                        }
                                                                    } catch (PDOException $ex) {
                                                                        $_SESSION['tipo'] = "error";
                                                                        $_SESSION['title'] = "ops!";
                                                                        $_SESSION['msg'] = $ex->getMessage();
                                                                    }
                                                                }
                                                                ?>



                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <!-- /.card-body -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer text-end ">
                                        <a href="./" class="btn btn-outline-danger">
                                            Voltar
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            Salvar
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <!-- /.card -->
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <!-- Footer -->
        <?php include("../footer.php"); ?>
        <!-- /. Footer -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="../dist/plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="../dist/plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="../dist/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="../dist/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Bootstrap 5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!-- overlayScrollbars -->
    <script src="../dist/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- ChartJS -->
    <script src="../dist/plugins/chart.js/Chart.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../dist/js/adminlte.js"></script>
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="../dist/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <!-- Jquery mask -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <?php
    include("../sweet_alert2.php");
    ?>

    <script>
        $(function() {


            $("#cpf").keyup(function() {
                // Limpa o input de nome
                $("#nome").val("");
            })


            $("#btn-search").click(function() {
                // limpa input de nome
                $("#nome").val("");
                // faz a requisição para o arquivo "consultar_cpf.php"
                $.getJSON(
                    'consultar_cpf.php', {
                        cpf: $("#cpf").val()
                    },
                    function(data) {
                        if (data['success'] == true) {
                            $("#nome").val(data['dado']['nome']);
                        } else {
                            alert(data['dado'])
                            $("#cpf").val("")
                            $("#cpf").focus()
                        }
                    }
                )
            })

            $("#btn-add").click(function() {
                var newRow = $("<tr>");
                var cols = "";
                cols += '<td>';
                cols += '<select class="form-select" name="fk_servico[]">';
                cols += '<?php echo $options ?>';
                cols += '</select>';
                cols += '</td>';
                cols += '<td><input class="form-control" type="number" name="valor[]" id=""></td>'
                cols += '<td class="text-center"><button class="btn btn-danger btn-sm" onclick="RemoveRow(this)" type="button" ><i class="bi bi-trash"></i></button></td>'
                newRow.append(cols);
                $("#tabela_servicos").append(newRow);
            });

            // Remover linha

            RemoveRow = function(item) {
                var tr = $(item).closest('tr');
                tr.fadeOut(200, function() {
                    tr.remove();
                });
                return false;
            }







            // navbar-white navbar-light
            // sidebar-dark-primary

            $("#theme-mode").click(function() {
                var classMode = $("#theme-mode").attr("class")
                if (classMode == "fa fa-sun") {
                    $("body").removeClass("dark-mode");
                    $("#theme-mode").attr("class", "fa fa-moon")
                    $("#nav").removeClass("navbar-black navbar-dark")
                    $("#nav").addClass("navbar-white navbar-light")
                    $("#aside").removeClass("sidebar-dark-primary")
                    $("#aside").addClass("sidebar-light-primary")
                } else {
                    $("body").addClass("dark-mode")
                    $("#theme-mode").attr("class", "fa fa-sun")
                    $("#nav").removeClass("navbar-white navbar-light")
                    $("#nav").addClass("navbar-black navbar-dark")
                    $("#aside").removeClass("sidebar-light-primary")
                    $("#aside").addClass("sidebar-dark-primary")
                }
            })

        })
    </script>
</body>

</html>