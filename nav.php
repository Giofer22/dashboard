<?php
$sql='
SELECT COUNT(pk_ordem_servico) total_os,
(SELECT COUNT(pk_cliente)
FROM clientes
) total_clientes,
(SELECT COUNT(pk_servico)
FROM servicos
) total_servicos,
(SELECT COUNT(pk_ordem_servico) 
FROM ordens_servicos WHERE data_fim = CURDATE()
) total_os_concluidas
FROM ordens_servicos
';

try{
  $stmt = $conn->prepare($sql);
  $stmt->execute();
  $dados = $stmt->fetch(PDO::FETCH_OBJ);


  if($dados->total_os == 0){
    $cem_por = 0;
  }else{
    $cem_por = number_format((($dados->total_os_concluidas / $dados->total_os) * 100), 0);
  }


}catch (PDOException $ex){
  $_SESSION["tipo"] = 'error';
  $_SESSION["title"] = 'OPS!';
  $_SESSION["msg"] = $ex->getMessage();
}

?>


<nav id="nav" class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="<?php echo caminhoURL; ?>index.php" class="nav-link">Home</a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="<?php echo caminhoURL; ?>contato.php" class="nav-link">Contato</a>
    </li>
  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <li class="nav-item">
      <a class="nav-link" style="cursor: pointer ">
        <i class="fas fa-moon" id="theme-mode"></i>
        <!-- <i class="fas fa-moon"></i> -->
      </a>
    </li>
    <!-- Notifications Dropdown Menu -->
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-bell"></i>
        <span class="badge badge-warning navbar-badge"><?php echo $dados->total_os; ?></span>
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <span class="dropdown-item dropdown-header"><?php echo $dados->total_os; ?> Ordens de Serviço</span>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
          <i class="fas fa-envelope mr-2"></i> 4 new messages
          <span class="float-right text-muted text-sm">3 mins</span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
          <i class="fas fa-users mr-2"></i> 8 friend requests
          <span class="float-right text-muted text-sm">12 hours</span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
          <i class="fas fa-file mr-2"></i> 3 new reports
          <span class="float-right text-muted text-sm">2 days</span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-widget="fullscreen" href="#" role="button">
        <i class="fas fa-expand-arrows-alt"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="<?php echo caminhoURL; ?>logout.php">
        <i class="fas fa-sign-out-alt"></i>
      </a>
    </li>
  </ul>
</nav>